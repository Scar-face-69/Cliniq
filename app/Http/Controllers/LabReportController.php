<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabReport;
use App\Models\FamilyMember;
use App\Services\ClaudeService;
use Illuminate\Support\Facades\Storage;

class LabReportController extends Controller
{
    protected ClaudeService $claude;

    public function __construct(ClaudeService $claude)
    {
        $this->claude = $claude;
    }

    public function index()
    {
        $reports = LabReport::where('user_id', auth()->id())
            ->with('familyMember')
            ->latest()
            ->get();

        $members = FamilyMember::where('user_id', auth()->id())->get();

        $stats = [
            'total'    => $reports->count(),
            'analyzed' => $reports->where('status', 'analyzed')->count(),
            'abnormal' => $reports->sum('abnormal_count'),
            'normal'   => $reports->sum('normal_count'),
        ];

        return view('pages.lab-reports', compact('reports', 'members', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file'             => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'family_member_id' => 'nullable|exists:family_members,id',
            'report_type'      => 'nullable|string|max:100',
        ]);

        $file       = $request->file('file');
        $fileName   = time() . '_' . $file->getClientOriginalName();
        $filePath   = $file->storeAs('', $fileName, 'public');
        $mimeType   = $file->getMimeType();
        $reportType = $request->report_type ?? 'General';

        // Real Gemini AI analysis
        $analysis = $this->claude->analyzeLabReport($filePath, $mimeType, $reportType);

        $labValues     = $analysis['lab_values'] ?? [];
        $abnormalCount = collect($labValues)->whereIn('status', ['high', 'low'])->count();
        $normalCount   = collect($labValues)->where('status', 'normal')->count();

        LabReport::create([
            'user_id'          => auth()->id(),
            'family_member_id' => $request->family_member_id ?: null,
            'file_name'        => $file->getClientOriginalName(),
            'file_path'        => $filePath,
            'file_type'        => $mimeType,
            'report_type'      => $analysis['report_type'] ?? $reportType,
            'status'           => empty($labValues) ? 'failed' : 'analyzed',
            'ai_analysis'      => $analysis,
            'lab_values'       => $labValues,
            'summary'          => $analysis['summary'] ?? null,
            'abnormal_count'   => $abnormalCount,
            'normal_count'     => $normalCount,
        ]);

        return redirect('/lab-reports')->with('success', 'Report uploaded and analyzed by AI!');
    }

    public function show($id)
    {
        $report = LabReport::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($report);
    }

    public function destroy($id)
    {
        $report = LabReport::where('user_id', auth()->id())->findOrFail($id);
        Storage::disk('public')->delete($report->file_path);
        $report->delete();
        return redirect('/lab-reports')->with('success', 'Report deleted.');
    }
}