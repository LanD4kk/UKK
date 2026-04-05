<div class="flex-1 max-w-xl">
    <img src="/img/logo.png" alt="S-Patch Logo" class="h-10 w-auto object-contain" />
</div>

<div class="flex items-center gap-4">
    <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700 mx-2"></div>
    
    <!-- Profile Container (clickable for modal) -->
    <div class="flex items-center gap-3 cursor-pointer group" id="navbar-profile-btn" data-modal-target="accountDetailModal" data-modal-toggle="accountDetailModal">
        <div class="text-right hidden sm:block">
            <!-- Skeleton Loading -->
            <div id="navbar-skeleton" class="flex flex-col items-end gap-1">
                <div class="h-4 w-24 bg-slate-200 dark:bg-slate-700 rounded animate-pulse"></div>
                <div class="h-3 w-16 bg-slate-200 dark:bg-slate-700 rounded animate-pulse"></div>
            </div>
            
            <!-- Fetched Data Container -->
            <div id="navbar-data" class="hidden">
                <p id="nav-user-name" class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors"></p>
                <p id="nav-user-role" class="text-[10px] text-slate-500 font-medium capitalize"></p>
            </div>
        </div>
        <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border border-slate-300 dark:border-slate-600 ring-2 ring-transparent group-hover:ring-blue-600/20 transition-all">
            <img id="nav-user-avatar" alt="User avatar" class="w-full h-full object-cover" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="/>
        </div>
    </div>
</div>