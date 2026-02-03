<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Snippet;
use App\Models\SnippetFile;
use App\Models\User;

class SnippetSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users to assign snippets to
        $users = User::all();

        // 1. Image Upload with Storage
        $s1 = Snippet::create([
            'title' => 'Profile Image Upload',
            'description' => 'Validates and stores user profile images in public disk.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s1->files()->create([
            'file_name' => 'ProfileController.php',
            'file_path' => 'app/Http/Controllers',
            'content' => "public function update(Request \$request) {\n    \$request->validate(['avatar' => 'required|image|mimes:jpg,png|max:2048']);\n    \$path = \$request->file('avatar')->store('avatars', 'public');\n    auth()->user()->update(['avatar' => \$path]);\n    return back();\n}",
            'extension' => 'php'
        ]);

        // 2. Custom Middleware for Admin Access
        $s2 = Snippet::create([
            'title' => 'Admin Access Middleware',
            'description' => 'Checks if the authenticated user has an admin role.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s2->files()->create([
            'file_name' => 'IsAdmin.php',
            'file_path' => 'app/Http/Middleware',
            'content' => "public function handle(Request \$request, Closure \$next) {\n    if (auth()->check() && auth()->user()->is_admin) {\n        return \$next(\$request);\n    }\n    abort(403, 'Unauthorized');\n}",
            'extension' => 'php'
        ]);

        // 3. API Authentication with Sanctum
        $s3 = Snippet::create([
            'title' => 'Sanctum API Login',
            'description' => 'Authenticates user via API and returns a PlainTextToken.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s3->files()->create([
            'file_name' => 'ApiAuthController.php',
            'file_path' => 'app/Http/Controllers/Api',
            'content' => "public function login(Request \$request) {\n    \$user = User::where('email', \$request->email)->first();\n    if (!\$user || !Hash::check(\$request->password, \$user->password)) {\n        return response(['message' => 'Invalid'], 401);\n    }\n    return ['token' => \$user->createToken('web-app')->plainTextToken];\n}",
            'extension' => 'php'
        ]);

        // 4. Eloquent One-to-Many Relationship
        $s4 = Snippet::create([
            'title' => 'Category-Post Relationship',
            'description' => 'Defining a one-to-many relationship in Eloquent Models.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s4->files()->create([
            'file_name' => 'Category.php',
            'file_path' => 'app/Models',
            'content' => "public function posts() {\n    return \$this->hasMany(Post::class);\n}",
            'extension' => 'php'
        ]);

        // 5. Global Search using Eloquent Scopes
        $s5 = Snippet::create([
            'title' => 'Dynamic Search Scope',
            'description' => 'Reusable local scope for searching multiple columns.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s5->files()->create([
            'file_name' => 'User.php',
            'file_path' => 'app/Models',
            'content' => "public function scopeSearch(\$query, \$term) {\n    return \$query->where('name', 'LIKE', \"%\$term%\")\n                 ->orWhere('email', 'LIKE', \"%\$term%\");\n}",
            'extension' => 'php'
        ]);

        // 6. Send Mail with Mailable
        $s6 = Snippet::create([
            'title' => 'Welcome Email Mailable',
            'description' => 'Sending a welcome email to newly registered users.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s6->files()->create([
            'file_name' => 'WelcomeUser.php',
            'file_path' => 'app/Mail',
            'content' => "public function content(): Content {\n    return new Content(view: 'emails.welcome');\n}",
            'extension' => 'php'
        ]);

        // 7. DB Transactions for Security
        $s7 = Snippet::create([
            'title' => 'Database Transactions',
            'description' => 'Ensuring data integrity during multiple DB operations.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s7->files()->create([
            'file_name' => 'OrderController.php',
            'file_path' => 'app/Http/Controllers',
            'content' => "DB::transaction(function () use (\$request) {\n    \$order = Order::create([...]);\n    \$order->items()->createMany(\$request->items);\n    User::decrement('balance', \$order->total);\n});",
            'extension' => 'php'
        ]);

        // 8. Custom Blade Directive
        $s8 = Snippet::create([
            'title' => 'Blade Currency Formatter',
            'description' => 'Creating a custom @money directive for Blade views.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s8->files()->create([
            'file_name' => 'AppServiceProvider.php',
            'file_path' => 'app/Providers',
            'content' => "public function boot() {\n    Blade::directive('money', function (\$amount) {\n        return \"<?php echo 'Rs.' . number_format(\$amount); ?>\";\n    });\n}",
            'extension' => 'php'
        ]);

        // 9. API Resource Transformation
        $s9 = Snippet::create([
            'title' => 'User API Resource',
            'description' => 'Hiding sensitive fields like password in API responses.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s9->files()->create([
            'file_name' => 'UserResource.php',
            'file_path' => 'app/Http/Resources',
            'content' => "public function toArray(Request \$request): array {\n    return [\n        'id' => \$this->id,\n        'full_name' => \$this->name,\n        'joined' => \$this->created_at->format('Y-m-d')\n    ];\n}",
            'extension' => 'php'
        ]);

        // 10. Scheduling Console Commands
        $s10 = Snippet::create([
            'title' => 'Daily Database Cleanup',
            'description' => 'Running a scheduled task to delete old logs.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s10->files()->create([
            'file_name' => 'console.php',
            'file_path' => 'routes',
            'content' => "Schedule::command('logs:clear')->dailyAt('00:00');",
            'extension' => 'php'
        ]);
    }
}