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
    <p class="text-slate-500 mt-1">Kelola data akun Siswa dan Staff secara terpusat</p>
</div>

<!-- Search, Filter, and Add Button Section -->
<div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-8 mt-2">
    <form method="GET" action="{{ route('admin.accounts.index') }}" class="flex flex-wrap md:flex-nowrap items-center gap-3 w-full md:w-auto">
        <div class="relative flex-1 md:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 dark:bg-slate-900 focus:ring-blue-600 focus:border-blue-600 text-sm shadow-sm" placeholder="Cari Nama atau NIS/NIP..." type="text"/>
        </div>
        <button type="submit" class="hidden"></button>
    </form>
    <button data-modal-target="addAccountModal" data-modal-toggle="addAccountModal" type="button" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-blue-600/20 whitespace-nowrap">
        <span class="material-symbols-outlined">person_add</span>
        Tambah Akun Baru
    </button>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                    <th class="px-6 py-4">Nomor Identitas</th>
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Peran</th>
                    <th class="px-6 py-4">Kelas</th>
                    <th class="px-6 py-4">No. Telp</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @forelse($users as $user)
                <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors group">
                    <td class="px-6 py-4 font-mono text-sm text-slate-600 dark:text-slate-400">{{ $user->identity_number }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @php
                                $names = explode(' ', $user->full_name);
                                $initials = strtoupper(substr($names[0] ?? 'A', 0, 1) . substr($names[1] ?? '', 0, 1));
                                $colorClass = $user->role === 'staff' ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400';
                            @endphp
                            <div class="size-8 rounded-full {{ $colorClass }} flex items-center justify-center font-bold text-xs uppercase">{{ $initials }}</div>
                            <span class="text-sm font-bold text-slate-900 dark:text-slate-100">{{ $user->full_name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->role === 'student')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">Siswa</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">Staff Petugas</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->role === 'student')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300">{{ $user->class_name ?? '-' }}</span>
                        @else
                            <span class="text-slate-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $user->phone_number ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button data-modal-target="editAccountModal-{{ $user->user_id }}" data-modal-toggle="editAccountModal-{{ $user->user_id }}" type="button" class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <button data-modal-target="deleteAccountModal-{{ $user->user_id }}" data-modal-toggle="deleteAccountModal-{{ $user->user_id }}" type="button" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Hapus">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Edit Account Modal -->
                <div id="editAccountModal-{{ $user->user_id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
                            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                        <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-none">
                                            Edit Profil Akun
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-1">Perbarui informasi data diri</p>
                                    </div>
                                </div>
                                <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="editAccountModal-{{ $user->user_id }}">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.accounts.user.update', $user->user_id) }}" method="POST" class="p-6">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="form_type" value="edit-{{ $user->user_id }}">
                                <div class="space-y-4 mb-6 p-4">
                                    <div>
                                        <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nomor Identitas (NIS/NIP)</label>
                                        <input type="text" value="{{ $user->identity_number }}" readonly disabled class="bg-slate-50 border border-slate-200 text-slate-500 font-mono text-sm rounded-xl block w-full py-2.5 px-4 dark:bg-slate-800/50 dark:border-slate-700 dark:text-slate-400 cursor-not-allowed shadow-inner">
                                        <p class="mt-1.5 text-[11px] font-medium text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">lock</span>
                                            Atribut ini dikunci oleh sistem (Read-only)
                                        </p>
                                    </div>
                                    <div>
                                        <label for="edit_role_{{ $user->user_id }}" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Peran Akun</label>
                                        <select name="role" id="edit_role_{{ $user->user_id }}" onchange="toggleClassName('edit', this.value, '{{ $user->user_id }}')" required class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm border-slate-200 dark:border-slate-700">
                                            <option value="student" {{ (old('form_type') == 'edit-'.$user->user_id ? old('role') : $user->role) === 'student' ? 'selected' : '' }}>Siswa</option>
                                            <option value="staff" {{ (old('form_type') == 'edit-'.$user->user_id ? old('role') : $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="full_name_{{ $user->user_id }}" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                                        <input type="text" name="full_name" id="full_name_{{ $user->user_id }}" value="{{ old('form_type') == 'edit-'.$user->user_id ? old('full_name', $user->full_name) : $user->full_name }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all {{ old('form_type') == 'edit-'.$user->user_id && $errors->has('full_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required>
                                        @if(old('form_type') == 'edit-'.$user->user_id)
                                            @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div id="edit_class_wrapper_{{ $user->user_id }}" style="display: {{ (old('form_type') == 'edit-'.$user->user_id ? old('role', $user->role) : $user->role) === 'student' ? 'block' : 'none' }}">
                                            <label for="class_name_{{ $user->user_id }}" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Kelas</label>
                                            <input type="text" name="class_name" id="class_name_{{ $user->user_id }}" value="{{ old('form_type') == 'edit-'.$user->user_id ? old('class_name', $user->class_name) : $user->class_name }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all {{ old('form_type') == 'edit-'.$user->user_id && $errors->has('class_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="Contoh: XII RPL 1">
                                            @if(old('form_type') == 'edit-'.$user->user_id)
                                                @error('class_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                            @endif
                                        </div>
                                        <div>
                                            <label for="phone_number_{{ $user->user_id }}" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">No. Telp / WA</label>
                                            <input type="text" name="phone_number" id="phone_number_{{ $user->user_id }}" value="{{ old('form_type') == 'edit-'.$user->user_id ? old('phone_number', $user->phone_number) : $user->phone_number }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all placeholder-slate-300 {{ old('form_type') == 'edit-'.$user->user_id && $errors->has('phone_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="08...">
                                            @if(old('form_type') == 'edit-'.$user->user_id)
                                                @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 pb-4">
                                    <button type="submit" class="w-full text-white inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-600/30 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-500 shadow-lg shadow-blue-600/20 transition-all active:scale-[0.98]">
                                        <span class="material-symbols-outlined mr-2 text-[20px]">save</span>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Account Modal -->
                <div id="deleteAccountModal-{{ $user->user_id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 transform transition-all">
                            <button type="button" class="absolute top-3 end-2.5 text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="deleteAccountModal-{{ $user->user_id }}">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </button>
                            <div class="p-6 text-center">
                                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-red-600 dark:text-red-500 text-[32px]">warning</span>
                                </div>
                                <h3 class="mb-2 text-lg font-bold text-slate-800 dark:text-white">Menghapus Data Akun?</h3>
                                <p class="mb-6 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Tindakan ini permanen. Seluruh riwayat pengaduan dan profil akun <strong>{{ $user->full_name }}</strong> ({{ $user->role === 'student' ? 'Siswa' : 'Staff' }}) akan terhapus sepenuhnya dari sistem.</p>
                                
                                <div class="flex items-center justify-center gap-3">
                                    <button data-modal-toggle="deleteAccountModal-{{ $user->user_id }}" type="button" class="py-2.5 px-5 text-sm font-bold text-slate-700 focus:outline-none bg-slate-100 rounded-xl hover:bg-slate-200 hover:text-slate-900 focus:z-10 focus:ring-4 focus:ring-slate-100 dark:focus:ring-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700 transition-colors">
                                        Batal
                                    </button>
                                    <form action="{{ route('admin.accounts.user.destroy', $user->user_id) }}" method="POST" class="m-0 p-0 inline-block">
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
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        Belum ada data akun.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800">
        {{ $users->links('pagination::tailwind') }}
    </div>
</div>

<!-- Add Account Modal -->
<div id="addAccountModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
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
                            Tambah Akun Baru
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Tambahkan akun akses untuk pengguna baru</p>
                    </div>
                </div>
                <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="addAccountModal">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('admin.accounts.user.store') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="form_type" value="add-account">
                <div class="space-y-4 mb-6 p-4">
                    <div>
                        <label for="add_role" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Peran Akun</label>
                        <select name="role" id="add_role" onchange="toggleClassName('add', this.value)" required class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm border-slate-200 dark:border-slate-700">
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Siswa</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>
                    <div>
                        <label for="identity_number" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nomor Identitas (NIS/NIP)</label>
                        <input type="text" name="identity_number" id="identity_number" value="{{ old('form_type') == 'add-account' ? old('identity_number') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-account' && $errors->has('identity_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="Contoh: 101010">
                        @if(old('form_type') == 'add-account')
                            @error('identity_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @endif
                    </div>
                    <div>
                        <label for="full_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('form_type') == 'add-account' ? old('full_name') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-account' && $errors->has('full_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="Nama Lengkap">
                        @if(old('form_type') == 'add-account')
                            @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @endif
                    </div>
                    <div>
                        <label for="password" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Password</label>
                        <input type="password" name="password" id="password" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-account' && $errors->has('password') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="••••••••">
                        @if(old('form_type') == 'add-account')
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div id="add_class_wrapper" style="display: {{ old('role', 'student') == 'student' ? 'block' : 'none' }}">
                            <label for="new_class_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Kelas</label>
                            <input type="text" name="class_name" id="new_class_name" value="{{ old('form_type') == 'add-account' ? old('class_name') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-account' && $errors->has('class_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="Contoh: XII RPL 1">
                            @if(old('form_type') == 'add-account')
                                @error('class_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            @endif
                        </div>
                        <div>
                            <label for="new_phone_number" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">No. Telp / WA</label>
                            <input type="text" name="phone_number" id="new_phone_number" value="{{ old('form_type') == 'add-account' ? old('phone_number') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:text-white shadow-sm transition-all placeholder-slate-300 {{ old('form_type') == 'add-account' && $errors->has('phone_number') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" placeholder="08...">
                            @if(old('form_type') == 'add-account')
                                @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            @endif
                        </div>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <button type="submit" class="w-full text-white inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-600/30 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-500 shadow-lg shadow-blue-600/20 transition-all active:scale-[0.98]">
                        <span class="material-symbols-outlined mr-2 text-[20px]">add_circle</span>
                        Tambahkan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleClassName(modalPrefix, roleValue, userId = '') {
        const wrapperId = userId ? `${modalPrefix}_class_wrapper_${userId}` : `${modalPrefix}_class_wrapper`;
        const wrapper = document.getElementById(wrapperId);
        const inputId = userId ? `class_name_${userId}` : `new_class_name`;
        const inputField = document.getElementById(inputId);
        
        if (!wrapper) return;
        
        if (roleValue === 'student') {
            wrapper.style.display = 'block';
        } else {
            wrapper.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            @if(old('form_type') === 'add-account')
                const btn = document.querySelector('[data-modal-target="addAccountModal"]');
                if(btn) btn.click();
            @elseif(old('form_type') && strpos(old('form_type'), 'edit-') === 0)
                const editBtn = document.querySelector(`[data-modal-target="editAccountModal-{{ str_replace('edit-', '', old('form_type')) }}"]`);
                if(editBtn) editBtn.click();
            @endif
        }, 300);
    });
</script>
@endsection
