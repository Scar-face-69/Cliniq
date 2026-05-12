<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\FamilyMember;
use App\Services\ClaudeService;

class ConsultationController extends Controller
{
    protected ClaudeService $claude;

    public function __construct(ClaudeService $claude)
    {
        $this->claude = $claude;
    }

    public function index(Request $request)
    {
        $members = FamilyMember::where('user_id', auth()->id())->get();
        $selectedMemberId = $request->get('member');
        $selectedMember   = $selectedMemberId
            ? FamilyMember::where('user_id', auth()->id())->find($selectedMemberId)
            : null;

        $recentConsultations = Consultation::where('user_id', auth()->id())
            ->with('familyMember')->latest()->take(5)->get();

        $consultationId = $request->get('consultation');
        $consultation   = $consultationId
            ? Consultation::where('user_id', auth()->id())->with('messages')->find($consultationId)
            : null;

        return view('pages.consultation', compact('members', 'selectedMember', 'recentConsultations', 'consultation'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message'          => 'required|string|max:2000',
            'family_member_id' => 'nullable|exists:family_members,id',
            'consultation_id'  => 'nullable|exists:consultations,id',
        ]);

        $member = null;
        if ($request->family_member_id) {
            $member = FamilyMember::where('user_id', auth()->id())->find($request->family_member_id);
        }

        $profile = [];
        if ($member) {
            $profile = [
                'name'        => $member->name,
                'age'         => $member->age,
                'gender'      => $member->gender,
                'blood_group' => $member->blood_group,
                'allergies'   => $member->allergies,
                'conditions'  => $member->conditions,
                'medications' => $member->medications,
            ];
        } else {
            $user = auth()->user();
            $profile = [
                'name'        => $user->name,
                'blood_group' => $user->blood_group,
                'gender'      => $user->gender,
                'allergies'   => $user->allergies,
                'conditions'  => $user->conditions,
                'medications' => $user->medications,
            ];
        }

        if ($request->consultation_id) {
            $consultation = Consultation::where('user_id', auth()->id())->find($request->consultation_id);
        } else {
            $consultation = Consultation::create([
                'user_id'          => auth()->id(),
                'family_member_id' => $member?->id,
                'symptoms'         => $request->message,
                'risk_level'       => 'low',
            ]);
        }

        // Save user message
        ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'role'            => 'user',
            'content'         => $request->message,
        ]);

        // Build history with ONLY user messages (not AI JSON responses)
        // This prevents the huge JSON from breaking Gemini on follow-up messages
        $history = $consultation->messages()
            ->orderBy('created_at')
            ->where('role', 'user')
            ->get()
            ->map(fn($m) => ['role' => 'user', 'content' => $m->content])
            ->toArray();

        $aiResponse = $this->claude->analyze($request->message, $profile, $history);

        // Save AI message as JSON
        ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'role'            => 'assistant',
            'content'         => json_encode($aiResponse),
        ]);

        $consultation->update([
            'symptoms'        => $request->message,
            'ai_response'     => $aiResponse,
            'risk_level'      => $aiResponse['risk_level'] ?? 'low',
            'conditions'      => $aiResponse['conditions'] ?? [],
            'recommendations' => $aiResponse['recommendations'] ?? [],
            'is_emergency'    => $aiResponse['is_emergency'] ?? false,
        ]);

        if ($aiResponse['is_emergency'] ?? false) {
            $consultation->familyMember?->update(['status' => 'alert']);
        }

        return response()->json([
            'success'         => true,
            'consultation_id' => $consultation->id,
            'response'        => $aiResponse,
        ]);
    }

    public function history()
    {
        $consultations = Consultation::where('user_id', auth()->id())
            ->with('familyMember')
            ->latest()
            ->paginate(10);

        $stats = [
            'total'  => Consultation::where('user_id', auth()->id())->count(),
            'low'    => Consultation::where('user_id', auth()->id())->where('risk_level', 'low')->count(),
            'medium' => Consultation::where('user_id', auth()->id())->where('risk_level', 'medium')->count(),
            'high'   => Consultation::where('user_id', auth()->id())->where('risk_level', 'high')->count(),
        ];

        return view('pages.consultation-history', compact('consultations', 'stats'));
    }

    public function destroy($id)
    {
        $consultation = Consultation::where('user_id', auth()->id())->findOrFail($id);
        $consultation->delete();
        return redirect('/consultations')->with('success', 'Consultation deleted.');
    }
}