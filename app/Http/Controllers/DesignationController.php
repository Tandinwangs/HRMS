<?php

namespace App\Http\Controllers;

use App\Models\designation;
use App\Http\Requests\StoredesignationRequest;
use App\Http\Requests\UpdatedesignationRequest;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = designation::all();
        return view('work_structure.designation.designation', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('work_structure.designation.designationAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredesignationRequest $request)
    {
        Designation::create($request->validated());
        return redirect()->back()->with('success', 'Designation added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(designation $designation)
    {
        return view('work_structure.designation.designationEdit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedesignationRequest $request, designation $designation)
    {
        $designation->update($request->validated());
        return redirect()->route('designation.index')
        ->with('success', 'Designation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(designation $designation)
    {
        $designation->delete();
        return redirect()->route('designation.index')->with('success', 'Designation Deleted Successfully!!!');
    }
}
