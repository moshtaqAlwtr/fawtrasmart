<?php
use App\Http\Controllers\Branches\BranchesController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/auth.php';

// مجموعة الراوتات الخاصة بالفروع
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        // مجموعة راوت خاصة بـ branches
        Route::prefix('branches')->middleware(['auth'])->group(function () {
            Route::get('/index', [BranchesController::class, 'index'])->name('branches.index'); // عرض جميع الفروع
            Route::get('/create', [BranchesController::class, 'create'])->name('branches.create'); // نموذج إضافة فرع جديد
            Route::post('/store', [BranchesController::class, 'store'])->name('branches.store'); // تخزين فرع جديد
            Route::get('/show/{id}', [BranchesController::class, 'show'])->name('branches.show'); // عرض تفاصيل فرع معين
            Route::get('/edit/{id}', [BranchesController::class, 'edit'])->name('branches.edit'); // عرض نموذج تعديل فرع
            Route::put('/update/{id}', [BranchesController::class, 'update'])->name('branches.update'); // تحديث بيانات الفرع
            Route::get('/updateStatus/{id}', [BranchesController::class, 'updateStatus'])->name('branches.updateStatus'); // تحديث بيانات الفرع
            Route::delete('/delete/{id}', [BranchesController::class, 'destroy'])->name('branches.destroy');// حذف فرع
            Route::get('/settings', [BranchesController::class, 'settings'])->name('branches.settings');

        });
    }
);
