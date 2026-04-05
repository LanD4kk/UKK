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
        // Setup categories
        $categories = ['Fasilitas', 'Akademik', 'Pelayanan', 'Lainnya'];
        $catIds = [];
        foreach ($categories as $cat) {
            $category = Category::firstOrCreate(['category_name' => $cat]);
            $catIds[$cat] = $category->category_id;
        }

        // Create Staff
        User::firstOrCreate(
            ['identity_number' => 'STAFF001'],
            [
                'full_name' => 'Bapak Staff Satu',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone_number' => '081111111111'
            ]
        );

        User::firstOrCreate(
            ['identity_number' => 'STAFF002'],
            [
                'full_name' => 'Ibu Staff Dua',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone_number' => '082222222222'
            ]
        );

        // Create Students
        $student1 = User::firstOrCreate(
            ['identity_number' => 'STU001'],
            [
                'full_name' => 'Andi Siswa',
                'class_name' => 'XI-RPL-1',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone_number' => '083333333333'
            ]
        );

        $student2 = User::firstOrCreate(
            ['identity_number' => 'STU002'],
            [
                'full_name' => 'Budi Murid',
                'class_name' => 'XI-RPL-2',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone_number' => '084444444444'
            ]
        );

        $student3 = User::firstOrCreate(
            ['identity_number' => 'STU003'],
            [
                'full_name' => 'Citra Pelajar',
                'class_name' => 'XI-RPL-3',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone_number' => '085555555555'
            ]
        );

        // Clear their existing complaints just in case they have it
        Complaint::whereIn('user_id', [$student1->user_id, $student2->user_id, $student3->user_id])->delete();

        // Create varying aspirations
        $aspirations = [
            // Student 1
            [
                'user_id' => $student1->user_id,
                'category_id' => $catIds['Fasilitas'],
                'title' => 'Kerusakan Bangku Kelas',
                'description' => 'Ada 3 bangku reyot di kelas XI-RPL-1.',
                'status' => 'Pending',
                'created_at' => Carbon::parse('2026-03-15 10:00:00'),
                'updated_at' => Carbon::parse('2026-03-15 10:00:00')
            ],
            [
                'user_id' => $student1->user_id,
                'category_id' => $catIds['Pelayanan'],
                'title' => 'Antrian Kantin',
                'description' => 'Kantin sangat antri saat jam istirahat pertama.',
                'status' => 'Resolved',
                'created_at' => Carbon::parse('2026-02-10 12:30:00'),
                'updated_at' => Carbon::parse('2026-02-12 09:00:00')
            ],
            // Student 2
            [
                'user_id' => $student2->user_id,
                'category_id' => $catIds['Akademik'],
                'title' => 'Jadwal Bentrok',
                'description' => 'Jadwal ekskul bentrok dengan les tambahan.',
                'status' => 'In Progress',
                'created_at' => Carbon::parse('2026-04-01 14:15:00'),
                'updated_at' => Carbon::parse('2026-04-02 08:00:00')
            ],
            [
                'user_id' => $student2->user_id,
                'category_id' => $catIds['Fasilitas'],
                'title' => 'AC Mati',
                'description' => 'AC di perpus mati dari kemarin.',
                'status' => 'Rejected',
                'created_at' => Carbon::parse('2025-12-20 09:00:00'),
                'updated_at' => Carbon::parse('2025-12-21 10:00:00')
            ],
            // Student 3
            [
                'user_id' => $student3->user_id,
                'category_id' => $catIds['Lainnya'],
                'title' => 'Parkiran Motor',
                'description' => 'Parkiran motor kurang luas untuk siswa kelas XI.',
                'status' => 'Pending',
                'created_at' => Carbon::parse('2026-04-02 07:30:00'),
                'updated_at' => Carbon::parse('2026-04-02 07:30:00')
            ],
            [
                'user_id' => $student3->user_id,
                'category_id' => $catIds['Pelayanan'],
                'title' => 'Petugas TU jutek',
                'description' => 'Petugas TU kurang ramah saat mengurus surat izin.',
                'status' => 'Resolved',
                'created_at' => Carbon::parse('2026-01-05 11:00:00'),
                'updated_at' => Carbon::parse('2026-01-07 10:00:00')
            ],
        ];

        Complaint::insert($aspirations);

        $this->command->info('Dummy data (2 staff, 3 students) dengan variasi aspirasi berhasil dibuat!');
    }
}
