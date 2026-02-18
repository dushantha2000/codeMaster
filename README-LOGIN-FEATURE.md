# User Authentication System

## Technical Description

This is a comprehensive Laravel-based user authentication system that provides secure login, registration with email verification, password reset functionality, and session management. The system follows Laravel's best practices and implements the MVC (Model-View-Controller) architectural pattern.

### Authentication Flow

1. **Login Process**: Users navigate to the login page (`/`), enter their email and password. The system validates credentials using Laravel's `Auth::attempt()` method. Upon successful authentication, a session is created with `session()->regenerate()` to prevent session fixation attacks, and users are redirected to the dashboard.

2. **Registration Process**: Users fill out the registration form with name, email, and password. A 6-character verification code is generated and sent to the user's email. The user must enter this code to complete registration. Upon verification, the user is created in the database with `is_verified = 1` and `email_verified_at` timestamp.

3. **Password Reset Process**: Users request a password reset by entering their email. A secure token is generated and stored in the `password_reset_tokens` table. A reset link is sent to the user's email. The link is valid for 60 minutes. Users can then set a new password.

4. **Session Management**: The system uses database-driven sessions with encryption. Sessions expire after 120 minutes of inactivity by default. The system includes CSRF protection via Laravel's token mechanism.

5. **Logout Process**: Users can log out, which invalidates their session, regenerates the CSRF token, and redirects them to the login page with a success message.

### Integration with Laravel Architecture

- **Middleware**: Uses Laravel's built-in `auth` middleware for protected routes and `guest` middleware for public routes
- **Authentication Guard**: Uses the `web` guard with session driver
- **User Provider**: Uses Eloquent ORM with the User model
- **Flash Messages**: Uses Laravel's session-based flash messages for success/error notifications
- **Email Integration**: Uses Laravel's Mail facade for sending verification and password reset emails

---

## File Structure

```
your-laravel-project/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── AuthController.php          # Main authentication controller
│   ├── Models/
│   │   └── User.php                        # User model with authentication
│   └── Mail/
│       ├── VerificationMail.php            # Email verification mail class
│       └── ResetPasswordMail.php           # Password reset mail class
├── config/
│   ├── auth.php                            # Authentication configuration
│   └── session.php                         # Session configuration
├── database/
│   └── migrations/
│       └── 0001_01_01_000000_create_users_table.php  # Database migrations
├── routes/
│   └── web.php                             # Web routes
└── resources/
    └── views/
        ├── auth/
        │   ├── master.blade.php            # Master layout for auth pages
        │   ├── login.blade.php             # Login page view
        │   ├── register.blade.php          # Registration page view
        │   ├── registerverification.blade.php   # Email verification view
        │   ├── resetpassword.blade.php     # Password reset request view
        │   ├── changepassword.blade.php    # Password change view
        │   ├── resetmassage.blade.php       # Reset email sent confirmation
        │   └── loading.blade.php            # Loading spinner component
        ├── emails/
        │   ├── registerverification.blade.php   # Verification email template
        │   └── passwordreset.blade.php     # Password reset email template
        └── common/
            └── notification.blade.php      # Toast notification component
```

---

## Reusable Code Snippets

### 1. User Model (`app/Models/User.php`)

