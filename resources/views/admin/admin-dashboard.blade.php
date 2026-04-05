@extends('layouts.app')

@section('title', 'Admin Dashboard - SMKN 4 Tangerang')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Facility Overview</h2>
    <p class="text-slate-500 mt-1">Status monitor for campus infrastructure</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-[#101622] p-6 rounded-[20px] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-[140px] text-blue-600 select-none">assignment</span>
            </div>
            <div class="relative z-10">
                <p class="text-slate-500 text-sm font-bold tracking-wide mb-1">Total Complaints</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ number_format($totalComplaints) }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#101622] p-6 rounded-[20px] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-[140px] text-amber-500 select-none">verified_user</span>
            </div>
            <div class="relative z-10">
                <p class="text-slate-500 text-sm font-bold tracking-wide mb-1">Pending / Pending</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ number_format($needVerification) }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#101622] p-6 rounded-[20px] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-[140px] text-emerald-500 select-none">task_alt</span>
            </div>
            <div class="relative z-10">
                <p class="text-slate-500 text-sm font-bold tracking-wide mb-1">Resolved Cases</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ number_format($resolvedCases) }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#101622] p-6 rounded-[20px] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-[140px] text-blue-400 select-none">group</span>
            </div>
            <div class="relative z-10">
                <p class="text-slate-500 text-sm font-bold tracking-wide mb-1">Active Staff</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ number_format($activeStaff) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-slate-900 dark:text-white font-bold text-lg">Laporan Terbaru</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Daftar keluhan fasilitas sekolah terbaru masuk</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pelapor</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($complaints as $complaint)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-400">#{{ str_pad($complaint->complaint_id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 shrink-0">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                </div>
                                <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $complaint->user->full_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-full text-xs font-medium">{{ $complaint->category->category_name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($complaint->status == 'Pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Pending
                                </span>
                            @elseif($complaint->status == 'In Progress')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> In Progress
                                </span>
                            @elseif($complaint->status == 'Resolved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Resolved
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.aspirations.show', ['id' => $complaint->complaint_id, 'from' => 'dashboard']) }}" class="text-blue-600 hover:text-blue-700 hover:underline text-sm font-bold">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada laporan keluhan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between border-t border-slate-100 dark:border-slate-800">
            <div class="w-full">
                {{ $complaints->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection