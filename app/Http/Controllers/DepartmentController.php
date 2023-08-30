<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\User;
use App\Http\Requests\StoredepartmentRequest;
use App\Http\Requests\UpdatedepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = department::all();
        return view('work_structure.department.department', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('work_structure.department.departmentAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredepartmentRequest $request)
    {
        Department::create($request->validated());
        return redirect()->back()->with('success', 'Section added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(department $department)
    {
        return view('work_structure.department.departmentEdit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedepartmentRequest $request, department $department)
    { 
        $department->update([
            'name' => $request->input('name'), 
            'status' => $request->input('status'),
        ]);
        return redirect()->route('department.index')
        ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(department $department)
    {
        $department->delete();
        return redirect()->route('department.index')->with('success', 'Department Deleted Successfully!!!');
    }
}
