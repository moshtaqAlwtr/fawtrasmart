<?php if(Session::has('success')): ?>
<div class="alert alert-success text-xl-center" role="alert">
    <p class="mb-0">
        <?php echo e(Session::get('success')); ?>

    </p>
</div>
<?php endif; ?>
<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/layouts/alerts/success.blade.php ENDPATH**/ ?>