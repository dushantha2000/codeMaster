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

        Snippet::factory(1000)->create();
        // Get all users to assign snippets to
        $users = User::all();

        // 1. Image Upload with Storage
        $s1 = Snippet::create([
            'title' => 'User Registration Service',
            'description' => 'A robust service layer handling user creation, avatar processing, and welcome notifications.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s1->files()->create([
            'file_name' => 'UserRegistrationService.php',
            'file_path' => 'app/Services',
            'content' => "namespace App\Services;\n\nuse App\Models\User;\nuse Illuminate\Support\Facades\DB;\nuse Illuminate\Support\Facades\Hash;\nuse Illuminate\Support\Facades\Storage;\n\nclass UserRegistrationService {\n    public function register(array \$data): User {\n        return DB::transaction(function () use (\$data) {\n            \$user = User::create([\n                'name' => \$data['name'],\n                'email' => \$data['email'],\n                'password' => Hash::make(\$data['password']),\n            ]);\n\n            if (isset(\$data['avatar'])) {\n                \$path = \$data['avatar']->store('avatars', 'public');\n                \$user->update(['avatar' => \$path]);\n            }\n\n            // Fire events or send notifications\n            event(new \App\Events\UserRegistered(\$user));\n\n            return \$user;\n        });\n    }\n}",
            'extension' => 'php'
        ]);

        // 2. Custom Middleware for Admin Access
        $s2 = Snippet::create([
            'title' => 'Whitelist IP Middleware',
            'description' => 'Security layer that only allows specific IP addresses to access the admin routes.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s2->files()->create([
            'file_name' => 'RestrictIpAddress.php',
            'file_path' => 'app/Http/Middleware',
            'content' => "namespace App\Http\Middleware;\n\nuse Closure;\nuse Illuminate\Http\Request;\n\nclass RestrictIpAddress {\n    protected \$whitelist = ['127.0.0.1', '192.168.1.1'];\n\n    public function handle(Request \$request, Closure \$next) {\n        if (!in_array(\$request->ip(), \$this->whitelist)) {\n            logger()->warning('Unauthorized access attempt from IP: ' . \$request->ip());\n            abort(403, 'Your IP address is not authorized.');\n        }\n\n        return \$next(\$request);\n    }\n}",
            'extension' => 'php'
        ]);

        // 3. API Authentication with Sanctum
        $s3 = Snippet::create([
            'title' => 'Polymorphic Comment Model',
            'description' => 'Defining a model that can belong to multiple other model types using morphTo.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);
        $s3->files()->create([
            'file_name' => 'Comment.php',
            'file_path' => 'app/Models',
            'content' => "namespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\Relations\MorphTo;\n\nclass Comment extends Model {\n    protected \$fillable = ['body', 'commentable_id', 'commentable_type'];\n\n    /**\n     * Get the parent commentable model (Post or Video).\n     */\n    public function commentable(): MorphTo {\n        return \$this->morphTo();\n    }\n}",
            'extension' => 'php'
        ]);

        // --- 20. Advanced Repository Pattern ---
        $s4 = Snippet::create([
            'title' => 'Decoupled Repository & Service Layer',
            'description' => 'A professional architecture pattern to separate Eloquent queries from business logic.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);

        $s4->files()->create([
            'file_name' => 'UserRepository.php',
            'file_path' => 'app/Repositories',
            'content' => "namespace App\Repositories;\n\nuse App\Models\User;\n\nclass UserRepository {\n    public function getActiveWithRecentPosts() {\n        return User::where('active', true)\n            ->with(['posts' => function(\$query) {\n                \$query->latest()->limit(5);\n            }])\n            ->whereHas('posts')\n            ->get();\n    }\n\n    public function updateLastLogin(int \$id) {\n        return User::where('id', \$id)->update(['last_login_at' => now()]);\n    }\n}",
            'extension' => 'php'
        ]);

        $s4->files()->create([
            'file_name' => 'UserManagementService.php',
            'file_path' => 'app/Services',
            'content' => "namespace App\Services;\n\nuse App\Repositories\UserRepository;\nuse Illuminate\Support\Facades\Cache;\n\nclass UserManagementService {\n    public function __construct(protected UserRepository \$repository) {}\n\n    public function getDashboardData() {\n        return Cache::remember('admin_dashboard', 3600, function() {\n            return \$this->repository->getActiveWithRecentPosts();\n        });\n    }\n}",
            'extension' => 'php'
        ]);

        // --- 21. Large File Processing Logic ---
        $s5 = Snippet::create([
            'title' => 'Chunked Media Processor',
            'description' => 'Logic for handling large file uploads, generating thumbnails, and moving to S3.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);

        $s5->files()->create([
            'file_name' => 'MediaProcessor.php',
            'file_path' => 'app/Jobs',
            'content' => "namespace App\Jobs;\n\nuse Illuminate\Support\Facades\Storage;\nuse Intervention\Image\Facades\Image;\n\nclass ProcessMedia implements ShouldQueue {\n    public function handle() {\n        \$raw = Storage::disk('local')->get(\$this->path);\n        \n        // Create multiple sizes\n        foreach (['thumb' => 150, 'medium' => 600] as \$label => \$size) {\n            \$img = Image::make(\$raw)->resize(\$size, null, function (\$constraint) {\n                \$constraint->aspectRatio();\n            });\n            \n            Storage::disk('s3')->put(\"media/{\$label}/{\$this->filename}\", \$img->stream());\n        }\n\n        Storage::disk('local')->delete(\$this->path);\n    }\n}",
            'extension' => 'php'
        ]);

        // 7. DB Transactions for Security
        // --- 22. Request Pipeline Filtering ---
        $s6 = Snippet::create([
            'title' => 'Dynamic Query Pipeline',
            'description' => 'Using Laravels Pipeline to clean up messy controller filtering logic.',
            'language' => 'Laravel',
            'user_id' => $users->random()->id,
        ]);

        $s6->files()->create([
            'file_name' => 'ProductController.php',
            'file_path' => 'app/Http/Controllers',
            'content' => "use Illuminate\Pipeline\Pipeline;\n\npublic function index() {\n    \$products = app(Pipeline::class)\n        ->send(Product::query())\n        ->through([\n            \App\QueryFilters\Active::class,\n            \App\QueryFilters\Sort::class,\n            \App\QueryFilters\Category::class,\n        ])\n        ->thenReturn()\n        ->paginate(20);\n\n    return view('products.index', compact('products'));\n}",
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