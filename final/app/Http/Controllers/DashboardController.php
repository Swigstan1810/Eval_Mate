<?php

namespace App\Http\Controllers;
use App\Models\Review;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch top reviewers for leaderboard
        $topReviewers = Review::select('reviewer_id')
            ->selectRaw('AVG(score) as average_score')
            ->with('reviewer') 
            ->groupBy('reviewer_id')
            ->orderBy('average_score', 'DESC')
            ->take(5)
            ->get();

        if ($user->isStudent()) {
            // Retrieve the courses the student is enrolled in
            $courses = $user->enrolledCourses;

            // Return a view specifically for students to see their enrolled courses
            return view('courses.index', compact('courses', 'topReviewers'));
        } elseif ($user->isTeacher()) {
            // Retrieve the courses the teacher is teaching
            $courses = $user->teachingCourses;

            // Return the dashboard view for teachers with courses and top reviewers
            return view('Dashboards.dashboard', compact('courses', 'topReviewers'));
        } else {
            // Empty collection if neither student nor teacher
            $courses = collect();
            return view('Dashboards.dashboard', compact('courses', 'topReviewers'));
        }
    }

}
