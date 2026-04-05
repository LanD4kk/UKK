<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title id="page-title">Detail Laporan - SIPAS</title>

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

        /* Fade-in animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeInUp 0.4s ease both; }
        .fade-in-delay-1 { animation: fadeInUp 0.4s 0.1s ease both; }
        .fade-in-delay-2 { animation: fadeInUp 0.4s 0.2s ease both; }

        /* Timeline line */
        .timeline-line {
            position: absolute;
            left: 20px;
            top: 24px;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
        }
        .dark .timeline-line { background-color: #374151; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-gray-100 min-h-screen">

    <!-- ─── Header ─────────────────────────────────────────────────────────────── -->
    <header class="sticky top-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm">
        <div class="max-w-[1024px] mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/student/dashboard"
                   class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-300">arrow_back</span>
                </a>
                <div class="flex flex-col">
                    <h1 class="text-lg font-bold tracking-tight">
                        Detail Laporan
                        <span id="header-id" class="text-primary">
                            <span class="skeleton inline-block w-16 h-5 rounded align-middle">&nbsp;</span>
                        </span>
                    </h1>
                    <span class="text-xs text-gray-500 font-medium">Laporan Saya / Detail</span>
                </div>
            </div>
            <div id="header-status">
                <span class="skeleton inline-block w-28 h-8 rounded-full">&nbsp;</span>
            </div>
        </div>
    </header>

    <main class="max-w-[1024px] mx-auto px-4 sm:px-6 py-8">

        <!-- ─── Error State ──────────────────────────────────────────────────────── -->
        <div id="error-state" class="hidden flex flex-col items-center justify-center py-24 text-center">
            <span class="material-symbols-outlined text-6xl text-red-400 mb-4">error_outline</span>
            <p class="text-gray-800 dark:text-gray-100 font-bold text-xl mb-2">Laporan tidak ditemukan</p>
            <p id="error-message" class="text-gray-400 text-sm mb-6">
                Terjadi kesalahan saat mengambil data dari server.
            </p>
            <div class="flex gap-3">
                <a href="/student/dashboard"
                   class="px-5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg text-sm transition-colors">
                    Kembali
                </a>
                <button onclick="fetchDetail()"
                        class="px-5 py-2 bg-primary text-white font-bold rounded-lg text-sm hover:bg-blue-700 transition-colors">
                    Coba Lagi
                </button>
            </div>
        </div>

        <!-- ─── Loading Skeleton ─────────────────────────────────────────────────── -->
        <div id="loading-skeleton">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div class="skeleton h-64 w-full rounded-xl"></div>
                    <div class="skeleton h-32 w-full rounded-xl"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="skeleton h-20 w-full rounded-xl"></div>
                        <div class="skeleton h-20 w-full rounded-xl"></div>
                    </div>
                </div>
                <div class="lg:col-span-5 flex flex-col gap-4">
                    <div class="skeleton h-8 w-48 rounded"></div>
                    <div class="skeleton h-36 w-full rounded-xl"></div>
                    <div class="skeleton h-24 w-full rounded-xl"></div>
                    <div class="skeleton h-24 w-full rounded-xl"></div>
                </div>
            </div>
        </div>

        <!-- ─── Main Content (hidden until loaded) ────────────────────────────────── -->
        <div id="detail-content" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left Column ────────────────────────────────── -->
                <div class="lg:col-span-7 flex flex-col gap-6">

                    <!-- Complaint Card -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden fade-in">
                        <!-- Photo / No-photo area -->
                        <div id="photo-container" class="h-64 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                            <!-- Injected by JS -->
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap justify-between items-start gap-2 mb-3">
                                <h2 id="complaint-title" class="text-2xl font-bold text-gray-900 dark:text-white"></h2>
                                <p id="complaint-date" class="text-sm text-gray-400 shrink-0"></p>
                            </div>
                            <p id="complaint-description" class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm"></p>
                        </div>
                    </div>

                    <!-- Quick Info Grid -->
                    <div class="grid grid-cols-2 gap-4 fade-in-delay-1">
                        <!-- Kategori -->
                        <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800 flex items-center gap-3">
                            <div class="bg-primary/10 p-2.5 rounded-lg">
                                <span class="material-symbols-outlined text-primary">category</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Kategori</p>
                                <p id="info-category" class="text-sm font-semibold text-gray-800 dark:text-gray-100"></p>
                            </div>
                        </div>
                        <!-- Tanggal -->
                        <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800 flex items-center gap-3">
                            <div class="bg-orange-500/10 p-2.5 rounded-lg">
                                <span class="material-symbols-outlined text-orange-500">calendar_today</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Tanggal Laporan</p>
                                <p id="info-date" class="text-sm font-semibold text-gray-800 dark:text-gray-100"></p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Timeline ─────────────────────── -->
                <div class="lg:col-span-5 fade-in-delay-2">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">history</span>
                        Riwayat Pengerjaan
                    </h3>
                    <div id="timeline" class="relative space-y-6">
                        <!-- Injected by JS -->
                    </div>
                </div>

            </div>
        </div>

    </main>

    <script>
        // ─── Status Config ────────────────────────────────────────────────────────
        const STATUS_CONFIG = {
            'Pending': {
                badge:     'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                label:     'Pending',
                dotColor:  'bg-yellow-400',
                icon:      'hourglass_empty',
            },
            'In Progress': {
                badge:     'bg-primary/10 text-primary dark:bg-primary/20',
                label:     'In Progress',
                dotColor:  'bg-primary',
                icon:      'build',
                pulse:     true,
            },
            'Resolved': {
                badge:     'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                label:     'Selesai',
                dotColor:  'bg-green-500',
                icon:      'check_circle',
            },
            'Rejected': {
                badge:     'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                label:     'Ditolak',
                dotColor:  'bg-red-500',
                icon:      'cancel',
            },
        };

        // ─── Helpers ──────────────────────────────────────────────────────────────
        function getComplaintId() {
            const parts = window.location.pathname.split('/');
            return parts[parts.length - 1];
        }

        function renderStatusBadge(status) {
            const cfg = STATUS_CONFIG[status] || { badge: 'bg-gray-100 text-gray-600', label: status };
            const pulse = cfg.pulse
                ? `<span class="relative flex h-2 w-2 mr-1.5">
                       <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                       <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                   </span>`
                : '';
            return `<span class="flex items-center ${cfg.badge} px-4 py-1.5 rounded-full text-sm font-bold">${pulse}${cfg.label}</span>`;
        }

        function renderPhoto(url, category) {
            const container = document.getElementById('photo-container');
            const categoryBadge = `
                <div class="absolute top-4 left-4">
                    <span class="bg-black/50 backdrop-blur-md text-white px-3 py-1 rounded text-xs font-semibold uppercase tracking-wider">
                        ${category}
                    </span>
                </div>`;

            if (url) {
                container.innerHTML = `
                    <img src="${url}" alt="Foto bukti laporan" class="w-full h-full object-cover"/>
                    ${categoryBadge}`;
            } else {
                container.innerHTML = `
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-gray-600 gap-3">
                        <span class="material-symbols-outlined !text-6xl">hide_image</span>
                        <p class="text-sm font-medium">Tidak ada foto bukti</p>
                    </div>
                    ${categoryBadge}`;
            }
        }

        function renderTimeline(complaint, responses) {
            const timeline = document.getElementById('timeline');
            const cfg = STATUS_CONFIG[complaint.status] || { dotColor: 'bg-gray-400', icon: 'info' };
            let items = [];

            // Responses - terbaru di atas
            const sorted = [...responses].reverse();

            sorted.forEach((r, i) => {
                const isLatest = i === 0;
                const dotColor   = isLatest ? cfg.dotColor  : 'bg-green-500';
                const dotIcon    = isLatest ? cfg.icon       : 'chat';
                const cardBg     = isLatest
                    ? 'bg-primary/5 border-primary/20'
                    : 'bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800';
                const titleColor = isLatest ? 'text-primary' : 'text-gray-900 dark:text-white';

                const photoHtml = r.action_photo
                    ? `<div class="rounded-lg overflow-hidden h-28 w-full bg-gray-200 mt-3">
                           <img src="${r.action_photo}" alt="Foto tindakan" class="w-full h-full object-cover"/>
                       </div>`
                    : '';

                items.push(`
                    <div class="relative pl-12">
                        <div class="absolute left-0 top-0 size-10 rounded-full ${dotColor} flex items-center justify-center text-white ring-8 ring-background-light dark:ring-background-dark z-10">
                            <span class="material-symbols-outlined text-[20px]">${dotIcon}</span>
                        </div>
                        <div class="${cardBg} border p-5 rounded-xl shadow-sm">
                            <div class="flex justify-between items-start mb-2 gap-2">
                                <h4 class="font-bold ${titleColor}">Tanggapan Admin</h4>
                                <span class="text-[11px] font-medium text-gray-400 shrink-0">${r.created_at}</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">${r.message}</p>
                            ${photoHtml}
                            <div class="mt-4 flex items-center gap-2">
                                <div class="size-8 rounded-full overflow-hidden bg-gray-200 shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(r.responder)}&background=135bec&color=fff" alt="${r.responder}"/>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">${r.responder}</p>
                                    <p class="text-[10px] text-gray-500 capitalize">${r.role}</p>
                                </div>
                            </div>
                        </div>
                    </div>`);
            });

            // Jika belum ada tanggapan – tampilkan "Menunggu"
            if (responses.length === 0) {
                items.push(`
                    <div class="relative pl-12">
                        <div class="absolute left-0 top-0 size-10 rounded-full bg-yellow-400 flex items-center justify-center text-white ring-8 ring-background-light dark:ring-background-dark z-10">
                            <span class="material-symbols-outlined text-[20px]">hourglass_empty</span>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800/40 p-5 rounded-xl">
                            <h4 class="font-bold text-yellow-700 dark:text-yellow-400 mb-1">Menunggu Tanggapan</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Laporan Anda sedang ditinjau oleh admin atau staf yang berwenang.
                            </p>
                        </div>
                    </div>`);
            }

            // "Laporan Terkirim" selalu di bawah (paling lama)
            items.push(`
                <div class="relative pl-12 pb-4">
                    <div class="absolute left-0 top-0 size-10 rounded-full bg-gray-400 dark:bg-gray-600 flex items-center justify-center text-white ring-8 ring-background-light dark:ring-background-dark z-10">
                        <span class="material-symbols-outlined text-[20px]">send</span>
                    </div>
                    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-5 rounded-xl shadow-sm">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h4 class="font-bold text-gray-900 dark:text-white">Laporan Terkirim</h4>
                            <span class="text-[11px] font-medium text-gray-400 shrink-0">${complaint.created_at}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Laporan berhasil dibuat oleh <strong>${complaint.reporter}</strong>. Menunggu verifikasi admin.
                        </p>
                    </div>
                </div>`);

            timeline.innerHTML = `<div class="timeline-line"></div>` + items.join('');
        }

        // ─── Fetch Detail API ─────────────────────────────────────────────────────
        async function fetchDetail() {
            const id = getComplaintId();

            // Reset state
            document.getElementById('error-state').classList.add('hidden');
            document.getElementById('loading-skeleton').classList.remove('hidden');
            document.getElementById('detail-content').classList.add('hidden');

            try {
                const res = await fetch(`/api/student/report/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                if (res.status === 404) throw new Error('not_found');
                if (!res.ok) throw new Error(`HTTP ${res.status}`);

                const data = await res.json();
                const { complaint, responses } = data;

                // ── Header ──
                document.getElementById('page-title').textContent = `Detail Laporan #${complaint.id} - SIPAS`;
                document.getElementById('header-id').textContent  = `#${complaint.id}`;
                document.getElementById('header-status').innerHTML = renderStatusBadge(complaint.status);

                // ── Photo ──
                renderPhoto(complaint.evidence_photo, complaint.category);

                // ── Complaint info ──
                document.getElementById('complaint-title').textContent       = complaint.title;
                document.getElementById('complaint-date').textContent        = complaint.created_at;
                document.getElementById('complaint-description').textContent = complaint.description;
                document.getElementById('info-category').textContent         = complaint.category;
                document.getElementById('info-date').textContent             = complaint.created_raw
                    ? new Date(complaint.created_raw).toLocaleDateString('id-ID', {
                          day: 'numeric', month: 'long', year: 'numeric'
                      })
                    : complaint.created_at;

                // ── Timeline ──
                renderTimeline(complaint, responses);

                // ── Show ──
                document.getElementById('loading-skeleton').classList.add('hidden');
                document.getElementById('detail-content').classList.remove('hidden');

            } catch (err) {
                console.error('Detail fetch error:', err);
                document.getElementById('loading-skeleton').classList.add('hidden');

                if (err.message === 'not_found') {
                    document.getElementById('error-message').textContent =
                        'Laporan tidak ditemukan atau Anda tidak memiliki akses ke laporan ini.';
                }

                document.getElementById('error-state').classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', fetchDetail);
    </script>

</body>
</html>
