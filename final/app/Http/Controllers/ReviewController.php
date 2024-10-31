<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Assessment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a list of peer reviews for a specific student.
     *
     * @param int $studentId
     * @return \Illuminate\View\View
     */
    public function show($studentId)
    {
        // Find the student by ID
        $student = User::findOrFail($studentId);

        // Get all reviews that this student has submitted or received
        $submittedReviews = Review::where('reviewer_id', $studentId)->get();
        $receivedReviews = Review::where('reviewee_id', $studentId)->get();

        // Pass the reviews to the view
        return view('reviews.show', compact('student', 'submittedReviews', 'receivedReviews'));
    }

    /**
     * Show the form for editing a specific peer review.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Find the review by ID
        $review = Review::findOrFail($id);

        // Pass the review to the edit form
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        // Find the review by ID
        $review = Review::findOrFail($id);

        // Update the review with new data
        $review->rating = $validatedData['rating'];
        $review->feedback = $validatedData['feedback'];
        $review->save();

        // Redirect back with a success message
        return redirect()->route('reviews.show', $review->reviewee_id)
                         ->with('success', 'Review updated successfully.');
    }
}
