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
        Asesmen & Penilaian
     <?php $__env->endSlot(); ?>

    <div class="p-6 bg-white rounded-md shadow-md max-w-2xl mx-auto">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Pilih Buku Nilai</h3>
        <p class="text-gray-600 mb-6">Pilih kelas dan mata pelajaran yang ingin Anda kelola penilaiannya.</p>

        <?php if($assignments->isEmpty()): ?>
            <div class="p-4 text-center text-yellow-800 bg-yellow-100 border-l-4 border-yellow-500">
                <p>Anda belum memiliki penugasan mengajar. Hubungi Admin untuk mendapatkan penugasan.</p>
            </div>
        <?php else: ?>
            <form id="select-gradebook-form">
                <div class="space-y-4">
                    <div>
                        <label for="context" class="block text-sm font-medium text-gray-700">Pilih Kelas & Mata
                            Pelajaran:</label>
                        <select id="context" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih --</option>
                            <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e(route('teacher.gradebook.index', ['class' => $assignment->class_id, 'subject' => $assignment->subject_id])); ?>">
                                    <?php echo e($assignment->class_name); ?> - <?php echo e($assignment->subject_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="flex justify-start mt-6">
                    <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Buka Buku Nilai &rarr;
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.getElementById('select-gradebook-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const select = document.getElementById('context');
                const url = select.value;
                if (url) {
                    window.location.href = url;
                }
            });
        </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/guru/gradebook/select.blade.php ENDPATH**/ ?>