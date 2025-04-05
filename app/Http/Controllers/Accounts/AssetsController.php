<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\ChartOfAccount;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Log as ModelsLog;
use App\Models\AssetDepreciation;
use App\Models\JournalEntry;
use App\Models\JournalDetail;
use App\Models\JournalEntryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Asset;
use App\Models\AssetDep;
use Illuminate\Support\Facades\Log;
use TCPDF;
use Carbon\Carbon;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = AssetDepreciation::with(['employee', 'client', 'depreciation'])->latest()->paginate(10);
        return view('accounts.asol.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::where('type', '')->get();
        $employees = Employee::all();
        $clients = Client::all();
        return view('accounts.asol.create', compact('accounts', 'employees', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validated = $request->validate([
                'code' => 'required|unique:asset_depreciations,code',
                'name' => 'required|string|max:255',
                'date_price' => 'required|date',
                'date_service' => 'required|date',
                'account_id' => 'nullable|exists:chart_of_accounts,id',
                'place' => 'nullable|string|max:255',
                'region_age' => 'nullable|integer|min:1',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string',
                'purchase_value' => 'required|numeric|min:0',
                'currency' => 'required|in:1,2',
                'cash_account' => 'nullable|exists:chart_of_accounts,id',
                'tax1' => 'nullable|in:1,2,3',
                'tax2' => 'nullable|in:1,2,3',
                'employee_id' => 'nullable|exists:employees,id',
                'client_id' => 'nullable|exists:clients,id',
                'attachments' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            ]);

            DB::beginTransaction();

            // إنشاء الأصل
            $asset = new AssetDepreciation();
            $asset->code = $request->code;
            $asset->name = $request->name;
            $asset->date_price = $request->date_price;
            $asset->date_service = $request->date_service;
            $asset->account_id = $request->account_id;
            $asset->place = $request->place;
            $asset->region_age = $request->region_age;
            $asset->quantity = $request->quantity;
            $asset->description = $request->description;
            $asset->purchase_value = $request->purchase_value;
            $asset->currency = $request->currency;
            $asset->cash_account = $request->cash_account;
            $asset->tax1 = $request->tax1;
            $asset->tax2 = $request->tax2;
            $asset->employee_id = $request->employee_id;
            $asset->client_id = $request->client_id;

             // تسجيل السجل
    ModelsLog::create([
        'type' => 'finance_log',
        'type_id' => $asset->id, // ID النشاط المرتبط
        'type_log' => 'log', // نوع النشاط
        'description' => 'تم إضافة اصل جديد **' . $request->name . '**',
        'created_by' => auth()->id(), // ID المستخدم الحالي
    ]);

            // تحديد حالة الأصل (مهلك أم لا)
            if ($request->region_age && $request->region_age > 0) {
                $purchaseDate = Carbon::parse($request->date_price);
                $depreciationYears = $request->region_age;
              $fullyDepreciatedDate = $purchaseDate->copy()->addYears(intval($depreciationYears));


                if (Carbon::now()->greaterThan($fullyDepreciatedDate)) {
                    $asset->status = 3; // مهلك
                } else {
                    $asset->status = 1; // في الخدمة
                }
            } else {
                $asset->status = 1; // في الخدمة
            }

            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('assets/attachments', $fileName, 'public');
                $asset->attachments = 'assets/attachments/' . $fileName;
            }

            $asset->save();

        $account = new Account();
        $account->name = $request->name;
        $account->type_accont = 0; // نوع الحساب (خزينة)
        $account->is_active = $request->is_active ?? 1; // حالة الحساب (افتراضي: نشط)
        $account->parent_id = 6; // الأب الافتراضي
        $account->code = $this->generateNextCode($request->input('parent_id')); // إنشاء الكود
        $account->balance_type = 'debit'; // نوع الرصيد (مدين)
        // $account->treasury_id = $treasury->id; // ربط الحساب بالخزينة
        $account->save();

            DB::commit();

            return redirect()->route('Assets.show', $asset->id)
                ->with('success_message', 'تم إضافة الأصل بنجاح')
                ->with('asset_id', $asset->id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'حدث خطأ أثناء إضافة الأصل. ' . $e->getMessage()]);
        }
    }
   public function generateNextCode($parentId)
    {
        // جلب أعلى كود موجود تحت نفس الحساب الأب
        $lastCode = Account::where('parent_id', $parentId)->orderBy('code', 'DESC')->value('code'); // يأخذ فقط قيمة الكود الأعلى

        // إذا لم يكن هناك أي كود سابق، ابدأ من 1
        return $lastCode ? $lastCode + 1 : 1;
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // البحث عن الأصل مع علاقاته
            $asset = AssetDepreciation::with(['employee', 'client'])->findOrFail($id);

            // البحث عن الحساب المرتبط
            $account = ChartOfAccount::find($asset->account_id);

            // البحث عن القيود المحاسبية المرتبطة
            $journalEntries = JournalEntry::with(['details' => function($query) {
                    $query->with('account');
                }])
                ->where('reference_number', 'ASSET-' . $asset->id)
                ->get();

            return view('accounts.asol.show', compact('asset', 'account', 'journalEntries'));
        } catch (\Exception $e) {
            return redirect()->route('Assets.index')
                ->with('error', 'حدث خطأ أثناء عرض الأصل: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asset = AssetDepreciation::findOrFail($id);
        $accounts = ChartOfAccount::where('type', 'asset')->get();
        $employees = Employee::all();
        $clients = Client::all();
        return view('accounts.asol.edit', compact('asset', 'accounts', 'employees', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // التحقق من صحة البيانات
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'date_price' => 'required|date',
                'date_service' => 'required|date',
                'account_id' => 'required|exists:chart_of_accounts,id',
                'place' => 'nullable|string|max:255',
                'region_age' => 'nullable|integer|min:1',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string',
                'purchase_value' => 'required|numeric|min:0',
                'currency' => 'required|in:1,2',
                'cash_account' => 'nullable|string',
                'tax1' => 'nullable|in:1,2,3',
                'tax2' => 'nullable|in:1,2,3',
                'depreciation_value' => 'nullable|numeric|min:0',
                'dep_method' => 'nullable|in:1,2,3,4',
                'employee_id' => 'nullable|exists:employees,id',
                'client_id' => 'nullable|exists:clients,id',
                'attachments' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            ]);


            DB::beginTransaction();

            // البحث عن الأصل
            $asset = AssetDepreciation::findOrFail($id);
  ModelsLog::create([
        'type' => 'finance_log',
        'type_id' => $asset->id, // ID النشاط المرتبط
        'type_log' => 'log', // نوع النشاط
        'description' => 'تم تعديل اصل  **' . $request->name . '**',
        'created_by' => auth()->id(), // ID المستخدم الحالي
    ]);
            // معالجة المرفقات إذا وجدت
            if ($request->hasFile('attachments')) {
                // حذف الصورة القديمة إذا وجدت
                if ($asset->attachments) {
                    Storage::disk('public')->delete($asset->attachments);
                }

                $file = $request->file('attachments');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('assets/uploads/Assets', $fileName, 'public');
                $validated['attachments'] = $filePath;
            }

            // تحديث الأصل
            $asset->update($validated);

            // تحديث الحساب المرتبط
            $account = ChartOfAccount::where('code', $asset->code)->first();
            if ($account) {
                $account->update([
                    'name' => $validated['name'],
                    'parent_id' => $validated['account_id']
                ]);
            }

            // تحديث القيد المحاسبي
            $journalEntry = JournalEntry::where('reference_number', 'ASSET-' . $asset->id)->first();
            if ($journalEntry) {
                $journalEntry->update([
                    'date' => $validated['date_price'],
                    'description' => 'تعديل الأصل: ' . $validated['name']
                ]);

                // تحديث تفاصيل القيد
                $journalEntry->details()->delete(); // حذف التفاصيل القديمة

                // إضافة التفاصيل الجديدة
                // مدين - حساب الأصل
                JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $account->id,
                    'debit' => $validated['purchase_value'],
                    'credit' => 0,
                    'description' => 'تعديل قيمة الأصل: ' . $validated['name']
                ]);

                // دائن - حساب النقدية
                JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $request->client_id,
                    'debit' => 0,
                    'credit' => $validated['purchase_value'],
                    'description' => 'تعديل دفع قيمة الأصل: ' . $validated['name']
                ]);
            }

            DB::commit();

            return redirect()->route('Assets.index')
                ->with('success_message', 'تم تحديث الأصل بنجاح')
                ->with('success_details', [
                    'حساب الأستاذ' => 'منى العليا #11204',
                    'مجمع إهلاك - منى العليا' => '#224001',
                    'مصروف إهلاك - منى العليا' => '#32001'
                ]);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث الأصل: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            // البحث عن الأصل
            $asset = AssetDepreciation::findOrFail($id);
  ModelsLog::create([
        'type' => 'finance_log',
        'type_id' => $asset->id, // ID النشاط المرتبط
        'type_log' => 'log', // نوع النشاط
        'description' => 'تم حذف الاصل **' . $asset->name . '**',
        'created_by' => auth()->id(), // ID المستخدم الحالي
    ]);
            // حذف الصورة إذا كانت موجودة
            if ($asset->attachments) {
                Storage::disk('public')->delete($asset->attachments);
            }

            // البحث عن الحساب المرتبط بالأصل وحذفه
            $account = ChartOfAccount::where('code', $asset->code)->first();
            if ($account) {
                $account->delete();
            }

            // حذف القيود المحاسبية المرتبطة
            $journalEntries = JournalEntry::where('reference_number', 'ASSET-' . $asset->id)->get();
            foreach ($journalEntries as $entry) {
                $entry->details()->delete(); // حذف تفاصيل القيد
                $entry->delete(); // حذف القيد
            }

            // حذف الأصل
            $asset->delete();

            DB::commit();

            return redirect()->route('Assets.index')
                ->with('success_message', 'تم حذف الأصل بنجاح')
                ->with('success_details', [
                    'حساب الأستاذ' => 'منى العليا #11204',
                    'مجمع إهلاك - منى العليا' => '#224001',
                    'مصروف إهلاك - منى العليا' => '#32001'
                ]);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حذف الأصل: ' . $e->getMessage());
        }
    }

    /**
     * بيع الأصل
     */
    public function sell(Request $request, $id)
    {
        try {
            // التحقق من البيانات
            $validated = $request->validate([
                'sale_price' => 'required|numeric|min:0',
                'sale_date' => 'required|date',
                'client_id' => 'required|exists:clients,id',
                'tax1' => 'nullable|in:1,2,3',
                'tax2' => 'nullable|in:1,2,3'
            ]);

            DB::beginTransaction();

            // البحث عن الأصل والعميل
            $asset = AssetDepreciation::with('depreciation')->findOrFail($id);
            $client = Client::findOrFail($validated['client_id']);

            // حساب الربح أو الخسارة
            $bookValue = $asset->depreciation ? $asset->depreciation->book_value : $asset->purchase_value;
            $profit = $validated['sale_price'] - $bookValue;

            // إنشاء رقم مرجعي للعملية
            $reference = 'ASSET-SALE-' . $asset->id;

            // إنشاء قيد محاسبي للبيع
            $journalEntry = new JournalEntry();
            $journalEntry->date = $validated['sale_date'];
            $journalEntry->description = sprintf('بيع أصل: %s للعميل: %s', $asset->name, $client->trade_name);
            $journalEntry->reference_number = $reference;
            $journalEntry->status = 0; // pending
            $journalEntry->save();

            // إضافة تفاصيل القيد
            // مدين - حساب العميل
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $client->account_id,
                'debit' => $validated['sale_price'],
                'credit' => 0,
                'description' => sprintf('مستحق على العميل %s - بيع أصل: %s', $client->trade_name, $asset->name),
                'reference' => $reference
            ]);

            // دائن - حساب الأصل
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $asset->account_id,
                'debit' => 0,
                'credit' => $bookValue,
                'description' => 'بيع الأصل: ' . $asset->name,
                'reference' => $reference
            ]);

            // إذا كان هناك ربح أو خسارة
            if ($profit != 0) {
                $profitAccountId = $profit > 0 ?
                    config('accounts.asset_sale_profit_account') :
                    config('accounts.asset_sale_loss_account');

                JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $profitAccountId,
                    'debit' => $profit < 0 ? abs($profit) : 0,
                    'credit' => $profit > 0 ? $profit : 0,
                    'description' => ($profit > 0 ? 'ربح' : 'خسارة') . ' بيع الأصل: ' . $asset->name,
                    'reference' => $reference
                ]);
            }

            // تحديث حالة الأصل
            $asset->update([
                'status' => 2, // تم البيع
                'sale_price' => $validated['sale_price'],
                'sale_date' => $validated['sale_date'],
                'client_id' => $validated['client_id'],
                'reference' => $reference
            ]);

            DB::commit();

            return redirect()->route('Assets.show', $asset->id)
                ->with('success_message', 'تم بيع الأصل بنجاح')
                ;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء بيع الأصل: ' . $e->getMessage());
        }
    }

    /**
     * عرض صفحة بيع الأصل
     */
    public function showSellForm($id)
    {
        $asset = AssetDepreciation::with('depreciation')->findOrFail($id);
        $clients = Client::all();
        return view('accounts.asol.sell', compact('asset', 'clients'));
    }

    /**
     * إنشاء تقرير PDF للأصل
     */
    public function generatePdf($id)
    {
        $asset = AssetDepreciation::findOrFail($id);

        // إنشاء PDF جديد
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // تعيين معلومات الوثيقة
        $pdf->SetCreator('Fawtra');
        $pdf->SetAuthor('Fawtra System');
        $pdf->SetTitle('تقرير الأصل المحصصي');

        // تعيين الهوامش
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        // تعطيل رأس وتذييل الصفحة
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // إضافة صفحة جديدة
        $pdf->AddPage();

        // تعيين اتجاه النص من اليمين إلى اليسار
        $pdf->setRTL(true);

        // تعيين الخط
        $pdf->SetFont('aealarabiya', '', 14);

        // بداية المحتوى
        $html = view('accounts.asol.pdf', compact('asset'))->render();

        // إضافة المحتوى للـ PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // إخراج الملف
        return $pdf->Output('asset-report.pdf', 'I');
    }

    /**
     * حساب تاريخ نهاية الإهلاك
     */
    private function calculateEndDate($startDate, $duration, $period)
    {
        $start = \Carbon\Carbon::parse($startDate);

        switch ($period) {
            case 1: // يومي
                return $start->addDays($duration);
            case 2: // شهري
                return $start->addMonths($duration);
            case 3: // سنوي
                return $start->addYears($duration);
            default:
                return $start->addYears($duration);
        }
    }
}
