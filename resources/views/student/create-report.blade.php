<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Buat Laporan Baru - S - Patch</title>

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
                    fontFamily: { "display": ["Lexend", "Inter", "sans-serif"] },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>

    <style>
        body { font-family: 'Lexend', 'Inter', sans-serif; }

        .skeleton {
            background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 50%, #e5e7eb 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 0.5rem;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeInUp 0.35s ease both; }

        select {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"><path d="M7 10l5 5 5-5z"/></svg>');
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .field-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(19,91,236,0.15); border-color: #135bec; }

        #drop-zone.drag-over { border-color: #135bec; background-color: rgba(19,91,236,0.06); }

        #title-counter, #desc-counter { transition: color 0.2s; }

        #toast {
            transition: all 0.35s cubic-bezier(0.34,1.56,0.64,1);
            transform: translateY(120%);
            opacity: 0;
        }
        #toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { animation: spin 0.8s linear infinite; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-gray-100 min-h-screen flex flex-col">

    <header class="sticky top-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm">
        <div class="max-w-3xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/student/dashboard"
                   class="flex items-center justify-center size-10 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-base font-bold text-gray-900 dark:text-white leading-tight">Buat Laporan Baru</h1>
                    <p class="text-xs text-gray-400">S - Patch · SMKN 4 Tangerang</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-gray-400">
                <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold">1</span>
                <span>Isi detail laporan</span>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto">
        <div class="max-w-3xl mx-auto px-4 py-8 pb-36">

            <div class="mb-8 p-5 rounded-xl border border-primary/20 bg-primary/5 dark:bg-primary/10 flex gap-4 items-start fade-in">
                <span class="material-symbols-outlined text-primary text-[28px] shrink-0 mt-0.5">info</span>
                <div>
                    <p class="text-gray-900 dark:text-white text-sm font-bold mb-1">Tips laporan yang baik</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Berikan judul yang singkat dan deskripsi yang jelas termasuk lokasi spesifik.
                        Lampirkan foto bukti agar laporan dapat segera ditindaklanjuti.
                    </p>
                </div>
            </div>

            <form id="report-form" class="space-y-6" novalidate>

                <div class="space-y-2 fade-in">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Kategori Masalah <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="category_id" name="category_id"
                                class="field-input w-full h-14 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white transition-all">
                            <option disabled selected value="">— Pilih kategori masalah —</option>
                        </select>
                        <div id="category-skeleton" class="absolute inset-0 skeleton rounded-xl"></div>
                    </div>
                    <p id="category-error" class="hidden text-xs text-red-500 font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">error</span> Pilih kategori terlebih dahulu.
                    </p>
                </div>

                <div class="space-y-2 fade-in">
                    <div class="flex justify-between items-center">
                        <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Judul Laporan <span class="text-red-500">*</span>
                        </label>
                        <span id="title-counter" class="text-xs text-gray-400">0 / 100</span>
                    </div>
                    <input id="title" name="title" type="text" maxlength="100" autocomplete="off"
                           placeholder="Contoh: AC Bocor di Lab Komputer 2"
                           class="field-input w-full h-14 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder:text-gray-400 transition-all"/>
                    <p id="title-error" class="hidden text-xs text-red-500 font-medium">
                        Judul laporan wajib diisi (minimal 5 karakter).
                    </p>
                </div>

                <div class="space-y-2 fade-in">
                    <div class="flex justify-between items-center">
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Detail Keluhan <span class="text-red-500">*</span>
                        </label>
                        <span id="desc-counter" class="text-xs text-gray-400">0 / 1000</span>
                    </div>
                    <textarea id="description" name="description" rows="6" maxlength="1000"
                              placeholder="Jelaskan detail keluhan Anda: lokasi spesifik, waktu kejadian, kronologi, dan dampak yang ditimbulkan..."
                              class="field-input w-full p-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder:text-gray-400 transition-all resize-none"></textarea>
                    <p id="desc-error" class="hidden text-xs text-red-500 font-medium">
                        Deskripsi keluhan wajib diisi (minimal 10 karakter).
                    </p>
                </div>

                <div class="space-y-2 fade-in">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Foto Bukti <span class="text-gray-400 font-normal">(Opsional, maks. 5 MB)</span>
                    </label>

                    <div id="drop-zone"
                         class="relative flex flex-col items-center justify-center w-full min-h-[180px] border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800/50 transition-all cursor-pointer hover:border-primary/50 hover:bg-primary/5">
                        <input id="evidence_photo" name="evidence_photo" type="file"
                               accept="image/jpeg,image/png,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"/>

                        <div id="upload-placeholder" class="flex flex-col items-center gap-2 text-center px-4 pointer-events-none">
                            <span class="material-symbols-outlined text-[48px] text-primary">photo_camera</span>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">Klik atau seret foto ke sini</p>
                            <p class="text-xs text-gray-400">JPG, PNG, WEBP · Maks. 5 MB</p>
                        </div>

                        <div id="upload-preview" class="hidden w-full h-full relative">
                            <img id="preview-img" src="" alt="Preview foto bukti"
                                 class="w-full h-56 object-cover rounded-xl"/>
                            <div class="absolute top-2 right-2 z-20">
                                <button type="button" id="remove-photo"
                                        class="bg-black/60 hover:bg-black/80 text-white rounded-full p-1.5 flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </button>
                            </div>
                            <div class="absolute bottom-2 left-2 z-20">
                                <span id="photo-name"
                                      class="bg-black/50 text-white text-xs font-medium px-2 py-1 rounded backdrop-blur-sm"></span>
                            </div>
                        </div>
                    </div>
                    <p id="photo-error" class="hidden text-xs text-red-500 font-medium">
                        File terlalu besar atau format tidak didukung. Gunakan JPG/PNG/WEBP maks. 5 MB.
                    </p>
                </div>

            </form>
        </div>
    </main>

    <footer class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 p-4 shadow-[0_-4px_16px_rgba(0,0,0,0.07)] z-40">
        <div class="max-w-3xl mx-auto">
            <button id="submit-btn" type="button" onclick="submitReport()"
                    class="w-full h-14 bg-primary hover:bg-blue-700 active:scale-[0.98] text-white rounded-xl font-bold flex items-center justify-center gap-2 transition-all shadow-lg shadow-primary/30">
                <span class="material-symbols-outlined" id="submit-icon">send</span>
                <span id="submit-label">Kirim Laporan</span>
            </button>
        </div>
    </footer>

    <div id="toast"
         class="fixed bottom-24 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-2xl text-white text-sm font-semibold min-w-[260px] max-w-sm">
        <span id="toast-icon" class="material-symbols-outlined text-[22px]"></span>
        <span id="toast-msg"></span>
    </div>

    <div id="success-overlay" class="hidden fixed inset-0 z-50 bg-white dark:bg-background-dark flex flex-col items-center justify-center text-center px-8">
        <div class="w-24 h-24 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-green-500 !text-5xl">check_circle</span>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">Laporan Terkirim!</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 max-w-xs">
            Laporan Anda telah berhasil dikirim dan sedang menunggu ditinjau oleh admin.
        </p>
        <a id="view-report-btn" href="/student/dashboard"
           class="w-full max-w-xs h-13 py-3.5 bg-primary text-white rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-blue-700 transition-colors mb-3 shadow-lg shadow-primary/30">
            <span class="material-symbols-outlined">visibility</span>
            Lihat Laporan Saya
        </a>
        <a href="/student/dashboard"
           class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
            Kembali ke Dashboard
        </a>
    </div>

    <script>
        function getCsrfToken() {
            const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
            return match ? decodeURIComponent(match[1]) : '';
        }

        const titleInput = document.getElementById('title');
        const descInput  = document.getElementById('description');

        titleInput.addEventListener('input', () => {
            const n = titleInput.value.length;
            const el = document.getElementById('title-counter');
            el.textContent = `${n} / 100`;
            el.className = n >= 90 ? 'text-xs text-red-500 font-medium' : 'text-xs text-gray-400';
        });

        descInput.addEventListener('input', () => {
            const n = descInput.value.length;
            const el = document.getElementById('desc-counter');
            el.textContent = `${n} / 1000`;
            el.className = n >= 900 ? 'text-xs text-red-500 font-medium' : 'text-xs text-gray-400';
        });

        async function loadCategories() {
            const skeleton = document.getElementById('category-skeleton');
            const select   = document.getElementById('category_id');
            try {
                const res = await fetch('/api/student/categories', {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin',
                });
                if (!res.ok) throw new Error();
                const categories = await res.json();
                categories.forEach(cat => {
                    const opt = document.createElement('option');
                    opt.value       = cat.category_id;
                    opt.textContent = cat.category_name;
                    select.appendChild(opt);
                });
            } catch {
                const opt = document.createElement('option');
                opt.disabled = true;
                opt.textContent = 'Gagal memuat kategori – refresh halaman';
                select.appendChild(opt);
            } finally {
                skeleton.remove();
            }
        }

        const fileInput     = document.getElementById('evidence_photo');
        const dropZone      = document.getElementById('drop-zone');
        const placeholder   = document.getElementById('upload-placeholder');
        const previewWrap   = document.getElementById('upload-preview');
        const previewImg    = document.getElementById('preview-img');
        const photoNameEl   = document.getElementById('photo-name');
        const photoErrorEl  = document.getElementById('photo-error');
        const removePhotoBtn= document.getElementById('remove-photo');

        function showPreview(file) {
            if (!file) return;
            const MAX = 5 * 1024 * 1024;
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (file.size > MAX || !allowed.includes(file.type)) {
                photoErrorEl.classList.remove('hidden');
                clearPhoto();
                return;
            }
            photoErrorEl.classList.add('hidden');
            const url = URL.createObjectURL(file);
            previewImg.src = url;
            photoNameEl.textContent = file.name.length > 28 ? file.name.substring(0, 25) + '...' : file.name;
            placeholder.classList.add('hidden');
            previewWrap.classList.remove('hidden');
        }

        function clearPhoto() {
            fileInput.value = '';
            previewImg.src  = '';
            previewWrap.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        fileInput.addEventListener('change', () => showPreview(fileInput.files[0]));
        removePhotoBtn.addEventListener('click', (e) => { e.stopPropagation(); e.preventDefault(); clearPhoto(); });

        dropZone.addEventListener('dragover',  (e) => { e.preventDefault(); dropZone.classList.add('drag-over'); });
        dropZone.addEventListener('dragleave', ()  => dropZone.classList.remove('drag-over'));
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                showPreview(file);
            }
        });

        let toastTimer;
        function showToast(msg, type = 'error') {
            const toast   = document.getElementById('toast');
            const toastMsg  = document.getElementById('toast-msg');
            const toastIcon = document.getElementById('toast-icon');

            if (type === 'success') {
                toast.className = toast.className.replace(/bg-\S+/, '') + '';
                toast.style.background = '#16a34a';
                toastIcon.textContent  = 'check_circle';
            } else {
                toast.style.background = '#dc2626';
                toastIcon.textContent  = 'error';
            }

            toastMsg.textContent = msg;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 3500);
        }

        function validate() {
            let ok = true;

            const catVal = document.getElementById('category_id').value;
            const catErr = document.getElementById('category-error');
            if (!catVal) { catErr.classList.remove('hidden'); ok = false; }
            else catErr.classList.add('hidden');

            const titleVal = titleInput.value.trim();
            const titleErr = document.getElementById('title-error');
            if (titleVal.length < 5) { titleErr.classList.remove('hidden'); ok = false; }
            else titleErr.classList.add('hidden');

            const descVal = descInput.value.trim();
            const descErr = document.getElementById('desc-error');
            if (descVal.length < 10) { descErr.classList.remove('hidden'); ok = false; }
            else descErr.classList.add('hidden');

            if (!ok) showToast('Lengkapi semua field yang wajib diisi.');
            return ok;
        }

        async function submitReport() {
            if (!validate()) return;

            const btn   = document.getElementById('submit-btn');
            const icon  = document.getElementById('submit-icon');
            const label = document.getElementById('submit-label');

            btn.disabled  = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            icon.innerHTML = `<svg class="spinner w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>`;
            label.textContent = 'Mengirim…';

            const formData = new FormData();
            formData.append('category_id',  document.getElementById('category_id').value);
            formData.append('title',         titleInput.value.trim());
            formData.append('description',   descInput.value.trim());
            if (fileInput.files[0]) {
                formData.append('evidence_photo', fileInput.files[0]);
            }

            try {
                const res = await fetch('/api/student/report', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-XSRF-TOKEN': getCsrfToken(),
                    },
                    credentials: 'same-origin',
                    body: formData,
                });

                const data = await res.json();

                if (res.status === 422) {
                    const msgs = Object.values(data.errors || {}).flat();
                    showToast(msgs[0] || 'Data tidak valid.');
                    return;
                }

                if (!res.ok) throw new Error(data.message || 'Server error');

                const complaintId = data.complaint_id;
                document.getElementById('view-report-btn').href = `/student/report/${complaintId}`;
                document.getElementById('success-overlay').classList.remove('hidden');

            } catch (err) {
                console.error('Submit error:', err);
                showToast('Gagal mengirim laporan. Periksa koneksi dan coba lagi.');
            } finally {
                btn.disabled = false;
                btn.classList.remove('opacity-80', 'cursor-not-allowed');
                icon.innerHTML = '';
                icon.textContent = 'send';
                label.textContent = 'Kirim Laporan';
            }
        }

        document.addEventListener('DOMContentLoaded', loadCategories);
    </script>

</body>
</html>
