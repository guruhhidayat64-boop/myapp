<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        Dashboard Administrator
     <?php $__env->endSlot(); ?>

    <!-- Salam Pembuka -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800"><?php echo e($greeting); ?>, <?php echo e(Auth::user()->name); ?>!</h2>
        <p class="text-gray-600">Selamat datang di panel kontrol utama sistem.</p>
    </div>

    <!-- Grid untuk Kartu Statistik -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <!-- Kartu Total Pengguna -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.225-1.273-.639-1.756M17 20V5a2 2 0 00-2-2H9a2 2 0 00-2 2v15m7 0a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                <p class="text-2xl font-bold text-gray-800"><?php echo e($userCount); ?></p>
            </div>
        </div>
        <!-- Kartu Total Guru -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0012 12a5.995 5.995 0 00-3-5.197M15 21a9 9 0 00-9-9"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Guru</p>
                <p class="text-2xl font-bold text-gray-800"><?php echo e($teacherCount); ?></p>
            </div>
        </div>
        <!-- Kartu Total Mata Pelajaran -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path><path d="M8 9h8"></path><path d="M8 13h5"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Mata Pelajaran</p>
                <p class="text-2xl font-bold text-gray-800"><?php echo e($subjectCount); ?></p>
            </div>
        </div>
        <!-- Kartu Total Capaian Pembelajaran -->
        <div class="p-6 bg-white rounded-lg shadow-md flex items-center">
            <div class="p-3 bg-indigo-100 rounded-full">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Capaian Pembelajaran</p>
                <p class="text-2xl font-bold text-gray-800"><?php echo e($cpCount); ?></p>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Panel Akses Cepat -->
        <div class="lg:col-span-1">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
                <div class="space-y-3">
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center p-3 text-base font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        Kelola Pengguna
                    </a>
                    <a href="<?php echo e(route('admin.subjects.index')); ?>" class="flex items-center p-3 text-base font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        Kelola Mata Pelajaran
                    </a>
                    <a href="<?php echo e(route('admin.learning-outcomes.index')); ?>" class="flex items-center p-3 text-base font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        Kelola Capaian Pembelajaran
                    </a>
                     <a href="<?php echo e(route('admin.school_profile.index')); ?>" class="flex items-center p-3 text-base font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100">
                        Kelola Profil Sekolah
                    </a>
                </div>
            </div>
        </div>

        <!-- Panel Pengguna Terbaru -->
        <div class="lg:col-span-2">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengguna Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <tbody class="divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-2 py-3">
                                        <p class="font-medium text-gray-900"><?php echo e($user->name); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($user->email); ?></p>
                                    </td>
                                    <td class="px-2 py-3 text-right">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($user->role == 'admin' ? 'bg-red-100 text-red-800' : ($user->role == 'guru' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')); ?>">
                                            <?php echo e(Str::title(str_replace('_', ' ', $user->role))); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="2" class="py-4 text-center text-gray-500">Tidak ada pengguna baru.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\myapp\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>