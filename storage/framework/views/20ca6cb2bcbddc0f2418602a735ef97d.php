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
        Manajemen Kelas Wali: <?php echo e($homeroomClass->name); ?>

     <?php $__env->endSlot(); ?>

    <div class="p-6 bg-white rounded-md shadow-md">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Siswa</h3>
                <p class="text-sm text-gray-500">Total: <?php echo e($homeroomClass->students->count()); ?> siswa</p>
            </div>
            <a href="<?php echo e(route('teacher.homeroom.printAttendance')); ?>" target="_blank"
                class="inline-block px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                Cetak Daftar Hadir
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Siswa</th>
                        <th class="px-6 py-3 text-left">NISN</th>
                        <th class="px-6 py-3 text-left">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left">Kontak Orang Tua</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $homeroomClass->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4 font-medium">
                                <a href="<?php echo e(route('teacher.portfolio.show', $student)); ?>"
                                    class="text-indigo-600 hover:underline">
                                    <?php echo e($student->name); ?>

                                </a>
                            </td>
                            <td class="px-6 py-4"><?php echo e($student->nisn ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($student->gender); ?></td>
                            <td class="px-6 py-4"><?php echo e($student->parent_phone ?? '-'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Belum ada siswa yang ditempatkan di kelas ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/guru/homeroom/index.blade.php ENDPATH**/ ?>