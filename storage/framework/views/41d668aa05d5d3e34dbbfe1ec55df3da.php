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
        Dasbor Siswa
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <!-- Kartu Asesmen Mendatang -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Asesmen Mendatang</h3>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingAssessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-blue-800"><?php echo e($assessment->name); ?></span>
                            <span
                                class="text-sm font-medium text-blue-600"><?php echo e($assessment->assessment_date->isoFormat('dddd, D MMM')); ?></span>
                        </div>
                        <p class="text-sm text-gray-600"><?php echo e($assessment->subject->name); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500 text-center">Tidak ada asesmen dalam 7 hari ke depan. Selamat
                        belajar!</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kartu Nilai Terbaru -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Nilai Terbaru</h3>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $recentGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-green-800"><?php echo e($grade->assessment->name); ?></span>
                            <span class="text-2xl font-bold text-green-600"><?php echo e($grade->score); ?></span>
                        </div>
                        <p class="text-sm text-gray-600"><?php echo e($grade->assessment->subject->name); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500 text-center">Belum ada nilai yang diinput oleh guru.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kartu Info Sekolah -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Info Sekolah</h3>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $schoolEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 bg-gray-50 border-l-4 border-gray-400 rounded-r-lg">
                        <p class="font-semibold text-gray-800"><?php echo e($event->title); ?></p>
                        <p class="text-sm text-gray-600"><?php echo e($event->start->isoFormat('dddd, D MMMM YYYY')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500 text-center">Tidak ada agenda sekolah dalam waktu dekat.</p>
                <?php endif; ?>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/siswa/dashboard.blade.php ENDPATH**/ ?>