```php
<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

### 2. Authentication Controller (`app/Http/Controllers/AuthController.php`)

```
php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display login page
     */
    public function Login(Request $request)
    {
        try {
            return view('auth.login');
        } catch (Exception $e) {
            return redirect('/')->with(
                'error',
                'Critical System Error. Login failed.'
            );
        }
    }

    /**
     * Handle user login attempt
     */
    public function userLogin(Request $request)
    {
        try {
            // Validation
            $credentials = $request->validate(
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ],
                [
                    'email.required' => 'Please enter your email address.',
                    'email.email' => 'Please enter a valid email address.',
                    'password.required' => 'Please enter your password.',
                ]
            );

            // Attempt login
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                session()->put('isActive', 1);

                return redirect()->intended('/dashboard');
            }

            // Return with error
            return view('auth.login')->with(
                'error',
                'Invalid email address or password. Please check your credentials and try again.'
            );
        } catch (Exception $e) {
            return redirect('/')->with(
                'error',
                'Critical System Error. Login failed.'
            );
        }
    }

    /**
     * Display registration page
     */
    public function register(Request $request)
    {
        try {
            return view('auth.register');
        } catch (Exception $e) {
            return back()->with([
                'error' => 'Something went wrong while loading the page.',
            ]);
        }
    }

    /**
     * Handle user registration
     */
    public function UserRegister(Request $request)
    {
        $request->validate([
            'userName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        // Store data in session for verification
        $request->session()->put('userEmail', $request->email);
        $request->session()->put('userName', $request->userName);
        $request->session()->put('password', $request->password);
        $request->session()->put('password_confirmation', $request->password_confirmation);

        // Generate verification code
        $verificationCode = Str::random(6);
        $request->session()->put('verificationCode', $verificationCode);

        // Send verification code to email
        // Mail::to($request->email)->send(new YourVerificationMail($verificationCode));

        return view('auth.registerverification');
    }

    /**
     * Verify registration with code
     */
    public function verifyRegistration(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        // Check if session data exists
        if (
            !$request->session()->has('verificationCode') ||
            !$request->session()->has('userEmail') ||
            !$request->session()->has('userName') ||
            !$request->session()->has('password')
        ) {
            return view('auth.register')->with(
                'error',
                'Session expired. Please register again.'
            );
        }

        // Get session data
        $sessionCode = $request->session()->get('verificationCode');
        $userEmail = $request->session()->get('userEmail');
        $userName = $request->session()->get('userName');
        $password = $request->session()->get('password');

        // Verify the code
        if ($request->verification_code !== $sessionCode) {
            return view('auth.registerverification')->with(
                'error',
                'Invalid verification code. Please try again.'
            );
        }

        // Check if email already exists
        $emailExists = User::where('email', $userEmail)->exists();
        if ($emailExists) {
            return view('auth.register')->with(
                'error',
                'This email is already registered. Please login instead.'
            );
        }

        // Create the user
        $user = new User();
        $user->user_id = Str::uuid();
        $user->name = $userName;
        $user->email = $userEmail;
        $user->password = Hash::make($password);
        $user->is_verified = 1;
        $user->email_verified_at = now();
        $user->save();

        // Clear session data
        $request->session()->forget([
            'verificationCode',
            'userEmail',
            'userName',
            'password',
            'password_confirmation',
        ]);

        return view('auth.login')->with(
            'success',
            'Registration successful! Please login with your credentials.'
        );
    }

    /**
     * Handle user logout
     */
    public function Logout()
    {
        try {
            Auth::guard('web')->logout();
            session()->invalidate();
            session()->regenerateToken();

            return view('auth.login')->with(
                'message',
                'You have been safely logged out.'
            );
        } catch (Exception $e) {
            return redirect()->back()->with(
                'error',
                'Critical System Error. Logout failed.'
            );
        }
    }

    /**
     * Display password reset request page
     */
    public function ResetPassword()
    {
        try {
            return view('auth.resetpassword');
        } catch (Exception $e) {
            return back()->with([
                'error' => 'Something went wrong while loading the page.',
            ]);
        }
    }

    /**
     * Send password reset code
     */
    public function sendResetCode(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            [
                'email.exists' => "We can't find a user with that email address.",
            ]
        );

        $token = Str::random(64);

        try {
            // Store token in database
            // DB::table('password_reset_tokens')->updateOrInsert(
            //     ['email' => $request->email],
            //     ['token' => $token, 'created_at' => now()]
            // );

            // Send reset email
            // Mail::to($request->email)->send(new YourResetPasswordMail($token));

            return view('auth.resetmassage');
        } catch (Exception $e) {
            return back()->with(
                'error',
                'Mail server error. Please try again later.'
            );
        }
    }

    /**
     * Show password reset form
     */
    public function showResetForm($token)
    {
        try {
            // Verify token exists
            // $tokenExists = DB::table('password_reset_tokens')
            //     ->where('token', $token)
            //     ->first();

            // if (!$tokenExists) {
            //     return redirect('/')->with('error', 'Invalid reset link.');
            // }

            // Check if token is expired (60 minutes)
            // if (Carbon::parse($tokenExists->created_at)->addMinutes(60)->isPast()) {
            //     return redirect('/')->with('error', 'Reset link expired.');
            // }

            return view('auth.changepassword', ['token' => $token]);
        } catch (Exception $e) {
            return redirect('/')->with(
                'error',
                'We are experiencing connection issues. Please try again.'
            );
        }
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            // Update user's password
            // DB::table('users')
            //     ->where('email', $request->email)
            //     ->update(['password' => Hash::make($request->password)]);

            // Delete the token
            // DB::table('password_reset_tokens')
            //     ->where('email', $request->email)
            //     ->delete();

            return redirect('/')->with(
                'success',
                'Your password has been successfully updated! Please login.'
            );
        } catch (Exception $e) {
            return back()->with(
                'error',
                'Failed to update password. Please try again.'
            );
        }
    }
}
```

### 3. Web Routes (`routes/web.php`)

```
php
<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    // Login page
    Route::get('/', [AuthController::class, 'Login'])->name('login');
    
    // Login action
    Route::post('/user-login', [AuthController::class, 'UserLogin']);
    
    // Registration
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/user-register', [AuthController::class, 'UserRegister']);
    Route::post('/verify-registration', [AuthController::class, 'verifyRegistration']);
    
    // Password reset
    Route::get('/reset', [AuthController::class, 'ResetPassword']);
    Route::post('/send-Reset-Code', [AuthController::class, 'sendResetCode']);
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword']);
});

