<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use App\Models\Course; 
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = User::where('user_type', 'teacher')->pluck('id')->toArray();
        $courses = Course::pluck('id')->toArray();
        $courseTeacherAssignments = [];

        foreach ($courses as $courseId) {
            $randomTeachers = array_rand($teachers, rand(1, 2)); 
            $randomTeachers = is_array($randomTeachers) ? $randomTeachers : [$randomTeachers];

            foreach ($randomTeachers as $teacherIndex) {
                $courseTeacherAssignments[] = [
                    'course_id' => $courseId,
                    'teacher_id' => $teachers[$teacherIndex],
                ];
            }
        }

    
        DB::table('course_teacher')->insert($courseTeacherAssignments);
    }
}
