@extends('layouts.app')

@section('title', 'Admin - Manajemen Siswa | SMKN 4 Tangerang')

@section('content')

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

<!-- Page Title Section -->
<div class="mb-6">
    <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Student Management</h2>
    <p class="text-slate-500 mt-1">Manage student data and information</p>
</div>

<!-- Search, Filter, and Add Button Section -->
<div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-8">
    <div class="flex items-center gap-3 w-full md:max-w-2xl">
        <div class="relative flex-1">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-blue-600 focus:border-blue-600 text-sm shadow-sm" placeholder="Cari Nama atau NIS..." type="text"/>
        </div>
        <div class="relative w-48">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">filter_list</span>
            <select class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-blue-600 focus:border-blue-600 text-sm appearance-none shadow-sm cursor-pointer">
                <option value="">Semua Kelas</option>
                <option value="XII RPL 1">XII RPL 1</option>
                <option value="XII RPL 2">XII RPL 2</option>
                <option value="XI TKJ 1">XI TKJ 1</option>
                <option value="XI TKJ 2">XI TKJ 2</option>
                <option value="X TKR 1">X TKR 1</option>
                <option value="X TKR 2">X TKR 2</option>
            </select>
        </div>
    </div>
    <button class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-blue-600/20 whitespace-nowrap">
        <span class="material-symbols-outlined">person_add</span>
        Tambah Siswa Baru
    </button>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                    <th class="px-6 py-4">NIS</th>
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Kelas</th>
                    <th class="px-6 py-4">No. Telp</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($students as $student)
                    <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors group">
                        <td class="px-6 py-4 font-mono text-sm text-slate-600 dark:text-slate-400">{{ $student->identity_number }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $names = explode(' ', $student->full_name);
                                    $initials = strtoupper(substr($names[0] ?? 'A', 0, 1) . substr($names[1] ?? '', 0, 1));
                                @endphp
                                <div class="size-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-xs uppercase">{{ $initials }}</div>
                                <span class="text-sm font-bold text-slate-900 dark:text-slate-100">{{ $student->full_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">{{ $student->class_name ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $student->phone_number ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button data-modal-target="editStudentModal-{{ $student->user_id }}" data-modal-toggle="editStudentModal-{{ $student->user_id }}" type="button" class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </button>
                                <button data-modal-target="deleteStudentModal-{{ $student->user_id }}" data-modal-toggle="deleteStudentModal-{{ $student->user_id }}" type="button" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Student Modal -->
                    <div id="editStudentModal-{{ $student->user_id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                            <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-none">
                                                Edit Profil Siswa
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-1">Perbarui informasi data diri siswa</p>
                                        </div>
                                    </div>
                                    <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="editStudentModal-{{ $student->user_id }}">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form action="{{ route('admin.students.update', $student->user_id) }}" method="POST" class="p-6">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-5 mb-6 p-4">
                                        <div>
                                            <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nomor Identitas (NIS)</label>
                                            <input type="text" value="{{ $student->identity_number }}" readonly disabled class="bg-slate-50 border border-slate-200 text-slate-500 font-mono text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-800/50 dark:border-slate-700 dark:text-slate-400 cursor-not-allowed shadow-inner">
                                            <p class="mt-1.5 text-[11px] font-medium text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">lock</span>
                                                Atribut ini dikunci oleh sistem (Read-only)
                                            </p>
                                        </div>
                                        <div>
                                            <label for="full_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                                            <input type="text" name="full_name" id="full_name" value="{{ $student->full_name }}" class="bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:border-slate-700 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all" required>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="class_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Kelas</label>
                                                <div class="relative">
                                                    <select name="class_name" id="class_name" class="bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 pl-4 pr-10 appearance-none dark:bg-slate-900 dark:border-slate-700 dark:text-white shadow-sm transition-all cursor-pointer">
                                                        <option value="">Pilih</option>
                                                        <option value="XII RPL 1" {{ $student->class_name == 'XII RPL 1' ? 'selected' : '' }}>XII RPL 1</option>
                                                        <option value="XII RPL 2" {{ $student->class_name == 'XII RPL 2' ? 'selected' : '' }}>XII RPL 2</option>
                                                        <option value="XI TKJ 1" {{ $student->class_name == 'XI TKJ 1' ? 'selected' : '' }}>XI TKJ 1</option>
                                                        <option value="XI TKJ 2" {{ $student->class_name == 'XI TKJ 2' ? 'selected' : '' }}>XI TKJ 2</option>
                                                        <option value="X TKR 1" {{ $student->class_name == 'X TKR 1' ? 'selected' : '' }}>X TKR 1</option>
                                                        <option value="X TKR 2" {{ $student->class_name == 'X TKR 2' ? 'selected' : '' }}>X TKR 2</option>
                                                    </select>
                                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[20px]">expand_more</span>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="phone_number" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">No. Telp / WA</label>
                                                <input type="text" name="phone_number" id="phone_number" value="{{ $student->phone_number }}" class="bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:border-slate-700 dark:text-white shadow-sm transition-all placeholder-slate-300" placeholder="08...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                    <button type="submit" class="w-full text-white inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-600/30 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-500 shadow-lg shadow-blue-600/20 transition-all active:scale-[0.98]">
                                        <span class="material-symbols-outlined mr-2 text-[20px]">save</span>
                                        Simpan Perubahan
                                    </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Student Modal -->
                    <div id="deleteStudentModal-{{ $student->user_id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 transform transition-all">
                                <button type="button" class="absolute top-3 end-2.5 text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="deleteStudentModal-{{ $student->user_id }}">
                                    <span class="material-symbols-outlined text-[20px]">close</span>
                                </button>
                                <div class="p-6 text-center">
                                    <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4">
                                        <span class="material-symbols-outlined text-red-600 dark:text-red-500 text-[32px]">warning</span>
                                    </div>
                                    <h3 class="mb-2 text-lg font-bold text-slate-800 dark:text-white">Menghapus Data Siswa?</h3>
                                    <p class="mb-6 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Tindakan ini permanen. Seluruh riwayat pengaduan dan profil akun <strong>{{ $student->full_name }}</strong> akan terhapus sepenuhnya dari sistem.</p>
                                    
                                    <div class="flex items-center justify-center gap-3">
                                        <button data-modal-toggle="deleteStudentModal-{{ $student->user_id }}" type="button" class="py-2.5 px-5 text-sm font-bold text-slate-700 focus:outline-none bg-slate-100 rounded-xl hover:bg-slate-200 hover:text-slate-900 focus:z-10 focus:ring-4 focus:ring-slate-100 dark:focus:ring-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700 transition-colors">
                                            Batal
                                        </button>
                                        <form action="{{ route('admin.students.destroy', $student->user_id) }}" method="POST" class="m-0 p-0 inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-bold rounded-xl text-sm inline-flex items-center px-5 py-2.5 text-center transition-all shadow-lg shadow-red-600/20 active:scale-[0.98]">
                                                Ya, Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data siswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800">
        {{ $students->links('pagination::tailwind') }}
    </div>
</div>
@endsection
