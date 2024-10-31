<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Teachers
        $teachers = [
            ['name' => 'Sophia Johnson', 'email' => 'sophia.johnson@example.com', 's_number' => 'S0001', 'user_type' => 'teacher', 'password' => bcrypt('password')],
            ['name' => 'Samuel Thompson', 'email' => 'samuel.thompson@example.com', 's_number' => 'S0002', 'user_type' => 'teacher', 'password' => bcrypt('password')],
            ['name' => 'Olivia Martinez', 'email' => 'olivia.martinez@example.com', 's_number' => 'S0006', 'user_type' => 'teacher', 'password' => bcrypt('password')],
            ['name' => 'James Wilson', 'email' => 'james.wilson@example.com', 's_number' => 'S0007', 'user_type' => 'teacher', 'password' => bcrypt('password')],
        ];

        foreach ($teachers as $teacher) {
            if (!User::where('s_number', $teacher['s_number'])->exists()) {
                User::create($teacher);
            }
        }

        // Students
        $students = [
            ['name' => 'Samantha Brown', 'email' => 'samantha.brown@example.com', 's_number' => 'S0003', 'user_type' => 'student', 'password' => bcrypt('password')],
            ['name' => 'Steven Garcia', 'email' => 'steven.garcia@example.com', 's_number' => 'S0004', 'user_type' => 'student', 'password' => bcrypt('password')],
            ['name' => 'Sarah Miller', 'email' => 'sarah.miller@example.com', 's_number' => 'S0005', 'user_type' => 'student', 'password' => bcrypt('password')],
            ['name' => 'Emma Taylor', 'email' => 'emma.taylor@example.com', 's_number' => 'S0008', 'user_type' => 'student', 'password' => bcrypt('password')],
            ['name' => 'Liam Anderson', 'email' => 'liam.anderson@example.com', 's_number' => 'S0009', 'user_type' => 'student', 'password' => bcrypt('password')],
        ];

        foreach ($students as $student) {
            if (!User::where('s_number', $student['s_number'])->exists()) {
                User::create($student);
            }
        }
    }
}
