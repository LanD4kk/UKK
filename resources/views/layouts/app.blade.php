<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - SIKUSA')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet">

    <style>
        body { font-family: 'Lexend', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-card {
            background: rgba(16, 22, 34, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f6f6f8] dark:bg-[#101622] text-slate-900 dark:text-slate-100 antialiased font-sans">

    <header class="fixed top-0 left-0 right-0 h-20 bg-white/50 dark:bg-[#101622]/50 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-8 flex items-center justify-between z-50">
        @include('partials.navbar')
    </header>

    <div class="flex pt-20 h-screen overflow-hidden">
        
        <aside class="w-72 bg-white dark:bg-[#101622] border-r border-slate-200 dark:border-slate-800 flex flex-col shrink-0 h-full overflow-y-auto hidden md:flex">
            @include('partials.sidebar')
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden relative">
            <div class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </div>
        </main>

    </div>

    @include('partials.account-modal')
</body>
</html>