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
        Penugasan Guru (berdasarkan Kelas Spesifik)
     <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if(session('success')): ?>
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- ======================= 1. MANAJEMEN WALI KELAS ======================= -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Manajemen Wali Kelas</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Kelas</th>
                            <th class="px-4 py-2 text-left">Wali Kelas Saat Ini</th>
                            <th class="px-4 py-2 text-left">Tetapkan Wali Kelas Baru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-4 py-3 font-medium"><?php echo e($class->name); ?></td>
                                <td class="px-4 py-3">
                                    <?php if($class->homeroomTeacher): ?>
                                        <span class="font-semibold"><?php echo e($class->homeroomTeacher->name); ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Belum Ditetapkan</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <form action="<?php echo e(route('admin.assignments.storeHomeroom')); ?>" method="POST"
                                        class="flex items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="class_id" value="<?php echo e($class->id); ?>">
                                        <select name="teacher_id" required
                                            class="block w-full max-w-xs text-sm border-gray-300 rounded-md shadow-sm">
                                            <option value="">-- Pilih Guru --</option>
                                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======================= 2. MANAJEMEN GURU MATA PELAJARAN ======================= -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Manajemen Guru Mata Pelajaran</h3>

            <div class="mb-8 p-4 border rounded-md bg-gray-50">
                <h4 class="font-semibold mb-2">Tambah Penugasan Mengajar Baru</h4>
                <form action="<?php echo e(route('admin.assignments.storeTeaching')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Pilih Guru</label>
                            <select name="teacher_id" required
                                class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Guru --</option>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Pilih Mata Pelajaran</label>
                            <select name="subject_id" required
                                class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Mapel --</option>
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Pilih Kelas (bisa lebih dari satu)</label>
                            <div class="mt-1 p-2 border bg-white rounded-md max-h-32 overflow-y-auto">
                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center text-sm">
                                        <input type="checkbox" name="class_ids[]" value="<?php echo e($class->id); ?>"
                                            class="rounded">
                                        <span class="ml-2"><?php echo e($class->name); ?></span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">Tambah
                            Penugasan</button>
                    </div>
                </form>
            </div>

            <div>
                <h4 class="font-semibold mb-2">Daftar Penugasan Saat Ini</h4>
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $teachingAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacherName => $assignments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border rounded-md p-3">
                            <h5 class="font-bold"><?php echo e($teacherName); ?></h5>
                            <ul class="mt-2 list-disc list-inside pl-4 text-sm space-y-1">
                                <?php $__currentLoopData = $assignments->groupBy('subject_name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjectName => $subjectAssignments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <strong><?php echo e($subjectName); ?></strong> di kelas:
                                        <?php $__currentLoopData = $subjectAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="inline-flex items-center bg-gray-100 rounded-full px-2 py-0.5">
                                                <?php echo e($assignment->class_name); ?>

                                                <form
                                                    action="<?php echo e(route('admin.assignments.destroyTeaching', [$assignment->user_id, $assignment->subject_id, $assignment->class_id])); ?>"
                                                    method="POST" class="inline-block ml-1"
                                                    onsubmit="return confirm('Hapus tugas ini?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700">&times;</button>
                                                </form>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center text-gray-500 italic">Belum ada penugasan mengajar yang dibuat.</p>
                    <?php endif; ?>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/admin/assignments/index.blade.php ENDPATH**/ ?>