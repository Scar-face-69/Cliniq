@extends('admin.layout')
@section('page-title', 'Users')
@section('content')

@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
@endif

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Consultations</th>
                    <th class="px-5 py-3">Lab Reports</th>
                    <th class="px-5 py-3">Family</th>
                    <th class="px-5 py-3">Role</th>
                    <th class="px-5 py-3">Joined</th>
                    <th class="px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $user->name }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $user->consultations_count }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $user->lab_reports_count }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $user->family_members_count }}</td>
                        <td class="px-5 py-3">
                            @if ($user->is_admin)
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Admin</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">User</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-3">
                            @if ($user->id === auth()->id())
                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">You</span>
                            @else
                                <form method="POST" action="{{ route('admin.users.toggleAdmin', $user) }}" class="inline">
                                    @csrf
                                    @if ($user->is_admin)
                                        <button type="submit" class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-200 transition hover:bg-red-100">Remove Admin</button>
                                    @else
                                        <button type="submit" class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-200 transition hover:bg-blue-100">Make Admin</button>
                                    @endif
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>

@endsection
