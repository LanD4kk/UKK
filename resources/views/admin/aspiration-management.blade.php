@extends('layouts.app')

@section('title', 'Admin - Manajemen Aspirasi | SMKN 4 Tangerang')

@section('content')

<div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6 mt-2">
    <div>
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Manajemen Aspirasi</h2>
        <p class="text-slate-500 mt-1">Kelola dan pantau seluruh laporan dari siswa</p>
    </div>
    <div class="flex items-center gap-3 w-full md:w-auto">
        <div class="relative flex-1 md:w-72">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input type="text" id="searchInput" onkeyup="searchTable()" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-blue-600 focus:border-blue-600 text-sm shadow-sm transition duration-150 ease-in-out" placeholder="Cari data, tanggal, kategori..."/>
        </div>
    </div>
</div>

{{-- ─── Results Table ───────────────────────────────────────────────────────── --}}
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-slate-800 dark:text-slate-100">Daftar Laporan Aspirasi</h3>
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
        <table id="myTable" class="w-full text-left border-collapse">
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
                <tr id="noDataMessage" style="display: none;">
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        Opps! Data tidak ditemukan.
                    </td>
                </tr>
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

<script>
    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("myTable");
        let tbody = table.getElementsByTagName("tbody")[0];
        let tr = tbody.getElementsByTagName("tr");
        let hasVisibleRow = false;

        for (let i = 0; i < tr.length; i++) {
            if (tr[i].id === "noDataMessage") continue;
            
            let td = tr[i].getElementsByTagName("td");
            let showRow = false;

            for (let j = 0; j < td.length; j++) {
                if (td[j] && td[j].textContent.toLowerCase().indexOf(filter) > -1) {
                    showRow = true;
                    break;
                }
            }

            if (showRow) {
                tr[i].style.display = "";
                hasVisibleRow = true;
            } else {
                tr[i].style.display = "none";
            }
        }

        let noDataMsg = document.getElementById("noDataMessage");
        if (noDataMsg) {
            noDataMsg.style.display = hasVisibleRow ? "none" : "table-row";
        }
    }
</script>

@endsection
