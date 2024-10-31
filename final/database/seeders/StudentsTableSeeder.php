<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use App\Models\Assessment; 

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        
        $courseId = 1;

        // Create an assessment
        $assessment = Assessment::create([
            'course_id' => $courseId,
            'title' => 'Midterm Exam',
            'maximum_score' => 100,
            'instructions' => 'This is the midterm exam instructions.',
            'number_of_reviews' => 3,
            'due_date' => now()->addDays(7),
            'type' => 'teacher-assign'
        ]);

        // Create students and assign them to the assessment
        for ($i = 1; $i <= 50; $i++) {
            $student = User::create([
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@example.com',
                'password' => bcrypt('password'),
                's_number' => 'S' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_type' => 'student'
            ]);

            
            $student->assessments()->attach($assessment->id, ['score' => rand(0, 100)]);
        }
    }
}
