<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ReviewController; 
use App\Http\Controllers\GroupController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Welcome route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route for dashboard home
Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboards.dashboard');

// Profile routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Course and Enrollment routes (authenticated)
Route::middleware('auth')->group(function () {
    // Show all courses
    Route::get('/courses', [EnrollmentController::class, 'index'])->name('courses.index');

    // Show specific course details
    Route::get('/courses/{id}', [EnrollmentController::class, 'show'])->name('courses.show');

    // Apply logic to restrict enrollments to teachers only
    Route::get('/courses/{course}/enroll', function ($course) {
        if (auth()->user()->isTeacher()) {
            return app(EnrollmentController::class)->create($course);
        }
        return redirect('/dashboard')->with('error', 'Access denied. Only teachers are allowed to enroll students.');
    })->name('enrollments.create');

    // Post route for enrolling a student (restricted to teachers)
    Route::post('/courses/{course}/enroll', function (Request $request, $course) {
        if (auth()->user()->isTeacher()) {
            return app(EnrollmentController::class)->store($request);
        }
        return redirect('/dashboard')->with('error', 'Access denied. Only teachers are allowed to perform this action.');
    })->name('enrollments.store');
});

// Routes related to assessments (authenticated)
Route::middleware('auth')->group(function () {
    // Show specific assessment details or redirect to teacher's view if the user is a teacher
    Route::get('/assessments/{id}', function ($id) {
        if (auth()->user()->isTeacher()) {
            return app(TeacherController::class)->markAssessment($id);
        }

        return app(AssessmentController::class)->show($id);
    })->name('assessments.show');

    // Submit peer review (students)
    Route::post('/assessments/{assessmentId}/review', [AssessmentController::class, 'submitReview'])->name('reviews.store');

    // Teacher access to mark assessments
    Route::get('/assessments/{assessmentId}/mark', function ($assessmentId) {
        if (auth()->user()->isTeacher()) {
            return app(TeacherController::class)->markAssessment($assessmentId);
        }
        return redirect('/dashboard')->with('error', 'Access denied. Only teachers can mark assessments.');
    })->name('assessments.mark');

    // Pagination for teacher marking
    Route::get('/assessments/{assessmentId}/mark/page/{page?}', function ($assessmentId, $page = 1) {
        if (auth()->user()->isTeacher()) {
            return app(TeacherController::class)->markAssessment($assessmentId, $page);
        }
        return redirect('/dashboard')->with('error', 'Access denied. Only teachers can mark assessments.');
    })->name('assessments.mark.paginated');

    // Upload a course information file
    Route::post('/courses/upload', [CourseController::class, 'upload'])->name('courses.upload');

    // Route to show the form for creating a new assessment
    Route::get('/courses/{course}/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');

    // Route to store a newly created assessment
    Route::post('/courses/{course}/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
    
    // Edit assessment form
    Route::get('/assessments/{assessment}/edit', [AssessmentController::class, 'edit'])->name('assessments.edit');

    // Update the assessment
    Route::patch('/assessments/{assessment}', [AssessmentController::class, 'update'])->name('assessments.update');

    // Assign score to a student
    Route::post('/assessments/{assessmentId}/assign-score/{studentId}', [AssessmentController::class, 'assignScore'])->name('assessments.assignScore');
    
    // Routes for assigning groups and viewing assigned groups
    Route::post('/assessments/{assessment}/assign-groups', [GroupController::class, 'assignGroups'])->name('groups.assign');
    Route::get('/assessments/{assessment}/groups', [GroupController::class, 'viewGroups'])->name('groups.view');

    Route::get('/assessments/{assessmentId}/view-score', [AssessmentController::class, 'viewScore'])->name('assessments.view-score');

    Route::post('/reviews/{reviewId}/rate', [AssessmentController::class, 'rateReviewer'])->name('reviews.rate');
});

// Routes related to reviews (authenticated)
Route::middleware('auth')->group(function () {
    // Show reviews for a specific student
    Route::get('/students/{studentId}/reviews', [ReviewController::class, 'show'])->name('reviews.show');

    // Edit a specific review
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');

    // Update a specific review
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
});

require __DIR__.'/auth.php';
