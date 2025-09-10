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
        Database Siswa
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <?php if(session('success')): ?>
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert"><?php echo session('success'); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"><?php echo session('error'); ?></div>
        <?php endif; ?>

        <!-- ==================== PANEL IMPOR BARU ==================== -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Impor Data Siswa dari Excel</h3>
            <form action="<?php echo e(route('admin.students.import')); ?>" method="POST" enctype="multipart/form-data"
                class="flex items-center gap-4">
                <?php echo csrf_field(); ?>
                <input type="file" name="file" required
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                <button type="submit"
                    class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700 whitespace-nowrap">Impor
                    Data</button>
            </form>
            <p class="mt-2 text-xs text-gray-500">
                Unduh <a href="<?php echo e(route('admin.students.downloadTemplate')); ?>"
                    class="text-blue-600 hover:underline font-semibold">template Excel</a> untuk memastikan format data
                sudah benar.
            </p>
        </div>
        <!-- ========================================================== -->

        <div class="p-6 bg-white rounded-md shadow-md">
            <div class="mb-4">
                <a href="<?php echo e(route('admin.students.create')); ?>"
                    class="inline-block px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    + Tambah Siswa (Manual)
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama Siswa</th>
                            <th class="px-6 py-3 text-left">NISN</th>
                            <th class="px-6 py-3 text-left">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-6 py-4 font-medium"><?php echo e($student->name); ?></td>
                                <td class="px-6 py-4"><?php echo e($student->nisn ?? '-'); ?></td>
                                <td class="px-6 py-4"><?php echo e($student->gender); ?></td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="<?php echo e(route('admin.students.edit', $student)); ?>"
                                        class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="<?php echo e(route('admin.students.destroy', $student)); ?>" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus data siswa ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data siswa.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4"><?php echo e($students->links()); ?></div>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/admin/students/index.blade.php ENDPATH**/ ?>