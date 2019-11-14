<form class="pl-3 pr-3" method="post" action="<?php echo e(route('store_lang_workspace',$currantWorkspace->slug)); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="code"><?php echo e(__('Language Code')); ?></label>
        <input class="form-control" type="text" id="code" name="code" required="" placeholder="<?php echo e(__('Language Code')); ?>">
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit"><?php echo e(__('Create')); ?></button>
    </div>
</form>
<!-- third party js -->
<script src="<?php echo e(asset('js/app.min.js')); ?>"></script>
<!-- third party js ends --><?php /**PATH C:\xampp\htdocs\taskly\resources\views/lang/create.blade.php ENDPATH**/ ?>