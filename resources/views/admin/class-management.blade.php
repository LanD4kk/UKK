@extends('layouts.app')

@section('title', 'Admin - Manajemen Kategori | SMKN 4 Tangerang')

@section('content')
<!-- Content Header -->
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
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">Daftar Kategori Laporan</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Kelola jenis-jenis permasalahan fasilitas sekolah secara efisien.</p>
    </div>
    <button data-modal-target="addCategoryModal" data-modal-toggle="addCategoryModal" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg shadow-blue-600/20 transition-all active:scale-95">
        <span class="material-symbols-outlined text-[20px]">add_circle</span>
        <span>Tambah Kategori</span>
    </button>
</div>

<!-- Category Table Card -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">ID</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">Nama Kategori</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 text-center">Laporan Terkait</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($categories as $category)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-6 py-5 font-mono text-sm text-slate-500 dark:text-slate-400">#CAT-{{ str_pad($category->category_id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-5">
                        <span class="font-bold text-slate-800 dark:text-white">{{ $category->category_name }}</span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                            {{ $category->complaints_count }} Laporan
                        </span>
                    </td>
                    <td class="px-6 py-5 text-right space-x-2">
                        <button data-modal-target="editCategoryModal-{{ $category->category_id }}" data-modal-toggle="editCategoryModal-{{ $category->category_id }}" type="button" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </button>
                        <button data-modal-target="deleteCategoryModal-{{ $category->category_id }}" data-modal-toggle="deleteCategoryModal-{{ $category->category_id }}" type="button" class="p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-colors" title="Hapus">
                            <span class="material-symbols-outlined text-[20px]">delete</span>
                        </button>
                    </td>
                </tr>

                <!-- Edit Category Modal -->
                <div id="editCategoryModal-{{ $category->category_id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                        <span class="material-symbols-outlined text-[20px]">edit_note</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-none">
                                            Edit Kategori
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-1">Perbarui nama kategori laporan</p>
                                    </div>
                                </div>
                                <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="editCategoryModal-{{ $category->category_id }}">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form action="{{ route('admin.categories.update', $category->category_id) }}" method="POST" class="p-6">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="form_type" value="edit-category-{{ $category->category_id }}">
                                <div class="space-y-5 mb-6 p-4">
                                    <div>
                                        <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">ID Kategori</label>
                                        <input type="text" value="#CAT-{{ str_pad($category->category_id, 3, '0', STR_PAD_LEFT) }}" readonly disabled class="bg-slate-50 border border-slate-200 text-slate-500 font-mono text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-800/50 dark:border-slate-700 dark:text-slate-400 cursor-not-allowed shadow-inner">
                                        <p class="mt-1.5 text-[11px] font-medium text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">lock</span>
                                            Atribut ini dikunci oleh sistem
                                        </p>
                                    </div>
                                    <div>
                                        <label for="category_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Kategori</label>
                                        <input type="text" name="category_name" id="category_name" value="{{ old('form_type') == 'edit-category-'.$category->category_id ? old('category_name', $category->category_name) : $category->category_name }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'edit-category-'.$category->category_id && $errors->has('category_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required>
                                        @if(old('form_type') == 'edit-category-'.$category->category_id)
                                            @error('category_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                        @endif
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

                <!-- Delete Category Modal -->
                <div id="deleteCategoryModal-{{ $category->category_id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 transform transition-all">
                            <button type="button" class="absolute top-3 end-2.5 text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="deleteCategoryModal-{{ $category->category_id }}">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </button>
                            <div class="p-6 text-center">
                                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-red-600 dark:text-red-500 text-[32px]">warning</span>
                                </div>
                                <h3 class="mb-2 text-lg font-bold text-slate-800 dark:text-white">Hapus Kategori Laporan?</h3>
                                @if($category->complaints_count > 0)
                                    <p class="mb-6 text-sm text-red-600 dark:text-red-400 font-medium leading-relaxed">
                                        Perhatian! Terdapat <strong>{{ $category->complaints_count }} laporan</strong> yang terkait dengan kategori <strong>{{ $category->category_name }}</strong>. Anda tidak dapat menghapus kategori ini sebelum laporan-laporan tersebut dipindahkan atau dihapus.
                                    </p>
                                    <div class="flex items-center justify-center gap-3">
                                        <button data-modal-toggle="deleteCategoryModal-{{ $category->category_id }}" type="button" class="py-2.5 px-5 text-sm font-bold text-white focus:outline-none bg-blue-600 rounded-xl hover:bg-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-300 transition-colors w-full">
                                            Kembali
                                        </button>
                                    </div>
                                @else
                                    <p class="mb-6 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Peringatan: Kategori <strong>{{ $category->category_name }}</strong> akan terhapus sepenuhnya dari sistem.</p>
                                    
                                    <div class="flex items-center justify-center gap-3">
                                        <button data-modal-toggle="deleteCategoryModal-{{ $category->category_id }}" type="button" class="py-2.5 px-5 text-sm font-bold text-slate-700 focus:outline-none bg-slate-100 rounded-xl hover:bg-slate-200 hover:text-slate-900 focus:z-10 focus:ring-4 focus:ring-slate-100 dark:focus:ring-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700 transition-colors">
                                            Batal
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category->category_id) }}" method="POST" class="m-0 p-0 inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-bold rounded-xl text-sm inline-flex items-center px-5 py-2.5 text-center transition-all shadow-lg shadow-red-600/20 active:scale-[0.98]">
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                        Belum ada data kategori.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-6 py-4 flex items-center justify-between border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
        <div class="w-full">
            {{ $categories->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined text-[20px]">category</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-none">
                            Tambah Kategori
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Tambahkan kategori laporan baru</p>
                    </div>
                </div>
                <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="addCategoryModal">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="form_type" value="add-category">
                <div class="space-y-5 mb-6 p-4">
                    <div>
                        <label for="category_name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Kategori</label>
                        <input type="text" name="category_name" id="category_name" value="{{ old('form_type') == 'add-category' ? old('category_name') : '' }}" class="bg-white border text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full py-2.5 px-4 dark:bg-slate-900 dark:placeholder-slate-500 dark:text-white shadow-sm transition-all {{ old('form_type') == 'add-category' && $errors->has('category_name') ? 'border-red-500 dark:border-red-500' : 'border-slate-200 dark:border-slate-700' }}" required placeholder="Contoh: Infrastruktur">
                        @if(old('form_type') == 'add-category')
                            @error('category_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @endif
                    </div>
                </div>
                <div class="p-4">
                    <button type="submit" class="w-full text-white inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-600/30 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-500 shadow-lg shadow-blue-600/20 transition-all active:scale-[0.98]">
                        <span class="material-symbols-outlined mr-2 text-[20px]">add_circle</span>
                        Tambahkan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            @if(old('form_type') === 'add-category')
                const addModalBtn = document.querySelector('[data-modal-target="addCategoryModal"]');
                if(addModalBtn) addModalBtn.click();
            @elseif(old('form_type') && strpos(old('form_type'), 'edit-category-') === 0)
                const editModalBtn = document.querySelector(`[data-modal-target="editCategoryModal-{{ str_replace('edit-category-', '', old('form_type')) }}"]`);
                if(editModalBtn) editModalBtn.click();
            @endif
        }, 300);
    });
</script>
@endsection
