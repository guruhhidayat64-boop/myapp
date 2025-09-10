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
            Buat Modul Ajar Baru (Langkah 1 dari 2)
         <?php $__env->endSlot(); ?>

        <div class="p-6 bg-white rounded-md shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pilih Alur Tujuan Pembelajaran (ATP)</h3>
            <p class="text-gray-600 mb-6">Pilih ATP yang akan Anda jadikan dasar untuk membuat Modul Ajar. Tujuan Pembelajaran dari ATP tersebut akan tersedia untuk dipilih di langkah berikutnya.</p>

            <?php if($teachingFlows->isEmpty()): ?>
                <div class="p-4 text-center text-yellow-800 bg-yellow-100 border-l-4 border-yellow-500">
                    <p>Anda belum memiliki Alur Tujuan Pembelajaran (ATP). Silakan buat ATP terlebih dahulu sebelum membuat Modul Ajar.</p>
                    <a href="<?php echo e(route('teacher.teaching-flows.create')); ?>" class="inline-block mt-4 font-semibold text-yellow-900 hover:underline">
                        Buat ATP Sekarang &rarr;
                    </a>
                </div>
            <?php else: ?>
                <form action="<?php echo e(route('teacher.lesson-plans.create')); ?>" method="GET"> <!-- Aksi form ini akan kita tentukan di langkah selanjutnya -->
                    <div class="space-y-4">
                        <div>
                            <label for="teaching_flow_id" class="block text-sm font-medium text-gray-700">Pilih ATP yang sudah ada:</label>
                            <select name="teaching_flow_id" id="teaching_flow_id" required class="block w-full max-w-lg mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">-- Pilih sebuah ATP --</option>
                                <?php $__currentLoopData = $teachingFlows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($flow->id); ?>"><?php echo e($flow->name); ?> (<?php echo e($flow->subject->name); ?> - <?php echo e($flow->gradeLevel->name); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-start mt-6">
                        <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Lanjutkan ke Pemilihan TP &rarr;
                        </button>
                    </div>
                </form>
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
    <?php /**PATH D:\laragon\www\myapp\resources\views/guru/lesson_plans/start.blade.php ENDPATH**/ ?>