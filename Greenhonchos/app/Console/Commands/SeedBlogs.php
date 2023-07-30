<?php

namespace App\Console\Commands;

use App\Models\Blogs;
use Faker\Factory as Faker;
use Illuminate\Console\Command;

class SeedBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:blogs';
    protected $description = 'Seed 50,000 fake blogs into the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '512M');
        $faker = Faker::create();

        // Define the number of records to insert in one batch
        $batchSize = 1000;

        // Define the total number of blogs to be added
        $totalBlogs = 50000;

        $this->info('Seeding 50,000 blogs...');

        // Use a loop to insert the blogs in batches
        for ($i = 0; $i < $totalBlogs; $i += $batchSize) {
            $blogs = [];
            for ($j = 0; $j < $batchSize; $j++) {
                $blogs[] = [
                    'title' => $faker->sentence,
                    'content' => $faker->paragraph(2),
                    'tags' => $faker->words(3, true), // Generate 3 random words as tags
                    'image' => $faker->imageUrl(640, 480), // Generate a random image URL
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Blogs::insert($blogs);
        }

        $this->info('50,000 blogs seeded successfully!');
    }
}
