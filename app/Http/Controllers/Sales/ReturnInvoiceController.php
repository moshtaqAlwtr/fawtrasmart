<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use App\Models\PaymentsProcess;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\StoreHouse;
use App\Models\Treasury;
use App\Models\User;
use App\Models\TaxSitting;
use App\Models\TaxInvoice;
use App\Models\AccountSetting;
use App\Models\WarehousePermits;
use App\Models\WarehousePermitsProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReturnInvoiceController extends Controller
{
    public function index(Request $request)
    {
        // بدء بناء الاستعلام
        $query = Invoice::with(['client', 'createdByUser', 'updatedByUser'])->orderBy('created_at', 'desc');

        // 1. البحث حسب العميل
        if ($request->has('client_id') && $request->client_id) {
            $query->where('client_id', $request->client_id);
        }

        // 2. البحث حسب رقم الفاتورة
        if ($request->has('invoice_number') && $request->invoice_number) {
            $query->where('id', 'like', '%' . $request->invoice_number . '%');
        }

        // 3. البحث حسب حالة الفاتورة
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // 4. البحث حسب البند
        if ($request->has('item') && $request->item) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('item', 'like', '%' . $request->item . '%');
            });
        }

        // 5. البحث حسب العملة
        if ($request->has('currency') && $request->currency) {
            $query->where('currency', $request->currency);
        }

        // 6. البحث حسب الإجمالي (من)
        if ($request->has('total_from') && $request->total_from) {
            $query->where('grand_total', '>=', $request->total_from);
        }

        // 7. البحث حسب الإجمالي (إلى)
        if ($request->has('total_to') && $request->total_to) {
            $query->where('grand_total', '<=', $request->total_to);
        }

        // 8. البحث حسب حالة الدفع
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // 9. البحث حسب التاريخ (من)
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // 10. البحث حسب التاريخ (إلى)
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // 11. البحث حسب تاريخ الاستحقاق (من)
        if ($request->has('due_date_from') && $request->due_date_from) {
            $query->whereDate('due_date', '>=', $request->due_date_from);
        }

        // 12. البحث حسب تاريخ الاستحقاق (إلى)
        if ($request->has('due_date_to') && $request->due_date_to) {
            $query->whereDate('due_date', '<=', $request->due_date_to);
        }

        // 13. البحث حسب المصدر
        if ($request->has('source') && $request->source) {
            $query->where('source', $request->source);
        }

        // 14. البحث حسب الحقل المخصص
        if ($request->has('custom_field') && $request->custom_field) {
            $query->where('custom_field', 'like', '%' . $request->custom_field . '%');
        }

        // 15. البحث حسب تاريخ الإنشاء (من)
        if ($request->has('created_at_from') && $request->created_at_from) {
            $query->whereDate('created_at', '>=', $request->created_at_from);
        }

        // 16. البحث حسب تاريخ الإنشاء (إلى)
        if ($request->has('created_at_to') && $request->created_at_to) {
            $query->whereDate('created_at', '<=', $request->created_at_to);
        }

        // 17. البحث حسب حالة التسليم
        if ($request->has('delivery_status') && $request->delivery_status) {
            $query->where('delivery_status', $request->delivery_status);
        }

        // 18. البحث حسب "أضيفت بواسطة"
        if ($request->has('added_by') && $request->added_by) {
            $query->where('created_by', $request->added_by);
        }

        // 19. البحث حسب مسؤول المبيعات
        if ($request->has('sales_person') && $request->sales_person) {
            $query->where('sales_person_id', $request->sales_person);
        }

        // 20. البحث حسب خيارات الشحن
        if ($request->has('shipping_option') && $request->shipping_option) {
            $query->where('shipping_option', $request->shipping_option);
        }

        // 21. البحث حسب مصدر الطلب
        if ($request->has('order_source') && $request->order_source) {
            $query->where('order_source', $request->order_source);
        }

        // 22. البحث حسب التخصيص (شهريًا، أسبوعيًا، يوميًا)
        if ($request->has('custom_period') && $request->custom_period) {
            if ($request->custom_period == 'monthly') {
                $query->whereMonth('created_at', now()->month);
            } elseif ($request->custom_period == 'weekly') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->custom_period == 'daily') {
                $query->whereDate('created_at', now()->toDateString());
            }
        }

        // 23. البحث حسب حالة التسليم
        if ($request->has('delivery_status') && $request->delivery_status) {
            $query->where('delivery_status', $request->delivery_status);
        }

        // 24. البحث حسب "أضيفت بواسطة" (الموظفين)
        if ($request->has('added_by_employee') && $request->added_by_employee) {
            $query->where('created_by', $request->added_by_employee);
        }

        // 25. البحث حسب مسؤول المبيعات (المستخدمين)
        if ($request->has('sales_person_user') && $request->sales_person_user) {
            $query->where('sales_person_id', $request->sales_person_user);
        }

        // جلب النتائج مع التقسيم
        $return = $query->paginate(25); // استبدل get() بـ paginate()

        // البيانات الأخرى المطلوبة للواجهة
        $clients = Client::all();
        $users = User::all();
        $employees = Employee::all();
        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();

        return view('sales.retend_invoice.index', compact('return', 'account_setting', 'clients', 'users', 'employees'));
    }
    public function create($id)
    {
        // العثور على الفاتورة
        $invoice = Invoice::findOrFail($id);

        // تحديث نوع الفاتورة إلى مرتجع
        $invoice->type = 'مرتجع'; // أو 'returned' حسب ما تحتاج
        $invoice->save(); // حفظ التغييرات في قاعدة البيانات

        // توليد رقم الفاتورة
        // $invoice_number = $this->generateInvoiceNumber();
        $items = Product::all();
        $clients = Client::all();
        $treasury = Treasury::all();
        $users = User::all();
        $taxs = TaxSitting::all();
        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();
        // تمرير البيانات إلى العرض
        return view('sales.retend_invoice.create', compact('clients', 'account_setting', 'taxs', 'items', 'treasury', 'users', 'invoice'));
    }
    // private function generateInvoiceNumber()
    // {
    //     $lastInvoice = Invoice::latest()->first();
    //     $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
    //     return str_pad($nextId, 6, '0', STR_PAD_LEFT);
    // }

    public function store(Request $request)
    {
        try {
            // التحقق من وجود invoice_id
            if (empty($request->invoice_id) || !is_numeric($request->invoice_id)) {
                return redirect()->back()->withInput()->with('error', 'رقم الفاتورة غير صالح.');
            }

            // جلب الفاتورة الأصلية
            $invoice = Invoice::find($request->invoice_id);

            if (!$invoice) {
                return redirect()->back()->withInput()->with('error', 'الفاتورة غير موجودة.');
            }

            // بدء المعاملة
            DB::beginTransaction();

            // تحديث نوع الفاتورة إلى "مرتجع"
            $invoice->type = 'returned';
            $invoice->save();

            // جلب العناصر (items) الخاصة بالفاتورة
            $invoiceItems = $invoice->items;

            // التكرار على كل عنصر (item) وإضافة الكمية المرتجعة إلى المخزون
            foreach ($invoiceItems as $item) {
                // جلب المنتج من جدول المنتجات
                $product = Product::find($item->product_id);

                if (!$product) {
                    throw new \Exception('المنتج غير موجود: ' . $item->product_id);
                }

                // جلب المستودع الذي تم البيع منه
                $storeHouse = StoreHouse::find($item->store_house_id);

                if (!$storeHouse) {
                    throw new \Exception('المستودع غير موجود: ' . $item->store_house_id);
                }

                // إضافة الكمية المرتجعة إلى المخزون
                $productDetails = ProductDetails::where('store_house_id', $item->store_house_id)->where('product_id', $item->product_id)->first();

                if (!$productDetails) {
                    throw new \Exception('تفاصيل المنتج غير موجودة في المستودع.');
                }

                // زيادة الكمية في المخزون
                $productDetails->increment('quantity', $item->quantity);

                // تسجيل حركة المخزون للإرجاع
                $wareHousePermits = new WarehousePermits();
                $wareHousePermits->permission_type = 11; // نوع الإذن للإرجاع
                $wareHousePermits->permission_date = now();
                $wareHousePermits->number = $invoice->id;
                $wareHousePermits->grand_total = $invoice->grand_total;
                $wareHousePermits->store_houses_id = $storeHouse->id;
                $wareHousePermits->created_by = auth()->user()->id;
                $wareHousePermits->save();

                // تسجيل تفاصيل حركة المخزون
                WarehousePermitsProducts::create([
                    'quantity' => $item->quantity,
                    'total' => $item->total,
                    'unit_price' => $item->unit_price,
                    'product_id' => $item->product_id,
                    'stock_before' => $productDetails->quantity - $item->quantity, // الكمية قبل الإضافة
                    'stock_after' => $productDetails->quantity, // الكمية بعد الإضافة
                    'warehouse_permits_id' => $wareHousePermits->id,
                ]);
            }
            foreach ($invoiceItems as $item) {
                // حساب الإجمالي لكل منتج (السعر × الكمية)
                $item_subtotal = $item['unit_price'] * $item['quantity'];

                // حساب قيمة الضريبة 1 إن وجدت
                if (!empty($item['tax_1_id'])) {
                    $tax1 = TaxSitting::find($item['tax_1_id']);
                    if ($tax1) {
                        $tax_value1 = ($tax1->tax / 100) * $item_subtotal; // حساب قيمة الضريبة كنسبة مئوية من المجموع الجزئي للمنتج
                        TaxInvoice::create([
                            'name' => $tax1->name,
                            'invoice_id' => $invoice->id,
                            'type' => $tax1->type,
                            'rate' => $tax1->tax,
                            'value' => $tax_value1,
                        ]);
                    }
                }

                // حساب قيمة الضريبة 2 إن وجدت
                if (!empty($item['tax_2_id'])) {
                    $tax2 = TaxSitting::find($item['tax_2_id']);
                    if ($tax2) {
                        $tax_value2 = ($tax2->tax / 100) * $item_subtotal; // حساب قيمة الضريبة كنسبة مئوية من المجموع الجزئي للمنتج
                        TaxInvoice::create([
                            'name' => $tax2->name,
                            'invoice_id' => $invoice->id,
                            'type' => $tax2->type,
                            'rate' => $tax2->tax,
                            'value' => $tax_value2,
                        ]);
                    }
                }
            }
            // عكس القيود المحاسبية
            $journalEntries = JournalEntry::where('invoice_id', $invoice->id)->get();

            // foreach ($journalEntries as $journalEntry) {
            //     // عكس تفاصيل القيد المحاسبي
            //     foreach ($journalEntry->details as $detail) {
            //         $detail->debit = $detail->credit; // تبديل المدين والدائن
            //         $detail->credit = $detail->debit;
            //         $detail->save();
            //     }

            //     // تحديث رصيد الحسابات
            //     if ($detail->account) {
            //         if ($detail->is_debit) {
            //             $detail->account->balance -= $detail->debit; // خصم المبلغ من المدين
            //         } else {
            //             $detail->account->balance += $detail->credit; // إضافة المبلغ إلى الدائن
            //         }
            //         $detail->account->save();
            //     }
            // }
            // استرجاع حساب القيمة المضافة المحصلة
            $vatAccount = Account::where('name', 'القيمة المضافة المحصلة')->first();
            if (!$vatAccount) {
                throw new \Exception('حساب القيمة المضافة المحصلة غير موجود');
            }
            $storeAccount = Account::where('name', 'المخزون')->first();
            if (!$storeAccount) {
                throw new \Exception('حساب المخزون غير موجود');
            }
            $costAccount = Account::where('id', 50)->first();
            if (!$costAccount) {
                throw new \Exception('حساب تكلفة المبيعات غير موجود');
            }
            $retursalesnAccount = Account::where('id', 45)->first();
            if (!$retursalesnAccount) {
                throw new \Exception('حساب  مردودات المبيعات غير موجود');
            }
            $mainAccount = Account::where('name', 'الخزينة الرئيسية')->first();
            if (!$mainAccount) {
                throw new \Exception('حساب  الخزينة الرئيسية غير موجود');
            }

            $clientaccounts = Account::where('client_id', $invoice->client_id)->first();

            if ($invoice->payment_status = 1) {
                $journalEntry = JournalEntry::create([
                    'reference_number' => $invoice->code,
                    'date' => now(),
                    'description' => 'مرتجع مبيعات لفاتورة رقم ' . $invoice->code,
                    'status' => 1,
                    'currency' => 'SAR',
                    'client_id' => $invoice->client_id,
                    'invoice_id' => $invoice->id,
                     'created_by_employee' => Auth::id(),
                    // 'created_by_employee' => Auth::id(),
                ]);

                // // 2. حساب العميل (مدين)
                JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $clientaccounts->id, // حساب المبيعات
                    'description' => 'العميل',
                    'debit' => $invoice->grand_total, // المبلغ بعد الخصم (مدين)
                    'credit' => 0,
                    'is_debit' => false,
                ]);

               // // 2. حساب الخزينة (دائن)
               JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $mainAccount->id, // حساب المبيعات
                'description' => 'مرتجع مبيعات',
                'debit' => 0,
                'credit' => $invoice->grand_total, // المبلغ بعد الخصم (دائن)
                'is_debit' => false,
            ]);
            $journalEntry = JournalEntry::create([
                'reference_number' => $invoice->code,
                'date' => now(),
                'description' => 'مرتجع مبيعات لفاتورة رقم ' . $invoice->code,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $invoice->client_id,
                'invoice_id' => $invoice->id,
                // 'created_by_employee' => Auth::id(),
            ]);

             // // 2. حساب مردود المبيعات (مدين)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $retursalesnAccount->id, // حساب المبيعات
                'description' => 'مردود المبيعات',
                'debit' => $invoice->grand_total, // المبلغ بعد الخصم (مدين)
                'credit' => 0, 
                'is_debit' => false,
            ]);

                // // 2. حساب  العميل (دائن)
                JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $clientaccounts->id, // حساب المبيعات
                    'description' => 'مردود المبيعات',
                    'debit' => 0,
                    'credit' => $invoice->grand_total, // المبلغ بعد الخصم (دائن)
                    'is_debit' => false,
                ]);

            $journalEntry = JournalEntry::create([
                'reference_number' => $invoice->code,
                'date' => now(),
                'description' => 'مرتجع مبيعات لفاتورة رقم ' . $invoice->code,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $invoice->client_id,
                'invoice_id' => $invoice->id,
                // 'created_by_employee' => Auth::id(),
            ]);

                // // 2. حساب  المخزون (مدين)
                JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $storeAccount->id, // حساب المبيعات
                    'description' => 'مردود المبيعات',
                    'debit' => $invoice->grand_total, // المبلغ بعد الخصم (مدين)
                    'credit' => 0,
                    'is_debit' => true,
                ]);

                // // 2. حساب  تكلفة المبيعات (دائن)
                JournalEntryDetail::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $costAccount->id, // حساب المبيعات
                    'description' => 'مردود المبيعات',
                    'debit' => 0,
                    'credit' => $invoice->grand_total, // المبلغ بعد الخصم (دائن)
                    'is_debit' => false,
                ]);

                if ($clientaccounts) {
                    $clientaccounts->balance += $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                    $clientaccounts->save();
                }
                if ($storeAccount) {
                    $storeAccount->balance += $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                    $storeAccount->save();
                }
                if ($retursalesnAccount) {
                    $retursalesnAccount->balance += $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                    $retursalesnAccount->save();
                }
                if ($mainAccount) {
                    $mainAccount->balance -= $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                    $mainAccount->save();
                }
                if ($costAccount) {
                    $costAccount->balance -= $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                    $costAccount->save();
                }
            }
            //     // إنشاء القيد المحاسبي للفاتورة
            $journalEntry = JournalEntry::create([
                'reference_number' => $invoice->code,
                'date' => now(),
                'description' => 'مرتجع مبيعات رقم ' . $invoice->code,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $invoice->client_id,
                'invoice_id' => $invoice->id,
                // 'created_by_employee' => Auth::id(),

            ]);

            // // إضافة تفاصيل القيد المحاسبي

            // // 2. حساب المخزون (مدين)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $storeAccount->id, // حساب المبيعات
                'description' => 'المخزون',
                'debit' => $invoice->grand_total, // المبلغ بعد الخصم (مدين)
                'credit' => 0,
                'is_debit' => false,
            ]);

            // // 1. حساب تكلفة المبيعات (دائن)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $costAccount->id, // حساب تكلفة المبيعات
                'description' => 'فاتورة مبيعات',
                'debit' => 0, //
                'credit' => $invoice->grand_total, // دائن ف حساب العميل
                'is_debit' => false,
            ]);

            //   // // 3. حساب القيمة المضافة المحصلة (دائن)
            //   JournalEntryDetail::create([
            //     'journal_entry_id' => $journalEntry->id,
            //     'account_id' => $vatAccount->id, // حساب القيمة المضافة المحصلة
            //     'description' => 'ضريبة القيمة المضافة',
            //     'debit' => $invoice->tax_total, // قيمة الضريبة (مدين)
            //     'credit' => 0,
            //     'is_debit' => false,
            // ]);

            $journalEntry = JournalEntry::create([
                'reference_number' => $invoice->code,
                'date' => now(),
                'description' => 'مرتجع مبيعات رقم ' . $invoice->code,
                'status' => 1,
                'currency' => 'SAR',
                'client_id' => $invoice->client_id,
                'invoice_id' => $invoice->id,
                // 'created_by_employee' => Auth::id(),

            ]);

            // // 2. حساب العميل (دائن)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $clientaccounts->id, // حساب المبيعات
                'description' => 'العميل',
                'debit' => 0,
                'credit' => $invoice->grand_total, // المبلغ بعد الخصم (دائن)
                'is_debit' => false,
            ]);

            // // 2. حساب مردود المبيعات (مدين)
            JournalEntryDetail::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $retursalesnAccount->id, // حساب المبيعات
                'description' => 'مردود مبيعات',
                'debit' => $invoice->grand_total, // المبلغ بعد الخصم (مدين)
                'credit' => 0,
                'is_debit' => false,
            ]);
            // تحديث رصيد حساب المخزون الرئيسية

            if ($storeAccount) {
                $storeAccount->balance += $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                $storeAccount->save();
            }

            // //الضريبه المحصلة
            // if ($vatAccount) {
            //     $vatAccount->balance -= $invoice->tax_total; // المبلغ الكلي (المبيعات + الضريبة)
            //     $vatAccount->save();
            // }

            //العميل
            if ($clientaccounts) {
                $clientaccounts->balance -= $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                $clientaccounts->save();
            }

            //تكلفة المبيعات
            if ($retursalesnAccount) {
                $retursalesnAccount->balance += $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                $retursalesnAccount->save();
            }
            //مردود المبيعات

            if ($costAccount) {
                $costAccount->balance -= $invoice->grand_total; // المبلغ الكلي (المبيعات + الضريبة)
                $costAccount->save();
            }

            // تحديث حالة الفاتورة
            $invoice->payment_status = 4; // حالة الإرجاع
            $invoice->save();

            // إتمام المعاملة
            DB::commit();

            return redirect()->route('ReturnIInvoices.show', $invoice->id)->with('success', 'تم إرجاع الفاتورة بنجاح.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في إرجاع الفاتورة: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'عذراً، حدث خطأ أثناء إرجاع الفاتورة: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        return redirect()
            ->back()
            ->with('error', 'لا يمكنك تعديل الفاتورة رقم ' . $id . '. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy($id)
    {
        return redirect()->route('ReturnIInvoices.index')->with('error', 'لا يمكنك حذف الفاتورة. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, $id)
    {
        return redirect()->route('ReturnIInvoices.index')->with('error', 'لا يمكنك تعديل الفاتورة. طبقا لتعليمات هيئة الزكاة والدخل يمنع حذف أو تعديل الفاتورة بعد إصدارها وفقا لمتطلبات الفاتورة الإلكترونية، ولكن يمكن إصدار فاتورة مرتجعة أو إشعار دائن لإلغائها أو تعديلها.');
    }

    public function show($id)
    {
        $clients = Client::all();
        $employees = Employee::all();
        $return_invoice = Invoice::find($id);
        $TaxsInvoice = TaxInvoice::where('invoice_id', $id)->get();
        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();
        // $invoice_number = $this->generateInvoiceNumber();
        return view('sales.retend_invoice.show', compact('clients', 'TaxsInvoice', 'employees', 'account_setting', 'return_invoice'));
    }
}
