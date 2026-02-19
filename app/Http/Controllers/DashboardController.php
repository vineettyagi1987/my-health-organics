<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }


public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'phone' => 'required|string|max:15',
    ]);

    $user->update([
        'name'  => $request->name,
        'phone' => $request->phone,
    ]);

    return back()->with('success', 'Profile updated successfully.');
}
}

