<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Response;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Insert Users (Admin, Staff, Student)
        $admin = User::create([
            'identity_number' => 'admin1',
            'full_name' => 'Super Administrator',
            'password' => Hash::make('123'),
            'role' => 'admin',
            'phone_number' => '08111111',
        ]);

        $staff = User::create([
            'identity_number' => 'staff1',
            'full_name' => 'Mr. Budi (Maintenance)',
            'password' => Hash::make('123'),
            'role' => 'staff',
            'phone_number' => '08222222',
        ]);

        $student = User::create([
            'identity_number' => '102030',
            'full_name' => 'John Doe',
            'class_name' => 'XII Science 1',
            'password' => Hash::make('102030'),
            'role' => 'student',
            'phone_number' => '08999999',
        ]);

        // 2. Insert Categories
        $catFacilities = Category::create(['category_name' => 'Classroom Facilities']);
        $catCleanliness = Category::create(['category_name' => 'Cleanliness']);
        $catSecurity = Category::create(['category_name' => 'Security']);

        // 3. Insert Complaints (Aspirasi)
        $complaint1 = Complaint::create([
            'user_id' => $student->user_id,
            'category_id' => $catFacilities->category_id,
            'title' => 'AC in Class XII Science 1 is broken',
            'description' => 'The AC has been leaking water since yesterday and it is not cooling the room at all.',
            'status' => 'In Progress',
        ]);

        $complaint2 = Complaint::create([
            'user_id' => $student->user_id,
            'category_id' => $catCleanliness->category_id,
            'title' => 'Trash bins are full',
            'description' => 'The trash bins near the basketball court are extremely full and scattering.',
            'status' => 'Pending',
        ]);

        // 4. Insert Responses
        Response::create([
            'complaint_id' => $complaint1->complaint_id,
            'user_id' => $admin->user_id,
            'message' => 'Noted, we have forwarded this issue to the maintenance team. Please wait.',
        ]);

        Response::create([
            'complaint_id' => $complaint1->complaint_id,
            'user_id' => $staff->user_id,
            'message' => 'I am currently checking the AC unit and replacing the filter.',
        ]);

        // Call the faker-based dummy data seeder
        $this->call(TestingDummyDataSeeder::class);
    }
}
