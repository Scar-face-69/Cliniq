@extends('admin.layout')
@section('page-title', 'Lab Reports')
@section('content')

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">Patient</th>
                    <th class="px-5 py-3">File Name</th>
                    <th class="px-5 py-3">Report Type</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Abnormal</th>
                    <th class="px-5 py-3">Normal</th>
                    <th class="px-5 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @foreach ($labReports as $r)
                    <tr>
                        <td class="px-5 py-3 font-mono text-slate-700">{{ $r->id }}</td>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $r->user?->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $r->file_name }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $r->report_type ?? '—' }}</td>
                        <td class="px-5 py-3">
                            @if (($r->status ?? 'pending') === 'processing')
                                <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700">processing</span>
                            @elseif (($r->status ?? 'pending') === 'analyzed')
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">analyzed</span>
                            @elseif (($r->status ?? 'pending') === 'failed')
                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">failed</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">pending</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-700">{{ $r->abnormal_count ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $r->normal_count ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $r->created_at?->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $labReports->links() }}
</div>

@endsection