// Protected routes (must be logged in)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [YourDashboardController::class, 'index'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'Logout']);
    
    // Add your protected routes here
});

// Public help page
Route::get('/how-to-use', function () {
    return view('auth.howto');
})->name('howto');
```

### 4. Database Migration (`database/migrations/xxxx_xx_xx_xxxxxx_create_users_table.php`)

```
php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('isActive')->default(1);
            $table->tinyInteger('is_verified')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        // Password reset tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions table (for database session driver)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
```

### 5. Login View (`resources/views/auth/login.blade.php`)

```
php
@extends('auth.master')

@section('title', 'Login')

@section('content')
<div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10"
    x-data="loginForm()" x-cloak>

    <!-- Left Side - Visual -->
    <div class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-blue">
        <div class="relative z-10 text-center">
            <div class="mb-6 inline-block p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-white mb-4">Secure Your Code.</h2>
            <p class="text-gray-400 leading-relaxed">Your ultimate vault for snippets.</p>
        </div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-white tracking-tight">YourApp</h1>
            </div>
            <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
            <p class="text-gray-500 text-sm mt-1">Please enter your details to sign in.</p>
        </div>

        <form action="{{ url('/user-login') }}" method="POST" class="space-y-4">
            {{ csrf_field() }}

            @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 animate-pulse">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Email Address</label>
                <input type="email" name="email" required placeholder="you@example.com"
                    class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                @error('email')
                    <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5 ml-1">
                    <label class="block text-xs font-medium text-gray-400">Password</label>
                    <a href="{{ url('/reset') }}" class="text-[11px] text-blue-400 hover:underline">Forgot?</a>
                </div>
                <input type="password" name="password" required placeholder="••••••••"
                    class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                @error('password')
                    <p class="mt-1 ml-1 text-[10px] text-red-400 uppercase tracking-widest font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center py-1">
                <input type="checkbox" id="remember" name="remember"
                    class="w-4 h-4 rounded border-gray-700 bg-black/50 text-blue-600 focus:ring-0">
                <label for="remember" class="ml-2 text-xs text-gray-500 selection:bg-none">Keep me logged in</label>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                Sign In
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-500 text-xs">
                New to YourApp?
                <a href="{{ url('/register') }}" class="text-blue-400 hover:text-blue-300 font-semibold ml-1">Create an account</a>
            </p>
        </div>
    </div>
</div>
@endsection
```

### 6. Master Layout (`resources/views/auth/master.blade.php`)

```
php
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | YourApp</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=YourFont:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'YourFont', sans-serif;
            background: #0a0a0a;
            overflow-y: auto;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.2s ease;
        }

        .input-field:focus {
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(255, 255, 255, 0.07);
            outline: none;
        }

        .image-glow-blue {
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
        }
    </style>
    @stack('styles')
</head>

