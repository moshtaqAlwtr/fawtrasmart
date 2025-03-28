
  

   
    <div class="card">
        <div class="card-body p-0">
           
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>العملية</th>
                            <th>مدين</th>

                            <th>دائن</th>
                       

                            <th>الرصيد بعد</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $journalEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <!-- القسم الأيمن - رقم القيد والمبلغ -->


                                <td>    <?php echo e($entry->description ?? ""); ?>  قيد رقم #<?php echo e($entry->journal_entry_id); ?>   </td>
                                
                                <td>    <?php echo e($entry->debit ?? ""); ?> </td>
                                <td>    <?php echo e($entry->credit ?? ""); ?> </td>
                                <td>    <?php echo e($entry->account->balance ?? ""); ?> </td>

                        
                                <!-- الإجراءات -->
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?php echo e(route('journal.edit', $entry->journalEntry->id)); ?>">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('journal.show', $entry->journalEntry->id)); ?>">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                                <form action="<?php echo e(route('journal.destroy', $entry->journalEntry->id)); ?>" method="POST"
                                                    class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </button>
                                                </form>

                                                <a class="dropdown-item" href="">
                                                    <i class="fa fa-edit me-2 text-success"></i>عرض  المصدر
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
           
         
        </div>
    </div>


<?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Accounts/accounts_chart/tree_details.blade.php ENDPATH**/ ?>