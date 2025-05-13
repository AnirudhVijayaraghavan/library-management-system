<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
        $gateAuthorization = Gate::inspect('update', auth()->user());
        if ($gateAuthorization->denied()) {
            return redirect()->route('dashboard')->with('failure', 'Unauthorized.');
        }
        return Inertia::render('Users/Profile/Edit', [
            'user' => auth()->user()->only('name', 'email'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $user = $request->user();
        // $this->authorize('update', $user);
        $gateAuthorization = Gate::inspect('update', $user);
        if ($gateAuthorization->denied()) {
            return redirect()->route('dashboard')->with('failure', 'Unauthorized.');
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($data);

        return redirect()->route('dashboard')->with('success', 'Profile updated.');
    }
    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $gateAuthorization = Gate::inspect('update', $user);
        if ($gateAuthorization->denied()) {
            return redirect()->route('dashboard')->with('failure', 'Unauthorized.');
        }

        $data = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return redirect()->route('dashboard')->with('failure', 'Wrong current password.');
        }

        $user->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('dashboard')->with('success', 'Password changed.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