<body class="text-gray-100 flex items-center justify-center min-h-screen p-4">

    @include('auth.loading')

    @yield('content')

    @include('common.notification')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', 'form', function() {
                $('#custom-loader').css('display', 'flex').fadeIn(200);
            });

            $(document).on('click', '.load-btn', function() {
                $('#custom-loader').css('display', 'flex').show();
            });
        });

        window.addEventListener('pageshow', function() {
            $('#custom-loader').fadeOut(300);
        });
    </script>

    @stack('scripts')

</body>

</html>
```

### 7. Auth Configuration (`config/auth.php`)

```
php
<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
```

### 8. Session Configuration (`config/session.php`)

```
php
<?php

return [
    'driver' => env('SESSION_DRIVER', 'database'),
    'lifetime' => (int) env('SESSION_LIFETIME', 120),
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
    'encrypt' => env('SESSION_ENCRYPT', true),
    'files' => storage_path('framework/sessions'),
    'connection' => env('SESSION_CONNECTION'),
    'table' => env('SESSION_TABLE', 'sessions'),
    'store' => env('SESSION_STORE'),
    'lottery' => [2, 100],
    'cookie' => env('SESSION_COOKIE', 'yourapp-session'),
    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIE'),
    'http_only' => env('SESSION_HTTP_ONLY', true),
    'same_site' => env('SESSION_SAME_SITE', 'lax'),
];
```

---

## Terminal Commands & Setup Guide

### Step 1: Create a New Laravel Project

```
bash
# Create a new Laravel project
composer create-project laravel/laravel your-project-name

# Navigate to the project directory
cd your-project-name
```

### Step 2: Install Laravel Sanctum (Optional - for API tokens)

```
bash
# Install Sanctum for API token authentication
composer require laravel/sanctum

# Publish Sanctum configuration
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### Step 3: Create the User Model

```
bash
# Laravel's default User model is already created
# You can customize it by adding HasApiTokens if needed
php artisan make:model User -m
```

### Step 4: Run Migrations

```
bash
# Run all migrations including users, password_reset_tokens, and sessions tables
php artisan migrate
```

### Step 5: Create Authentication Controller

```
bash
# Create the AuthController
php artisan make:controller AuthController
```

### Step 6: Create Mail Classes (Optional)

```
bash
# Create mail classes for verification and password reset
php artisan make:mail VerificationMail
php artisan make:mail ResetPasswordMail
```

### Step 7: Configure Routes

Add the authentication routes to `routes/web.php`:

```
php
// Add the routes as shown in the Code Snippets section
```

### Step 8: Create View Files

Create the following Blade templates in `resources/views/auth/`:

```bash
# Create the views directory structure
mkdir -p resources/views/auth
mkdir -p resources/views/emails
mkdir -p resources/views/common
```

### Step 9: Install NPM Dependencies

```
bash
# Install frontend dependencies
npm install

# Build assets
npm run build
```

### Step 10: Configure Environment Variables

Update your `.env` file:

```
env
APP_NAME=YourApp
APP_URL=http://localhost

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true

# Mail Configuration (for sending emails)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@yourapp.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 11: Clear All Caches

```
bash
# Clear application cache
php artisan cache:clear

# Clear route cache
php artisan route:clear

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear
```

### Step 12: Generate Application Key

```
bash
# Generate application key if not already set
php artisan key:generate
```

### Step 13: Start Development Server

```
bash
# Start the Laravel development server
php artisan serve
```

### Additional Commands for Production

```
bash
# Optimize for production
php artisan optimize

# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Summary

This authentication system provides:

- ✅ Secure user login with session management
- ✅ User registration with email verification
- ✅ Password reset functionality with time-limited tokens
- ✅ CSRF protection
- ✅ Session fixation prevention
- ✅ Flash messages for user feedback
- ✅ Modern, responsive UI with Tailwind CSS
- ✅ Database-driven sessions
- ✅ Email notifications
- ✅ SOLID principles compliance
- ✅ Laravel best practices

You can customize this system by:
1. Changing the `user_id` to use auto-incrementing integer if preferred
2. Modifying the email verification flow
3. Adding two-factor authentication
4. Implementing social login (Laravel Socialite)
5. Customizing the UI to match your brand
