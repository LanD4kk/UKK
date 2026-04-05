@extends('layouts.app')

@section('title', 'Histori Aspirasi - SMKN 4 Tangerang')

@section('content')

{{-- ─── Page Header ──────────────────────────────────────────────────────────── --}}
<div class="mb-8">
    <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Histori Aspirasi</h2>
    <p class="text-slate-500 dark:text-slate-400 mt-1">Rekap semua laporan yang telah diselesaikan atau ditolak</p>
</div>

{{-- ─── Stats Summary ────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    {{-- Total Resolved --}}
    <div class="bg-white dark:bg-[#101622] p-6 rounded-[20px] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -right-5 -bottom-5 opacity-10 group-hover:opacity-20 transition-opacity">
            <span class="material-symbols-outlined text-[120px] text-emerald-500 select-none">task_alt</span>
        </div>
        <div class="relative z-10">
            <p class="text-slate-500 dark:text-slate-400 text-sm font-bold tracking-wide mb-1">Total Selesai</p>
            <h3 class="text-4xl font-black text-emerald-600 tracking-tight">{{ number_format($totalResolved) }}</h3>
        </div>
    </div>
    {{-- Total Rejected --}}
    <div class="bg-white dark:bg-[#101622] p-6 rounded-[20px] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -right-5 -bottom-5 opacity-10 group-hover:opacity-20 transition-opacity">
            <span class="material-symbols-outlined text-[120px] text-red-500 select-none">cancel</span>
        </div>
        <div class="relative z-10">
            <p class="text-slate-500 dark:text-slate-400 text-sm font-bold tracking-wide mb-1">Total Ditolak</p>
            <h3 class="text-4xl font-black text-red-500 tracking-tight">{{ number_format($totalRejected) }}</h3>
        </div>
    </div>
    {{-- Total Responses Given --}}
    <div class="bg-white dark:bg-[#101622] p-6 rounded-[20px] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -right-5 -bottom-5 opacity-10 group-hover:opacity-20 transition-opacity">
            <span class="material-symbols-outlined text-[120px] text-blue-500 select-none">forum</span>
        </div>
        <div class="relative z-10">
            <p class="text-slate-500 dark:text-slate-400 text-sm font-bold tracking-wide mb-1">Total Tanggapan</p>
            <h3 class="text-4xl font-black text-blue-600 tracking-tight">{{ number_format($totalResponses) }}</h3>
        </div>
    </div>
</div>

{{-- ─── Filter Section ───────────────────────────────────────────────────────── --}}
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
        <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">filter_list</span>
            Filter Histori
        </h3>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ url()->current() }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 items-end">

            {{-- Per Bulan --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Per Bulan</label>
                <input name="month" type="month" value="{{ request('month') }}"
                       class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-3 text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all"/>
            </div>

            {{-- Mulai Tanggal --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Mulai Tanggal</label>
                <input name="date_from" type="date" value="{{ request('date_from') }}"
                       class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-3 text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all"/>
            </div>

            {{-- Sampai Tanggal --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Sampai Tanggal</label>
                <input name="date_to" type="date" value="{{ request('date_to') }}"
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
                    <input name="student" type="text" value="{{ request('student') }}"
                           placeholder="Cari NIS atau nama..."
                           class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg pl-9 pr-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all"/>
                    <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="sm:col-span-2 lg:col-span-3 xl:col-span-5 flex justify-end gap-3">
                <a href="{{ url()->current() }}"
                   class="h-11 px-5 rounded-lg border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                    Reset
                </a>
                <button type="submit"
                        class="h-11 px-7 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-sm shadow-md shadow-blue-600/25 flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Tampilkan
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

{{-- ─── Table ────────────────────────────────────────────────────────────────── --}}
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-slate-800 dark:text-slate-100">Daftar Histori Laporan</h3>
            <p class="text-xs text-slate-400 mt-0.5">
                Menampilkan
                <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $histories->firstItem() ?? 0 }}–{{ $histories->lastItem() ?? 0 }}</span>
                dari total
                <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $histories->total() }}</span> laporan
            </p>
        </div>
        <button onclick="window.print()"
                class="p-2 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Print">
            <span class="material-symbols-outlined text-slate-500">print</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/30 dark:bg-slate-800/30 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    <th class="px-6 py-4 text-center border-b border-slate-100 dark:border-slate-800 w-16">No</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Tanggal</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Siswa</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Kategori</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Judul Laporan</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 text-center">Tanggapan</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">Status</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 text-center">Selesai Pada</th>
                    <th class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($histories as $index => $item)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                    {{-- No --}}
                    <td class="px-6 py-5 text-center font-mono text-sm text-slate-400">
                        {{ str_pad($histories->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- Tanggal Dibuat --}}
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="block text-sm font-medium text-slate-700 dark:text-slate-200">
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $item->created_at->format('H:i') }} WIB</span>
                    </td>

                    {{-- Siswa --}}
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded-full overflow-hidden shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->full_name) }}&background=135bec&color=fff&size=36"
                                     alt="{{ $item->user->full_name }}" class="w-full h-full object-cover"/>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-slate-800 dark:text-slate-100">{{ $item->user->full_name }}</span>
                                <span class="text-xs text-slate-400">NIS: {{ $item->user->identity_number }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Kategori --}}
                    <td class="px-6 py-5">
                        <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap">
                            {{ $item->category->category_name }}
                        </span>
                    </td>

                    {{-- Judul --}}
                    <td class="px-6 py-5 min-w-[220px]">
                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 truncate max-w-[200px]">{{ $item->title }}</p>
                        <p class="text-xs text-slate-400 line-clamp-1 max-w-[200px]">{{ $item->description }}</p>
                    </td>

                    {{-- Jumlah Tanggapan --}}
                    <td class="px-6 py-5 text-center">
                        @if($item->responses_count > 0)
                            <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold px-2.5 py-1 rounded-full">
                                <span class="material-symbols-outlined text-[13px]">forum</span>
                                {{ $item->responses_count }}
                            </span>
                        @else
                            <span class="text-slate-300 dark:text-slate-600 text-xs font-medium">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-5">
                        @if($item->status === 'Resolved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2"></span>Ditolak
                            </span>
                        @endif
                    </td>

                    {{-- Selesai Pada (updated_at) --}}
                    <td class="px-6 py-5 text-center whitespace-nowrap">
                        <span class="text-sm text-slate-600 dark:text-slate-300">{{ $item->updated_at->format('d M Y') }}</span>
                        <span class="block text-xs text-slate-400">{{ $item->updated_at->diffForHumans() }}</span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-5 text-center">
                        <a href="{{ route('admin.aspirations.show', $item->complaint_id) }}"
                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 text-xs font-bold hover:underline transition-colors">
                            <span class="material-symbols-outlined text-[15px]">open_in_new</span>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <span class="material-symbols-outlined text-5xl">history</span>
                            <p class="text-sm font-semibold">Belum ada histori laporan yang selesai atau ditolak.</p>
                            @if(request()->hasAny(['date_from','date_to','category_id','student','month']))
                                <a href="{{ url()->current() }}" class="text-xs text-blue-500 hover:underline">Tampilkan semua histori</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($histories->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
        {{ $histories->links('pagination::tailwind') }}
    </div>
    @endif
</section>

@endsection
