<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assessments')->insert([
            [
                'course_id' => 1,
                'title' => 'Week 1 Peer Review',
                'instructions' => 'Provide feedback on week 1 assignments.', 
                'number_of_reviews' => 2,
                'maximum_score' => 100,
                'due_date' => Carbon::now()->addDays(7),
                'type' => 'student-select',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_id' => 2,
                'title' => 'Week 2 Peer Review',
                'instructions' => 'Provide feedback on week 2 assignments.',
                'number_of_reviews' => 3,
                'maximum_score' => 100,
                'due_date' => Carbon::now()->addDays(7),
                'type' => 'teacher-assign',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // New assessments
            [
                'course_id' => 3,
                'title' => 'Midterm Project Review',
                'instructions' => 'Provide peer feedback on the midterm project.',
                'number_of_reviews' => 3,
                'maximum_score' => 50,
                'due_date' => Carbon::now()->addDays(10),
                'type' => 'student-select',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_id' => 4,
                'title' => 'Database Design Critique',
                'instructions' => 'Review your peer\'s database design and suggest improvements.',
                'number_of_reviews' => 2,
                'maximum_score' => 80,
                'due_date' => Carbon::now()->addDays(5),
                'type' => 'teacher-assign',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_id' => 5,
                'title' => 'Final Project Evaluation',
                'instructions' => 'Evaluate your peer\'s final project for the course.',
                'number_of_reviews' => 5,
                'maximum_score' => 100,
                'due_date' => Carbon::now()->addDays(14),
                'type' => 'student-select',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_id' => 6,
                'title' => 'Network Design Peer Review',
                'instructions' => 'Provide feedback on your peer\'s network design.',
                'number_of_reviews' => 3,
                'maximum_score' => 75,
                'due_date' => Carbon::now()->addDays(7),
                'type' => 'teacher-assign',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
