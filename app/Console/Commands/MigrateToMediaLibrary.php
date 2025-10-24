<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateToMediaLibrary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing images to MediaLibrary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Migrating Article featured images...');
        $this->migrateArticleImages();
        
        $this->info('Migrating User avatars...');
        $this->migrateUserAvatars();
        
        $this->info('Migration completed!');
    }

    private function migrateArticleImages()
    {
        $articles = Article::whereNotNull('featured_image')->get();
        $bar = $this->output->createProgressBar(count($articles));

        foreach ($articles as $article) {
            try {
                $path = Storage::disk('public')->path($article->featured_image);
                if (file_exists($path)) {
                    $article->addMedia($path)
                        ->preservingOriginal()
                        ->toMediaCollection('featured');
                }
            } catch (\Exception $e) {
                $this->error("Failed to migrate article {$article->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateUserAvatars()
    {
        $users = User::whereNotNull('avatar')->get();
        $bar = $this->output->createProgressBar(count($users));

        foreach ($users as $user) {
            try {
                $path = Storage::disk('public')->path($user->avatar);
                if (file_exists($path)) {
                    $user->addMedia($path)
                        ->preservingOriginal()
                        ->toMediaCollection('avatar');
                }
            } catch (\Exception $e) {
                $this->error("Failed to migrate user {$user->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }
}
