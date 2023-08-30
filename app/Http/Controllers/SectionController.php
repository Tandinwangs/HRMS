<?php

namespace App\Http\Controllers;

use App\Models\section;
use App\Models\department;
use App\Http\Requests\StoresectionRequest;
use App\Http\Requests\UpdatesectionRequest;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::all();
        return view('work_structure.section.section', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = department::all();
        return view('work_structure.section.sectionAdd', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoresectionRequest $request)
    {
        Section::create($request->validated());
    
        return redirect()->back()->with('success', 'Section added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        $departments = department::all();
        return view('work_structure.section.section.sectionEdit', compact('departments', 'section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesectionRequest $request, section $section)
    {
        $section->update($request->validated());
        return redirect()->route('section.index')
        ->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(section $section)
    {
        $section->delete();
        return redirect()->route('section.index')->with('success', 'Section Deleted Successfully!!!');
    }

    public function getSectionsByDepartment($department)
    {
        $sections = Section::where('department', $department)->get();
        return response()->json(['sections' => $sections]); 
    }
}

