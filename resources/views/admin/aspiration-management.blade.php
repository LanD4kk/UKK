@extends('layouts.app')

@section('title', 'Admin - Manajemen Aspirasi | SMKN 4 Tangerang')

@section('content')

{{-- ─── Filter Section ─────────────────────────────────────────────────────── --}}
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">filter_list</span>
            Filter Data
        </h3>
    </div>

    <div class="p-6">
        <form method="GET" action="{{ url()->current() }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 items-end">

            {{-- Per Bulan --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Per Bulan</label>
                <input name="month" type="month"
                       value="{{ request('month') }}"
                       class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-3 text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all"/>
            </div>

            {{-- Mulai Tanggal --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Mulai Tanggal</label>
                <input name="date_from" type="date"
                       value="{{ request('date_from') }}"
                       class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-3 text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all"/>
            </div>

            {{-- Sampai Tanggal --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Sampai Tanggal</label>
                <input name="date_to" type="date"
                       value="{{ request('date_to') }}"
                       class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-3 text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all"/>
            </div>

            {{-- Kategori --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kategori</label>
                <select name="category_id"
                        class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-3 text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}"
                            {{ request('category_id') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NIS / Nama Siswa --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">NIS / Nama Siswa</label>
                <div class="relative">
                    <input name="student" type="text"
                           value="{{ request('student') }}"
                           placeholder="Cari NIS atau nama..."
                           class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg pl-9 pr-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all"/>
                    <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="relative">
                <a href="{{ url()->current() }}"
                   class="h-11 px-5 rounded-lg border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                    Reset
                </a>
                </div>
            </div>


            {{-- Tombol Submit --}}
            <div class="sm:col-span-2 lg:col-span-3 xl:col-span-6 flex justify-end gap-3">
                <button type="submit"
                        class="h-11 px-7 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-sm shadow-md shadow-blue-600/25 flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Tampilkan Data
                </button>
            </div>
        </form>
    </div>
</section>

{{-- ─── Active Filter Tags ───────────────────────────────────────────────────── --}}
@if(request()->hasAny(['date_from','date_to','category_id','student','month']))
<div class="flex flex-wrap gap-2 mb-4">
    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center">Filter aktif:</span>

    @if(request('month'))
        <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold px-2.5 py-1 rounded-full">
            <span class="material-symbols-outlined text-[13px]">calendar_month</span>
            Bulan: {{ \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') }}
        </span>
    @endif
    @if(request('date_from'))
        <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold px-2.5 py-1 rounded-full">
            <span class="material-symbols-outlined text-[13px]">event</span>
            Dari: {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
        </span>
    @endif
    @if(request('date_to'))
        <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold px-2.5 py-1 rounded-full">
            <span class="material-symbols-outlined text-[13px]">event</span>
            Sampai: {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
        </span>
    @endif
    @if(request('category_id'))
        @php $activeCat = $categories->firstWhere('category_id', request('category_id')); @endphp
        <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold px-2.5 py-1 rounded-full">
            <span class="material-symbols-outlined text-[13px]">category</span>
            {{ $activeCat?->category_name ?? 'Kategori' }}
        </span>
    @endif
    @if(request('student'))
        <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold px-2.5 py-1 rounded-full">
            <span class="material-symbols-outlined text-[13px]">person_search</span>
            Siswa: "{{ request('student') }}"
        </span>
    @endif
</div>
@endif

{{-- ─── Results Table ───────────────────────────────────────────────────────── --}}
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-slate-800 dark:text-slate-100">Hasil Pencarian</h3>
            <p class="text-xs text-slate-400 mt-0.5">
                Menampilkan <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $aspirations->firstItem() ?? 0 }}–{{ $aspirations->lastItem() ?? 0 }}</span>
                dari total <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $aspirations->total() }}</span> laporan
            </p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()"
                    class="p-2 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Print">
                <span class="material-symbols-outlined text-slate-500">print</span>
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
                    <td class="px-6 py-5 text-center font-mono text-sm text-slate-500 dark:text-slate-400">
                        {{ str_pad($aspirations->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                        <span class="block text-slate-700 dark:text-slate-200">{{ $aspiration->created_at->format('d M Y') }}</span>
                        <span class="text-xs text-slate-400">{{ $aspiration->created_at->format('H:i') }} WIB</span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center shrink-0 overflow-hidden">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($aspiration->user->full_name) }}&background=135bec&color=fff&size=32"
                                     alt="{{ $aspiration->user->full_name }}" class="w-full h-full object-cover"/>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $aspiration->user->full_name }}</span>
                                <span class="text-xs text-slate-400">NIS: {{ $aspiration->user->identity_number }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap">
                            {{ $aspiration->category->category_name }}
                        </span>
                    </td>
                    <td class="px-6 py-5 min-w-[260px]">
                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-0.5 truncate max-w-[240px]">{{ $aspiration->title }}</p>
                        <p class="text-xs line-clamp-1 text-slate-500 dark:text-slate-400 leading-relaxed">{{ $aspiration->description }}</p>
                    </td>
                    <td class="px-6 py-5">
                        @if($aspiration->status == 'Pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-2"></span>Menunggu
                            </span>
                        @elseif($aspiration->status == 'In Progress')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mr-2 animate-pulse"></span>Proses
                            </span>
                        @elseif($aspiration->status == 'Resolved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2"></span>Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <a href="{{ route('admin.aspirations.show', $aspiration->complaint_id) }}"
                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 text-xs font-bold hover:underline transition-colors">
                            <span class="material-symbols-outlined text-[15px]">open_in_new</span>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <span class="material-symbols-outlined text-5xl">search_off</span>
                            <p class="text-sm font-semibold">Tidak ada laporan yang cocok dengan filter.</p>
                            <a href="{{ url()->current() }}" class="text-xs text-blue-500 hover:underline">Tampilkan semua laporan</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($aspirations->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
        {{ $aspirations->links('pagination::tailwind') }}
    </div>
    @endif
</section>

@endsection
