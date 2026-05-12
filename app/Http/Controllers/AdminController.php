<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Consultation;
use App\Models\FamilyMember;
use App\Models\LabReport;
class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalConsultations = Consultation::count();
        $emergencyCount = Consultation::where('is_emergency', true)->count();
        $totalLabReports = LabReport::count();
        $totalFamilyMembers = FamilyMember::count();
        $recentUsers = User::latest()->take(5)->get();
        $recentConsultations = Consultation::with('user')->latest()->take(5)->get();
        return view('admin.dashboard', compact(
            'totalUsers','totalConsultations','emergencyCount',
            'totalLabReports','totalFamilyMembers',
            'recentUsers','recentConsultations'
        ));
    }

    public function users()
    {
        $users = User::withCount(['consultations','labReports','familyMembers'])
                     ->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own admin status.');
        }
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 'User role updated.');
    }

    public function consultations()
    {
        $consultations = Consultation::with('user')->latest()->paginate(20);
        return view('admin.consultations', compact('consultations'));
    }

    public function labReports()
    {
        $labReports = LabReport::with('user')->latest()->paginate(20);
        return view('admin.lab-reports', compact('labReports'));
    }
}
