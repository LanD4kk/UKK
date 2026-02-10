<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Student Dashboard - SIPAS</title>
    
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
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark min-h-screen font-display">

    <header class="sticky top-0 z-50 w-full bg-white dark:bg-background-dark border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white">
                        <span class="material-symbols-outlined">domain</span>
                    </div>
                    <h1 class="text-xl font-extrabold tracking-tight text-gray-900 dark:text-white uppercase">SIPAS</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Ahmad Rizki</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Siswa SMKN 4 Tangerang</span>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-primary/10 border-2 border-primary/20 flex items-center justify-center overflow-hidden">
                        <img alt="Ahmad Profile" src="https://ui-avatars.com/api/?name=Ahmad+Rizki&background=135bec&color=fff" class="w-full h-full object-cover"/>
                    </div>
                    <a href="/" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-sm transition-colors">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                        <span class="hidden sm:inline">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-[1200px] mx-auto px-4 py-8 sm:px-6 lg:px-8">
        
        <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 p-8 md:p-12 mb-8 shadow-xl shadow-primary/20">
            <div class="absolute right-[-20px] top-[-20px] opacity-10">
                <span class="material-symbols-outlined !text-[200px]">assignment</span>
            </div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-2">Selamat Datang, Ahmad Rizki</h2>
                <div class="flex flex-wrap items-center gap-4 text-blue-100">
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">badge</span>
                        <span class="text-sm md:text-base">NIS: 212210345</span>
                    </div>
                    <div class="w-1 h-1 bg-blue-300 rounded-full"></div>
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">school</span>
                        <span class="text-sm md:text-base">Kelas: XII RPL 1</span>
                    </div>
                </div>
                <button class="mt-8 flex items-center gap-2 bg-white text-primary px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-blue-50 transition-colors">
                    Lihat Panduan Laporan
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mb-1">Total Laporan</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">5</h3>
                    </div>
                    <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-300">description</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mb-1">Dalam Proses</p>
                        <h3 class="text-3xl font-bold text-primary">2</h3>
                    </div>
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <span class="material-symbols-outlined text-primary">sync</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mb-1">Selesai</p>
                        <h3 class="text-3xl font-bold text-green-600">3</h3>
                    </div>
                    <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Riwayat Laporan</h3>
            <button class="text-primary text-sm font-semibold hover:underline">Lihat Semua</button>
        </div>

        <div class="flex flex-col gap-4 mb-20">
            <!-- Card 1 -->
            <a href="/student/report/1" class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center gap-4 hover:border-primary/30 transition-all cursor-pointer">
                <div class="w-14 h-14 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-600 dark:text-gray-300">
                    <span class="material-symbols-outlined !text-3xl">chair</span>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h4 class="font-bold text-gray-900 dark:text-white">Meja Guru Patah Kaki</h4>
                        <span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Pending</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ruang Guru • Dilaporkan: 2 Jam yang lalu</p>
                </div>
                <div class="hidden sm:block">
                    <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="/student/report/2" class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-primary/20 dark:border-primary/40 shadow-sm flex items-center gap-4 relative">
                <div class="w-14 h-14 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined !text-3xl">ac_unit</span>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h4 class="font-bold text-gray-900 dark:text-white">AC Lab Komputer Bocor</h4>
                        <span class="flex items-center gap-1 bg-blue-100 text-primary dark:bg-primary/20 dark:text-blue-300 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                            In Progress
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Lab RPL 2 • Dilaporkan: Kemarin</p>
                        <span class="flex items-center gap-1 text-[11px] font-bold text-primary bg-primary/5 px-2 py-0.5 rounded border border-primary/10">
                            <span class="material-symbols-outlined text-xs">notifications</span>
                            1 Tanggapan Baru
                        </span>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <span class="material-symbols-outlined text-primary">chevron_right</span>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="/student/report/3" class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center gap-4 opacity-75">
                <div class="w-14 h-14 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500">
                    <span class="material-symbols-outlined !text-3xl">sports_esports</span>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h4 class="font-bold text-gray-900 dark:text-white">Request Pasang PS5</h4>
                        <span class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Rejected</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kantin • Dilaporkan: 3 Hari yang lalu</p>
                </div>
                <div class="hidden sm:block">
                    <span class="material-symbols-outlined text-gray-400">close</span>
                </div>
            </a>
        </div>
    </main>

    <!-- Floating Action Button -->
    <a href="/student/create-report" class="fixed bottom-8 right-8 flex items-center gap-3 bg-primary text-white p-4 pr-6 rounded-full shadow-2xl shadow-primary/40 hover:scale-105 active:scale-95 transition-transform z-50">
        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined">edit</span>
        </div>
        <span class="font-bold tracking-wide">Buat Laporan</span>
    </a>

</body>
</html>
