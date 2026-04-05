<!-- Account Detail Modal -->
<div id="accountDetailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[100] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/60 backdrop-blur-sm transition-opacity">
    <div class="relative p-4 w-full max-w-md max-h-full z-[101]">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-slate-900 border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined text-[20px]">badge</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-none">
                            Detail Akun Saya
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Informasi profil yang sedang aktif</p>
                    </div>
                </div>
                <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors" data-modal-toggle="accountDetailModal">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-6">
                <!-- User Avatar in Modal -->
                <div class="flex flex-col items-center justify-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-slate-200 overflow-hidden border-4 border-white dark:border-slate-800 shadow-lg mb-3">
                        <img id="modal-user-avatar" alt="Avatar" class="w-full h-full object-cover shrink-0" src=""/>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="modal-user-role-badge" class="bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 text-[10px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full">
                            Role
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Nama Lengkap</p>
                        <p id="modal-user-name" class="font-semibold text-slate-900 dark:text-white">-</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">ID (NIS/NIP)</p>
                            <p id="modal-user-id" class="font-semibold text-slate-900 dark:text-white font-mono">-</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">No. Telp</p>
                            <p id="modal-user-phone" class="font-semibold text-slate-900 dark:text-white">-</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button data-modal-toggle="accountDetailModal" type="button" class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold px-6 py-2.5 rounded-xl transition-colors text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('/api/admin/profile', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if(response.ok) {
            const data = await response.json();
            
            // Generate Avatar
            const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.full_name)}&background=135bec&color=fff&size=128`;
            
            // Populate Navbar
            document.getElementById('nav-user-name').textContent = data.full_name;
            document.getElementById('nav-user-role').textContent = data.role === 'admin' ? 'Administrator' : 'Staff Petugas';
            document.getElementById('nav-user-avatar').src = avatarUrl;
            
            // Swap skeletons
            document.getElementById('navbar-skeleton').classList.add('hidden');
            document.getElementById('navbar-data').classList.remove('hidden');

            // Populate Modal
            document.getElementById('modal-user-name').textContent = data.full_name;
            document.getElementById('modal-user-id').textContent = data.identity_number;
            document.getElementById('modal-user-phone').textContent = data.phone_number || '-';
            document.getElementById('modal-user-role-badge').textContent = data.role === 'admin' ? 'Administrator' : 'Staff Petugas';
            document.getElementById('modal-user-avatar').src = avatarUrl;
        }
    } catch (error) {
        console.error('Failed to fetch admin profile', error);
    }
});
</script>
