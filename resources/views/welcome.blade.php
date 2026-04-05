<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>S-Patch - Facility Complaint</title>
    
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
                        "display": ["Lexend", "Noto Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>

    <style>
        body { margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        img { display: block; max-width: 100%; }
    </style>
</head>

<body class="bg-background-light font-display text-[#0d121b] antialiased overflow-x-hidden">

    <header class="sticky top-0 z-50 w-full bg-white/90 backdrop-blur-md border-b border-[#e7ebf3]">
        <div class="max-w-[1280px] mx-auto px-6 lg:px-10 py-4 flex items-center justify-between">
            
            <div class="flex items-center gap-3">
                <!-- Logo Image -->
                <img src="/img/logo.png" alt="S-Patch Logo" class="h-10 w-auto object-contain" />
            </div>

            <nav class="hidden md:flex items-center gap-10">
                <a class="text-[#0d121b] text-sm font-semibold hover:text-primary transition-colors" href="#flow">Flow</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="/login" class="flex min-w-[120px] items-center justify-center rounded-lg h-10 px-6 border-2 border-primary text-primary bg-white hover:bg-primary hover:text-white transition-all text-sm font-bold">
                    <span>Login</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-[1280px] mx-auto w-full relative">
        
        <section class="px-6 lg:px-10 py-12 lg:py-24">
                <div class="relative z-10 max-w-4xl mx-auto text-center flex flex-col items-center gap-8">
                    
                    <!-- Background Decoration -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-100/50 rounded-full blur-3xl -z-10 opacity-60"></div>
                    
                    <div class="space-y-6 flex flex-col items-center">
                        <span class="inline-block px-4 py-2 bg-blue-50 border border-blue-100 text-primary text-sm font-bold uppercase tracking-widest rounded-full shadow-sm">
                            Sistem Pengaduan Sarana & Prasarana
                        </span>
                        <h1 class="text-[#0d121b] text-5xl lg:text-7xl font-black leading-[1.1] tracking-tight">
                            Punya Keluhan <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">Fasilitas Sekolah?</span>
                        </h1>
                        <p class="text-[#4c669a] text-xl lg:text-2xl font-normal max-w-2xl leading-relaxed mx-auto">
                            Sampaikan aspirasimu, pantau proses pengerjaannya secara real-time. Identitas pelapor aman dan terenkripsi.
                        </p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
                        <a href="/login">
                        <button class="flex items-center justify-center gap-2 min-w-[220px] rounded-2xl h-16 px-8 bg-primary text-white text-lg font-bold shadow-xl shadow-blue-500/20 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/30 transition-all duration-300">
                            <span class="material-symbols-outlined text-2xl">campaign</span>
                            <span>LAPORKAN SEKARANG</span>
                        </button>
                        </a>
                    </div>

                    <!-- Trusted Stats -->
                    <div class="pt-8 flex items-center gap-2 text-sm text-gray-500 font-medium">
                        <span class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-xs font-bold text-gray-600">A</div>
                            <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center text-xs font-bold text-gray-600">B</div>
                            <div class="w-8 h-8 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs font-bold text-gray-600">C</div>
                        </span>
                        <span>Dipercaya oleh 1,200+ Siswa & Guru</span>
                    </div>
                </div>
        </section>

        <section class="px-6 lg:px-10 py-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6">
                    <div class="h-16 w-16 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                        <span class="material-symbols-outlined text-4xl">inventory</span>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-[#0d121b]">1,284</p>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Laporan</p>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6">
                    <div class="h-16 w-16 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                        <span class="material-symbols-outlined text-4xl">pending_actions</span>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-[#0d121b]">12</p>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Sedang Proses</p>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6">
                    <div class="h-16 w-16 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                        <span class="material-symbols-outlined text-4xl">task_alt</span>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-[#0d121b]">1,272</p>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Selesai</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-6 lg:px-10 py-20 bg-gray-50 rounded-t-[3rem] mt-10" id="flow">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-black mb-4 text-[#0d121b]">Alur Pengaduan</h2>
                <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <div class="absolute top-[40px] left-0 w-full h-1 bg-gray-200 -z-10 hidden md:block"></div>
                
                <div class="flex flex-col items-center text-center group bg-gray-50">
                    <div class="h-20 w-20 bg-white rounded-full border-4 border-primary flex items-center justify-center mb-6 shadow-sm z-10">
                        <span class="material-symbols-outlined text-3xl text-primary">edit_note</span>
                    </div>
                    <h4 class="text-lg font-bold mb-2 text-[#0d121b]">Tulis Laporan</h4>
                    <p class="text-sm text-gray-500">Laporkan keluhan fasilitas sekolah dengan data yang lengkap.</p>
                </div>
                
                <div class="flex flex-col items-center text-center group bg-gray-50">
                    <div class="h-20 w-20 bg-white rounded-full border-4 border-primary flex items-center justify-center mb-6 shadow-sm z-10">
                        <span class="material-symbols-outlined text-3xl text-primary">verified_user</span>
                    </div>
                    <h4 class="text-lg font-bold mb-2 text-[#0d121b]">Verifikasi</h4>
                    <p class="text-sm text-gray-500">Laporan Anda akan ditinjau dan diverifikasi oleh tim admin.</p>
                </div>
                
                <div class="flex flex-col items-center text-center group bg-gray-50">
                    <div class="h-20 w-20 bg-white rounded-full border-4 border-primary flex items-center justify-center mb-6 shadow-sm z-10">
                        <span class="material-symbols-outlined text-3xl text-primary">engineering</span>
                    </div>
                    <h4 class="text-lg font-bold mb-2 text-[#0d121b]">Tindak Lanjut</h4>
                    <p class="text-sm text-gray-500">Tim sarpras akan menindaklanjuti dan memperbaiki fasilitas.</p>
                </div>
                
                <div class="flex flex-col items-center text-center group bg-gray-50">
                    <div class="h-20 w-20 bg-white rounded-full border-4 border-primary flex items-center justify-center mb-6 shadow-sm z-10">
                        <span class="material-symbols-outlined text-3xl text-primary">check_circle</span>
                    </div>
                    <h4 class="text-lg font-bold mb-2 text-[#0d121b]">Selesai</h4>
                    <p class="text-sm text-gray-500">Fasilitas sudah diperbaiki dan laporan dinyatakan selesai.</p>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-[1280px] mx-auto px-6 lg:px-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3 opacity-70">
                    <img src="/img/logo.png" alt="S-Patch Logo" class="h-8 w-auto object-contain" />
                </div>
                <div class="text-gray-500 text-sm font-medium">
                    Copyright © 2026 • Layanan Pengaduan Sarana Sekolah
                </div>
                <div class="flex items-center gap-4">
                </div>
            </div>
        </div>
    </footer>
</body>
</html>