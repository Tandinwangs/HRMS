<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\department;
use App\Models\section;
use App\Models\role;
use App\Models\designation;
use App\Models\grade;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    protected $adminController;

    public function __construct(AdminController $adminController)
    {
        $this->adminController = $adminController;
    }

    public function create(): View
    {
        // Fetch departments and sections using the injected adminController instance
        $departments = department::all();
        $roles = role::all();
        $designations = Designation::all();
        $grades = Grade::all();
        return view('auth.register', compact('departments', 'roles', 'designations', 'grades'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Use 'users' table name
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department' => ['required', 'exists:departments,id'], // Validate department
            'section' => ['required', 'exists:sections,id'], // Validate section
            'role' => ['required', 'exists:roles,id'], // Validate role
            'designation' => ['required', 'exists:designations,id'],
            'grade' => ['required', 'exists:grades,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department' => $request->department,
            'section' => $request->section,
            'role' => $request->role,
            'designation' => $request->designation,
            'grade' => $request->grade,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
