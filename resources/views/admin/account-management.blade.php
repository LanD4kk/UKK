@extends('layouts.app')

@section('title', 'Admin - Manajemen Akun | SMKN 4 Tangerang')

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

@if($errors->any() && !old('form_type'))
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
    <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Manajemen Akun</h2>
    <p class="text-slate-500 mt-1">Kelola data akun Siswa dan Staff</p>
</div>

<!-- Tabs Component -->
<div class="mb-4 border-b border-slate-200 dark:border-slate-800">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="account-tabs" data-tabs-toggle="#account-tab-content" role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg aria-selected:text-blue-600 aria-selected:border-blue-600 text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300 border-transparent focus:ring-0" id="student-tab" data-tabs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="{{ request('tab', 'student') == 'student' ? 'true' : 'false' }}">Modul Siswa</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg aria-selected:text-blue-600 aria-selected:border-blue-600 text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300 border-transparent focus:ring-0" id="staff-tab" data-tabs-target="#staff" type="button" role="tab" aria-controls="staff" aria-selected="{{ request('tab') == 'staff' ? 'true' : 'false' }}">Modul Staff</button>
        </li>
    </ul>
</div>

<div id="account-tab-content">
    
    <!-- TAB 1: SISWA -->
    <div class="hidden" id="student" role="tabpanel" aria-labelledby="student-tab">
        <!-- Search, Filter, and Add Button Section -->
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-8 mt-2">
            <form method="GET" action="{{ route('admin.accounts.index') }}" class="flex items-center gap-3 w-full md:max-w-2xl">
                <input type="hidden" name="tab" value="student">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-blue-600 focus:border-blue-600 text-sm shadow-sm" placeholder="Cari Nama atau NIS..." type="text"/>
                </div>
                <div class="relative w-48">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">filter_list</span>
                    <select name="class_name" onchange="this.form.submit()" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-blue-600 focus:border-blue-600 text-sm appearance-none shadow-sm cursor-pointer">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $c)
                            <option value="{{ $c }}" {{ request('class_name') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="hidden"></button>
            </form>
            <button data-modal-target="addStudentModal" data-modal-toggle="addStudentModal" type="button" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-blue-600/20 whitespace-nowrap">
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
                                        <form action="{{ route('admin.accounts.student.update', $student->user_id) }}" method="POST" class="p-6">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="form_type" value="edit-{{ $student->user_id }}">
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
                                                    <input type="text" name="full_name" id="full_name" value="{{ old('form_type') == 'edit-'.$student->user_id ? old('full_name', $student->full_name) : $student->full_name }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all {{ old('form_type') == 'edit-'.$student->user_id && $errors->has('full_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required>
                                                    @if(old('form_type') == 'edit-'.$student->user_id)
                                                        @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                                    @endif
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="class_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Kelas</label>
                                                        <input type="text" name="class_name" id="class_name" value="{{ old('form_type') == 'edit-'.$student->user_id ? old('class_name', $student->class_name) : $student->class_name }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all {{ old('form_type') == 'edit-'.$student->user_id && $errors->has('class_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="Contoh: XII RPL 1" required>
                                                        @if(old('form_type') == 'edit-'.$student->user_id)
                                                            @error('class_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <label for="phone_number" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">No. Telp / WA</label>
                                                        <input type="text" name="phone_number" id="phone_number" value="{{ old('form_type') == 'edit-'.$student->user_id ? old('phone_number', $student->phone_number) : $student->phone_number }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all placeholder-slate-300 {{ old('form_type') == 'edit-'.$student->user_id && $errors->has('phone_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="08...">
                                                        @if(old('form_type') == 'edit-'.$student->user_id)
                                                            @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                                        @endif
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
                                                <form action="{{ route('admin.accounts.student.destroy', $student->user_id) }}" method="POST" class="m-0 p-0 inline-block">
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
                {{ $students->appends(['tab' => 'student'])->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Add Student Modal -->
        <div id="addStudentModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <span class="material-symbols-outlined text-[20px]">person_add</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-none">
                                    Tambah Siswa Baru
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">Tambahkan akun akses untuk siswa</p>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="addStudentModal">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="{{ route('admin.accounts.student.store') }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="form_type" value="add-student">
                        <div class="space-y-5 mb-6 p-4">
                            <div>
                                <label for="identity_number" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nomor Identitas (NIS)</label>
                                <input type="text" name="identity_number" id="identity_number" value="{{ old('form_type') == 'add-student' ? old('identity_number') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-student' && $errors->has('identity_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="Contoh: 101010">
                                @if(old('form_type') == 'add-student')
                                    @error('identity_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @endif
                            </div>
                            <div>
                                <label for="full_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('form_type') == 'add-student' ? old('full_name') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-student' && $errors->has('full_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="Nama Lengkap Siswa">
                                @if(old('form_type') == 'add-student')
                                    @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @endif
                            </div>
                            <div>
                                <label for="password" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Password</label>
                                <input type="password" name="password" id="password" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-student' && $errors->has('password') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="••••••••">
                                @if(old('form_type') == 'add-student')
                                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="new_class_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Kelas</label>
                                    <input type="text" name="class_name" id="new_class_name" value="{{ old('form_type') == 'add-student' ? old('class_name') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-student' && $errors->has('class_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="Contoh: XII RPL 1" required>
                                    @if(old('form_type') == 'add-student')
                                        @error('class_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    @endif
                                </div>
                                <div>
                                    <label for="new_phone_number" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">No. Telp / WA</label>
                                    <input type="text" name="phone_number" id="new_phone_number" value="{{ old('form_type') == 'add-student' ? old('phone_number') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all placeholder-slate-300 {{ old('form_type') == 'add-student' && $errors->has('phone_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="08...">
                                    @if(old('form_type') == 'add-student')
                                        @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <button type="submit" class="w-full text-white inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-600/30 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-500 shadow-lg shadow-blue-600/20 transition-all active:scale-[0.98]">
                                <span class="material-symbols-outlined mr-2 text-[20px]">add_circle</span>
                                Tambahkan Akun Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- TAB 2: STAFF -->
    <div class="hidden" id="staff" role="tabpanel" aria-labelledby="staff-tab">
        <!-- Search and Add Button Section for Staff -->
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-8 mt-2">
            <form method="GET" action="{{ route('admin.accounts.index') }}" class="flex items-center gap-3 w-full md:max-w-2xl">
                <input type="hidden" name="tab" value="staff">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-blue-600 focus:border-blue-600 text-sm shadow-sm" placeholder="Cari Nama atau NIP Staff..." type="text"/>
                </div>
                <button type="submit" class="hidden"></button>
            </form>
            <button data-modal-target="addStaffModal" data-modal-toggle="addStaffModal" type="button" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-indigo-600/20 whitespace-nowrap">
                <span class="material-symbols-outlined">person_add</span>
                Tambah Staff Baru
            </button>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">NIP</th>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Peran</th>
                            <th class="px-6 py-4">No. Telp</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @forelse($staffs as $staff)
                            <tr class="hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 transition-colors group">
                                <td class="px-6 py-4 font-mono text-sm text-slate-600 dark:text-slate-400">{{ $staff->identity_number }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $names = explode(' ', $staff->full_name);
                                            $initials = strtoupper(substr($names[0] ?? 'A', 0, 1) . substr($names[1] ?? '', 0, 1));
                                        @endphp
                                        <div class="size-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase">{{ $initials }}</div>
                                        <span class="text-sm font-bold text-slate-900 dark:text-slate-100">{{ $staff->full_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">Staff Petugas</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $staff->phone_number ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button data-modal-target="editStaffModal-{{ $staff->user_id }}" data-modal-toggle="editStaffModal-{{ $staff->user_id }}" type="button" class="p-1.5 rounded-lg text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                        <button data-modal-target="deleteStaffModal-{{ $staff->user_id }}" data-modal-toggle="deleteStaffModal-{{ $staff->user_id }}" type="button" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Staff Modal -->
                            <div id="editStaffModal-{{ $staff->user_id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
                                        <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                                    <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-none">
                                                        Edit Profil Staff
                                                    </h3>
                                                    <p class="text-xs text-slate-500 mt-1">Perbarui informasi staff terpilih</p>
                                                </div>
                                            </div>
                                            <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="editStaffModal-{{ $staff->user_id }}">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.accounts.staff.update', $staff->user_id) }}" method="POST" class="p-6">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="form_type" value="edit-staff-{{ $staff->user_id }}">
                                            <div class="space-y-5 mb-6 p-4">
                                                <div>
                                                    <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nomor Identitas Pegawai (NIP)</label>
                                                    <input type="text" value="{{ $staff->identity_number }}" readonly disabled class="bg-slate-50 border border-slate-200 text-slate-500 font-mono text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full py-2.5 px-4 dark:bg-slate-800/50 dark:border-slate-700 dark:text-slate-400 cursor-not-allowed shadow-inner">
                                                    <p class="mt-1.5 text-[11px] font-medium text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                                        <span class="material-symbols-outlined text-[14px]">lock</span>
                                                        Atribut ini dikunci oleh sistem (Read-only)
                                                    </p>
                                                </div>
                                                <div>
                                                    <label for="full_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                                                    <input type="text" name="full_name" id="full_name" value="{{ old('form_type') == 'edit-staff-'.$staff->user_id ? old('full_name', $staff->full_name) : $staff->full_name }}" class="bg-white border text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all {{ old('form_type') == 'edit-staff-'.$staff->user_id && $errors->has('full_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required>
                                                    @if(old('form_type') == 'edit-staff-'.$staff->user_id)
                                                        @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                                    @endif
                                                </div>
                                                <div>
                                                    <label for="phone_number" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">No. Telp / WA</label>
                                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('form_type') == 'edit-staff-'.$staff->user_id ? old('phone_number', $staff->phone_number) : $staff->phone_number }}" class="bg-white border text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all placeholder-slate-300 {{ old('form_type') == 'edit-staff-'.$staff->user_id && $errors->has('phone_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="08...">
                                                    @if(old('form_type') == 'edit-staff-'.$staff->user_id)
                                                        @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="p-4">
                                            <button type="submit" class="w-full text-white inline-flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-600/30 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-indigo-600 dark:hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition-all active:scale-[0.98]">
                                                <span class="material-symbols-outlined mr-2 text-[20px]">save</span>
                                                Simpan Perubahan
                                            </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Staff Modal -->
                            <div id="deleteStaffModal-{{ $staff->user_id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 transform transition-all">
                                        <button type="button" class="absolute top-3 end-2.5 text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="deleteStaffModal-{{ $staff->user_id }}">
                                            <span class="material-symbols-outlined text-[20px]">close</span>
                                        </button>
                                        <div class="p-6 text-center">
                                            <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4">
                                                <span class="material-symbols-outlined text-red-600 dark:text-red-500 text-[32px]">warning</span>
                                            </div>
                                            <h3 class="mb-2 text-lg font-bold text-slate-800 dark:text-white">Menghapus Data Staff?</h3>
                                            <p class="mb-6 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Tindakan ini permanen. Profil akun <strong>{{ $staff->full_name }}</strong> akan terhapus sepenuhnya dari sistem.</p>
                                            
                                            <div class="flex items-center justify-center gap-3">
                                                <button data-modal-toggle="deleteStaffModal-{{ $staff->user_id }}" type="button" class="py-2.5 px-5 text-sm font-bold text-slate-700 focus:outline-none bg-slate-100 rounded-xl hover:bg-slate-200 hover:text-slate-900 focus:z-10 focus:ring-4 focus:ring-slate-100 dark:focus:ring-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700 transition-colors">
                                                    Batal
                                                </button>
                                                <form action="{{ route('admin.accounts.staff.destroy', $staff->user_id) }}" method="POST" class="m-0 p-0 inline-block">
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
                                    Belum ada data staff yang terdaftar.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800">
                {{ $staffs->appends(['tab' => 'staff'])->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Add Staff Modal -->
        <div id="addStaffModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
                    <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <span class="material-symbols-outlined text-[20px]">person_add</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-none">
                                    Tambah Staff Baru
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">Tambahkan akun akses untuk staff petugas</p>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="addStaffModal">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.accounts.staff.store') }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="form_type" value="add-staff">
                        <div class="space-y-5 mb-6 p-4">
                            <div>
                                <label for="identity_number_staff" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nomor Identitas Pegawai (NIP)</label>
                                <input type="text" name="identity_number" id="identity_number_staff" value="{{ old('form_type') == 'add-staff' ? old('identity_number') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-staff' && $errors->has('identity_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="Contoh: 198001012010011001">
                                @if(old('form_type') == 'add-staff')
                                    @error('identity_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @endif
                            </div>
                            <div>
                                <label for="full_name_staff" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                                <input type="text" name="full_name" id="full_name_staff" value="{{ old('form_type') == 'add-staff' ? old('full_name') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-staff' && $errors->has('full_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="Nama Lengkap Staff">
                                @if(old('form_type') == 'add-staff')
                                    @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @endif
                            </div>
                            <div>
                                <label for="password_staff" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Password</label>
                                <input type="password" name="password" id="password_staff" class="bg-white border text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-staff' && $errors->has('password') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="••••••••">
                                @if(old('form_type') == 'add-staff')
                                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @endif
                            </div>
                            <div>
                                <label for="new_phone_number_staff" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">No. Telp / WA</label>
                                <input type="text" name="phone_number" id="new_phone_number_staff" value="{{ old('form_type') == 'add-staff' ? old('phone_number') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all placeholder-slate-300 {{ old('form_type') == 'add-staff' && $errors->has('phone_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="08...">
                                @if(old('form_type') == 'add-staff')
                                    @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @endif
                            </div>
                        </div>
                        <div class="p-4">
                            <button type="submit" class="w-full text-white inline-flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-600/30 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-indigo-600 dark:hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition-all active:scale-[0.98]">
                                <span class="material-symbols-outlined mr-2 text-[20px]">add_circle</span>
                                Tambahkan Akun Staff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            @if(old('form_type') === 'add-student')
                const btn = document.querySelector('[data-modal-target="addStudentModal"]');
                if(btn) btn.click();
            @elseif(old('form_type') && strpos(old('form_type'), 'edit-') === 0 && strpos(old('form_type'), 'edit-staff-') === false)
                const editBtn = document.querySelector(`[data-modal-target="editStudentModal-{{ str_replace('edit-', '', old('form_type')) }}"]`);
                if(editBtn) editBtn.click();
            @elseif(old('form_type') === 'add-staff')
                const staffBtn = document.querySelector('[data-modal-target="addStaffModal"]');
                if(staffBtn) {
                    staffBtn.click();
                    const staffTab = document.getElementById('staff-tab');
                    if(staffTab) staffTab.click();
                }
            @elseif(old('form_type') && strpos(old('form_type'), 'edit-staff-') === 0)
                const editStaffBtn = document.querySelector(`[data-modal-target="editStaffModal-{{ str_replace('edit-staff-', '', old('form_type')) }}"]`);
                if(editStaffBtn) {
                    editStaffBtn.click();
                    const staffTab = document.getElementById('staff-tab');
                    if(staffTab) staffTab.click();
                }
            @endif
        }, 300); // Beri jeda 300ms agar script Flowbite selesai inisialisasi
    });
</script>
@endsection
