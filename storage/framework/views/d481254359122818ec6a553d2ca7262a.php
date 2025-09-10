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
        Manajemen Kelompok Bimbingan Guru Wali
     <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if(session('success')): ?>
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert"><?php echo session('success'); ?></div>
        <?php endif; ?>

        <!-- Panel 1: Buat Kelompok & Daftar Kelompok -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Buat Kelompok Baru</h3>
                <form action="<?php echo e(route('admin.mentorship-groups.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium">Nama Kelompok</label>
                            <input type="text" name="name" id="name" required class="block w-full mt-1"
                                placeholder="Contoh: Kelompok Angkatan 2025-A">
                        </div>
                        <div>
                            <label for="user_id" class="block text-sm font-medium">Pilih Guru Wali</label>
                            <select name="user_id" id="user_id" required class="block w-full mt-1">
                                <option value="">-- Pilih Guru --</option>
                                <?php $__currentLoopData = $availableTeachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Buat
                                Kelompok</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-2 p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Daftar Kelompok Bimbingan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Kelompok</th>
                                <th class="px-4 py-2 text-left">Guru Wali</th>
                                <th class="px-4 py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-4 py-3 font-medium"><?php echo e($group->name); ?></td>
                                    <td class="px-4 py-3"><?php echo e($group->mentor->name); ?></td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="<?php echo e(route('admin.mentorship-groups.destroy', $group)); ?>"
                                            method="POST" onsubmit="return confirm('Yakin hapus kelompok ini?');">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-400">Belum ada kelompok
                                        bimbingan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Panel 2: Manajemen Anggota Kelompok -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Manajemen Anggota Kelompok</h3>
            <form action="<?php echo e(route('admin.mentorship-groups.index')); ?>" method="GET"
                class="flex items-end gap-4 mb-6">
                <div>
                    <label for="group_id" class="block text-sm font-medium">Pilih Kelompok untuk Dikelola</label>
                    <select name="group_id" id="group_id" required class="block w-full mt-1">
                        <option value="">-- Pilih Kelompok --</option>
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($group->id); ?>" <?php if(request('group_id') == $group->id): echo 'selected'; endif; ?>><?php echo e($group->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Tampilkan
                    Anggota</button>
            </form>

            <?php if($selectedGroup): ?>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-semibold mb-2">Siswa Belum Punya Guru Wali</h4>
                        <div class="max-h-96 overflow-y-auto border rounded-md p-2">
                            <?php $__empty_1 = true; $__currentLoopData = $studentsNotInGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="flex justify-between items-center p-2 hover:bg-gray-50">
                                    <span><?php echo e($student->name); ?></span>
                                    <form action="<?php echo e(route('admin.mentorship-groups.assign')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="group_id" value="<?php echo e($selectedGroup->id); ?>">
                                        <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                                        <button type="submit" class="text-sm text-green-600">Tambahkan &rarr;</button>
                                    </form>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="p-4 text-center text-gray-400">Semua siswa sudah memiliki Guru Wali.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Anggota Kelompok: <?php echo e($selectedGroup->name); ?></h4>
                        <div class="max-h-96 overflow-y-auto border rounded-md p-2">
                            <?php $__empty_1 = true; $__currentLoopData = $studentsInGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="flex justify-between items-center p-2 hover:bg-gray-50">
                                    <span><?php echo e($student->name); ?></span>
                                    <form action="<?php echo e(route('admin.mentorship-groups.unassign')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="group_id" value="<?php echo e($selectedGroup->id); ?>">
                                        <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                                        <button type="submit" class="text-sm text-red-600">&larr; Keluarkan</button>
                                    </form>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="p-4 text-center text-gray-400">Belum ada anggota.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/admin/mentorship_groups/index.blade.php ENDPATH**/ ?>