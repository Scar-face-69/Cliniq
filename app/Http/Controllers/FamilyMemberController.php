<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember;

class FamilyMemberController extends Controller
{
    // Show family members page
    public function index()
    {
        $members = FamilyMember::where('user_id', auth()->id())
            ->orderBy('is_primary', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        $stats = [
            'total'    => $members->count(),
            'healthy'  => $members->where('status', 'healthy')->count(),
            'followup' => $members->where('status', 'followup')->count(),
            'alert'    => $members->where('status', 'alert')->count(),
        ];

        return view('pages.family', compact('members', 'stats'));
    }

    // Store new member
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'relation'    => 'required|string|max:50',
            'age'         => 'nullable|integer|min:0|max:120',
            'gender'      => 'nullable|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'allergies'   => 'nullable|string|max:500',
            'conditions'  => 'nullable|string|max:500',
            'medications' => 'nullable|string|max:1000',
        ]);

        FamilyMember::create([
            'user_id'     => auth()->id(),
            'name'        => $request->name,
            'relation'    => $request->relation,
            'age'         => $request->age,
            'gender'      => $request->gender,
            'blood_group' => $request->blood_group,
            'allergies'   => $request->allergies,
            'conditions'  => $request->conditions,
            'medications' => $request->medications,
            'status'      => 'healthy',
            'is_primary'  => false,
        ]);

        return redirect('/family')->with('success', 'Family member added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $member = FamilyMember::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($member);
    }

    // Update member
    public function update(Request $request, $id)
    {
        $member = FamilyMember::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100',
            'relation'    => 'required|string|max:50',
            'age'         => 'nullable|integer|min:0|max:120',
            'gender'      => 'nullable|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'allergies'   => 'nullable|string|max:500',
            'conditions'  => 'nullable|string|max:500',
            'medications' => 'nullable|string|max:1000',
        ]);

        $member->update($request->only([
            'name', 'relation', 'age', 'gender',
            'blood_group', 'allergies', 'conditions', 'medications',
        ]));

        return redirect('/family')->with('success', 'Member updated successfully!');
    }

    // Delete member
    public function destroy($id)
    {
        $member = FamilyMember::where('user_id', auth()->id())->findOrFail($id);
        $member->delete();
        return redirect('/family')->with('success', 'Member removed.');
    }
}
