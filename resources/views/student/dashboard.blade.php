<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Student Dashboard - S - Patch</title>
    
    <script src="/js/tailwind.min.js"></script>
    <link href="/css/google-fonts.css" rel="stylesheet"/>
    <link href="/css/material-symbols.css" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Lexend"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    
    <style>
        body { font-family: 'Lexend', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Skeleton loading animation */
        .skeleton {
            background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 50%, #e5e7eb 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 0.5rem;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Fade in animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeInUp 0.4s ease both; }
        .fade-in-delay-1 { animation: fadeInUp 0.4s 0.1s ease both; }
        .fade-in-delay-2 { animation: fadeInUp 0.4s 0.2s ease both; }
        .fade-in-delay-3 { animation: fadeInUp 0.4s 0.3s ease both; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark min-h-screen font-display">

    <!-- Header -->
    <header class="sticky top-0 z-50 w-full bg-white dark:bg-background-dark border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <img src="/img/logo.png" alt="S-Patch Logo" class="h-10 w-auto object-contain" />
                </div>
                <div class="flex items-center gap-4">
                    <!-- User Info (diisi dari API) -->
                    <div class="hidden md:flex flex-col items-end">
                        <span id="header-name" class="text-sm font-semibold text-gray-900 dark:text-white">
                            <span class="skeleton inline-block w-28 h-4 rounded">&nbsp;</span>
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Siswa SMKN 4 Tangerang</span>
                    </div>
                    <!-- Avatar (diisi dari API) -->
                    <div id="header-avatar" class="h-10 w-10 rounded-full bg-primary/10 border-2 border-primary/20 flex items-center justify-center overflow-hidden">
                        <span class="skeleton w-full h-full rounded-full inline-block">&nbsp;</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-sm transition-colors cursor-pointer outline-none">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-[1200px] mx-auto px-4 py-8 sm:px-6 lg:px-8">

        <!-- Hero Banner Skeleton → diisi API -->
        <div id="hero-section" class="relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 p-8 md:p-12 mb-8 shadow-xl shadow-primary/20">
            <div class="absolute right-[-20px] top-[-20px] opacity-10">
                <span class="material-symbols-outlined !text-[200px]">assignment</span>
            </div>
            <div class="relative z-10">
                <h2 id="hero-greeting" class="text-3xl md:text-4xl font-extrabold text-white mb-2">
                    <span class="skeleton inline-block w-64 h-9 rounded">&nbsp;</span>
                </h2>
                <div class="flex flex-wrap items-center gap-4 text-blue-100">
                    <div id="hero-nis" class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">badge</span>
                        <span class="skeleton inline-block w-32 h-4 rounded">&nbsp;</span>
                    </div>
                    <div class="w-1 h-1 bg-blue-300 rounded-full"></div>
                    <div id="hero-class" class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">school</span>
                        <span class="skeleton inline-block w-28 h-4 rounded">&nbsp;</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            <!-- Total Laporan -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm fade-in">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mb-1">Total Laporan</p>
                        <h3 id="stat-total" class="text-3xl font-bold text-gray-900 dark:text-white">
                            <span class="skeleton inline-block w-10 h-8 rounded">&nbsp;</span>
                        </h3>
                    </div>
                    <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-300">description</span>
                    </div>
                </div>
            </div>

            <!-- Dalam Proses -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm fade-in-delay-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mb-1">Dalam Proses</p>
                        <h3 id="stat-inprogress" class="text-3xl font-bold text-primary">
                            <span class="skeleton inline-block w-10 h-8 rounded">&nbsp;</span>
                        </h3>
                    </div>
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <span class="material-symbols-outlined text-primary">sync</span>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm fade-in-delay-2">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mb-1">Selesai</p>
                        <h3 id="stat-resolved" class="text-3xl font-bold text-green-600">
                            <span class="skeleton inline-block w-10 h-8 rounded">&nbsp;</span>
                        </h3>
                    </div>
                    <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Laporan -->
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 fade-in-delay-3">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Riwayat Laporan</h3>
            <span id="complaint-count" class="text-xs text-gray-400 font-medium whitespace-nowrap"></span>
        </div>


        <!-- List Complaints (diisi dari API) -->
        <div id="complaints-list" class="flex flex-col gap-4 mb-20">
            <!-- Skeleton items saat loading -->
            <div class="skeleton h-20 w-full rounded-xl"></div>
            <div class="skeleton h-20 w-full rounded-xl"></div>
            <div class="skeleton h-20 w-full rounded-xl"></div>
        </div>

        <!-- Error State -->
        <div id="error-state" class="hidden flex flex-col items-center justify-center py-16 text-center">
            <span class="material-symbols-outlined text-5xl text-red-400 mb-3">wifi_off</span>
            <p class="text-gray-600 dark:text-gray-300 font-semibold text-lg">Gagal memuat data</p>
            <p class="text-gray-400 text-sm mb-5">Terjadi kesalahan saat mengambil data dari server.</p>
            <button onclick="fetchDashboard()" class="px-5 py-2 bg-primary text-white font-bold rounded-lg text-sm hover:bg-blue-700 transition-colors">
                Coba Lagi
            </button>
        </div>

    </main>

    <!-- Floating Action Button -->
    <a href="/student/create-report" class="fixed bottom-8 right-8 flex items-center gap-3 bg-primary text-white p-4 pr-6 rounded-full shadow-2xl shadow-primary/40 hover:scale-105 active:scale-95 transition-transform z-50">
        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined">edit</span>
        </div>
        <span class="font-bold tracking-wide">Buat Laporan</span>
    </a>

    <script>
        // ─── Status Badge Helper ───────────────────────────────────────────────
        const STATUS_CONFIG = {
            'Pending': {
                badge: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                label: 'Pending',
            },
            'In Progress': {
                badge: 'bg-blue-100 text-primary dark:bg-primary/20 dark:text-blue-300',
                label: 'In Progress',
                pulse: true,
            },
            'Resolved': {
                badge: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                label: 'Selesai',
            },
            'Rejected': {
                badge: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                label: 'Rejected',
            },
        };

        function getStatusBadge(status) {
            const cfg = STATUS_CONFIG[status] || { badge: 'bg-gray-100 text-gray-600', label: status };
            const pulse = cfg.pulse
                ? `<span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse mr-1 inline-block"></span>`
                : '';
            return `<span class="inline-flex items-center ${cfg.badge} text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                        ${pulse}${cfg.label}
                    </span>`;
        }

        function getCategoryIcon(category) {
            const map = {
                'Classroom Facilities': 'chair',
                'Cleanliness': 'cleaning_services',
                'Security': 'security',
            };
            return map[category] ?? 'report';
        }

        // ─── Render Complaints ─────────────────────────────────────────────────
        function renderComplaints(complaints) {
            const list = document.getElementById('complaints-list');

            if (!complaints || complaints.length === 0) {
                list.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">inbox</span>
                        <p class="text-gray-500 font-semibold">Belum ada laporan</p>
                        <p class="text-gray-400 text-sm mt-1">Klik tombol <strong>Buat Laporan</strong> di bawah untuk memulai.</p>
                    </div>`;
                return;
            }

            document.getElementById('complaint-count').textContent = `${complaints.length} laporan`;

            list.innerHTML = complaints.map((c, i) => {
                const icon = getCategoryIcon(c.category);
                const badge = getStatusBadge(c.status);
                const hasResponse = c.responses > 0;
                const responseBadge = hasResponse
                    ? `<span class="flex items-center gap-1 text-[11px] font-bold text-primary bg-primary/5 px-2 py-0.5 rounded border border-primary/10 ml-2">
                            <span class="material-symbols-outlined text-xs">notifications</span>
                            ${c.responses} Tanggapan
                       </span>`
                    : '';

                return `
                    <a href="/student/report/${c.id}"
                       class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center gap-4
                              hover:border-primary/30 hover:shadow-md transition-all cursor-pointer fade-in"
                       style="animation-delay: ${i * 60}ms">
                        <div class="w-14 h-14 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-600 dark:text-gray-300 shrink-0">
                            <span class="material-symbols-outlined !text-3xl">${icon}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h4 class="font-bold text-gray-900 dark:text-white truncate">${c.title}</h4>
                                ${badge}
                            </div>
                            <div class="flex items-center flex-wrap gap-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">${c.category} • ${c.created_date || c.created_at}</p>
                                ${responseBadge}
                            </div>
                        </div>
                        <div class="hidden sm:block shrink-0">
                            <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                        </div>
                    </a>`;
            }).join('');
        }

        // ─── Render User Info ──────────────────────────────────────────────────
        function renderUser(user) {
            // Header
            document.getElementById('header-name').textContent = user.full_name;
            document.getElementById('header-avatar').innerHTML =
                `<img alt="${user.full_name}" src="https://ui-avatars.com/api/?name=${encodeURIComponent(user.full_name)}&background=135bec&color=fff" class="w-full h-full object-cover"/>`;

            // Hero banner
            document.getElementById('hero-greeting').textContent = `Selamat Datang, ${user.full_name}`;
            document.getElementById('hero-nis').innerHTML =
                `<span class="material-symbols-outlined text-sm">badge</span>
                 <span class="text-sm md:text-base">NIS: ${user.identity_number}</span>`;
            document.getElementById('hero-class').innerHTML =
                `<span class="material-symbols-outlined text-sm">school</span>
                 <span class="text-sm md:text-base">Kelas: ${user.class_name ?? '-'}</span>`;
        }

        // ─── Render Stats ──────────────────────────────────────────────────────
        function renderStats(stats) {
            document.getElementById('stat-total').textContent     = stats.total;
            document.getElementById('stat-inprogress').textContent = stats.in_progress;
            document.getElementById('stat-resolved').textContent  = stats.resolved;
        }

        // ─── Fetch API ─────────────────────────────────────────────────────────
        async function fetchDashboard() {
            document.getElementById('error-state').classList.add('hidden');
            document.getElementById('complaints-list').innerHTML = `
                <div class="skeleton h-20 w-full rounded-xl"></div>
                <div class="skeleton h-20 w-full rounded-xl"></div>
                <div class="skeleton h-20 w-full rounded-xl"></div>`;

            try {
                const res = await fetch('/api/student/dashboard', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                if (!res.ok) throw new Error(`HTTP ${res.status}`);

                const data = await res.json();

                renderUser(data.user);
                renderStats(data.stats);
                renderComplaints(data.complaints);

            } catch (err) {
                console.error('Dashboard fetch error:', err);
                document.getElementById('complaints-list').innerHTML = '';
                document.getElementById('error-state').classList.remove('hidden');
            }
        }

        // Jalankan saat halaman siap
        document.addEventListener('DOMContentLoaded', fetchDashboard);
    </script>

</body>
</html>
