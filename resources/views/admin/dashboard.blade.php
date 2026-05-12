@extends('admin.layout')
@section('page-title', 'Dashboard')
@section('content')

<div class="mb-6 grid grid-cols-5 gap-4">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z" /></svg>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
        <p class="mt-1 text-sm text-slate-500">Total Users</p>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $totalConsultations }}</p>
        <p class="mt-1 text-sm text-slate-500">Total Consultations</p>
    </div>
    <div class="rounded-2xl border p-5 shadow-sm {{ $emergencyCount > 0 ? 'border-red-200 bg-red-50' : 'border-slate-200 bg-white' }}">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-red-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
        </div>
        <p class="text-3xl font-bold {{ $emergencyCount > 0 ? 'text-red-700' : 'text-slate-900' }}">{{ $emergencyCount }}</p>
        <p class="mt-1 text-sm {{ $emergencyCount > 0 ? 'text-red-600' : 'text-slate-500' }}">Emergency Cases</p>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $totalLabReports }}</p>
        <p class="mt-1 text-sm text-slate-500">Lab Reports</p>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.09 9.09 0 003.741-.479 12.014 12.014 0 003.478-.97M18 18.72a9.09 9.09 0 01-3.741-.479 12.014 12.014 0 01-3.478-.97M18 18.72v-1.5m-9-1.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm9 1.125v1.5m0-1.5a3.375 3.375 0 00-6.75 0v1.5m6.75 0h-6.75" /></svg>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $totalFamilyMembers }}</p>
        <p class="mt-1 text-sm text-slate-500">Family Members</p>
    </div>
</div>

<div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 px-5 py-4">
        <h2 class="font-semibold text-slate-900">Recent Users</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Role</th>
                    <th class="px-5 py-3">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($recentUsers as $user)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $user->name }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-5 py-3">
                            @if ($user->is_admin)
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Admin</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">User</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">No users yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 px-5 py-4">
        <h2 class="font-semibold text-slate-900">Recent Consultations</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Patient</th>
                    <th class="px-5 py-3">Symptoms</th>
                    <th class="px-5 py-3">Risk Level</th>
                    <th class="px-5 py-3">Emergency</th>
                    <th class="px-5 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($recentConsultations as $c)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $c->user?->name ?? '—' }}</td>
                        <td class="max-w-xs px-5 py-3 text-slate-600">{{ \Illuminate\Support\Str::limit($c->symptoms ?? '', 60) }}</td>
                        <td class="px-5 py-3">
                            @if (($c->risk_level ?? '') === 'high')
                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">high</span>
                            @elseif (($c->risk_level ?? '') === 'medium')
                                <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700">medium</span>
                            @else
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">low</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if ($c->is_emergency)
                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">Emergency</span>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $c->created_at?->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">No consultations yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
