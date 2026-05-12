@extends('admin.layout')
@section('page-title', 'Consultations')
@section('content')

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">Patient</th>
                    <th class="px-5 py-3">Symptoms</th>
                    <th class="px-5 py-3">Risk Level</th>
                    <th class="px-5 py-3">Emergency</th>
                    <th class="px-5 py-3">Language</th>
                    <th class="px-5 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @foreach ($consultations as $c)
                    <tr>
                        <td class="px-5 py-3 font-mono text-slate-700">{{ $c->id }}</td>
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
                        <td class="px-5 py-3 text-slate-600">{{ $c->language ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $c->created_at?->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $consultations->links() }}
</div>

@endsection
