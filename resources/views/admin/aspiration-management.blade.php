@extends('layouts.app')

@section('title', 'Admin - Manajemen Aspirasi | SMKN 4 Tangerang')

@section('content')
<!-- Filter Section Untuk filter list aspirasi dan memudahkan pencarian-->
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
        <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">filter_list</span>
            Filter Data
        </h3>
    </div>
    <div class="p-6">
        <form class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Mulai Tanggal</label>
                <input class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 focus:ring-blue-600 focus:border-blue-600 transition-all text-sm" type="date"/>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Sampai Tanggal</label>
                <input class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 focus:ring-blue-600 focus:border-blue-600 transition-all text-sm" type="date"/>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kategori</label>
                <select class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 focus:ring-blue-600 focus:border-blue-600 transition-all text-sm">
                    <option>Pilih Kategori</option>
                    <option>Sarana & Prasarana</option>
                    <option>Kebersihan</option>
                    <option>Keamanan</option>
                    <option>Lainnya</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">NIS Siswa</label>
                <div class="relative">
                    <input class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg pl-10 pr-4 focus:ring-blue-600 focus:border-blue-600 transition-all text-sm" placeholder="Cari NIS..." type="text"/>
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                </div>
            </div>
            <div class="md:col-span-4 flex justify-end">
                <button class="bg-blue-600 text-white h-11 px-8 rounded-lg font-bold text-sm shadow-lg shadow-blue-600/25 flex items-center gap-2 hover:bg-blue-700 transition-colors" type="submit">
                    <span class="material-symbols-outlined">search</span>
                    Tampilkan Data
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Results Table -->
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 dark:text-slate-100">Hasil Pencarian</h3>
        <div class="flex gap-2">
            <button class="p-2 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Print">
                <span class="material-symbols-outlined text-slate-500">print</span>
            </button>
            <button class="p-2 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Download">
                <span class="material-symbols-outlined text-slate-500">download</span>
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/30 dark:bg-slate-800/30 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    <th class="px-6 py-4 text-center border-b border-slate-100 dark:border-slate-800 w-16">No</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Tanggal</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Siswa</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Kategori</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Isi Aspirasi</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Status</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($aspirations as $index => $aspiration)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-5 text-center font-mono text-sm text-slate-500 dark:text-slate-400">{{ str_pad($aspirations->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">{{ $aspiration->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold">{{ $aspiration->user->full_name }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">NIS/NIP: {{ $aspiration->user->identity_number }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-3 py-1 rounded-full text-xs font-semibold">{{ $aspiration->category->category_name }}</span>
                    </td>
                    <td class="px-6 py-5 min-w-[300px]">
                        <p class="text-sm line-clamp-2 text-slate-600 dark:text-slate-300 leading-relaxed">{{ $aspiration->description }}</p>
                    </td>
                    <td class="px-6 py-5">
                        @if($aspiration->status == 'Pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-2"></span>
                                Menunggu
                            </span>
                        @elseif($aspiration->status == 'In Progress')
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mr-2"></span>
                                Proses
                            </span>
                        @elseif($aspiration->status == 'Resolved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                                Selesai
                            </span>
                        @else
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2"></span>
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <a href="{{ route('admin.aspirations.show', $aspiration->complaint_id) }}" class="text-blue-600 hover:underline text-sm font-bold">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        Belum ada laporan aspirasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination Footer -->
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
        {{ $aspirations->links('pagination::tailwind') }}
    </div>
</section>
@endsection
