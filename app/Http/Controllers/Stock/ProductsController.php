<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProductsRequest;
use App\Imports\ProductsImport;
use App\Models\AccountSetting;
use App\Models\Category;
use App\Models\CompiledProducts;
use App\Models\GeneralSettings;
use App\Models\Log;
use App\Models\PriceList;
use App\Models\PriceListItems;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\StoreHouse;
use App\Models\SubUnit;
use App\Models\TemplateUnit;
use App\Models\WarehousePermits;
use App\Models\WarehousePermitsProducts;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        // جلب المستخدم الحالي
        $user = auth()->user();

        // التحقق مما إذا كان للمستخدم فرع أم لا
        if ($user->branch) {
            $branch = $user->branch;

            // التحقق من صلاحية "مشاركة المنتجات"
            $shareProductsStatus = $branch->settings()->where('key', 'share_products')->first();

            // إذا كانت الصلاحية غير مفعلة، عرض المنتجات التي أضافها المستخدمون من نفس الفرع فقط
            if ($shareProductsStatus && $shareProductsStatus->pivot->status == 0) {
                $products = Product::whereHas('creator', function ($query) use ($branch) {
                    $query->where('branch_id', $branch->id);
                })->orderBy('id', 'DESC')->paginate(5);
            } else {
                // إذا كانت الصلاحية مفعلة أو غير موجودة، عرض جميع المنتجات
                $products = Product::orderBy('id', 'DESC')->paginate(5);
            }
        } else {
            // إذا لم يكن لدى المستخدم فرع، عرض جميع المنتجات
            $products = Product::orderBy('id', 'DESC')->paginate(5);
        }

        // إعدادات الحساب والإعدادات العامة
        $account_setting = AccountSetting::where('user_id', auth()->user()->id)->first();
        $generalSettings = GeneralSettings::select()->first();
        $role = $generalSettings ? $generalSettings->enable_assembly_and_compound_units == 1 : false;

        return view('stock.products.index', compact('products', 'account_setting', 'role'));
    }



    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keywords')) {
            $query->where('name', 'LIKE', "%{$request->keywords}%")
                ->orWhere('barcode', 'LIKE', "%{$request->keywords}%");
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('barcode')) {
            $query->where('barcode', $request->barcode);
        }

        if ($request->filled('track_inventory')) {
            $query->where('track_inventory', $request->track_inventory);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        $products = $query->orderBy('id', 'DESC')->paginate(5);

        return view('stock.products.index', compact('products'));
    }

    public function create()
    {
        $record_count = DB::table('products')->count();
        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);
        $SubUnits = collect(); // متغير فارغ للوحدات الفرعية
        $TemplateUnit = TemplateUnit::where('status', 1)->get();
        // التأكد من أن هناك قوالب وحدات متاحة
        if ($TemplateUnit->isNotEmpty()) {
            $firstTemplateUnit = $TemplateUnit->first(); // القالب الأول افتراضيًا
            $SubUnits = SubUnit::where('template_unit_id', $firstTemplateUnit->id)->get();
        }
        $generalSettings = GeneralSettings::select()->first();
        $role = $generalSettings ? $generalSettings->enable_multi_units_system == 1 : false;

        $categories = Category::select('id', 'name')->get();
        $price_lists = PriceList::orderBy('id', 'DESC')->paginate(10);
        return view('stock.products.create', compact('categories', 'price_lists', 'role', 'serial_number', 'TemplateUnit', 'SubUnits'));
    }

    public function getSubUnits(Request $request)
    {
        // إذا لم يتم تحديد أي قالب، جلب الوحدات الفرعية لأول قالب
        if (!$request->has('template_unit_id') || !$request->template_unit_id) {
            $firstTemplateUnit = TemplateUnit::where('status', 1)->first();
            if ($firstTemplateUnit) {
                $subUnits = SubUnit::where('template_unit_id', $firstTemplateUnit->id)->get();
            } else {
                $subUnits = [];
            }
        } else {
            $subUnits = SubUnit::where('template_unit_id', $request->template_unit_id)->get();
        }

        return response()->json($subUnits);
    }

    public function traking()
    {
        $Products = Product::where('track_inventory', '!=', null)->get();


        return view('stock.products.track', compact('Products'));
    }


    public function create_services()
    {
        $record_count = DB::table('products')->count();
        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);


        $categories = Category::select('id', 'name')->get();
        return view('stock.products.create_services', compact('categories', 'serial_number'));
    }


    public function edit($id)
    {
        $categories = Category::select('id', 'name')->get();
        $product = Product::findOrFail($id);
        $product_details = ProductDetails::where('product_id', $id)->first();
        return view('stock.products.edit', compact('product', 'product_details', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $total_quantity = DB::table('product_details')->where('product_id', $id)->sum('quantity');
        $storeQuantities = ProductDetails::where('product_id', $id)->selectRaw('store_house_id, SUM(quantity) as total_quantity')
            ->groupBy('store_house_id')->with('storeHouse')
            ->get();
        $total_sold = $product->totalSold();
        $sold_last_28_days = $product->totalSoldLast28Days();
        $sold_last_7_days = $product->totalSoldLast7Days();
        $average_cost = $product->averageCost();
        $firstTemplateUnit = null;
        $firstTemplateUnit = optional(TemplateUnit::find($product->sub_unit_id))->base_unit_name;
        $CompiledProducts = CompiledProducts::where('compile_id', $id)->get();
        $logs = Log::where('type', 'product')->where('type_id', $id)->get();

        $stock_movements = WarehousePermitsProducts::where('product_id', $id)
            ->with(['warehousePermits' => function ($query) {
                $query->with(['storeHouse', 'fromStoreHouse', 'toStoreHouse']);
            }])->get();

        return view('stock.products.show', compact('product', 'logs', 'CompiledProducts', 'firstTemplateUnit', 'total_quantity', 'storeQuantities', 'total_sold', 'sold_last_28_days', 'sold_last_7_days', 'average_cost', 'stock_movements'));
    }
    public function categories(Request $request)
    {
        $search = $request->input('search');

        // البحث في قاعدة البيانات
        $categories = Category::where('name', 'like', '%' . $search . '%')->get();

        // تحضير النتائج لتتوافق مع Select2
        $results = [];
        foreach ($categories as $category) {
            $results[] = [
                'id' => $category->id,
                'text' => $category->name,
            ];
        }

        return response()->json(['results' => $results]);
    }

    public function store(ProductsRequest $request)
    {
       
       

        try {

            DB::beginTransaction();



            $product = new Product();

            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->sub_unit_id = $request->sub_unit_id;
            $product->serial_number = $request->serial_number;
            $product->brand = $request->brand;
            $product->supplier_id = $request->supplier_id;
            $product->barcode = $request->barcode;
            $product->track_inventory = $request->track_inventory;
            $product->barcode = $request->barcode;
            $product->inventory_type = $request->inventory_type;
            $product->low_stock_alert = $request->low_stock_alert;
            $product->sales_cost_account = $request->sales_cost_account;
            $product->sale_price = $request->sale_price;
            $product->Internal_notes = $request->Internal_notes;
            $product->tags = $request->tags;
            $product->status = $request->status;
            $product->purchase_price = $request->purchase_price;
            $product->sale_price = $request->sale_price;
            $product->purchase_unit_id = $request->purchase_unit_id;
            $product->sales_unit_id = $request->sales_unit_id;
            $product->tax1 = $request->tax1;
            $product->tax2 = $request->tax2;
            $product->min_sale_price = $request->min_sale_price;
            $product->discount = $request->discount;
            $product->discount_type = $request->discount_type;
            $product->type = $request->type;
            $product->profit_margin = $request->profit_margin;
            $product->expiry_date   = $request->expiry_date;
            $product->notify_before_days = $request->notify_before_days;
            $product->created_by = Auth::user()->id;


            if ($request->has('available_online')) {
                $product->available_online = 1;
            }

            if ($request->has('featured_product')) {
                $product->featured_product = 1;
            }

            if ($request->hasFile('images')) {
                $product->images = $this->UploadImage('assets/uploads/product', $request->images);
            }

            if ($request->has('available_online')) {
                $product->available_online = 1;
            }

            if ($request->has('featured_product')) {
                $product->featured_product = 1;
            }

            if ($request->hasFile('images')) {
                $product->images = $this->UploadImage('assets/uploads/product', $request->images);
            } # End If


            $product->save();

            ProductDetails::create([
                'quantity' => 0,
                'product_id' => $product->id,
            ]);

            if ($request->has('price_list_id') && !empty($request->price_list_id)) {
                // إذا تم اختيار price_list_id، قم بحفظ البيانات
                PriceListItems::create([
                    'product_id' => $product->id,
                    'price_list_id' => $request->price_list_id,
                    'sale_price' => $request->price_list,
                ]);
            }

            // تسجيل نشاط جديد
            Log::create([
                'type' => 'product',
                'type_id' => $product->id, // ID النشاط المرتبط
                'type_log' => 'create', // نوع النشاط
                'description' => 'تم اضافة منتج جديد',
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);

            DB::commit();


            if ($product->type == "services") {
                return redirect()->route('products.index')->with(['success' => 'تم إضافة الخدمة بنجاح !!']);
            }

            return redirect()->route('products.index')->with(['success' => 'تم إضافة المنتج بنجاح !!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء إضافة المنتج: ' . $e->getMessage()]);
        }


        if ($product->type == "services") {
            return redirect()->route('products.index')->with(['success' => 'تم اضافه الخدمة بنجاج !!']);
        }
        return redirect()->route('products.index')->with(['success' => 'تم اضافه المنتج بنجاج !!']);
    } # End Stor


    // اضافة الخدمة
    public function update(ProductsRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $oldName = $product->name;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->serial_number = $request->serial_number;
            $product->brand = $request->brand;
            $product->supplier_id = $request->supplier_id;
            $product->barcode = $request->barcode;
            $product->track_inventory = $request->track_inventory;
            $product->inventory_type = $request->inventory_type;
            $product->low_stock_alert = $request->low_stock_alert;
            $product->sales_cost_account = $request->sales_cost_account;
            $product->sale_price = $request->sale_price;
            $product->Internal_notes = $request->Internal_notes;
            $product->tags = $request->tags;
            $product->status = $request->status;
            $product->purchase_price = $request->purchase_price;
            $product->sale_price = $request->sale_price;
            $product->tax1 = $request->tax1;
            $product->tax2 = $request->tax2;
            $product->min_sale_price = $request->min_sale_price;
            $product->discount = $request->discount;
            $product->discount_type = $request->discount_type;
            $product->profit_margin = $request->profit_margin;
            $product->created_by = Auth::user()->id;

            if ($request->has('available_online')) {
                $product->available_online = 1;
            }

            if ($request->has('featured_product')) {
                $product->featured_product = 1;
            }

            if ($request->hasFile('images')) {
                $product->images = $this->UploadImage('assets/uploads/product', $request->images);
            } # End If

            $product->update();

            Log::create([
                'type' => 'product',
                'type_id' => $product->id, // ID النشاط المرتبط
                'type_log' => 'edit', // نوع النشاط
                'description' => 'تم تعديل المنتج',
                'old_value' =>  $oldName,
                'created_by' => auth()->id(), // ID المستخدم الحالي
            ]);
            DB::commit();
            return redirect()->route('products.index')->with(['success' => 'تم تحديث المنتج بنجاج !!']);
        } # End Try
        catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'حدث خطاء ما يرجى المحاوله مره اخره'])->withInput();
        }
    } # End Stor


    // اضافة منتج تجميعي

    public function compiled()
    {
        $record_count = DB::table('products')->count();
        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);
        $SubUnits = collect(); // متغير فارغ للوحدات الفرعية
        $TemplateUnit = TemplateUnit::where('status', 1)->get();
        // التأكد من أن هناك قوالب وحدات متاحة
        if ($TemplateUnit->isNotEmpty()) {
            $firstTemplateUnit = $TemplateUnit->first(); // القالب الأول افتراضيًا
            $SubUnits = SubUnit::where('template_unit_id', $firstTemplateUnit->id)->get();
        }
        $generalSettings = GeneralSettings::select()->first();
        $role = $generalSettings ? $generalSettings->enable_multi_units_system == 1 : false;
        $storehouses = StoreHouse::orderBy('id', 'DESC')->get();
        $products = Product::where('type', 'products')->get();
        $categories = Category::select('id', 'name')->get();
        return view('stock.products.compiled', compact('categories', 'storehouses', 'products', 'role', 'serial_number', 'TemplateUnit', 'SubUnits'));
    }
    public function compiled_store(Request $request)
    {
        

        try {
            DB::beginTransaction();

            $product = new Product();

            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->sub_unit_id = $request->sub_unit_id;
            $product->serial_number = $request->serial_number;
            $product->brand = $request->brand;
            $product->supplier_id = $request->supplier_id;
            $product->barcode = $request->barcode;
            $product->track_inventory = $request->track_inventory;
            $product->inventory_type = $request->inventory_type;
            $product->low_stock_alert = $request->low_stock_alert;
            $product->sales_cost_account = $request->sales_cost_account;
            $product->sale_price = $request->sale_price;
            $product->Internal_notes = $request->Internal_notes;
            $product->tags = $request->tags;
            $product->status = $request->status;
            $product->purchase_price = $request->purchase_price;
            $product->purchase_unit_id = $request->purchase_unit_id;
            $product->sales_unit_id = $request->sales_unit_id;
            $product->tax1 = $request->tax1;
            $product->tax2 = $request->tax2;
            $product->min_sale_price = $request->min_sale_price;
            $product->discount = $request->discount;
            $product->discount_type = $request->discount_type;
            $product->type = $request->type;
            $product->profit_margin = $request->profit_margin;
            $product->storehouse_id = $request->storehouse_id; // مخزن المنتجات الاوليه للمنتج التجميعي
            $product->compile_type = "Instant";  // نوع التجميعه معد مسبقا او فوري
            $product->created_by = Auth::user()->id;

            if ($request->has('available_online')) {
                $product->available_online = 1;
            }

            if ($request->has('featured_product')) {
                $product->featured_product = 1;
            }

            if ($request->hasFile('images')) {
                $product->images = $this->UploadImage('assets/uploads/product', $request->images);
            }

            $product->save();

            // تحقق من صحة البيانات
            $request->validate([

                'products' => 'required|array', // تأكد من وجود بيانات المنتجات
                'products.*.product_id' => 'required|exists:products,id', // تأكد من وجود product_id في جدول products
                'products.*.quantity' => 'required|numeric|min:1', // تأكد من أن الكمية رقم صحيح أكبر من 0
            ]);


            foreach ($request->products as $productData) {
                $compiledProduct = new CompiledProducts();

                // تعيين compile_id إلى المنتج التجميعي
                $compiledProduct->compile_id = $product->id;  // هذا هو المنتج التجميعي ويجب أن يتكرر لجميع المنتجات المرتبطة به

                // تعيين product_id إلى المنتج الفرعي
                $compiledProduct->product_id = $productData['product_id'];  // معرّف المنتج الفردي

                // تعيين الكمية
                $compiledProduct->qyt = $productData['quantity'];  // الكمية الخاصة بالمنتج

                // حفظ البيانات في جدول CompiledProducts
                $compiledProduct->save();
            }

            $quantity = $request->quantity;

            // إنشاء سجل جديد في `ProductDetails`
            ProductDetails::create([
                'quantity' => $quantity,
                'product_id' => $product->id,
            ]);
            
          
            

            DB::commit();

            if ($product->type == "services") {
                return redirect()->route('products.index')->with(['success' => 'تم إضافة الخدمة بنجاح !!']);
            }

            return redirect()->route('products.index')->with(['success' => 'تم إضافة المنتج بنجاح !!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء إضافة المنتج: ' . $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        ProductDetails::where('product_id', $id)->delete();
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with(['error' => 'تم حذف المنتج بنجاح المنتج بنجاج !!']);
    }

    public function manual_stock_adjust($id)
    {
        $product = Product::findOrFail($id);
        $storehouses = StoreHouse::select(['name', 'id'])->get();
        $generalSettings = GeneralSettings::select()->first();
        $role = $generalSettings ? $generalSettings->enable_multi_units_system == 1 : false;

        $SubUnits = $product->sub_unit_id ? SubUnit::where('template_unit_id', $product->sub_unit_id)->get() : collect();

        return view('stock.products.manual_stock_adjust', compact('product', 'role', 'storehouses', 'SubUnits'));
    }

    public function add_manual_stock_adjust(Request $request, $id)
    {

        $request->validate([
            'quantity' => 'required|numeric|min:1',
            'type' => 'required|in:1,2',
            'unit_price' => 'required|numeric',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
            'attachments' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'store_house_id' => 'required|exists:store_houses,id',
        ]);

        try {
            DB::beginTransaction();

            // جلب المنتج من المخزن المحدد فقط
            $product = ProductDetails::where('product_id', $id)->firstOrFail();

            if ($request->type == 2) {
                $product = ProductDetails::where('product_id', $id)
                    ->where('store_house_id', $request->store_house_id)
                    ->first();

                if (!$product) {
                    return redirect()->back()->with(['error' => 'المنتج غير موجود في المخزن المحدد.'])->withInput();
                }
            }

            $old_quantity_in_stock = $product->quantity;

            // التحقق من توفر الكمية قبل السحب
            if ($request->type == 2 && $old_quantity_in_stock < $request->quantity) {
                return redirect()->route('products.manual_stock_adjust', $id)
                    ->withInput()
                    ->with(['error' => 'الكميه غير متوفره في المخزن المحدد.']);
            }

            $this->updateProductAndCreatePermit($product, $request, $request->type, $id);

            DB::commit();

            $message = $request->type == 2 ? 'تم سحب الكميه من المخزون بنجاح' : 'تم اضافه الكميه الي المخزون بنجاح';
            return redirect()->route('products.show', $id)->withInput()->with(['success' => $message]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => $ex->getMessage()])->withInput();
        }
    }


    private function updateProductAndCreatePermit($product, $request, $type, $id)
    {
        if ($request->hasFile('attachments')) {
            $product->attachments = $this->UploadImage('assets/uploads/product/attachments', $request->attachments);
        }

        // التحقق من المخزون قبل التحديث
        if ($type == 2 && $product->quantity < $request->quantity) {
            return redirect()->back()->with(['error' => 'الكميه غير متوفره في المخزن المحدد.'])->withInput();
        }

        // تحديث الكمية بناءً على العملية (إضافة أو سحب)
        $SubUnit = SubUnit::find($request->sub_unit_id);

        if ($SubUnit) {
            $conversionFactor = $SubUnit->conversion_factor;
        } else {
            $conversionFactor = 1; // قيمة افتراضية في حالة عدم وجود الوحدة
        }

        $product->quantity = ($type == 2)
            ? $product->quantity - ($request->quantity * $conversionFactor)
            : $product->quantity + ($request->quantity * $conversionFactor);
        $product->type = $request->type;
        $product->unit_price = $request->unit_price;
        $product->date = $request->date;
        $product->time = $request->time;
        $product->type_of_operation = $request->type_of_operation;
        $product->comments = $request->comments;
        $product->subaccount = $request->subaccount;
        $product->duration = $request->duration;
        $product->status = $request->status;
        $product->store_house_id = $request->store_house_id;
        $product->product_id = $id;

        $product->update();

        // إنشاء إذن المخزن
        $wareHousePermits = new WarehousePermits();
        $wareHousePermits->store_houses_id = $request->store_house_id;
        $wareHousePermits->permission_type = $type;
        $record_count = DB::table('warehouse_permits')->count();
        $serial_number = str_pad($record_count + 1, 6, '0', STR_PAD_LEFT);
        $wareHousePermits->number = $serial_number;
        $wareHousePermits->grand_total = $request->quantity * $request->unit_price;
        $wareHousePermits->created_by = auth()->user()->id;
        $wareHousePermits->sub_account = $request->subaccount;
        $wareHousePermits->details = $request->comments;
        $wareHousePermits->permission_date = $request->has('date') && $request->has('time')
            ? Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time)
            : Carbon::now();
        $wareHousePermits->save();

        // حفظ تفاصيل المنتج في إذن المخزن
        WarehousePermitsProducts::create([
            'quantity' => $request->quantity,
            'total' => $request->quantity * $request->unit_price,
            'unit_price' => $request->unit_price,
            'product_id' => $id,
            'warehouse_permits_id' => $wareHousePermits->id,
        ]);
        $product = Product::find($id);
        if ($product->type == "compiled" && $product->compile_type !== "Instant") {
            // ** الحصول على المنتجات التابعة للمنتج التجميعي **
            $CompiledProducts = CompiledProducts::where('compile_id', $id)->get();

            foreach ($CompiledProducts as $compiledProduct) {
                // ** حساب المخزون قبل وبعد التعديل للمنتج التابع **
                $total_quantity = DB::table('product_details')->where('product_id', $compiledProduct->product_id)->sum('quantity');
                $stock_before = $total_quantity;
                $stock_after = $stock_before - ($compiledProduct->qyt * $request->quantity); // خصم الكمية المطلوبة

                // ** تسجيل المبيعات في حركة المخزون للمنتج التابع **
                $wareHousePermits = new WarehousePermits();
                $wareHousePermits->permission_type = 2; // خصم من الفاتورة
                $wareHousePermits->permission_date =  $request->has('date') && $request->has('time')
                    ? Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time)
                    : Carbon::now();
                $wareHousePermits->number = $product->id;
                $wareHousePermits->grand_total = $request->quantity * $request->unit_price;
                $wareHousePermits->store_houses_id = $request->store_house_id;
                $wareHousePermits->created_by = auth()->user()->id;
                $wareHousePermits->save();

                // ** تسجيل البيانات في WarehousePermitsProducts للمنتج التابع **
                WarehousePermitsProducts::create([
                    'quantity' => $compiledProduct->qyt * $request->quantity,
                    'total' => $request->quantity * $request->unit_price,
                    'unit_price' => $request->unit_price,
                    'product_id' => $compiledProduct->product_id,
                    'stock_before' => $stock_before, // المخزون قبل التحديث
                    'stock_after' => $stock_after,   // المخزون بعد التحديث
                    'warehouse_permits_id' => $wareHousePermits->id,
                ]);

                // ** تحديث المخزون للمنتج التابع **
                $compiledProductDetails = ProductDetails::where('store_house_id', $request->store_house_id)
                    ->where('product_id', $compiledProduct->product_id)
                    ->first();

                if (!$compiledProductDetails) {
                    $compiledProductDetails = ProductDetails::create([
                        'store_house_id' => $request->store_house_id,
                        'product_id' => $compiledProduct->product_id,
                        'quantity' => 0,
                    ]);
                }

                $compiledProductDetails->decrement('quantity', $compiledProduct->qyt * $request->quantity);
            }
        }
    }



    # Helper Function
    public function GenerateImage($image, $imageName)
    {
        $destinationsPath = public_path('assets/uploads');
        $img = Image::read($image->path());
        $img->cover(124, 124, 'top');
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationsPath . '/' . $imageName);
    }
    function uploadImage($folder, $image)
    {
        $fileExtension = $image->getClientOriginalExtension();
        $fileName = time() . rand(1, 99) . '.' . $fileExtension;
        $image->move($folder, $fileName);

        return $fileName;
    } //end of uploadImage
    public function GenerateProductImage($image, $imageName)
    {
        $destinationsPath = public_path('assets/uploads/product');
        $img = Image::read($image->path());

        $img->cover(540, 689, 'top');
        $img->resize(
            540,
            689,
            function ($constraint) {
                $constraint->aspectRatio();
            }
        )->save($destinationsPath . '/' . $imageName);
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt',
        ]);

        Excel::import(new ProductsImport(), $request->file('file'));





        return redirect()->back()->with('success', 'تم استيراد المنتجات بنجاح!');
    }
}

