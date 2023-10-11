<?php

namespace App\Http\Controllers\Leave\Approval;

use App\Http\Controllers\Controller;
use App\Models\applied_leave;
use App\Models\approvalRule;
use App\Models\approval_condition;
use App\Models\level;
use App\Http\Requests\StoreleaveApprovalRequest;
use App\Http\Requests\UpdateleaveApprovalRequest;
use Illuminate\Http\Request;
use App\Mail\LeaveApplicationMail;
use Illuminate\Support\Facades\Mail;

class LeaveApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sectionHeadId = auth()->user()->section_id;

        // Query leave applications for the section head's section
        $leaveApplications = Applied_Leave::whereHas('user.section', function ($query) use ($sectionHeadId) {
            $query->where('id', $sectionHeadId);
        })->get();


        return view('leave.approval.leaveApproval', compact('leaveApplications'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreleaveApprovalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(leaveApproval $leaveApproval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leaveApproval $leaveApproval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateleaveApprovalRequest $request, leaveApproval $leaveApproval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leaveApproval $leaveApproval)
    {
        //
    }

    public function approveLeave(Request $request, $id)
    {
        // Find the leave application by ID
        $leaveApplication = applied_leave::findOrFail($id);
        $leave_id = $leaveApplication->leave_id;
        $approvalRuleId = approvalRule::where('type_id', $leave_id)->value('id');
        $approvalType = approval_condition::where('approval_rule_id', $approvalRuleId)->first();
        $hierarchy_id = $approvalType->hierarchy_id;

        if ($leaveApplication->level1 === 'pending' && $approvalType->MaxLevel === 'Level1') {
            // Update the leave application fields
            $leaveApplication->update([
                'level1' => 'approved',
                'status' => 'approved',
            ]);
        
            Mail::to($recipient)->send(new LeaveApplicationMail($user, $startDate, $endDate, $currentUser));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Leave application approved successfully.');
        } else {
            // Handle cases where the leave application cannot be approved (e.g., it's not at the expected level or already approved)
            return redirect()->back()->with('error', 'Leave application cannot be approved.');
        }
    }
    
}
