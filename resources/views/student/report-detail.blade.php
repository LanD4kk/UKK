<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SIPAS SMKN 4 Tangerang - Detail Laporan</title>
    
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
                        "display": ["Lexend", "Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    
    <style>
        body { font-family: 'Lexend', 'Inter', sans-serif; }
        .timeline-line {
            position: absolute;
            left: 20px;
            top: 24px;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
        }
        .dark .timeline-line {
            background-color: #374151;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-gray-100 min-h-screen">

    <!-- Header Section -->
    <header class="sticky top-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm">
        <div class="max-w-[1024px] mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/student/dashboard" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-300">arrow_back</span>
                </a>
                <div class="flex flex-col">
                    <h1 class="text-lg font-bold tracking-tight">Detail Laporan <span class="text-primary">#ID-1025</span></h1>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-gray-500 font-medium">Laporan Saya / Detail</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-bold">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    Proses
                </span>
                <button class="p-2 text-gray-500 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">more_vert</span>
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-[1024px] mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Column: Complaint Details -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                
                <!-- Complaint Summary Card -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                    <div class="h-64 bg-gray-200 dark:bg-gray-800 relative overflow-hidden">
                        <img alt="Photo of leaking air conditioner unit in classroom" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=400&fit=crop"/>
                        <div class="absolute top-4 left-4">
                            <span class="bg-black/50 backdrop-blur-md text-white px-3 py-1 rounded text-xs font-semibold uppercase tracking-wider">
                                Sarana Kelas
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">AC Lab Komputer Bocor</h2>
                            <p class="text-sm text-gray-500">24 Okt 2023</p>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            AC di Lab Komputer 2 bocor dan airnya menetes ke meja praktek siswa. Mohon segera diperbaiki agar tidak merusak perangkat komputer. Kondisi sudah berlangsung sejak pagi tadi saat jam pertama dimulai.
                        </p>
                    </div>
                </div>

                <!-- Technical Details Quick Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800 flex items-center gap-3">
                        <div class="bg-primary/10 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-primary">location_on</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Lokasi</p>
                            <p class="text-sm font-semibold">Lab Komputer 2</p>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800 flex items-center gap-3">
                        <div class="bg-orange-500/10 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-orange-500">priority_high</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Prioritas</p>
                            <p class="text-sm font-semibold">Tinggi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Timeline Progress -->
            <div class="lg:col-span-5">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    Riwayat Pengerjaan
                </h3>

                <div class="relative space-y-8">
                    <div class="timeline-line"></div>

                    <!-- Step 1: In Progress (Active) -->
                    <div class="relative pl-12">
                        <div class="absolute left-0 top-0 size-10 rounded-full bg-primary flex items-center justify-center text-white ring-8 ring-background-light dark:ring-background-dark z-10">
                            <span class="material-symbols-outlined text-[20px]">build</span>
                        </div>
                        <div class="bg-primary/5 border border-primary/20 p-5 rounded-xl">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-primary">Sedang Dikerjakan</h4>
                                <span class="text-[11px] font-medium text-primary">Hari ini, 10:30</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                                "Teknisi sudah di lokasi. Sedang melakukan pembersihan drainase AC dan pengecekan freon."
                            </p>
                            <div class="rounded-lg overflow-hidden h-32 w-full bg-gray-200">
                                <img alt="Technician working on AC repair" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=400&h=200&fit=crop"/>
                            </div>
                            <div class="mt-4 flex items-center gap-2">
                                <div class="size-8 rounded-full bg-gray-300 overflow-hidden">
                                    <img alt="Technician profile" src="https://ui-avatars.com/api/?name=Pak+Rahmat&background=135bec&color=fff"/>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Pak Rahmat</p>
                                    <p class="text-[10px] text-gray-500">Maintenance Tim</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Accepted -->
                    <div class="relative pl-12">
                        <div class="absolute left-0 top-0 size-10 rounded-full bg-green-500 flex items-center justify-center text-white ring-8 ring-background-light dark:ring-background-dark z-10">
                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        </div>
                        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-5 rounded-xl shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-900 dark:text-white">Laporan Diterima</h4>
                                <span class="text-[11px] font-medium text-gray-400">24 Okt, 09:15</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Laporan telah diverifikasi oleh Admin Sarana &amp; Prasarana. Teknisi telah ditugaskan ke lokasi.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3: Sent -->
                    <div class="relative pl-12 pb-4">
                        <div class="absolute left-0 top-0 size-10 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-white ring-8 ring-background-light dark:ring-background-dark z-10">
                            <span class="material-symbols-outlined text-[20px]">send</span>
                        </div>
                        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-5 rounded-xl shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-900 dark:text-white">Laporan Terkirim</h4>
                                <span class="text-[11px] font-medium text-gray-400">24 Okt, 08:30</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Laporan berhasil dibuat oleh Anda (Ahmad Rizki). Menunggu verifikasi admin.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Mobile Action -->
    <div class="fixed bottom-6 right-6 lg:bottom-10 lg:right-10 flex flex-col gap-3">
        <button class="bg-primary hover:bg-blue-700 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-transform hover:scale-110">
            <span class="material-symbols-outlined">chat</span>
        </button>
    </div>

</body>
</html>
