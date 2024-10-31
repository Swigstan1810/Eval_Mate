<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Handle course creation via file upload.
     */
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:txt|max:2048',
        ]);

        // Log the uploaded file details
        Log::info('File uploaded:', [$request->file('file')->getClientOriginalName()]);

        // Read file content
        $fileContent = file_get_contents($request->file('file')->getRealPath());
        Log::info('File content:', [$fileContent]);

        // Parse the file content into lines
        $lines = explode(PHP_EOL, $fileContent);

        // Initialize course data
        $courseData = [];
        $students = [];
        $assessments = [];

        // Process each line in the file
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            Log::info('Processing line:', [$line]);

            // Parse course information
            if (strpos($line, 'Course:') === 0) {
                $courseInfo = explode(',', substr($line, 7)); // Remove "Course:"
                if (count($courseInfo) >= 2) {
                    $courseData['course_code'] = trim($courseInfo[0]); // Ensure no extra spaces
                    $courseData['name'] = trim($courseInfo[1]); // Ensure no extra spaces
                    Log::info('Parsed course data:', $courseData);
                } else {
                    return redirect()->back()->withErrors('Invalid course information format.');
                }
            }
            // Parse teacher information
            elseif (strpos($line, 'Teacher:') === 0) {
                $teacherEmail = substr($line, 8); // Remove "Teacher:"
                $teacher = User::where('email', $teacherEmail)->first();
                if ($teacher && $teacher->isTeacher()) {
                    $courseData['teacher_id'] = $teacher->id;
                    Log::info('Teacher found:', [$teacherEmail, $teacher->id]);
                } else {
                    return redirect()->back()->withErrors("Teacher with email $teacherEmail not found or not a teacher.");
                }
            }
            // Parse student information
            elseif (strpos($line, 'Student:') === 0) {
                $studentEmail = substr($line, 8); // Remove "Student:"
                $student = User::where('email', $studentEmail)->first();
                if ($student && $student->isStudent()) {
                    $students[] = $student->id;
                    Log::info('Student added:', [$studentEmail, $student->id]);
                } else {
                    Log::warning('Student not found or not a student:', [$studentEmail]);
                }
            }
            // Parse assessment information
            elseif (strpos($line, 'Assessment:') === 0) {
                $assessmentInfo = explode(',', substr($line, 11)); // Remove "Assessment:" and explode by comma
                if (count($assessmentInfo) == 6) { // Check if the right amount of data is present
                    $assessments[] = [
                        'title' => trim($assessmentInfo[0]),
                        'instructions' => trim($assessmentInfo[1]),
                        'number_of_reviews' => (int)$assessmentInfo[2],
                        'maximum_score' => (int)$assessmentInfo[3],
                        'due_date' => trim($assessmentInfo[4]),
                        'type' => trim($assessmentInfo[5]),
                    ];
                    Log::info('Assessment added:', [$assessmentInfo]);
                } else {
                    return redirect()->back()->withErrors('Invalid assessment information format.');
                }
            }
        }

        // Log the complete course data before creation
        Log::info('Final course data:', $courseData);

        if (empty($courseData['course_code']) || empty($courseData['name'])) {
            return redirect()->back()->withErrors('Course code and name are required.');
        }

        // Check if the course with the same course code already exists
        $existingCourse = Course::where('course_code', $courseData['course_code'])->first();
        if ($existingCourse) {
            return redirect()->back()->withErrors('A course with this course code already exists.');
        }

        // Create the new course
        try {
            $course = Course::create([
                'course_code' => $courseData['course_code'],
                'name' => $courseData['name'],
                'teacher_id' => $courseData['teacher_id'] ?? null,
            ]);
            Log::info('Course created successfully:', ['course' => $course]);

            // Enroll the students in the course
            if (!empty($students)) {
                $course->students()->sync($students);
                Log::info('Students enrolled:', $students);
            }

            // Add assessments to the course
            foreach ($assessments as $assessment) {
                $course->assessments()->create($assessment);
                Log::info('Assessment created for course:', [$assessment]);
            }

            return redirect()->route('courses.index')->with('success', 'Course created successfully.');

        } catch (\Exception $e) {
            Log::error('Course creation failed:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Failed to create the course. Please try again.');
        }
    }
}
