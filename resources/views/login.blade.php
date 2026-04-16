<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login Portal - SMKN 4 Tangerang</title>
    
    <link href="/css/google-fonts.css" rel="stylesheet"/>
    <link href="/css/material-symbols.css" rel="stylesheet"/>
    
    <script src="/js/tailwind.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                        "slate-dark": "#0d121b",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    
    <style>
        /* Transisi halus untuk perpindahan tab */
        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark min-h-screen text-slate-800 dark:text-slate-100">
    
    <div class="flex flex-col lg:flex-row h-screen w-full overflow-hidden">
        
        <div class="hidden lg:flex lg:w-[45%] relative items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-slate-900/80 z-10 backdrop-blur-sm"></div>
            <div class="absolute inset-0 z-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1000&auto=format&fit=crop');"></div>
            
            <div class="relative z-20 px-12 text-white max-w-xl">
                <div class="mb-8 flex items-center gap-3">
                    <div class="bg-primary/20 p-3 rounded-xl backdrop-blur-md border border-white/10">
                        <span class="material-symbols-outlined text-4xl text-white">school</span>
                    </div>
                    <div class="h-10 w-[1px] bg-white/20"></div>
                    <span class="text-lg font-medium tracking-wide text-white/90">SMKN 4 TANGERANG</span>
                </div>
                
                <h1 class="text-5xl font-black leading-[1.1] mb-6 tracking-tight">Sistem Pengaduan Sarana Sekolah</h1>
                <p class="text-lg font-light leading-relaxed text-slate-300">
                    Wujudkan lingkungan belajar yang nyaman dan kondusif. Laporkan kerusakan fasilitas dengan mudah, pantau perbaikan secara real-time.
                </p>
                
                <div class="mt-12 flex gap-4">
                    <div class="flex -space-x-4">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900" src="https://ui-avatars.com/api/?name=Siswa+1&background=random" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900" src="https://ui-avatars.com/api/?name=Siswa+2&background=random" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900" src="https://ui-avatars.com/api/?name=Siswa+3&background=random" alt="">
                        <div class="w-10 h-10 rounded-full border-2 border-slate-900 bg-slate-800 text-xs font-bold flex items-center justify-center">+1k</div>
                    </div>
                    <div class="flex flex-col justify-center text-sm">
                        <span class="font-bold">Bergabunglah bersama kami</span>
                        <span class="text-slate-400 font-light">Membangun sekolah lebih baik</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col bg-white dark:bg-background-dark overflow-y-auto relative">
            
            <div class="lg:hidden p-6 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-2xl">school</span>
                    <span class="font-bold text-slate-800 dark:text-white">SMKN 4</span>
                </div>
            </div>

            <div class="absolute top-6 right-6 lg:left-6 lg:right-auto z-30">
                <a href="/" class="flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors bg-white/50 px-3 py-2 rounded-lg hover:bg-slate-50">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>

            <div class="flex-1 flex flex-col justify-center items-center px-6 py-12">
                <div class="w-full max-w-md">
                    
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Selamat Datang!</h2>
                        <p class="text-slate-500 dark:text-slate-400">Silakan masuk sesuai peran Anda.</p>
                    </div>

                    <div class="flex p-1 bg-slate-100 dark:bg-slate-800 rounded-xl mb-8 relative">
                        <button onclick="switchTab('siswa')" id="btn-siswa" class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-bold rounded-lg transition-all shadow-sm bg-white text-primary dark:bg-slate-700 dark:text-white">
                            <span class="material-symbols-outlined text-[18px]">backpack</span>
                            Siswa
                        </button>
                        <button onclick="switchTab('staff')" id="btn-staff" class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-bold rounded-lg transition-all text-slate-500 hover:text-slate-700 dark:text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">badge</span>
                            Petugas / Admin
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm flex items-center gap-2">
                            <span class="material-symbols-outlined">error</span>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="/login" id="form-siswa" class="tab-content active">
                        @csrf
                        <div class="space-y-5">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold uppercase text-slate-500 tracking-wider ml-1">Nomor Induk Siswa</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">badge</span>
                                    <input type="text" name="identity_number" placeholder="Contoh: 212210050" required class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none font-medium">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex justify-between px-1">
                                    <label class="text-xs font-bold uppercase text-slate-500 tracking-wider">Password</label>
                                </div>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                                    <input type="password" name="password" placeholder="••••••••" required class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none font-medium">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 group">
                                <span>Masuk Sekarang</span>
                                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </button>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <p class="text-xs text-slate-400">
                                Lupa NIS atau Password? Hubungi <span class="font-bold text-slate-600 dark:text-slate-300">Wali Kelas</span>.
                            </p>
                        </div>
                    </form>

                    <form method="POST" action="/login" id="form-staff" class="tab-content">
                        @csrf
                        <div class="space-y-5">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold uppercase text-slate-500 tracking-wider ml-1">Username / NIP</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-purple-600 transition-colors">person</span>
                                    <input type="text" name="identity_number" placeholder="Masukkan username admin" required class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-transparent transition-all outline-none font-medium">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex justify-between px-1">
                                    <label class="text-xs font-bold uppercase text-slate-500 tracking-wider">Password</label>
                                </div>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-purple-600 transition-colors">key</span>
                                    <input type="password" name="password" placeholder="••••••••" required class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-transparent transition-all outline-none font-medium">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 dark:bg-white dark:text-slate-900 text-white font-bold py-4 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 group">
                                <span>Login Portal Admin</span>
                                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">dataset</span>
                            </button>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-[10px] font-bold border border-yellow-100">
                                <span class="material-symbols-outlined text-sm">secure</span>
                                Area Terbatas untuk Staff Berwenang
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            
            <div class="p-6 text-center">
                <p class="text-slate-400 text-xs">
                    © 2026 SMKN 4 Tangerang. Sistem Pengaduan Terpadu.
                </p>
            </div>
        </div>
    </div>

    <script>
        function switchTab(role) {
            const btnSiswa = document.getElementById('btn-siswa');
            const btnStaff = document.getElementById('btn-staff');
            const formSiswa = document.getElementById('form-siswa');
            const formStaff = document.getElementById('form-staff');

            // Reset Style Tombol
            const activeClass = "bg-white text-primary shadow-sm dark:bg-slate-700 dark:text-white";
            const inactiveClass = "text-slate-500 hover:text-slate-700 dark:text-slate-400";

            if (role === 'siswa') {
                // Aktifkan Siswa
                btnSiswa.className = `flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-bold rounded-lg transition-all ${activeClass}`;
                btnStaff.className = `flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-bold rounded-lg transition-all ${inactiveClass}`;
                
                formSiswa.classList.add('active');
                formStaff.classList.remove('active');
            } else {
                // Aktifkan Staff
                btnStaff.className = `flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-bold rounded-lg transition-all bg-white text-purple-600 shadow-sm dark:bg-slate-700 dark:text-white`; // Ubah warna aktif staff jadi ungu biar beda
                btnSiswa.className = `flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-bold rounded-lg transition-all ${inactiveClass}`;
                
                formStaff.classList.add('active');
                formSiswa.classList.remove('active');
            }
        }
    </script>
</body>
</html>