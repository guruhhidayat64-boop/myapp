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
        Profil Sekolah
     <?php $__env->endSlot(); ?>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md">
        <!-- Pesan Sukses -->
        <?php if(session('success')): ?>
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.school_profile.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Nama Sekolah -->
                <div>
                    <label for="school_name" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                    <input type="text" name="school_name" id="school_name" value="<?php echo e(old('school_name', $settings['school_name'] ?? '')); ?>" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- NPSN -->
                <div>
                    <label for="school_npsn" class="block text-sm font-medium text-gray-700">NPSN</label>
                    <input type="text" name="school_npsn" id="school_npsn" value="<?php echo e(old('school_npsn', $settings['school_npsn'] ?? '')); ?>" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label for="school_address" class="block text-sm font-medium text-gray-700">Alamat Sekolah</label>
                    <textarea name="school_address" id="school_address" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?php echo e(old('school_address', $settings['school_address'] ?? '')); ?></textarea>
                </div>

                <!-- Telepon -->
                <div>
                    <label for="school_phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input type="text" name="school_phone" id="school_phone" value="<?php echo e(old('school_phone', $settings['school_phone'] ?? '')); ?>" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Email -->
                <div>
                    <label for="school_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="school_email" id="school_email" value="<?php echo e(old('school_email', $settings['school_email'] ?? '')); ?>" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Nama Kepala Sekolah -->
                <div class="md:col-span-2">
                    <label for="school_headmaster" class="block text-sm font-medium text-gray-700">Nama Kepala Sekolah</label>
                    <input type="text" name="school_headmaster" id="school_headmaster" value="<?php echo e(old('school_headmaster', $settings['school_headmaster'] ?? '')); ?>" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Visi -->
                <div class="md:col-span-2">
                    <label for="school_vision" class="block text-sm font-medium text-gray-700">Visi</label>
                    <textarea name="school_vision" id="school_vision" rows="4" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?php echo e(old('school_vision', $settings['school_vision'] ?? '')); ?></textarea>
                </div>

                <!-- Misi -->
                <div class="md:col-span-2">
                    <label for="school_mission" class="block text-sm font-medium text-gray-700">Misi</label>
                    <textarea name="school_mission" id="school_mission" rows="4" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?php echo e(old('school_mission', $settings['school_mission'] ?? '')); ?></textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    Simpan Perubahan
                </button>
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
<?php endif; ?><?php /**PATH D:\laragon\www\myapp\resources\views/admin/school_profile/index.blade.php ENDPATH**/ ?>