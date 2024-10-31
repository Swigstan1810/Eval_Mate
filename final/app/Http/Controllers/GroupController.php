<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    /**
     * Method to assign groups to students for a given assessment.
     *
     * @param Request $request
     * @param int $assessmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignGroups(Request $request, $assessmentId)
    {
        $user = auth()->user();

   
        
        // Ensure the user is a teacher
        if ($user->role !== 'teacher') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        // Find the assessment
        $assessment = Assessment::findOrFail($assessmentId);
        // Get all students
        $students = User::where('role', 'student')->get();

        // Group students into random groups
        $groups = [];
        foreach ($students as $student) {
            // Randomly assign to one of the groups (1-5 in this example)
            $groupNumber = rand(1, 5); 
            if (!isset($groups[$groupNumber])) {
                $groups[$groupNumber] = [];
            }
            $groups[$groupNumber][] = $student->id;
        }

        // Save each group and assign users to the group
        foreach ($groups as $groupNumber => $studentIds) {
            $group = Group::create([
                'name' => "Group $groupNumber",
                'course_id' => $assessment->course_id, // Link to the course
            ]);

    

            // Assign students to the created group
            foreach ($studentIds as $studentId) {
                $group->users()->attach($studentId);
                }
        }

        return redirect()->route('groups.view', $assessment->id)->with('success', 'Groups assigned successfully');
    }

    /**
     * Method to view assigned groups for a given assessment.
     *
     * @param int $assessmentId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewGroups($assessmentId)
    {
        $user = auth()->user();
        
        // Ensure only teachers can view groups
        if ($user->role !== 'teacher') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        // Find the assessment
        $assessment = Assessment::findOrFail($assessmentId);
        // Retrieve groups associated with the assessment
        $groups = Group::with('users')->where('course_id', $assessment->course_id)->get();

        return view('groups.view', compact('assessment', 'groups'));
    }
}
