<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Snippet;
use App\Models\SnippetFile;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Identify Target User
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Demo Developer',
                'email' => 'dev@codevault.com',
                'password' => bcrypt('password'),
            ]);
        }
        $userId = $user->id;

        $this->command->info("Seeding data for User: {$user->name} (ID: {$userId})");

        // 2. Clear existing categories/snippets if needed (optional, appending per plan)
        // Category::where('user_id', $userId)->delete();

        // 3. Generate 50 Categories
        $categories = [];
        $colorNames = ['purple', 'indigo', 'emerald', 'amber', 'rose', 'cyan', 'blue', 'violet'];
        
        for ($i = 1; $i <= 50; $i++) {
            $name = "Category " . Str::random(5) . " " . $i;
            $catId = Str::slug($name) . "-" . Str::random(4);
            
            $categories[] = [
                'user_id' => $userId,
                'category_id' => $catId,
                'category_name' => $name,
                'category_description' => "Sample description for {$name}. High-density category for UI testing.",
                'color_name' => $colorNames[array_rand($colorNames)],
                'isActive' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insertOrIgnore($categories);
        $this->command->info("Created 50 Categories.");

        // Fetch all generated category IDs for this user
        $catIds = DB::table('categories')->where('user_id', $userId)->pluck('category_id')->toArray();

        // 4. Generate 500 Snippets
        $languages = ['PHP', 'Laravel', 'Javascript', 'React', 'Python', 'Tailwind', 'CSS', 'HTML', 'SQL'];
        
        for ($s = 1; $s <= 500; $s++) {
            $lang = $languages[array_rand($languages)];
            $title = "Sample Snippet {$s}: " . Str::title(str_replace('-', ' ', Str::slug(Str::random(10))));
            
            $snippetId = DB::table('snippets')->insertGetId([
                'user_id' => $userId,
                'category_id' => $catIds[array_rand($catIds)],
                'title' => $title,
                'description' => "Automated sample snippet {$s} for the premium SaaS dashboard. This snippet demonstrates high-density data handling and list rendering performance.",
                'language' => $lang,
                'isActive' => 1,
                'isMark' => rand(0, 1), // Some starred
                'created_at' => now()->subMinutes(rand(1, 10000)), // Spread them across time
                'updated_at' => now(),
            ]);

            // 5. Generate 1-2 Snippet Files
            $fileCount = rand(1, 2);
            for ($f = 1; $f <= $fileCount; $f++) {
                $ext = $this->getExtension($lang);
                $fileName = Str::slug(Str::random(8)) . "." . $ext;
                
                DB::table('snippet_files')->insert([
                    'snippet_id' => $snippetId,
                    'file_name' => $fileName,
                    'file_path' => "app/Samples",
                    'content' => $this->getMockContent($lang, $title),
                    'extension' => $ext,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($s % 100 === 0) {
                $this->command->info("Seeded {$s} snippets...");
            }
        }

        $this->command->info("Seeding complete! 50 categories and 500 snippets added.");
    }

    private function getExtension($lang)
    {
        return match (strtolower($lang)) {
            'php', 'laravel' => 'php',
            'javascript', 'react', 'js' => 'js',
            'python' => 'py',
            'css', 'tailwind' => 'css',
            'html' => 'html',
            'sql' => 'sql',
            default => 'txt',
        };
    }

    private function getMockContent($lang, $title)
    {
        $content = "/**\n * {$title}\n * Generated Sample Data\n */\n\n";
        
        return match (strtolower($lang)) {
            'php', 'laravel' => $content . "namespace App\\Samples;\n\nclass SampleClass {\n    public function execute() {\n        return 'Success for {$title}';\n    }\n}",
            'javascript', 'react', 'js' => $content . "const handleAction = () => {\n    console.log('Action triggered: {$title}');\n    return true;\n};",
            'python' => $content . "def main():\n    print('Sample: {$title}')\n\nif __name__ == '__main__':\n    main()",
            'sql' => $content . "SELECT * FROM snippets WHERE title LIKE '%{$title}%' AND isActive = 1 ORDER BY created_at DESC;",
            default => $content . "Sample content for a random code block related to {$title} in {$lang}.",
        };
    }
}
