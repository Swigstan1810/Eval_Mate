<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            ['course_code' => 'CSE101', 'name' => 'Introduction to Computer Science', 'teacher_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE102', 'name' => 'Data Structures and Algorithms', 'teacher_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE201', 'name' => 'Software Engineering', 'teacher_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE202', 'name' => 'Database Management Systems', 'teacher_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE203', 'name' => 'Web Development', 'teacher_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE204', 'name' => 'Computer Networks', 'teacher_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE205', 'name' => 'Operating Systems', 'teacher_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE301', 'name' => 'Mobile Application Development', 'teacher_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE302', 'name' => 'Cybersecurity Fundamentals', 'teacher_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE303', 'name' => 'Artificial Intelligence', 'teacher_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE304', 'name' => 'Machine Learning', 'teacher_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE305', 'name' => 'Cloud Computing', 'teacher_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            // New courses
            ['course_code' => 'CSE306', 'name' => 'Computer Vision', 'teacher_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE307', 'name' => 'Deep Learning', 'teacher_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE308', 'name' => 'Data Science', 'teacher_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['course_code' => 'CSE309', 'name' => 'Human-Computer Interaction', 'teacher_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
