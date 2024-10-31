<?php
namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Mark assessments for a specific course.
     */
    public function markAssessment($assessmentId)
    {
        // Find the assessment or fail with a 404 error
        $assessment = Assessment::findOrFail($assessmentId);

        // This keeps the pagination intact
        $students = $assessment->course->students()->paginate(10);

        // Map each student to include submitted and received reviews
        $studentsWithReviews = $students->map(function ($student) use ($assessment) {
            return [
                'student' => $student,
                'submitted_reviews' => Review::where('reviewer_id', $student->id)
                    ->where('assessment_id', $assessment->id)
                    ->count(),
                'received_reviews' => Review::where('reviewee_id', $student->id)
                    ->where('assessment_id', $assessment->id)
                    ->count(),
            ];
        });

        $students->setCollection($studentsWithReviews);

        // Return the view, passing the necessary variables
        return view('assessments.teacher', compact('assessment', 'students'));
    }

    /**
     * Assign score to a student.
     */
    public function assignScore(Request $request, $assessmentId, $studentId)
    {
        // Retrieve the assessment and student models
        $assessment = Assessment::findOrFail($assessmentId);
        $student = User::findOrFail($studentId);

        // Validate the input score
        $request->validate([
            'score' => 'required|integer|min:0|max:' . $assessment->maximum_score,
        ]);

        // Update the pivot table with the score for this student in this assessment
        $assessment->students()->updateExistingPivot($studentId, ['score' => $request->score]);

      
        return redirect()->back()->with('success', 'Score assigned successfully!');
    }
}
