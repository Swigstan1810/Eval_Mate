<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Show the details of a specific assessment.
     */
    public function show($id)
    {
        $assessment = Assessment::with('course.teachers', 'course.students', 'reviews')->findOrFail($id);
        $user = Auth::user();
        
        // Check if the user is a teacher of this course
        if ($user->isTeacher()) {
            // If teacher, check if they belong to the course
            if (!$assessment->course->teachers->contains($user->id)) {
                return redirect()->back()->with('error', 'Access denied. You are not a teacher of this course.');
            }

            // Fetch the students in the course except the teacher
            $otherStudents = $assessment->course->students;

            // Get all reviews for the teacher to mark
            $submittedReviews = Review::where('assessment_id', $assessment->id)->get();

            // Get reviews received by students
            $receivedReviews = Review::whereIn('reviewee_id', $assessment->course->students->pluck('id'))
                ->where('assessment_id', $assessment->id)
                ->get();

            return view('assessments.teacher', compact(
                'assessment', 
                'otherStudents', 
                'submittedReviews', 
                'receivedReviews'
            ));
        } else {
            // If the user is a student, allow them to submit their peer reviews
            if (!$assessment->course->students->contains($user->id)) {
                return redirect()->back()->with('error', 'Access denied. You are not enrolled in this course.');
            }

            // Fetch the students in the course except the current student
            $otherStudents = $assessment->course->students->except($user->id);

            // Get the reviews this student has already submitted
            $submittedReviews = Review::where('reviewer_id', $user->id)
                ->where('assessment_id', $assessment->id)
                ->get();

            // Get the ids of students that this user has already reviewed
            $alreadyReviewedIds = $submittedReviews->pluck('reviewee_id')->toArray();

            // Get the reviews received by this student
            $receivedReviews = Review::where('reviewee_id', $user->id)
                ->where('assessment_id', $assessment->id)
                ->get();

            return view('assessments.student', compact(
                'assessment', 
                'otherStudents', 
                'submittedReviews', 
                'alreadyReviewedIds', 
                'receivedReviews'
            ));
        }
    }

    /**
     * Show the form for creating a new assessment.
     */
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('assessments.create', compact('course'));
    }

    /**
     * Store a newly created assessment.
     */
    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|max:50',
            'instructions' => 'required',
            'number_of_reviews' => 'required|integer|min:1',
            'maximum_score' => 'required|integer|min:1|max:100',
            'due_date' => 'required|date',
            'type' => 'required|in:student-select,teacher-assign',
        ]);

        // Create the new assessment
        $course->assessments()->create($validated);

        return redirect()->route('courses.show', $courseId)->with('success', 'Assessment added successfully.');
    }

    /**
     * Show the form for editing an assessment.
     */
    public function edit($id)
    {
        $assessment = Assessment::findOrFail($id);

        // Prevent editing if there are already submissions
        if ($assessment->reviews()->exists()) {
            return redirect()->back()->with('error', 'Assessment cannot be edited as there are submissions.');
        }

        return view('assessments.edit', compact('assessment'));
    }

    /**
     * Update an existing assessment.
     */
    public function update(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        // Prevent updating if there are already submissions
        if ($assessment->reviews()->exists()) {
            return redirect()->back()->with('error', 'Assessment cannot be edited as there are submissions.');
        }

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|max:50',
            'instructions' => 'required',
            'number_of_reviews' => 'required|integer|min:1',
            'maximum_score' => 'required|integer|min:1|max:100',
            'due_date' => 'required|date',
            'type' => 'required|in:student-select,teacher-assign',
        ]);

        // Update the assessment
        $assessment->update($validated);

        return redirect()->route('courses.show', $assessment->course_id)->with('success', 'Assessment updated successfully.');
    }


    /**
     * Submit a peer review (for students).
     */
    public function submitReview(Request $request, $assessmentId)
    {
        
        
        $assessment = Assessment::findOrFail($assessmentId);
        $user = Auth::user();

        // Validate the input
        $request->validate([
            'reviewee_id' => 'required|exists:users,id',
            'content' => 'required|min:5',
            'score' => 'required|integer|min:1|max:100',
        ]);

       

        // Ensure the student has not already reviewed this reviewee for this assessment
        if (Review::where('assessment_id', $assessmentId)
            ->where('reviewer_id', $user->id)
            ->where('reviewee_id', $request->reviewee_id)
            ->exists()) {
            return redirect()->back()->withErrors('You have already reviewed this student.');
        }

        // Store the review
        Review::create([
            'assessment_id' => $assessmentId,
            'reviewer_id' => $user->id,
            'reviewee_id' => $request->reviewee_id,
            'score' => $request->score,
            'content' => $request->content,
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    
    public function assignScore(Request $request, $assessmentId, $studentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        $student = User::findOrFail($studentId);

        // Validate the score
        $request->validate([
            'score' => 'required|integer|min:0|max:' . $assessment->maximum_score,
        ]);

        // Assign score to the student (you might have a score field in the pivot table)
        $assessment->students()->updateExistingPivot($studentId, ['score' => $request->score]);

        return redirect()->back()->with('success', 'Score assigned successfully!');
    }

    public function viewScore($assessmentId)
    {
        $assessment = Assessment::with('course.teachers', 'course.students')->findOrFail($assessmentId);
        $user = Auth::user();

        // Check if the user is a student or teacher
        if ($user->isStudent()) {
            // Check if the user is enrolled in the course
            if (!$assessment->course->students->contains($user->id)) {
                return redirect()->back()->with('error', 'Access denied. You are not enrolled in this course.');
            }

            // Get the student's score
            $score = $assessment->students()->where('student_id', $user->id)->first()->pivot->score;

            return view('assessments.view-score', compact('assessment', 'score'));
        } elseif ($user->isTeacher()) {
            // Fetch all students and their scores
            $students = $assessment->course->students()->withPivot('score')->get();

            return view('assessments.view-scores', compact('assessment', 'students'));
        }

        return redirect()->back()->with('error', 'Unauthorized access.');
    }


   


}
