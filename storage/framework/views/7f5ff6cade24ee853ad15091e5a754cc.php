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
        Portofolio Nilai Saya
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <?php $__empty_1 = true; $__currentLoopData = $gradesBySubject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjectName => $grades): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-lg font-bold text-gray-800"><?php echo e($subjectName); ?></h3>

                <div class="mt-4 space-y-4">
                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border rounded-md p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-semibold"><?php echo e($grade->assessment->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($grade->assessment->type); ?></p>
                                </div>
                                <p class="text-2xl font-bold text-blue-600 ml-4"><?php echo e($grade->score); ?></p>
                            </div>
                            <div class="mt-2 text-xs text-gray-500 border-t pt-2">
                                <p><strong>TP yang Diukur:</strong></p>
                                <ul class="list-disc list-inside pl-2">
                                    <?php $__currentLoopData = $grade->assessment->learningObjectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($objective->description); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-6 bg-white rounded-lg shadow-md text-center text-gray-500">
                <p>Anda belum memiliki nilai untuk ditampilkan.</p>
            </div>
        <?php endif; ?>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/siswa/portfolio.blade.php ENDPATH**/ ?>