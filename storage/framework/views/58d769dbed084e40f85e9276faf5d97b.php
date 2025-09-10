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
        Peta Belajar Saya
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <?php $__empty_1 = true; $__currentLoopData = $teachingFlows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md">
                <!-- Header Akordeon -->
                <button @click="open = !open" class="w-full flex justify-between items-center p-6">
                    <h3 class="text-lg font-bold text-gray-800"><?php echo e($flow->subject->name); ?></h3>
                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-500 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Konten Akordeon (Timeline ATP) -->
                <div x-show="open" x-cloak class="border-t p-6">
                    <h4 class="font-semibold mb-4"><?php echo e($flow->name); ?></h4>
                    <ol class="relative border-l border-gray-200">
                        <?php $__currentLoopData = $flow->learningObjectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="mb-10 ml-6">
                                <!-- Penanda Progres -->
                                <?php if($assessedTpIds->contains($objective->id)): ?>
                                    <span
                                        class="absolute flex items-center justify-center w-6 h-6 bg-green-200 rounded-full -left-3 ring-8 ring-white">
                                        <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <h5 class="font-semibold text-gray-900">Tercapai</h5>
                                <?php else: ?>
                                    <span
                                        class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3 ring-8 ring-white">
                                        <svg class="w-3 h-3 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z">
                                            </path>
                                        </svg>
                                    </span>
                                    <h5 class="font-semibold text-gray-500">Akan Dipelajari</h5>
                                <?php endif; ?>

                                <p class="text-sm text-gray-700"><?php echo e($objective->description); ?></p>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-6 bg-white rounded-lg shadow-md text-center text-gray-500">
                <p>Peta belajar Anda belum tersedia.</p>
                <p class="text-sm">Ini mungkin karena guru Anda belum menyusun Alur Tujuan Pembelajaran (ATP) untuk
                    kelas Anda.</p>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/siswa/learning_map.blade.php ENDPATH**/ ?>