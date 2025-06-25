<?php $__env->startSection('title'); ?>
    الايرادات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">الايرادات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">عرض
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong> سند قبض </strong> | <small><?php echo e($income->code); ?> #</small> | <span
                            class="badge badge-pill badge badge-success">اصدر</span>
                    </div>

                    <div>
                        <a href="<?php echo e(route('incomes.edit', $income->id)); ?>" class="btn btn-outline-primary">
                            <i class="fa fa-edit"></i>تعديل
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="container" style="max-width: 1200px">
            <div class="card">
                <div class="card-title p-2">
                    <a href="<?php echo e(route('incomes.edit', $income->id)); ?>" class="btn btn-outline-primary btn-sm">تعديل <i
                            class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal"
                        data-target="#modal_DELETE<?php echo e($income->id); ?>">حذف <i class="fa fa-trash"></i></a>
                    <a href="" class="btn btn-outline-success btn-sm">نقل <i class="fa fa-reply-all"></i></a>
                    <a href="" class="btn btn-outline-info btn-sm">اضف عمليه <i class="fa fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home"
                                role="tab" aria-selected="false">التفاصيل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile"
                                role="tab" aria-selected="false">مطبوعات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" aria-controls="about"
                                role="tab" aria-selected="true">سجل النشاطات</a>
                        </li>

                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">

                            <div class="card">
                                <div class="card-header">
                                    <strong>التفاصيل :</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <td style="width: 50%">
                                                    <?php if($income->attachments): ?>
                                                        <img src="<?php echo e(asset('assets/uploads/incomes/' . $income->attachments)); ?>"
                                                            alt="img" width="150">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('assets/uploads/no_image.jpg')); ?>" alt="img"
                                                            width="150">
                                                    <?php endif; ?>
                                                    <br><br>
                                                    <strong>الوصف </strong>: <?php echo e($income->description); ?>

                                                </td>

                                                <td>
                                                    <strong> الكود </strong>: <?php echo e($income->code); ?>#
                                                    <br><br>
                                                    <strong>المبلغ </strong>: <?php echo e($income->amount); ?>

                                                    <br><br>
                                                    <strong>التاريخ </strong>: <?php echo e($income->date); ?>

                                                    <br><br>
                                                    <strong>خزينة </strong>: <?php echo e($income->store_id); ?>

                                                    <br><br>
                                                    <strong>الحساب الفرعي </strong>: <?php echo e($income->account->name?? 'لا يوجد'); ?>

                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel "
                            style="background: rgba(0, 0, 0, 0.05);">

                            <!-- عرض سند PDF -->
                            <?php echo $__env->make('finance.incomes.print_normal', ['income' => $income], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


                        </div>
                        <div class="tab-pane" id="about" aria-labelledby="about-tab" role="tabpanel">
                            <p>time table</p>
                        </div>
                        <div class="tab-pane" id="activate" aria-labelledby="activate-tab" role="tabpanel">
                            <p>activate records</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal delete -->
        <div class="modal fade text-left" id="modal_DELETE<?php echo e($income->id); ?>" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #EA5455 !important;">
                        <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف سند قبض</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #DC3545">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong>
                          عفوا لا يمكن الحذف يمكنك اصدار سند صرف
                        </strong>
                    </div>
                  
                </div>
            </div>
        </div>
        <!--end delete-->

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/finance/incomes/show.blade.php ENDPATH**/ ?>