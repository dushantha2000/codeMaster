<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationMailJob;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function UpdateProfile(Request $request)
    {
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
        ]);

        try {
            $user = auth()->user();
            $userId = $user->id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            // Invalidate profile cache
            Cache::forget("profile:user:{$userId}:partners");

            return redirect()->back()->with('success', 'Profile updated successfully!');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function Login(Request $request)
    {
        try {
            // dd('wdqwdqw');
            return view('auth.login');
        } catch (Exception $e) {
            return redirect('/')->with(
                'error',
                'Critical System Error. Login failed.',
            );
        }
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Show forgot password form
     */
    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    /**
     * Show reset password form
     */
    public function showReset($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function userLogin(Request $request)
    {
        // return $request;
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
                ],
            );

            // Attempt login
            if (Auth::attempt($credentials)) {
                $id = Auth::user()->id;
                $name = Auth::user()->name;
                $email = Auth::user()->email;

                $request->session()->regenerate();
                session()->put('isActive', $isActive = 1);

                // new user session

                return redirect()->intended('/dashboard');
            }

            // Return with error and keep the email input
            return view('auth.login')->with(
                'error',
                'Invalid email address or password. Please check your credentials and try again.',
            );
        } catch (Exception $e) {
            return redirect('/')->with(
                'error',
                'Critical System Error. Login failed.',
            );
        }
    }

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

    public function userRegister(Request $request)
    {
        // return $request;
        $request->validate([
            'userName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        try {
            DB::beginTransaction();
            // User Create
            $user = User::create([
                'user_id' => Str::uuid(),
                'name' => $request->userName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_verified' => 0,
            ]);

            // create verification Code
            $verificationCode = Str::upper(Str::random(6));

            // store verification code in cache
            Cache::put("verification_code_{$user->id}", $verificationCode, now()->addMinutes(5));

            $details = [
                'email' => $user->email,
                'code' => $verificationCode,
                'user' => $user,
            ];
            SendVerificationMailJob::dispatch($details);

            // Email send
            // SendVerificationMailJob::dispatch($user, $verificationCode);

            DB::commit();

            // user id add to session
            session(['pending_user_id' => $user->id]);

            return  view('auth.registerverification');

        } catch (Exception $e) {
            // all data reset
            DB::rollBack();

            return back()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function verifyRegistration(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        $userId = session('pending_user_id');

        if (! $userId) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        $user = User::find($userId);
        $cachedCode = Cache::get("verification_code_{$userId}");

        // Code check
        if (! $cachedCode || $request->verification_code !== $cachedCode) {
            return back()->with('error', 'Invalid or expired verification code.');
        }

        try {
            // User verify
            $user->is_verified = 1;
            $user->email_verified_at = now();
            $user->save();

            // Session clear
            Cache::forget("verification_code_{$userId}");
            session()->forget('pending_user_id');

            // new user session

            return redirect()->route('login')->with('success', 'Registration successful! Please login.');

        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function Logout()
    {
        // return 'greger';
        try {
            Auth::guard('web')->logout();
            session()->invalidate();
            session()->regenerateToken();

            // Always redirect to the login page (don't use view())
            return view('auth.login')->with(
                'message',
                'You have been safely logged out.',
            );
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Critical System Error. Logout failed.');
        }
    }

    public function Profile()
    {
        //  try {
        $currentUserId = auth()->id();

        $partners = DB::table('users')
            ->join(
                'partnerships',
                'users.id',
                '=',
                'partnerships.partner_id',
            )
            ->where('partnerships.user_id', $currentUserId)
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'partnerships.is_read',
                'partnerships.is_edit',
            )
            ->get();

        // return $partners;

        return view('auth.profile', [
            'user' => auth()->user(),
            'partners' => $partners,
        ]);
        //   } catch (Exception $e) {
        //       return back()->with([
        //         "error" => "Something went wrong while loading the page.",
        //     ]);
        //  }
    }

    public function Settings()
    {
        try {
            return view('auth.settings');
        } catch (Exception $e) {
            return back()->with([
                'error' => 'Something went wrong while loading the page.',
            ]);
        }
    }

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

    public function sendResetCode(Request $request)
    {
        // Validate the email exists in our users table
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            [
                'email.exists' => 'We can\'t find a user with that email address.',
            ],
        );

        $token = Str::random(64);

        try {
            DB::transaction(function () use ($request, $token) {
                // Update the token
                DB::table('password_reset_tokens')->updateOrInsert(
                    ['email' => $request->email],
                    [
                        'token' => $token,
                        'created_at' => now(),
                    ],
                );

                // Send the Mail
                Mail::to($request->email)->send(new ResetPasswordMail($token));
            });

            return view('auth.resetmassage');
        } catch (Exception $e) {
            return back()->with(
                'error',
                'Mail server error. Please try again later.',
            );
        }
    }

    public function showResetForm($token)
    {
        try {
            // token actually exists in database
            $tokenExists = DB::table('password_reset_tokens')
                ->where('token', $token)
                ->first();

            // fake or already used
            if (! $tokenExists) {
                return redirect('/')->with(
                    'error',
                    'This password reset link is invalid or has already been used. Please request a new one.',
                );
            }

            // Check if the link is older than 60 minutes
            $tokenExpired = \Carbon\Carbon::parse($tokenExists->created_at)
                ->addMinutes(60)
                ->isPast();
            if ($tokenExpired) {
                return redirect('/')->with(
                    'error',
                    'This reset link has expired for security reasons. Please try again.',
                );
            }

            // show the form
            return view('auth.changepassword', ['token' => $token]);
        } catch (Exception $e) {
            return redirect('/')->with(
                'error',
                'We are experiencing connection issues. Please try again in a few minutes.',
            );
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // token exists for this email
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (! $resetRecord) {
            return back()->with(
                'error',
                'Invalid token or email. Please try again.',
            );
        }

        // Check if token is expired (e.g., 60 minutes)
        // if (Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) { ... }
        try {
            // Update the user's password
            DB::table('users')
                ->where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            // Delete the token
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return redirect('/')->with(
                'success',
                'Your password has been successfully updated! Please login.',
            );
        } catch (Exception $e) {
            return back()->with(
                'error',
                'Your password has been unsuccessfully updated! Please try again .',
            );
        }
    }

    public function changePassword(Request $request)
    {
        // return $request;
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        try {
            $user->password = Hash::make($request->password);
            $user->save();

            return back()->with('success', 'Password changed successfully!');
        } catch (Exception $e) {
            return back()->with(
                'error',
                'Failed to change password. Please try again.',
            );
        }
    }

    public function destroyProfile(Request $request)
    {
        // return $request;
        $user = auth()->user();

        try {
            $userId = $user->id;

            // Delete related partnerships
            DB::table('partnerships')->where('user_id', $userId)->delete();
            DB::table('partnerships')->where('partner_id', $userId)->delete();

            // Delete related snippets
            DB::table('snippets')->where('user_id', $userId)->delete();

            // Invalidate all caches for this user
            Cache::forget("profile:user:{$userId}:partners");
            Cache::forget("partnerships:user:{$userId}:shared_with_me");
            Cache::forget("languages:user:{$userId}:list");

            // Try to delete snippet and search caches by pattern if Redis is available
            $store = Cache::getStore();
            if (method_exists($store, 'getRedis')) {
                try {
                    $redis = $store->getRedis();
                    $prefix = Cache::getPrefix();

                    // Delete snippet caches
                    $pattern = $prefix."snippets:user:{$userId}:*";
                    $keys = $redis->keys($pattern);
                    if (! empty($keys)) {
                        $redis->del($keys);
                    }

                    // Delete search caches
                    $pattern = $prefix."search:user:{$userId}:*";
                    $keys = $redis->keys($pattern);
                    if (! empty($keys)) {
                        $redis->del($keys);
                    }
                } catch (Exception $e) {
                    // If Redis pattern matching fails, cache will expire naturally via TTL
                }
            }

            // Delete the user
            $user->delete();

            // Logout the user
            Auth::logout();

            return redirect('/')->with(
                'success',
                'Your account has been deleted successfully.',
            );
        } catch (Exception $e) {
            return back()->with(
                'error',
                'Failed to delete account. Please try again.',
            );
        }
    }
}
