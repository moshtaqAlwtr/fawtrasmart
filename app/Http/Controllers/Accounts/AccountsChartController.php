<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountsChartController extends Controller
{
    public function statistics()
    {
        $statistics = [
            'asset' => ChartOfAccount::where('type', 'asset')->count(),
            'liability' => ChartOfAccount::where('type', 'liability')->count(),
            'expense' => ChartOfAccount::where('type', 'expense')->count(),
            'income' => ChartOfAccount::where('type', 'income')->count(),
        ];

        return view('accounts.statistics', compact('statistics'));
    }

    public function indexWithSections()
    {
        // جلب جميع الحسابات
        $accounts = ChartOfAccount::all();
        $assets = ChartOfAccount::where('type', 'asset')->get();
        $liabilities = ChartOfAccount::where('type', 'liability')->get();
        $expenses = ChartOfAccount::where('type', 'expense')->get();
        $income = ChartOfAccount::where('type', 'revenue')->get();

        // بناء الشجرة لكل قسم
        $assetsTree = $this->buildAccountTree($assets->where('parent_id', null));
        $liabilitiesTree = $this->buildAccountTree($liabilities->where('parent_id', null));
        $expensesTree = $this->buildAccountTree($expenses->where('parent_id', null));
        $incomeTree = $this->buildAccountTree($income->where('parent_id', null));

        // تمرير البيانات إلى العرض
        return view('layouts.nav-slider-route', [
            'page' => 'chart_of_accounts',
            'accounts' => $accounts,
            'assetsTree' => $assetsTree,
            'liabilitiesTree' => $liabilitiesTree,
            'expensesTree' => $expensesTree,
            'incomeTree' => $incomeTree,
            'assets' => $assets,
            'expenses' => $expenses,
            'liabilities' => $liabilities,
            'income' => $income,
        ]);
    }

    public function show($type)
    {
        switch ($type) {
            case 'asset':
                $data = ChartOfAccount::where('type', 'asset')->get();
                $title = 'الأصول';
                break;
            case 'liability':
                $data = ChartOfAccount::where('type', 'liability')->get();
                $title = 'الخصوم';
                break;
            case 'expense':
                $data = ChartOfAccount::where('type', 'expense')->get();
                $title = 'المصروفات';
                break;
            case 'income':
                $data = ChartOfAccount::where('type', 'income')->get();
                $title = 'الإيرادات';
                break;
            default:
                abort(404);
        }

        return view('accounts.show', [
            'accounts' => $data,
            'title' => $title,
        ]);
    }

    private function buildAccountTree($accounts)
    {
        $tree = [];

        foreach ($accounts as $account) {
            // نسخة من الحساب لتجنب تعديل الأصل
            $node = clone $account;

            // البحث عن الأبناء المباشرين
            $children = ChartOfAccount::where('parent_id', $account->id)->get();

            if ($children->count() > 0) {
                $node->children = $this->buildAccountTree($children);
            }

            $tree[] = $node;
        }

        return $tree;
    }

    private function generateNextCode($parentId)
    {
        $parentAccount = ChartOfAccount::findOrFail($parentId);
        $lastChild = ChartOfAccount::where('parent_id', $parentId)->orderBy(DB::raw('CAST(SUBSTRING_INDEX(code, ".", -1) AS UNSIGNED)'), 'desc')->first();

        if (!$lastChild) {
            return $parentAccount->code . '.1';
        }

        $lastNumber = intval(substr(strrchr($lastChild->code, '.'), 1));
        return $parentAccount->code . '.' . ($lastNumber + 1);
    }

    public function create()
    {
        $accounts = ChartOfAccount::all();
        return view('Accounts.accounts_chart.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'required|exists:chart_of_accounts,id',
            'operation' => 'required|in:debit,credit',
        ]);

        try {
            $parentAccount = ChartOfAccount::findOrFail($request->input('parent_id'));

            // Generate the next available code automatically
            $code = $this->generateNextCode($request->input('parent_id'));

            ChartOfAccount::create([
                'name' => $request->input('name'),
                'type' => $parentAccount->type,
                'code' => $code,
                'operation' => $request->input('operation'),
                'parent_id' => $request->input('parent_id'),
                'normal_balance' => $request->input('operation'),
                'level' => $parentAccount->level + 1,
            ]);

            return back()->with('success', 'تم إضافة الحساب بنجاح');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'حدث خطأ أثناء إضافة الحساب: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function index()
    {
        // $accounts = Account::with('children')->whereNull('parent_id')->get();
        $accounts = Account::with('children')->get();
        return view('accounts.accounts_chart.tree', compact('accounts'));
    }

    public function store_account(Request $request)
    {
        $validated = $request->validateWithBag(
            'storeAccount',
            [
                'code' => 'required|unique:accounts,code|max:10',
                'type' => 'required',
                'parent_id' => 'nullable|exists:accounts,id',
                'name' => 'required|string|max:255',
                'balance_type' => 'required|in:debit,credit',
            ],
            [
                'code.required' => 'يجب إدخال الكود.',
                'code.unique' => 'هذا الكود مستخدم من قبل.',
                'type.required' => 'نوع الحساب مطلوب.',
                'parent_id.exists' => 'الحساب الرئيسي غير موجود.',
                'name.required' => 'اسم الحساب مطلوب.',
                'balance_type.required' => 'نوع الرصيد (مدين أو دائن) مطلوب.',
                'balance_type.in' => 'نوع الرصيد غير صالح.',
            ],
        );

        try {
            $newCode = $request->code;
            $existingCode = Account::where('code', '===', $newCode)->exists();
            if ($existingCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'كود الحساب موجود مسبقًا.',
                    'errors' => ['code' => 'كود الحساب موجود مسبقًا.'],
                ]);
            }
            $account = new Account();
            $account->code = $request->code;
            $account->type = $request->type;
            $account->parent_id = $request->parent_id;
            $account->name = $request->name;
            $account->balance_type = $request->balance_type;
            $account->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'تم إضافة الحساب بنجاح',
                    'data' => $account, // يمكنك إرجاع البيانات المحفوظة إذا أردت
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إضافة الحساب. يرجى المحاولة لاحقًا.',
                ],
                500,
            );
        }
    }

    public function getTree()
    {
        $accounts = Account::all();

        $tree = $this->buildTree($accounts);

        return response()->json($tree);
    }

    private function buildTree($accounts, $parentId = null)
    {
        $branch = [];
        foreach ($accounts as $account) {
            if ($account->parent_id == $parentId) {
                $children = $this->buildTree($accounts, $account->id);
                $branch[] = [
                    'id' => $account->id,
                    'text' => $account->name,
                    'children' => $children,
                ];
            }
        }
        return $branch;
    }

    public function getChildren($id)
    {
        $children = Account::where('parent_id', $id)->get();

        return response()->json($children);
    }

    public function getParents()
    {
        $parents = Account::whereNull('parent_id')->get();
        return response()->json($parents);
    }
    public function showDetails($id)
    {
        // جلب البيانات الخاصة بالحساب
        $account = Account::findOrFail($id);
        $journalEntries = JournalEntryDetail::where('account_id', $id)->get();
        $entries = JournalEntry::with(['details.account'])->findOrFail($id);
        // تحقق من وجود حركات للحساب
        if ($journalEntries->isEmpty()) {
            return redirect()->back()->with('error', 'لا توجد حركات لهذا الحساب.');
        }

        // حساب الرصيد الكلي (مجموع الدائن - مجموع المدين)
        $totalBalance = $journalEntries->sum('credit') - $journalEntries->sum('debit');

        // تحديث حقل balance في جدول account بشكل آمن
        DB::transaction(function () use ($account, $totalBalance) {
            $account->lockForUpdate()->update(['balance' => $totalBalance]);
        });

        // تحديد نوع الحساب
        $accountType = 'default'; // القيمة الافتراضية
        switch ($account->name) {
            case 'المبيعات':
                $accountType = 'sales';
                break;
            case 'القيمة المضافة المحصلة':
                $accountType = 'vat';
                break;
            // يمكن إضافة حالات أخرى هنا
        }

        // حساب المجموع بناءً على نوع الحساب
        $totalSales = $journalEntries->where('accountType', 'sales')->sum('credit');
        $totalVat = $journalEntries->where('accountType', 'vat')->sum('credit');
        $totalRevenue = $journalEntries->where('category', 'الإيرادات')->sum('credit');
        $totalAssets = $journalEntries->where('category', 'الأصول')->sum('credit');
        $totalLiabilities = $journalEntries->where('category', 'الخصومات')->sum('debit');

        // إرسال البيانات إلى الـ View
        return view('accounts.accounts_chart.sales_account_details', [
            'account' => $account,
            'journalEntries' => $journalEntries,
            'accountType' => $accountType,
            'entries' => $entries,
            'totalBalance' => $totalBalance,
            'totalSales' => $totalSales,
            'totalVat' => $totalVat,
            'totalRevenue' => $totalRevenue,
            'totalAssets' => $totalAssets,
            'totalLiabilities' => $totalLiabilities,
        ]);
    }

    public function getNextCode(Account $parent)
    {
        $lastChildCode = Account::where('parent_id', $parent->id)->max('code');

        $nextCode = $lastChildCode ? $lastChildCode + 1 : $parent->code . '1';

        return response()->json(['nextCode' => $nextCode]);
    }

    // public function getAccountDetails($parentId)
    // {
    //     try {
    //         $account = Account::find($parentId);

    //         // إذا لم يتم العثور على الحساب
    //         if (!$account) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'الحساب غير موجود'
    //             ], 404);
    //         }

    //         $mainAccountName = $account->name;

    //         return response()->json([
    //             'success' => true,
    //             'mainAccountName' => $mainAccountName,
    //         ], 200);
    //     }
    //     catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'حدث خطأ أثناء جلب تفاصيل الحساب',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function getRootParent($accountId)
    {
        try {
            $account = Account::find($accountId);

            if (!$account) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'الحساب غير موجود',
                    ],
                    404,
                );
            }

            while ($account->parent) {
                $account = $account->parent;
            }

            return $account->name;
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'حدث خطأ أثناء جلب الحساب الجد',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function destroy($parentId)
    {
        try {
            $account = Account::findOrFail($parentId);
            $account->delete(); // الحذف

            return response()->json(
                [
                    'success' => true,
                    'message' => 'تم حذف الحساب بنجاح',
                ],
                200,
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'الحساب غير موجود',
                ],
                404,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'حدث خطأ أثناء الحذف',
                ],
                500,
            );
        }
    }

    public function edit($id)
    {
        try {
            $account = Account::findOrFail($id);

            return response()->json(
                [
                    'success' => true,
                    'data' => $account,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'تعذر جلب بيانات العنصر. الرجاء المحاولة مرة أخرى.',
                ],
                500,
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validateWithBag(
            'storeAccount',
            [
                'code' => 'required|unique:cost_centers,code,' . $id . '|max:10',
                'type' => 'required',
                'parent_id' => 'nullable|exists:accounts,id',
                'name' => 'required|string|max:255',
                'balance_type' => 'required|in:debit,credit',
            ],
            [
                'code.required' => 'يجب إدخال الكود.',
                'code.unique' => 'هذا الكود مستخدم من قبل.',
                'type.required' => 'نوع الحساب مطلوب.',
                'parent_id.exists' => 'الحساب الرئيسي غير موجود.',
                'name.required' => 'اسم الحساب مطلوب.',
                'balance_type.required' => 'نوع الرصيد (مدين أو دائن) مطلوب.',
                'balance_type.in' => 'نوع الرصيد غير صالح.',
            ],
        );

        try {
            $account = Account::findOrFail($id);
            $account->code = $request->code;
            $account->type = $request->type;
            $account->parent_id = $request->parent_id;
            $account->name = $request->name;
            $account->balance_type = $request->balance_type;
            $account->balance = $request->balance;
            $account->update();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'تم تحديث بيانات الحساب بنجاح.',
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'حدث خطأ أثناء التحديث. الرجاء المحاولة مرة أخرى.',
                ],
                500,
            );
        }
    }
    public function showSales()
    {
        // جلب حساب "المبيعات" من جدول الحسابات
        $salesAccount = Account::where('name', 'المبيعات')->first();
        $salesTransactions = [];

        // إذا وجد الحساب، جلب الحركات المالية المرتبطة به
        if ($salesAccount) {
            $salesTransactions = DB::table('transactions')->where('account_id', $salesAccount->id)->get();
        }

        // إرسال البيانات إلى الواجهة
        return view('sales', compact('salesTransactions'));
    }

    public function getAccountDetails($accountId)
    {
        try {
            // جلب الحساب
            $account = Account::findOrFail($accountId);

            // جلب تفاصيل القيود مع القيود والفواتير
            $entries = DB::table('journal_entry_details AS jed')->leftJoin('journal_entries AS je', 'jed.journal_entry_id', '=', 'je.id')->leftJoin('invoices AS inv', 'je.invoice_id', '=', 'inv.id')->where('jed.account_id', $accountId)->orderBy('je.date', 'desc')->select('jed.*', 'je.date', 'je.invoice_id', 'inv.id AS invoice_id')->paginate(10); // تحديد عدد الصفوف في كل صفحة

            Log::info('Fetched entries:', ['entries' => $entries]);

            // معالجة البيانات وإضافة رقم الفاتورة إن وجد
            $data = [];
            $balance = 0;
            foreach ($entries as $entry) {
                $balance += $entry->credit - $entry->debit;
                $invoiceNumber = $entry->invoice_id ? "فاتورة #{$entry->invoice_id}" : 'بدون فاتورة';

                $data[] = [
                    'date' => $entry->date,
                    'description' => $entry->description . ' - ' . $invoiceNumber,
                    'debit' => $entry->debit,
                    'credit' => $entry->credit,
                    'balance' => $balance,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'pagination' => [
                    'current_page' => $entries->currentPage(),
                    'last_page' => $entries->lastPage(),
                    'per_page' => $entries->perPage(),
                    'total' => $entries->total(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching account details:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage(), // إضافة تفاصيل الخطأ
            ]);
        }
    }
}
