<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-g">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KurikulumApp - Platform Perangkat Ajar Modern</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="antialiased font-sans bg-gray-50 text-gray-800">
    <div class="relative min-h-screen flex flex-col">
        <!-- Header -->
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5">
                        <span class="text-xl font-bold text-gray-900">KurikulumApp</span>
                    </a>
                </div>
                <div class="flex lg:flex-1 lg:justify-end">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>"
                            class="text-sm font-semibold leading-6 text-gray-900">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold leading-6 text-gray-900">Log in <span
                                aria-hidden="true">&rarr;</span></a>
                    <?php endif; ?>
                </div>
            </nav>
        </header>

        <main class="relative isolate flex-grow">
            <!-- Hero Section -->
            <div class="pt-24 sm:pt-32 pb-16 sm:pb-24">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Platform Perangkat Ajar
                            Generasi Baru</h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">Mulai dari penyusunan TP, ATP, hingga Modul Ajar
                            yang komprehensif dengan bantuan Asisten AI cerdas. Dirancang untuk memberdayakan guru dan
                            meningkatkan kualitas supervisi.</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="<?php echo e(route('login')); ?>"
                                class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mulai
                                Bekerja</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-white py-12 sm:py-16">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-2">
                        <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                            <dt class="text-base leading-7 text-gray-600">Guru Terdaftar</dt>
                            <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                <?php echo e($teacherCount); ?></dd>
                        </div>
                        <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                            <dt class="text-base leading-7 text-gray-600">Total Perangkat Ajar Dibuat</dt>
                            <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                <?php echo e($totalDocuments); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:text-center">
                        <h2 class="text-base font-semibold leading-7 text-indigo-600">Semua yang Anda Butuhkan</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Satu Platform untuk
                            Seluruh Siklus Perencanaan</p>
                    </div>
                    <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div
                                        class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                    Perancangan Berbasis AI
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Generate Tujuan Pembelajaran, susun
                                    draf ATP, dan dapatkan ide kegiatan Modul Ajar secara instan dengan asisten AI
                                    cerdas.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div
                                        class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    Alur Pembelajaran Interaktif
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Susun Alur Tujuan Pembelajaran dengan
                                    mudah menggunakan antarmuka drag-and-drop yang intuitif.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div
                                        class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    Modul Ajar Komprehensif
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Buat Modul Ajar yang detail dan
                                    terstruktur sesuai kerangka pedagogis mendalam, dari identifikasi hingga asesmen.
                                </dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div
                                        class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    Supervisi & Validasi
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Kepala Sekolah dapat memonitor semua
                                    perangkat ajar secara terpusat, memberikan validasi, dan umpan balik langsung di
                                    dalam sistem.</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-800 mt-20">
            <div
                class="container mx-auto px-6 py-8 text-center text-gray-400 flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-2">
                <span><?php echo e(date('Y')); ?> KurikulumApp | Dibuat dengan</span>
                <svg class="w-5 h-5 text-red-500 inline-block" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                        clip-rule="evenodd"></path>
                </svg>
                <span>dan</span>
                <svg class="w-5 h-5 text-yellow-500 inline-block" fill="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M18 8h-1V6a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a5 5 0 005 5h6a5 5 0 005-5v-6a2 2 0 00-2-2zm-7-2a3 3 0 016 0v2h-6V6zm7 10a3 3 0 01-3 3H9a3 3 0 01-3-3v-6h12v6z">
                    </path>
                </svg>
                <span>untuk Pendidikan Indonesia yang Lebih Maju | Tim IT SMPN 4 Gununghalu</span>
            </div>
        </footer>
    </div>
</body>

</html>
<?php /**PATH D:\laragon\www\myapp\resources\views/welcome.blade.php ENDPATH**/ ?>