<?php

namespace App\Http\Controllers\NoDue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\NoDueRequestApproval;
use App\models\NoDueRequest;
use App\models\User;

class NoDueRequestApprovalController extends Controller
{

    public function index() 
    {
        $userID = auth()->user()->id;
        $requests = NoDueRequestApproval::where('user_id', $userID)->get();
        return view('nodue.no_due_requests.approval', compact('requests'));
    }

    public function approve(Request $request, $id)
    {
        // Approve a request
        $approval = NoDueRequestApproval::findOrFail($id);
        $approval->status = 'approved';
        $approval->save();

        // Check if all section heads within a department have approved
        if ($this->checkSectionApproval($approval->noDueRequest)) {
            $departmentID = auth()->user()->department_id;

            $departmentHead = User::where('department_id', $departmentID)
                ->whereHas('designation', function ($query) {
                    $query->where('name', 'Department Head');
                })
                ->first();

                NoDueRequestApproval::create([
                    'no_due_request_id' => $approval->noDueRequest->id,
                    'user_id' => $departmentHead->id,
                    'status' => 'pending',
                ]);

            // Send notification to the department head and update the status
            $approval->noDueRequest->status = 'approved';
            $approval->noDueRequest->save();
        }

        return redirect()->route('nodueapproval.index', $approval->no_due_request_id);
    }

    public function decline(Request $request, $id)
    {
        // Decline a request
        $approval = NoDueRequestApproval::findOrFail($id);
        $approval->status = 'declined';
        $approval->save();

        // Update the status of the request
        $approval->noDueRequest->status = 'declined';
        $approval->noDueRequest->save();

        return redirect()->route('nodueapproval.index', $approval->no_due_request_id);
    }

    private function checkSectionApproval(NoDueRequest $request)
    {
        $department = $request->user->department; // Assuming the User model has a 'department' relationship

        $sectionHeads = $department->users()
        ->whereHas('designation', function ($query) {
            $query->where('name', 'Section Head');
        })->get();
    
        
        foreach ($sectionHeads as $sectionHead) {
            $approval = NoDueRequestApproval::where('no_due_request_id', $request->id)
                ->where('user_id', $sectionHead->id)
                ->first();

            if (!$approval || $approval->status !== 'approved') {
                return false; // Not all section heads have approved
            }
        }

        return true; // All section heads in the department have approved
    }
}