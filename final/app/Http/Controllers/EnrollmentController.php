<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Show all available courses.
     */
    public function index()
    {
        $courses = Course::all();
        $user = auth()->user();

        // Get newly enrolled courses for the authenticated user
        $newlyEnrolledCourses = $user->enrolledCourses()->get();

        return view('courses.index', compact('courses', 'newlyEnrolledCourses'));
    }

    /**
     * Display the specified course details.
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        $assessments = $course->assessments;
        return view('courses.show', compact('course', 'assessments'));
    }

    /**
     * Show the form for enrolling in a specific course.
     */
    public function create($courseId)
    {   
        $course = Course::findOrFail($courseId);
        $students = User::where('user_type', 'student')->get();
    
        return view('enrollments.create', compact('course', 'students'));
    
    }

    /**
     * Store the enrollment information.
     */
        public function store(Request $request)
    {
        // Validate the request to ensure 'student_id' and 'course_id' are present and valid
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Retrieve the course and student
        $course = Course::findOrFail($request->input('course_id'));
        $studentId = $request->input('student_id');

        // Check if the student is already enrolled in this course
        if ($course->students()->where('user_id', $studentId)->exists()) { // Change 'student_id' to 'user_id'
            return redirect()->route('courses.index')->with('error', 'Student is already enrolled in this course.');
        }

        // Enroll the student into the course
        $course->students()->attach($studentId);

        return redirect()->route('courses.index')->with('success', 'Student enrolled successfully!');
    }


}
