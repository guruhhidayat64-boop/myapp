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
            Tambah Data Siswa Baru
         <?php $__env->endSlot(); ?>

        <div class="p-6 bg-white rounded-md shadow-md max-w-4xl mx-auto">
            <form action="<?php echo e(route('admin.students.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                            class="block w-full mt-1">
                    </div>
                    <div>
                        <label for="nisn" class="block text-sm font-medium">NISN</label>
                        <input type="text" name="nisn" id="nisn" value="<?php echo e(old('nisn')); ?>"
                            class="block w-full mt-1">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium">Jenis Kelamin</label>
                        <select name="gender" id="gender" required class="block w-full mt-1">
                            <option value="Laki-laki" <?php if(old('gender') == 'Laki-laki'): echo 'selected'; endif; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php if(old('gender') == 'Perempuan'): echo 'selected'; endif; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="birth_place" class="block text-sm font-medium">Tempat Lahir</label>
                        <input type="text" name="birth_place" id="birth_place" value="<?php echo e(old('birth_place')); ?>"
                            class="block w-full mt-1">
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" value="<?php echo e(old('birth_date')); ?>"
                            class="block w-full mt-1">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium">Alamat</label>
                        <textarea name="address" id="address" rows="3" class="block w-full mt-1"><?php echo e(old('address')); ?></textarea>
                    </div>
                    <div>
                        <label for="parent_name" class="block text-sm font-medium">Nama Orang Tua/Wali</label>
                        <input type="text" name="parent_name" id="parent_name" value="<?php echo e(old('parent_name')); ?>"
                            class="block w-full mt-1">
                    </div>
                    <div>
                        <label for="parent_phone" class="block text-sm font-medium">Kontak Orang Tua/Wali</label>
                        <input type="text" name="parent_phone" id="parent_phone" value="<?php echo e(old('parent_phone')); ?>"
                            class="block w-full mt-1">
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan
                        Data Siswa</button>
                </div>
            </form>
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
<?php /**PATH D:\laragon\www\myapp\resources\views/admin/students/create.blade.php ENDPATH**/ ?>