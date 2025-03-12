<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employee;
use App\Models\Log as ModelsLog;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class TreasuryController extends Controller
{
    public function index()
    {
        $treasuries = Account::whereIn('parent_id', [13, 15])
        ->orderBy('id', 'DESC')
        ->paginate(10);


        return view('finance.treasury.index',compact('treasuries'));
    }

    public function create()
    {
        $employees = Employee::select()->get();
        return view('finance.treasury.carate',compact('employees'));
    }

    public function store(Request $request)
    {
        $treasury = new Account();
        $code = $this->generateNextCode($request->input('parent_id'));
        $treasury->name = $request->name;
        $treasury->type_accont = 0 ; # خزينه
        $treasury->is_active = $request->is_active;
        $treasury->parent_id  = 13;
        $treasury->code  = $code;
        $treasury->balance_type  = 'debit';
        // $treasury->description = $request->description;
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;
        $treasury->value_of_deposit_permissions = $request->value_of_deposit_permissions;
        $treasury->value_of_withdraw_permissions = $request->value_of_withdraw_permissions;
        
      ModelsLog::create([
    'type' => 'finance_log',
    'type_id' => $treasury->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
    'description' => 'تم اضافة خزينة  **' . $request->name . '**',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);




        #permissions-----------------------------------

        # view employee
        if(($request->deposit_permissions == 1)){
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }

       
        # view functional_role
        elseif(($request->deposit_permissions == 2)){
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_deposit_permissions = $request->v_branch_id	;
        }


        # view employee
        if(($request->withdraw_permissions == 1)){
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif(($request->withdraw_permissions == 2)){
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_withdraw_permissions = $request->c_branch_id	;
        }

        $treasury->save();
        return redirect()->route('treasury.index')->with(key: ['success'=>'تم اضافه الخزينة بنجاج !!']);

    }
    public function generateNextCode($parentId)
{
    // جلب أعلى كود موجود تحت نفس الحساب الأب
    $lastCode = Account::where('parent_id', $parentId)
        ->orderBy('code', 'DESC')
        ->value('code'); // يأخذ فقط قيمة الكود الأعلى

    // إذا لم يكن هناك أي كود سابق، ابدأ من 1
    return $lastCode ? $lastCode + 1 : 1;
}


public function transferin()
{
   
    $treasuries = Account::whereIn('parent_id', [13, 15])
    ->orderBy('id', 'DESC')
    ->paginate(10);

    return view('finance.treasury.transfer',compact('treasuries'));
}


public function transfer(Request $request)
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


    public function edit($id)
    {
        $treasury = Account::findOrFail($id);
        $employees = Employee::select()->get();
        return view('finance.treasury.edit',compact('treasury','employees'));
    }

    public function update(Request $request ,$id)
    {
        $treasury = Account::findOrFail($id);

        $treasury->name = $request->name;
        $oldName = $treasury->name; 
        $treasury->type = 0 ; # خزينه
        $treasury->status = $request->status;
        $treasury->description = $request->description;
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
        if(($request->deposit_permissions == 1)){
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif(($request->deposit_permissions == 2)){
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_deposit_permissions = $request->v_branch_id	;
        }


        # view employee
        if(($request->withdraw_permissions == 1)){
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif(($request->withdraw_permissions == 2)){
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_withdraw_permissions = $request->c_branch_id	;
        }

        $treasury->update();
        return redirect()->route('treasury.index')->with(key: ['success'=>'تم تحديث الخزينة بنجاج !!']);
    }

    public function create_account_bank()
    {
        $employees = Employee::select()->get();
        return view('finance.treasury.create_account_bank',compact('employees'));
    }

    public function store_account_bank(Request $request)
    {
        $treasury = new Treasury();

        $treasury->name = $request->name;
        $treasury->type = 1 ; # حساب بنكي
        $treasury->bank_name = $request->bank_name;
        $treasury->account_number = $request->account_number;
        $treasury->currency = $request->currency;
        $treasury->status = $request->status;
        $treasury->description = $request->description;
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;
        $treasury->value_of_deposit_permissions = $request->value_of_deposit_permissions;
        $treasury->value_of_withdraw_permissions = $request->value_of_withdraw_permissions;

        #permissions-----------------------------------

        # view employee
        if(($request->deposit_permissions == 1)){
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif(($request->deposit_permissions == 2)){
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_deposit_permissions = $request->v_branch_id	;
        }


        # view employee
        if(($request->withdraw_permissions == 1)){
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif(($request->withdraw_permissions == 2)){
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_withdraw_permissions = $request->c_branch_id	;
        }

        $treasury->save();
        return redirect()->route('treasury.index')->with(key: ['success'=>'تم اضافه الحساب بنجاج !!']);

    }

    public function edit_account_bank($id)
    {
        $treasury = Treasury::findOrFail($id);
        $employees = Employee::select()->get();
        return view('finance.treasury.edit_account_bank',compact('treasury','employees'));
    }

    public function update_account_bank(Request $request ,$id)
    {
        $treasury = Treasury::findOrFail($id);

        $treasury->name = $request->name;
        $treasury->type = 1 ; # حساب بنكي
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
        if(($request->deposit_permissions == 1)){
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif(($request->deposit_permissions == 2)){
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_deposit_permissions = $request->v_branch_id	;
        }


        # view employee
        if(($request->withdraw_permissions == 1)){
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif(($request->withdraw_permissions == 2)){
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_withdraw_permissions = $request->c_branch_id	;
        }

        $treasury->update();
        return redirect()->route('treasury.index')->with(key: ['success'=>'تم تحديث الحساب بنجاج !!']);
    }

    public function show($id)
    {
        $treasury = Account::findOrFail($id);
        return view('finance.treasury.show',compact('treasury'));
    }

}
