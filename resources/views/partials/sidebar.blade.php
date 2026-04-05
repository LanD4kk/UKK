<div class="p-6 flex items-center gap-3">
    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shrink-0">
        <span class="material-symbols-outlined text-2xl">school</span>
    </div>
    <div>
        <h1 class="text-sm font-bold tracking-tight text-slate-900 dark:text-white">SMKN 4 Tangerang</h1>
        <p class="text-[10px] text-slate-500 uppercase tracking-widest font-semibold">Facility Management</p>
    </div>
</div>

<nav class="flex-1 px-4 py-4 space-y-2">
    <a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600' }} transition-all {{ request()->is('admin/dashboard') ? 'hover:scale-[1.02]' : '' }}" href="/admin/dashboard">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-sm font-medium">Dashboard</span>
    </a>

    <a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/accounts') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600' }} transition-all {{ request()->is('admin/accounts') ? 'hover:scale-[1.02]' : '' }}" href="/admin/accounts">
        <span class="material-symbols-outlined">group</span>
        <span class="text-sm font-medium">Manajemen Akun</span>
    </a>

    <a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/categories') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600' }} transition-all {{ request()->is('admin/categories') ? 'hover:scale-[1.02]' : '' }}" href="/admin/categories">
        <span class="material-symbols-outlined">sell</span>
        <span class="text-sm font-medium">Manajemen Kategori</span>
    </a>

    <a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/aspirations') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600' }} transition-all {{ request()->is('admin/aspirations') ? 'hover:scale-[1.02]' : '' }}" href="/admin/aspirations">
        <span class="material-symbols-outlined">inbox</span>
        <span class="text-sm font-medium">Manajemen Aspirasi</span>
    </a>

    <a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/aspirations/histori') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600' }} transition-all {{ request()->is('admin/aspirations/histori') ? 'hover:scale-[1.02]' : '' }}" href="/admin/aspirations/histori">
        <span class="material-symbols-outlined">history</span>
        <span class="text-sm font-medium">Histori Aspirasi</span>
    </a>
</nav>

<div class="p-4 mt-auto">
    <form method="POST" action="{{ route('logout') }}" class="w-full">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 font-semibold text-sm transition-colors cursor-pointer outline-none">
            <span class="material-symbols-outlined text-[20px]">logout</span>
            <span>Logout</span>
        </button>
    </form>
</div>