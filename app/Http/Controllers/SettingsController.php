<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('pages.settings', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success_profile', 'Profile updated successfully.');
    }

    public function updateHealth(Request $request)
    {
        $request->validate([
            'blood_group'  => 'nullable|string|max:10',
            'date_of_birth'=> 'nullable|date',
            'gender'       => 'nullable|in:male,female,other',
            'height'       => 'nullable|numeric|min:50|max:250',
            'weight'       => 'nullable|numeric|min:10|max:300',
            'allergies'    => 'nullable|string|max:500',
            'conditions'   => 'nullable|string|max:500',
            'medications'  => 'nullable|string|max:500',
        ]);

        auth()->user()->update($request->only([
            'blood_group', 'date_of_birth', 'gender',
            'height', 'weight', 'allergies', 'conditions', 'medications',
        ]));

        return back()->with('success_health', 'Health profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])->with('tab', 'password');
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success_password', 'Password changed successfully.');
    }

    public function updateNotifications(Request $request)
    {
        auth()->user()->update([
            'notif_consultations' => $request->boolean('notif_consultations'),
            'notif_lab_reports'   => $request->boolean('notif_lab_reports'),
            'notif_family_alerts' => $request->boolean('notif_family_alerts'),
            'notif_tips'          => $request->boolean('notif_tips'),
        ]);

        return back()->with('success_notif', 'Notification preferences saved.');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirm_delete' => 'required|in:DELETE',
        ]);

        $user = auth()->user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}