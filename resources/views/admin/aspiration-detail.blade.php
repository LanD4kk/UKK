@extends('layouts.app')

@section('title', 'Admin - Detail Aspirasi | SMKN 4 Tangerang')

@push('styles')
<style>
    /* Sinkronisasi warna timeline line dengan desain siswa */
    .timeline-line {
        position: absolute;
        left: 20px;
        top: 24px;
        bottom: 0;
        width: 2px;
        background-color: #e5e7eb;
    }
    .dark .timeline-line { background-color: #374151; }
</style>
@endpush

@section('content')
<!-- Header Header Khusus Detail (Disamakan dengan siswa) -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        @php
            $backUrl = request('from') == 'dashboard' ? url('/admin/dashboard') : url('/admin/aspirations');
        @endphp
        <a href="{{ $backUrl }}" class="p-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors shadow-sm">
            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">arrow_back</span>
        </a>
        <div class="flex flex-col">
            <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                Detail Laporan
                <span class="text-blue-600">#{{ str_pad($aspiration->complaint_id, 4, '0', STR_PAD_LEFT) }}</span>
            </h1>
            <span class="text-xs text-slate-500 font-medium">Manajemen Aspirasi / Detail Laporan</span>
        </div>
    </div>
    <div class="flex items-center gap-3">
        @if($aspiration->status == 'Pending')
            <span class="flex items-center gap-2 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 px-4 py-1.5 rounded-full text-sm font-bold">
                <span class="material-symbols-outlined text-[16px]">hourglass_empty</span>
                Pending
            </span>
        @elseif($aspiration->status == 'In Progress')
            <span class="flex items-center gap-2 bg-blue-100/50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 px-4 py-1.5 rounded-full text-sm font-bold">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-600 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                </span>
                In Progress
            </span>
        @elseif($aspiration->status == 'Resolved')
            <span class="flex items-center gap-2 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-4 py-1.5 rounded-full text-sm font-bold">
                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                Selesai
            </span>
        @else
            <span class="flex items-center gap-2 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 px-4 py-1.5 rounded-full text-sm font-bold">
                <span class="material-symbols-outlined text-[16px]">cancel</span>
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

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left Column: Complaint Details -->
    <div class="lg:col-span-7 flex flex-col gap-6">
        
        <!-- Complaint Summary Card (Sama seperti siswa) -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <!-- Photo container -->
            <div class="h-64 bg-slate-100 dark:bg-slate-800 relative overflow-hidden">
                <div class="absolute top-4 left-4 z-10">
                    <span class="bg-black/50 backdrop-blur-md text-white px-3 py-1 rounded text-xs font-semibold uppercase tracking-wider">
                        {{ $aspiration->category->category_name ?? 'Umum' }}
                    </span>
                </div>
                
                @if($aspiration->evidence_photo)
                    <img src="{{ asset('storage/' . $aspiration->evidence_photo) }}" alt="Foto bukti laporan" class="w-full h-full object-cover"/>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600 gap-3">
                        <span class="material-symbols-outlined !text-6xl">hide_image</span>
                        <p class="text-sm font-medium">Tidak ada foto bukti</p>
                    </div>
                @endif
            </div>

            <div class="p-6">
                <!-- Info Pelapor (Khusus Admin) -->
                <div class="mb-5 pb-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold overflow-hidden">
                            {{ substr($aspiration->user->full_name ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-0.5">Dilaporkan Oleh</p>
                            <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">{{ $aspiration->user->full_name ?? 'Deleted User' }}</h4>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-0.5">NIS/Identitas</p>
                        <p class="text-sm font-mono text-slate-600 dark:text-slate-400">{{ $aspiration->user->identity_number ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap justify-between items-start gap-2 mb-3">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $aspiration->title ?? 'Laporan Aspirasi' }}</h2>
                    <p class="text-sm text-slate-400 shrink-0">{{ $aspiration->created_at->diffForHumans() }}</p>
                </div>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm">
                    {{ $aspiration->description }}
                </p>
            </div>
        </div>

        <!-- Quick Info Grid (Sama seperti siswa) -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Kategori -->
            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                <div class="bg-blue-600/10 p-2.5 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600">category</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-0.5">Kategori</p>
                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $aspiration->category->category_name ?? 'Umum' }}</p>
                </div>
            </div>
            <!-- Tanggal -->
            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                <div class="bg-amber-500/10 p-2.5 rounded-lg">
                    <span class="material-symbols-outlined text-amber-500">calendar_today</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-0.5">Tanggal Laporan</p>
                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $aspiration->created_at->format('d F Y') }}</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Status Update & Timeline Progress -->
    <div class="lg:col-span-5 flex flex-col gap-6">
        
        <!-- Action Form Card (Hanya di Admin) -->
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
                        <select name="status" class="w-full h-11 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 appearance-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all text-sm font-medium text-slate-700 dark:text-slate-200">
                            <option value="Pending" {{ $aspiration->status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                            <option value="In Progress" {{ $aspiration->status == 'In Progress' ? 'selected' : '' }}>In Progress (Dalam Proses)</option>
                            <option value="Resolved" {{ $aspiration->status == 'Resolved' ? 'selected' : '' }}>Resolved (Selesai)</option>
                            <option value="Rejected" {{ $aspiration->status == 'Rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center justify-between">
                        Pesan Tanggapan
                        <span class="text-[11px] font-normal text-slate-400">Tampil di portal siswa</span>
                    </label>
                    <textarea name="message" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all text-sm text-slate-700 dark:text-slate-200" placeholder="Tuliskan keterangan detail tindakan, atau alasan penolakan..."></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center justify-between">
                        Foto Bukti Tindakan
                        <span class="text-[11px] font-normal text-slate-400">Opsional (Max: 2MB)</span>
                    </label>
                    <input type="file" name="action_photo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-800 dark:file:text-slate-300 transition-all outline-none"/>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white h-11 rounded-lg font-bold text-sm shadow-lg shadow-blue-600/25 flex items-center justify-center gap-2 hover:bg-blue-700 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">send</span>
                    Kirim Tanggapan
                </button>
            </form>
        </div>

        <h3 class="text-lg font-bold mb-4 flex items-center gap-2 mt-4">
            <span class="material-symbols-outlined text-blue-600">history</span>
            Riwayat Pengerjaan
        </h3>

        <!-- Timeline (Desain identik dengan siswa) -->
        <div class="relative space-y-6">
            <div class="timeline-line"></div>
            
            @forelse($aspiration->responses->sortByDesc('created_at')->values() as $index => $response)
                @php
                    $isLatest = $index === 0;
                    
                    // Gunakan warna berdasarkan status jika ini adalah response terbaru, 
                    // jika tidak gunakan warna hijau (selesai/done)
                    $dotColor = 'bg-green-500';
                    $dotIcon = 'chat';
                    
                    if ($isLatest) {
                        if ($aspiration->status == 'Pending') { $dotColor = 'bg-yellow-400'; $dotIcon = 'hourglass_empty'; }
                        elseif ($aspiration->status == 'In Progress') { $dotColor = 'bg-blue-600'; $dotIcon = 'build'; }
                        elseif ($aspiration->status == 'Resolved') { $dotColor = 'bg-green-500'; $dotIcon = 'check_circle'; }
                        elseif ($aspiration->status == 'Rejected') { $dotColor = 'bg-red-500'; $dotIcon = 'cancel'; }
                    }

                    $cardBg = $isLatest ? 'bg-blue-600/5 border-blue-600/20' : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800';
                    $titleColor = $isLatest ? 'text-blue-600' : 'text-slate-900 dark:text-white';
                @endphp

                <div class="relative pl-12">
                    <div class="absolute left-0 top-0 w-10 h-10 rounded-full {{ $dotColor }} flex items-center justify-center text-white ring-8 ring-slate-50 dark:ring-slate-900 z-10">
                        <span class="material-symbols-outlined text-[20px]">{{ $dotIcon }}</span>
                    </div>
                    <div class="{{ $cardBg }} border p-5 rounded-xl shadow-sm">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h4 class="font-bold {{ $titleColor }}">Tanggapan Sistem</h4>
                            <span class="text-[11px] font-medium text-slate-400 shrink-0">{{ $response->created_at->format('d M, H:i') }}</span>
                        </div>
                        <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">{{ $response->message ?: '(Tanpa pesan keterangan)' }}</p>
                        
                        @if($response->action_photo)
                            <div class="rounded-lg overflow-hidden h-28 w-full bg-slate-200 mt-3">
                                <img src="{{ asset('storage/'.$response->action_photo) }}" alt="Foto tindakan" class="w-full h-full object-cover"/>
                            </div>
                        @endif

                        <div class="mt-4 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full overflow-hidden bg-slate-200 shrink-0 flex items-center justify-center font-bold text-xs text-blue-600 bg-blue-100">
                                {{ substr($response->user->full_name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ $response->user->full_name ?? 'Sistem' }}</p>
                                <p class="text-[10px] text-slate-500 capitalize">{{ $response->user->role ?? 'admin' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Belum ada tanggapan -->
                <div class="relative pl-12">
                    <div class="absolute left-0 top-0 w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center text-white ring-8 ring-slate-50 dark:ring-slate-900 z-10">
                        <span class="material-symbols-outlined text-[20px]">hourglass_empty</span>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800/40 p-5 rounded-xl">
                        <h4 class="font-bold text-yellow-700 dark:text-yellow-400 mb-1">Menunggu Tanggapan</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Laporan ini belum direspon atau diambil tindakannya.
                        </p>
                    </div>
                </div>
            @endforelse

            <!-- Initial State (Laporan Dibuat) -->
            <div class="relative pl-12 pb-4">
                <div class="absolute left-0 top-0 w-10 h-10 rounded-full bg-slate-400 dark:bg-slate-600 flex items-center justify-center text-white ring-8 ring-slate-50 dark:ring-slate-900 z-10">
                    <span class="material-symbols-outlined text-[20px]">send</span>
                </div>
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-5 rounded-xl shadow-sm relative z-0">
                    <div class="flex justify-between items-start mb-2 gap-2">
                        <h4 class="font-bold text-slate-900 dark:text-white">Laporan Terkirim</h4>
                        <span class="text-[11px] font-medium text-slate-400 shrink-0">{{ $aspiration->created_at->format('d M, H:i') }}</span>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Laporan berhasil dibuat oleh <strong>{{ $aspiration->user->full_name ?? 'Siswa' }}</strong>. Menunggu verifikasi admin.
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
