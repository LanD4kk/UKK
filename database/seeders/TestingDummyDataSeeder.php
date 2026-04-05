<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Complaint;

class TestingDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Setup categories
        $categories = ['Fasilitas', 'Akademik', 'Pelayanan', 'Lainnya'];
        $catIds = [];
        foreach ($categories as $cat) {
            $category = Category::firstOrCreate(['category_name' => $cat]);
            $catIds[] = $category->category_id;
        }

        // Create 15 Staff
        for ($i = 1; $i <= 15; $i++) {
            User::firstOrCreate(
                ['identity_number' => 'STAFF' . str_pad($i, 3, '0', STR_PAD_LEFT)],
                [
                    'full_name' => $faker->name,
                    'password' => Hash::make('password'),
                    'role' => 'staff',
                    'phone_number' => $faker->numerify('08##########')
                ]
            );
        }

        // Create 15 Students
        $studentIds = [];
        $classes = ['XII RPL 1', 'XII RPL 2', 'XI TKJ 1', 'X TKR 1'];
        for ($i = 1; $i <= 15; $i++) {
            $student = User::firstOrCreate(
                ['identity_number' => 'STU' . str_pad($i, 3, '0', STR_PAD_LEFT)],
                [
                    'full_name' => $faker->name,
                    'class_name' => $classes[array_rand($classes)],
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'phone_number' => $faker->numerify('08##########')
                ]
            );
            $studentIds[] = $student->user_id;
        }

        // Clear existing complaints for these generated students
        Complaint::whereIn('user_id', $studentIds)->delete();

        // Create 30 Aspirations
        $statuses = ['Pending', 'In Progress', 'Resolved', 'Rejected'];
        $aspirations = [];
        for ($i = 1; $i <= 30; $i++) {
            $createdAt = Carbon::now()->subDays(rand(1, 60));
            $aspirations[] = [
                'user_id' => $studentIds[array_rand($studentIds)],
                'category_id' => $catIds[array_rand($catIds)],
                'title' => $faker->sentence(4),
                'description' => $faker->paragraph(2),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $createdAt,
                'updated_at' => (bool)rand(0, 1) ? $createdAt->copy()->addDays(rand(1, 5)) : $createdAt
            ];
        }

        Complaint::insert($aspirations);

        $this->command->info('Dummy data (15 staff, 15 students, 30 aspirasi) berhasil dibuat!');
    }
}
