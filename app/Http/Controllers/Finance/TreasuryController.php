<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Log as ModelsLog;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\PaymentsProcess;
use App\Models\Receipt;
use App\Models\Revenue;
use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TreasuryController extends Controller
{
    public function index()
    {
        $treasuries = Account::whereIn('parent_id', [13, 15])
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('finance.treasury.index', compact('treasuries'));
    }

    public function create()
    {
        $employees = Employee::select()->get();
        return view('finance.treasury.carate', compact('employees'));
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'deposit_permissions' => 'required|integer',
        //     'withdraw_permissions' => 'required|integer',
        //     'value_of_deposit_permissions' => 'nullable|string',
        //     'value_of_withdraw_permissions' => 'nullable|string',
        //     'is_active' => 'nullable|boolean',
        // ]);

        // إنشاء الخزينة في جدول Treasury
        $treasury = new Treasury();
        $treasury->name = $request->name;
        $treasury->type = 0; // نوع الحساب (خزينة)
        $treasury->status = 1; // حالة الخزينة
        $treasury->description = $request->description ?? 'خزينة جديدة'; // وصف الخزينة
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;

        #permissions-----------------------------------

        # view employee
        if ($request->deposit_permissions == 1) {
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif ($request->deposit_permissions == 2) {
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id;
        }
        # view branch
        else {
            $treasury->value_of_deposit_permissions = $request->v_branch_id;
        }

        # view employee
        if ($request->withdraw_permissions == 1) {
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif ($request->withdraw_permissions == 2) {
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id;
        }
        # view branch
        else {
            $treasury->value_of_withdraw_permissions = $request->c_branch_id;
        }

        // حفظ الخزينة مرة واحدة فقط
        $treasury->save();

        // إنشاء الحساب المرتبط في جدول Account
        $account = new Account();
        $account->name = $request->name;
        $account->type_accont = 0; // نوع الحساب (خزينة)
        $account->is_active = $request->is_active ?? 1; // حالة الحساب (افتراضي: نشط)
        $account->parent_id = 13; // الأب الافتراضي


        $account->code = $this->generateNextCode(13);

        $account->balance_type = 'debit'; // نوع الرصيد (مدين)

      $account->balance_type = 'debit'; // نوع الرصيد (مدين)
      $account->code = 0;

        // $account->treasury_id = $treasury->id; // ربط الحساب بالخزينة
        $account->save();

        $account->code = $account->id;
           $account->save();


        // تسجيل النشاط في جدول السجلات
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $treasury->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم اضافة خزينة  **' . $request->name . '**',
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('treasury.index')->with('success', 'تم إضافة الخزينة بنجاح!');
    }

  public function generateNextCode($parentId)
{
    do {
        $lastCode = Account::where('parent_id', $parentId)->orderBy('code', 'DESC')->value('code');
        $newCode = $lastCode ? $lastCode + 1 : 1;
    } while (Account::where('code', $newCode)->exists()); // تأكيد عدم التكرار

    return $newCode;
}


    public function transferCreate()
    {
        // جلب الخزائن من جدول الحسابات (accounts) حيث parent_id هو 13 أو 15
        $treasuries = Account::whereIn('parent_id', [13, 15])
            ->orderBy('id', 'DESC')
            ->get();

        return view('finance.treasury.transferCreate', compact('treasuries'));
    }

    public function transferTreasuryStore(Request $request)
    {
        $request->validate([
            'from_treasury_id' => 'required|exists:accounts,id',
            'to_treasury_id' => 'required|exists:accounts,id|different:from_treasury_id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $fromTreasury = Account::find($request->from_treasury_id);
        $toTreasury = Account::find($request->to_treasury_id);

        // تحقق من توفر الرصيد
        if ($fromTreasury->balance < $request->amount) {
            return back()->withErrors(['error' => 'الرصيد غير كافٍ في الخزينة المختارة.']);
        }

        // خصم من الخزينة المرسلة
        $fromTreasury->updateBalance($request->amount, 'subtract');

        // إضافة إلى الخزينة المستقبلة
        $toTreasury->updateBalance($request->amount, 'add');

        // # القيد
        // إنشاء القيد المحاسبي للتحويل
        $journalEntry = JournalEntry::create([
            'reference_number' => $fromTreasury->id,
            'date' => now(),
            'description' => 'تحويل المالية',
            'status' => 1,
            'currency' => 'SAR',

            'created_by_employee' => Auth::id(),
        ]);

        // إضافة تفاصيل القيد المحاسبي
        // 1. حساب المورد (دائن)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $fromTreasury->id, // حساب المورد
            'description' => 'تحويل المالية من ' . $fromTreasury->code,
            'debit' => 0,
            'credit' => $request->amount, //دائن
            'is_debit' => false,
        ]);

        // 2. حساب الخزينة (مدين)
        JournalEntryDetail::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $toTreasury->id, // حساب المبيعات
            'description' => 'تحوي المالية الى' . $toTreasury->code,
            'debit' => $request->amount, //مدين
            'credit' => 0,
            'is_debit' => true,
        ]);

        return redirect()->route('treasury.index')->with('success', 'تم التحويل بنجاح!');
    }

    public function transferEdit($id)
    {
        // جلب التحويل المطلوب
        $transfer = JournalEntry::findOrFail($id);

        // جلب الخزائن
        $treasuries = Account::whereIn('parent_id', [13, 15])
            ->orderBy('id', 'DESC')
            ->get();

        return view('finance.treasury.transferEdit', compact('transfer', 'treasuries'));
    }

    public function transferTreasuryUpdate(Request $request, $id)
    {
        $request->validate([
            'from_treasury_id' => 'required|exists:accounts,id',
            'to_treasury_id' => 'required|exists:accounts,id|different:from_treasury_id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // جلب التحويل المطلوب
        $journalEntry = JournalEntry::findOrFail($id);

        // جلب الخزينة المصدر والهدف
        $fromTreasury = Account::find($request->from_treasury_id);
        $toTreasury = Account::find($request->to_treasury_id);

        // تحقق من توفر الرصيد في الخزينة المصدر
        if ($fromTreasury->balance < $request->amount) {
            return back()->withErrors(['error' => 'الرصيد غير كافٍ في الخزينة المختارة.']);
        }

        // التراجع عن التحويل السابق
        foreach ($journalEntry->details as $detail) {
            if ($detail->is_debit) {
                // التراجع عن الإضافة إلى الخزينة المستقبلة
                $toTreasury->updateBalance($detail->debit, 'subtract');
            } else {
                // التراجع عن الخصم من الخزينة المرسلة
                $fromTreasury->updateBalance($detail->credit, 'add');
            }
        }

        // تحديث القيد المحاسبي
        $journalEntry->update([
            'reference_number' => $fromTreasury->id,
            'date' => now(),
            'description' => 'تحويل المالية',
            'status' => 1,
            'currency' => 'SAR',
            'created_by_employee' => Auth::id(),
        ]);

        // تحديث تفاصيل القيد المحاسبي
        foreach ($journalEntry->details as $detail) {
            if ($detail->is_debit) {
                // تحديث الخزينة المستقبلة
                $detail->update([
                    'account_id' => $toTreasury->id,
                    'description' => 'تحويل المالية إلى ' . $toTreasury->code,
                    'debit' => $request->amount,
                    'credit' => 0,
                ]);
            } else {
                // تحديث الخزينة المرسلة
                $detail->update([
                    'account_id' => $fromTreasury->id,
                    'description' => 'تحويل المالية من ' . $fromTreasury->code,
                    'debit' => 0,
                    'credit' => $request->amount,
                ]);
            }
        }

        // تطبيق التحويل الجديد
        $fromTreasury->updateBalance($request->amount, 'subtract');
        $toTreasury->updateBalance($request->amount, 'add');

        return redirect()->route('treasury.index')->with('success', 'تم تحديث التحويل بنجاح!');
    }

    public function edit($id)
    {
        $treasury = Account::findOrFail($id);
        $employees = Employee::select()->get();
        return view('finance.treasury.edit', compact('treasury', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $treasury = Account::findOrFail($id);

        $treasury->name = $request->name;
        $oldName = $treasury->name;

        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;
        $treasury->value_of_deposit_permissions = $request->value_of_deposit_permissions;
        $treasury->value_of_withdraw_permissions = $request->value_of_withdraw_permissions;

        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $treasury->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم تعديل الخزينة من **' . $oldName . '** إلى **' . $treasury->name . '**',
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);

        #permissions-----------------------------------

        # view employee
        if ($request->deposit_permissions == 1) {
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif ($request->deposit_permissions == 2) {
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id;
        }
        # view branch
        else {
            $treasury->value_of_deposit_permissions = $request->v_branch_id;
        }

        # view employee
        if ($request->withdraw_permissions == 1) {
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif ($request->withdraw_permissions == 2) {
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id;
        }
        # view branch
        else {
            $treasury->value_of_withdraw_permissions = $request->c_branch_id;
        }

        $treasury->update();
        return redirect()->route('treasury.index')->with(key: ['success' => 'تم تحديث الخزينة بنجاج !!']);
    }

    public function create_account_bank()
    {
        $employees = Employee::select()->get();
        return view('finance.treasury.create_account_bank', compact('employees'));
    }

    public function store_account_bank(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'status' => 'required|integer',
            'description' => 'nullable|string',
            'deposit_permissions' => 'required|integer',
            'withdraw_permissions' => 'required|integer',
            'value_of_deposit_permissions' => 'nullable|string',
            'value_of_withdraw_permissions' => 'nullable|string',
        ]);

        // إنشاء الحساب البنكي في جدول Treasury
        $treasury = new Treasury();
        $treasury->name = $request->name;
        $treasury->type = 1; // نوع الحساب (بنكي)
        $treasury->bank_name = $request->bank_name;
        $treasury->account_number = $request->account_number;
        $treasury->currency = $request->currency;
        $treasury->status = $request->status;
        $treasury->description = $request->description ?? 'حساب بنكي جديد';
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;

        #permissions-----------------------------------

        # view employee
        if ($request->deposit_permissions == 1) {
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif ($request->deposit_permissions == 2) {
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id;
        }
        # view branch
        else {
            $treasury->value_of_deposit_permissions = $request->v_branch_id;
        }

        # view employee
        if ($request->withdraw_permissions == 1) {
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif ($request->withdraw_permissions == 2) {
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id;
        }
        # view branch
        else {
            $treasury->value_of_withdraw_permissions = $request->c_branch_id;
        }

        // حفظ الحساب البنكي مرة واحدة فقط
        $treasury->save();

        // إنشاء الحساب المرتبط في جدول Account
        $account = new Account();
        $account->name = $request->name;
        $account->type_accont = 1; // نوع الحساب (بنكي)
        $account->is_active = $request->status; // حالة الحساب (افتراضي: نشط)
        $account->parent_id = 13; // الأب الافتراضي
       $account->code = $this->generateNextCode(13);
        $account->balance_type = 'debit'; // نوع الرصيد (مدين)
        // $account->treasury_id = $treasury->id; // ربط الحساب بالخزينة
        $account->save();

        // تسجيل النشاط في جدول السجلات
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $treasury->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم اضافة حساب بنكي  **' . $request->name . '**',
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('treasury.index')->with('success', 'تم إضافة الحساب البنكي بنجاح!');
    }

    public function edit_account_bank($id)
    {
        $treasury = Treasury::findOrFail($id);
        $employees = Employee::select()->get();
        return view('finance.treasury.edit_account_bank', compact('treasury', 'employees'));
    }

    public function update_account_bank(Request $request, $id)
    {
        $treasury = Treasury::findOrFail($id);

        $treasury->name = $request->name;
        $treasury->type = 1; # حساب بنكي
        $treasury->status = $request->status;
        $treasury->bank_name = $request->bank_name;
        $treasury->account_number = $request->account_number;
        $treasury->currency = $request->currency;
        $treasury->description = $request->description;
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;
        $treasury->value_of_deposit_permissions = $request->value_of_deposit_permissions;
        $treasury->value_of_withdraw_permissions = $request->value_of_withdraw_permissions;

        #permissions-----------------------------------

        # view employee
        if ($request->deposit_permissions == 1) {
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif ($request->deposit_permissions == 2) {
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id;
        }
        # view branch
        else {
            $treasury->value_of_deposit_permissions = $request->v_branch_id;
        }

        # view employee
        if ($request->withdraw_permissions == 1) {
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif ($request->withdraw_permissions == 2) {
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id;
        }
        # view branch
        else {
            $treasury->value_of_withdraw_permissions = $request->c_branch_id;
        }

        $treasury->update();
        return redirect()->route('treasury.index')->with(key: ['success' => 'تم تحديث الحساب بنجاج !!']);
    }
public function show($id)
{
    // جلب بيانات الخزينة
    $treasury = $this->getTreasury($id);
    $branches = $this->getBranches();

    // جلب العمليات المالية
    $transactions = $this->getTransactions($id);
    $transfers = $this->getTransfers($id)->load(['details.account']);
    $expenses = $this->getExpenses($id);
    $revenues = $this->getRevenues($id);

    // معالجة العمليات الأساسية (بدون تحويلات)
    $allOperations = $this->processOperations($transactions, [], $expenses, $revenues, $treasury);

    // ترتيب العمليات الأساسية حسب التاريخ
    usort($allOperations, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // تقسيم العمليات الأساسية إلى صفحات (فقط للمعاملات)
    $operationsPaginator = $this->paginateOperations($allOperations);

    // معالجة التحويلات بشكل منفصل (بدون تقسيم صفحات)
    $formattedTransfers = [];
    foreach ($transfers as $transfer) {
        $fromAccount = null;
        $toAccount = null;
        $amount = $transfer->details->sum('debit');

        foreach ($transfer->details as $detail) {
            if ($detail->is_debit) {
                $toAccount = $detail->account;
            } else {
                $fromAccount = $detail->account;
            }
        }

        if ($fromAccount->id == $treasury->id || $toAccount->id == $treasury->id) {
            $formattedTransfers[] = [
                'operation' => 'تحويل مالي',
                'deposit' => $toAccount->id == $treasury->id ? $amount : 0,
                'withdraw' => $fromAccount->id == $treasury->id ? $amount : 0,
                'balance_after' => 0,
                'date' => $transfer->date,
                'type' => 'transfer',
                'reference_number' => $transfer->reference_number,
                'from_account' => $fromAccount,
                'to_account' => $toAccount,
                'amount' => $amount,
                'id' => $transfer->id
            ];
        }
    }

    // ترتيب التحويلات حسب التاريخ
    usort($formattedTransfers, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return view('finance.treasury.show', compact(
        'treasury',
        'operationsPaginator',
        'branches',
        'formattedTransfers' // إرسال التحويلات كاملة بدون تقسيم صفحات
    ));
}
 private function getTreasury($id)
    {
        return Account::findOrFail($id);
    }

    private function getBranches()
    {
        return Branch::all();
    }

    private function getTransactions($id)
    {
        return JournalEntryDetail::where('account_id', $id)
            ->with(['journalEntry' => function ($query) {
                $query->with('invoice', 'client');
            }])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function getTransfers($id)
{
    return JournalEntry::whereHas('details', function ($query) use ($id) {
            $query->where('account_id', $id);
        })
        ->with(['details.account'])
        ->where('description', 'تحويل المالية')
        ->orderBy('created_at', 'asc')
        ->get();
}


    private function getExpenses($id)
    {
        return Expense::where('treasury_id', $id)
            ->with(['expenses_category', 'branch', 'client'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function getRevenues($id)
    {
        return Revenue::where('treasury_id', $id)
            ->with(['account', 'paymentVoucher', 'treasury', 'bankAccount', 'journalEntry'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function processOperations($transactions, $transfers, $expenses, $revenues, $treasury)
    {
        $currentBalance = 0;
        $allOperations = [];


        // معالجة المدفوعات
        foreach ($transactions as $transaction) {
            $amount = $transaction->debit > 0 ? $transaction->debit : $transaction->credit;
            $type = $transaction->debit > 0 ? 'إيداع' : 'سحب';

            $currentBalance = $this->updateBalance($currentBalance, $amount, $type);



            $allOperations[] = [
                'operation' => 'مدفوعات العميل',
                'deposit' => $type === 'إيداع' ? $amount : 0,
                'withdraw' => $type === 'سحب' ? $amount : 0,
                'balance_after' => $currentBalance,
                'date' => $transaction->journalEntry->date,
                'invoice' => $transaction->journalEntry->invoice,
                'client' => $transaction->journalEntry->client,
                'type' => 'transaction',
            ];
        }


        // معالجة التحويلات
        // foreach ($transfers as $transfer) {
        //     $amount = $transfer->details->sum('debit');
        //     $fromAccount = $transfer->details->firstWhere('is_debit', true)->account;
        //     $toAccount = $transfer->details->firstWhere('is_debit', false)->account;

        //     if ($fromAccount->id == $treasury->id) {
        //         $currentBalance -= $amount;
        //         $operationText = 'تحويل مالي إلى ' . $toAccount->name;
        //     } else {
        //         $currentBalance += $amount;
        //         $operationText = 'تحويل مالي من ' . $fromAccount->name;
        //     }

        //     $allOperations[] = [
        //         'operation' => $operationText,
        //         'deposit' => $fromAccount->id != $treasury->id ? $amount : 0,
        //         'withdraw' => $fromAccount->id == $treasury->id ? $amount : 0,
        //         'balance_after' => $currentBalance,
        //         'date' => $transfer->date,
        //         'invoice' => null,
        //         'client' => null,
        //         'type' => 'transfer',
        //     ];
        // }

        // معالجة سندات الصرف
        foreach ($expenses as $expense) {
            $currentBalance -= $expense->amount;


            $allOperations[] = [
                'operation' => 'سند صرف: ' . $expense->description,
                'deposit' => 0,
                'withdraw' => $expense->amount,
                'balance_after' => $currentBalance,
                'date' => $expense->date,
                'invoice' => null,
                'client' => $expense->client,
                'type' => 'expense',
            ];
        }


        // معالجة سندات القبض
        foreach ($revenues as $revenue) {
            $currentBalance += $revenue->amount;


            $allOperations[] = [
                'operation' => 'سند قبض: ' . $revenue->description,
                'deposit' => $revenue->amount,
                'withdraw' => 0,
                'balance_after' => $currentBalance,
                'date' => $revenue->date,
                'invoice' => null,
                'client' => null,
                'type' => 'revenue',
            ];
        }


        return $allOperations;
    }

    private function updateBalance($currentBalance, $amount, $type)
    {
        return $type === 'إيداع' ? $currentBalance + $amount : $currentBalance - $amount;
    }

    private function paginateOperations($allOperations)
    {
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedOperations = array_slice($allOperations, $offset, $perPage);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedOperations,
            count($allOperations),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }


    public function updateStatus($id)
    {
        // البحث عن العنصر باستخدام الـ ID
        $treasury = Account::find($id);

        // إذا لم يتم العثور على العنصر
        if (!$treasury) {
            return redirect()
                ->back()
                ->with(['error' => 'الخزينة غير موجود!']);
        }

        // تحديث حالة العنصر
        $treasury->update(['is_active' => !$treasury->is_active]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()
            ->back()
            ->with(['success' => 'تم تحديث حالة  الخزينة بنجاح!']);
    }
    public function updateType($id)
    {
        // البحث عن العنصر باستخدام الـ ID
        $treasury = Account::find($id);

        // إذا لم يتم العثور على العنصر
        if (!$treasury) {
            return redirect()
                ->back()
                ->with(['error' => 'الخزينة غير موجود!']);
        }

        // طباعة القيم للتحقق

        // تبديل النوع بين 'main' و 'sub'
        $newType = $treasury->type == 'main' ? 'sub' : 'main';

        // تحديث نوع الخزينة
        $treasury->update(['type' => $newType]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()
            ->back()
            ->with(['success' => 'تم تحديث نوع الخزينة بنجاح!']);
    }
    public function destroy($id)
    {
        // البحث عن الخزينة بواسطة الـ ID
        $treasury = Treasury::findOrFail($id);

        // البحث عن الحساب المرتبط بالخزينة
        $account = Account::where('treasury_id', $id)->first();

        // تسجيل نشاط الحذف في جدول السجلات
        ModelsLog::create([
            'type' => 'finance_log',
            'type_id' => $treasury->id, // ID النشاط المرتبط
            'type_log' => 'log', // نوع النشاط
            'description' => 'تم حذف خزينة **' . $treasury->name . '**',
            'created_by' => auth()->id(), // ID المستخدم الحالي
        ]);

        // حذف الحساب المرتبط بالخزينة إذا وجد
        if ($account) {
            $account->delete();
        }

        // حذف الخزينة
        $treasury->delete();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('treasury.index')->with('success', 'تم حذف الخزينة بنجاح!');
    }
}
