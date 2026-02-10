<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Buat Laporan Baru - SIPAS</title>
    
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
        body {
            font-family: "Lexend", "Inter", sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        }
        select {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"><path d="M7 10l5 5 5-5z"/></svg>');
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col">

    <!-- Header Section -->
    <header class="sticky top-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-3xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/student/dashboard" class="flex items-center justify-center size-10 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="text-lg font-bold text-gray-900 dark:text-white">Buat Laporan Baru</h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">SIPAS SMKN 4</span>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-3xl mx-auto px-4 py-8">
            
            <!-- Info Box -->
            <div class="mb-8 p-5 rounded-xl border border-primary/20 bg-primary/5 dark:bg-primary/10 flex gap-4 items-start">
                <div class="text-primary mt-0.5">
                    <span class="material-symbols-outlined text-[28px]">info</span>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-gray-900 dark:text-white text-base font-bold leading-tight">Informasi Laporan</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-normal leading-relaxed">
                        Berikan detail keluhan yang jelas dan lampirkan foto bukti agar laporan dapat segera ditindaklanjuti oleh tim sarana prasarana.
                    </p>
                    <a class="inline-flex items-center gap-1 mt-2 text-primary text-sm font-semibold hover:underline" href="#">
                        Lihat Panduan Pelaporan
                        <span class="material-symbols-outlined text-[18px]">arrow_right_alt</span>
                    </a>
                </div>
            </div>

            <!-- Form Fields -->
            <form class="space-y-6 pb-32">
                
                <!-- Category Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Kategori Masalah</label>
                    <select class="w-full h-14 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none">
                        <option disabled selected value="">Pilih kategori masalah</option>
                        <option value="fasilitas-kelas">Fasilitas Kelas</option>
                        <option value="laboratorium">Laboratorium</option>
                        <option value="kebersihan">Kebersihan &amp; Sanitasi</option>
                        <option value="listrik-air">Listrik &amp; Air</option>
                        <option value="olahraga-umum">Area Olahraga &amp; Umum</option>
                    </select>
                </div>

                <!-- Report Title -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Judul Laporan</label>
                    <input class="w-full h-14 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" placeholder="Contoh: AC Bocor di Lab 1" type="text"/>
                </div>

                <!-- Detailed Description -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Detail Keluhan</label>
                    <textarea class="w-full p-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none resize-none" placeholder="Jelaskan detail keluhan Anda di sini, termasuk lokasi spesifik dan kronologi jika perlu..." rows="5"></textarea>
                </div>

                <!-- Photo Upload Area -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Foto Bukti (Wajib)</label>
                    <div class="relative group">
                        <input accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" multiple type="file"/>
                        <div class="flex flex-col items-center justify-center w-full min-h-[200px] border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-800/50 group-hover:bg-gray-100 dark:group-hover:bg-gray-800 transition-all text-gray-500">
                            <span class="material-symbols-outlined text-[48px] mb-3 text-primary">photo_camera</span>
                            <p class="text-base font-medium text-gray-900 dark:text-white">Klik untuk ambil / upload foto</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG atau JPEG (Maks. 5MB per file)</p>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </main>

    <!-- Sticky Footer Action -->
    <footer class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 p-4 shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
        <div class="max-w-3xl mx-auto">
            <button class="w-full h-14 bg-primary hover:bg-primary/90 text-white rounded-xl font-bold flex items-center justify-center gap-2 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined">send</span>
                Kirim Laporan
            </button>
        </div>
    </footer>

</body>
</html>
