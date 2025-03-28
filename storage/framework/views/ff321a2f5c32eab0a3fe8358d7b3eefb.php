<?php if(Session::has('error')): ?>
    <div class="alert alert-danger text-xl-center" role="alert">
        <p class="mb-0">
            <?php echo e(Session::get('error')); ?>

        </p>
    </div>
<?php endif; ?>

<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/layouts/alerts/error.blade.php ENDPATH**/ ?>