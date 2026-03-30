@extends('layouts.app')

@section('title', 'Admin - Detail Aspirasi | SMKN 4 Tangerang')

@section('content')
<!-- Header Header Khusus Detail -->
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
        @php
            $backUrl = request('from') == 'dashboard' ? url('/admin/dashboard') : url('/admin/aspirations');
        @endphp
        <a href="{{ $backUrl }}" class="p-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors shadow-sm">
            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">arrow_back</span>
        </a>
        <div class="flex flex-col">
            <h1 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Detail Laporan <span class="text-blue-600">#{{ str_pad($aspiration->complaint_id, 4, '0', STR_PAD_LEFT) }}</span></h1>
            <div class="flex items-center gap-2 mt-0.5">
                <span class="text-sm text-slate-500 font-medium">Manajemen Aspirasi / Detail Laporan</span>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-3">
        @if($aspiration->status == 'Pending')
            <span class="flex items-center gap-2 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-500 px-4 py-1.5 rounded-full text-sm font-bold">
                <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                Menunggu Verifikasi
            </span>
        @elseif($aspiration->status == 'In Progress')
            <span class="flex items-center gap-2 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 px-4 py-1.5 rounded-full text-sm font-bold">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-600 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                </span>
                Proses
            </span>
        @elseif($aspiration->status == 'Resolved')
            <span class="flex items-center gap-2 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-500 px-4 py-1.5 rounded-full text-sm font-bold">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Selesai
            </span>
        @else
            <span class="flex items-center gap-2 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-500 px-4 py-1.5 rounded-full text-sm font-bold">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Ditolak
            </span>
        @endif
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-start gap-3">
    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
    <div>
        <p class="font-bold">Berhasil</p>
        <p class="text-sm">{{ session('success') }}</p>
    </div>
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-start gap-3">
    <span class="material-symbols-outlined text-red-500">error</span>
    <div>
        <p class="font-bold">Terjadi Kesalahan</p>
        <ul class="text-sm list-disc list-inside mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
    
    <!-- Left Column: Complaint Details -->
    <div class="xl:col-span-7 flex flex-col gap-6">
        
        <!-- Complaint Summary Card -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="h-64 bg-slate-200 dark:bg-slate-800 relative overflow-hidden flex items-center justify-center">
                @if($aspiration->evidence_photo)
                    <img alt="Evidence Photo" class="w-full h-full object-cover" src="{{ asset('storage/' . $aspiration->evidence_photo) }}"/>
                @else
                    <span class="material-symbols-outlined text-6xl text-slate-400">image_not_supported</span>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="bg-black/50 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider border border-white/20">
                        {{ $aspiration->category->category_name ?? 'Umum' }}
                    </span>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Data Pelapor (Admin View Only) -->
                <div class="mb-6 pb-6 border-b border-slate-100 dark:border-slate-800 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-xl uppercase overflow-hidden">
                        {{ substr($aspiration->user->full_name ?? 'Siswa', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-0.5">Dilaporkan Oleh</p>
                        <h4 class="font-bold text-slate-800 dark:text-slate-100">{{ $aspiration->user->full_name }}</h4>
                        <p class="text-xs text-slate-500">NIS/NIP: {{ $aspiration->user->identity_number }}</p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-0.5">Waktu Laporan</p>
                        <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $aspiration->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">{{ $aspiration->title ?? 'Laporan Aspirasi' }}</h2>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800">
                        {{ $aspiration->description }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Status Update & Timeline Progress -->
    <div class="xl:col-span-5 flex flex-col gap-6">
        
        <!-- Action Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">manage_history</span>
                    Update Status Target
                </h3>
            </div>
            
            <form action="{{ route('admin.aspirations.update', $aspiration->complaint_id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="mb-5">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Ubah Status Laporan</label>
                    <div class="relative">
                        <select name="status" class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 appearance-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all font-medium text-slate-700 dark:text-slate-200">
                            <option value="Pending" {{ $aspiration->status == 'Pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="In Progress" {{ $aspiration->status == 'In Progress' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="Resolved" {{ $aspiration->status == 'Resolved' ? 'selected' : '' }}>Selesai</option>
                            <option value="Rejected" {{ $aspiration->status == 'Rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center justify-between">
                        Pesan / Tindakan (Opsional)
                        <span class="text-xs font-normal text-slate-400">Tidak wajib diisi</span>
                    </label>
                    <textarea name="message" rows="4" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all text-sm text-slate-700 dark:text-slate-200" placeholder="Tuliskan keterangan tindakan, kendala, atau tanggapan untuk siswa..."></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center justify-between">
                        Foto Bukti Tindakan (Opsional)
                        <span class="text-xs font-normal text-slate-400">Maksimal 2MB (JPG/PNG)</span>
                    </label>
                    <input type="file" name="action_photo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-800 dark:file:text-slate-300 transition-all outline-none"/>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white h-11 rounded-lg font-bold text-sm shadow-lg shadow-blue-600/25 flex items-center justify-center gap-2 hover:bg-blue-700 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <h3 class="text-lg font-bold mb-2 flex items-center gap-2 text-slate-800 dark:text-slate-100">
            <span class="material-symbols-outlined text-blue-600">history</span>
            Riwayat Tanggapan
        </h3>

        <!-- Timeline -->
        <div class="relative space-y-8 mt-4 pl-4 before:absolute before:inset-0 before:ml-[2.25rem] before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent dark:before:via-slate-700">
            
            @forelse($aspiration->responses->sortByDesc('created_at') as $response)
                <!-- Response Card -->
                <div class="relative pl-14">
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 ring-8 ring-[#f6f6f8] dark:ring-[#101622] z-10 hidden lg:block">
                        <span class="material-symbols-outlined text-[16px]">reply</span>
                    </div>
                    <!-- timeline dot mobile -->
                    <div class="absolute left-0 top-2 w-3 h-3 rounded-full bg-blue-500 ring-4 ring-[#f6f6f8] dark:ring-[#101622] z-10 lg:hidden"></div>

                    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-5 rounded-xl shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100 text-sm flex items-center gap-2">
                                    {{ $response->user->full_name }}
                                    @if(in_array($response->user->role, ['admin', 'staff']))
                                        <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full capitalize">{{ $response->user->role }}</span>
                                    @endif
                                </h4>
                            </div>
                            <span class="text-[11px] font-medium text-slate-400 bg-slate-50 dark:bg-slate-800 px-2 py-1 rounded">{{ $response->created_at->format('d M, H:i') }}</span>
                        </div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            @if(!empty(trim($response->message)))
                                "{{ $response->message }}"
                            @else
                                <span class="italic text-slate-400">(Tindakan diselesaikan tanpa pesan khusus)</span>
                            @endif
                        </p>
                        @if($response->action_photo)
                            <div class="mt-4 rounded-lg overflow-hidden h-40 w-full sm:w-64 bg-slate-200 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm cursor-pointer hover:opacity-90 transition-opacity">
                                <img alt="Action Photo Evidence" class="w-full h-full object-cover" src="{{ asset('storage/' . $response->action_photo) }}"/>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-sm text-slate-500 italic pl-14">Belum ada tanggapan untuk asrpirasi ini.</div>
            @endforelse

            <!-- Initial State (Laporan Dibuat) -->
            <div class="relative pl-14 pb-4">
                 <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 ring-8 ring-[#f6f6f8] dark:ring-[#101622] z-10 hidden lg:block">
                    <span class="material-symbols-outlined text-[16px]">send</span>
                </div>
                <!-- timeline dot mobile -->
                <div class="absolute left-0 top-2 w-3 h-3 rounded-full bg-slate-400 ring-4 ring-[#f6f6f8] dark:ring-[#101622] z-10 lg:hidden"></div>

                <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 p-5 rounded-xl">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-slate-800 dark:text-slate-100 text-sm">Laporan Dibuat</h4>
                        <span class="text-[11px] font-medium text-slate-400">{{ $aspiration->created_at->format('d M, H:i') }}</span>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Laporan dikirimkan oleh sistem dan masuk ke antrean pengecekan admin.
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>

<style>
    /* Timeline overrides to align properly on admin page */
    .relative.space-y-8::before {
        left: 1rem !important;
        transform: none !important;
        margin: 0 !important;
    }
</style>
@endsection
