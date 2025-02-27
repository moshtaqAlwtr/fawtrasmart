<?php

namespace App\Http\Controllers\Reports\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\StoreHouse;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    // عرض الصفحة الرئيسية لتقارير المخزون
    public function index()
    {
        return view('reports.inventory.index');
    }

    // تقرير المخزون بالمخازن
    public function inventorySheet(Request $request)
    {
        // جلب جميع التصنيفات والعلامات التجارية والمستودعات للفلترة
        $categories = Category::all();
        $brands = Product::distinct('brand')->pluck('brand');
        $warehouses = StoreHouse::all();

        // جلب البيانات مع الفلترة
        $products = Product::query()
            ->with(['category', 'product_details'])
            ->when($request->category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when($request->brand, function ($query, $brand) {
                return $query->where('brand', $brand);
            })
            ->when($request->warehouse, function ($query, $warehouse) {
                return $query->whereHas('product_details', function ($q) use ($warehouse) {
                    $q->where('store_house_id', $warehouse);
                });
            })
            ->get();

        return view('reports.inventory.stock_report.inventory_sheet', compact('products', 'categories', 'brands', 'warehouses'));
    }
    public function summaryInventory(Request $request)
    {
        // جلب الفلترات من الطلب
        $categoryId = $request->input('category');
        $brand = $request->input('brand');
        $warehouseId = $request->input('warehouse');
        $hideZeroBalance = $request->has('hideZeroBalance');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $type = $request->input('type');

        // استعلام لجلب البيانات
        $query = Product::with(['product_details', 'category', 'invoice_items']);

        // تطبيق الفلترات
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($brand) {
            $query->where('brand', $brand);
        }
        if ($warehouseId) {
            $query->whereHas('product_details', function ($q) use ($warehouseId) {
                $q->where('store_house_id', $warehouseId);
            });
        }
        if ($hideZeroBalance) {
            $query->whereHas('product_details', function ($q) {
                $q->where('quantity', '>', 0);
            });
        }
        if ($startDate && $endDate) {
            $query->whereHas('invoice_items', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }
        if ($type) {
            $query->whereHas('invoice_items', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        // جلب البيانات
        $products = $query->get();

        // تمرير البيانات إلى العرض
        return view('reports.inventory.stock_report.summary_inventory', [
            'products' => $products,
            'categories' => Category::all(), // قائمة التصنيفات
            'brands' => Product::distinct('brand')->pluck('brand'), // قائمة العلامات التجارية
            'warehouses' => StoreHouse::all(), // قائمة المستودعات
        ]);
    }
    public function detailedMovementInventory(Request $request)
    {
        // جلب الفلترات من الطلب
        $categoryId = $request->input('category');
        $type = $request->input('type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $brand = $request->input('brand');
        $warehouseId = $request->input('warehouse');

        // استعلام لجلب البيانات
        $query = ProductDetails::with(['product', 'storeHouse']);

        // تطبيق الفلترات
        if ($categoryId) {
            $query->whereHas('product', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }
        if ($type) {
            $query->where('type_of_operation', $type);
        }
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
        if ($brand) {
            $query->whereHas('product', function ($q) use ($brand) {
                $q->where('brand', $brand);
            });
        }
        if ($warehouseId) {
            $query->where('store_house_id', $warehouseId);
        }

        // جلب البيانات
        $movements = $query->get();

        // تمرير البيانات إلى العرض
        return view('reports.inventory.stock_report.detailed_movement_inventory', [
            'movements' => $movements,
            'categories' => Category::all(), // قائمة التصنيفات
            'brands' => Product::distinct('brand')->pluck('brand'), // قائمة العلامات التجارية
            'warehouses' => StoreHouse::all(), // قائمة المستودعات
        ]);
    }
    public function valueInventory(Request $request)
    {
        // جلب جميع الفلترات من الطلب
        $supplierId = $request->input('supplier');
        $brand = $request->input('brand');
        $categoryId = $request->input('category');
        $warehouseId = $request->input('warehouse');
        $dateRange = $request->input('dateRange');

        // جلب البيانات الأساسية للفلترات
        $suppliers = Supplier::all();
        $categories = Category::all();
        $warehouses = StoreHouse::all();
        $brands = Product::distinct('brand')->pluck('brand');

        // بناء الاستعلام لجلب المنتجات بناءً على الفلترات
        $productsQuery = Product::query();

        // فلترة حسب المورد
        if ($supplierId) {
            $productsQuery->where('supplier_id', $supplierId);
        }

        // فلترة حسب العلامة التجارية
        if ($brand) {
            $productsQuery->where('brand', $brand);
        }

        // فلترة حسب التصنيف
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        // فلترة حسب المستودع
        if ($warehouseId) {
            $productsQuery->whereHas('product_details', function ($query) use ($warehouseId) {
                $query->where('store_house_id', $warehouseId);
            });
        }

        // فلترة حسب الفترة الزمنية
        if ($dateRange) {
            $dates = explode(' إلى ', $dateRange);
            if (count($dates) == 2) {
                $fromDate = trim($dates[0]);
                $toDate = trim($dates[1]);
                $productsQuery->whereHas('invoice_items', function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('created_at', [$fromDate, $toDate]);
                });
            }
        }

        // جلب المنتجات بعد التصفية
        $products = $productsQuery->with(['product_details', 'invoice_items'])->get();

        // حساب القيم المطلوبة لكل منتج
        $products->each(function ($product) {
            // حساب الكمية الإجمالية من جميع المستودعات
            $product->total_quantity = $product->product_details->sum('quantity');

            // حساب متوسط سعر الشراء
            $product->average_purchase_price = $product->product_details->avg('unit_price');

            // إذا لم يكن هناك تفاصيل للمنتج، اجعل الكمية 0
            if ($product->total_quantity == 0) {
                $product->average_purchase_price = 0;
            }

            // حساب الكمية المباعة
            $product->total_sold = $product->invoice_items->sum('quantity');

            // حساب متوسط سعر البيع
            $product->average_sale_price = $product->invoice_items->avg('unit_price');

            // حساب إجمالي سعر البيع المتوقع
            $product->total_sale_value = $product->total_quantity * $product->sale_price;

            // حساب إجمالي سعر الشراء
            $product->total_purchase_value = $product->total_quantity * $product->purchase_price;

            // حساب الربح المتوقع
            $product->expected_profit = $product->total_sale_value - $product->total_purchase_value;
        });

        // تمرير البيانات إلى الواجهة
        return view('reports.inventory.stock_report.value_inventory', compact('categories', 'warehouses', 'suppliers', 'brands', 'products'));
    }

    public function inventoryBlance(Request $request)
    {
        // جلب جميع الفلترات من الطلب
        $productId = $request->input('product');
        $categoryId = $request->input('category');
        $brand = $request->input('brand');
        $warehouseId = $request->input('warehouse');
        $status = $request->input('status');

        // جلب البيانات الأساسية للفلترات
        $products = Product::all();
        $categories = Category::all();
        $brands = Product::distinct('brand')->pluck('brand');
        $warehouses = StoreHouse::all();

        // بناء الاستعلام لجلب المنتجات بناءً على الفلترات
        $productsQuery = Product::query();

        // فلترة حسب المنتج
        if ($productId) {
            $productsQuery->where('id', $productId);
        }

        // فلترة حسب التصنيف
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        // فلترة حسب العلامة التجارية
        if ($brand) {
            $productsQuery->where('brand', $brand);
        }

        // فلترة حسب المستودع
        if ($warehouseId) {
            $productsQuery->whereHas('product_details', function ($query) use ($warehouseId) {
                $query->where('store_house_id', $warehouseId);
            });
        }

        // فلترة حسب الحالة
        if ($status) {
            if ($status == 1) {
                $productsQuery->where('status', 'متاح');
            } elseif ($status == 2) {
                $productsQuery->where('status', 'مخزون منخفض');
            } elseif ($status == 3) {
                $productsQuery->where('status', 'مخزون نفد');
            } elseif ($status == 4) {
                $productsQuery->where('status', 'غير نشط');
            }
        }

        // جلب المنتجات بعد التصفية
        $products = $productsQuery->with(['category', 'product_details'])->get();

        // حساب القيم المطلوبة لكل منتج
        $products->each(function ($product) {
            // حساب الكمية الإجمالية من جميع المستودعات
            $product->total_quantity = $product->product_details->sum('quantity');

            // حساب الإجمالي
            $product->total_value = $product->total_quantity * $product->sale_price;
        });

        // تمرير البيانات إلى الواجهة
        return view('reports.inventory.stock_report.inventory_blance', compact(
            'products', 'categories', 'brands', 'warehouses'
        ));
    }

    public function trialBalance(Request $request)
    {
        // جلب جميع الفلترات من الطلب
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $productId = $request->input('product');
        $categoryId = $request->input('category');
        $warehouseId = $request->input('warehouse');

        // جلب البيانات الأساسية للفلترات
        $products = Product::all();
        $categories = Category::all();
        $warehouses = StoreHouse::all();

        // بناء الاستعلام لجلب المنتجات بناءً على الفلترات
        $productsQuery = Product::query();

        // فلترة حسب المنتج
        if ($productId) {
            $productsQuery->where('id', $productId);
        }

        // فلترة حسب التصنيف
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        // فلترة حسب المستودع
        if ($warehouseId) {
            $productsQuery->whereHas('product_details', function ($query) use ($warehouseId) {
                $query->where('store_house_id', $warehouseId);
            });
        }

        // جلب المنتجات بعد التصفية
        $products = $productsQuery->with(['category', 'product_details', 'invoice_items'])->get();

        // حساب القيم المطلوبة لكل منتج
        $products->each(function ($product) use ($startDate, $endDate) {
            // حساب الكمية والمبالغ قبل الفترة
            $product->initial_quantity = $product->product_details->sum('quantity');
            $product->initial_amount = $product->initial_quantity * $product->purchase_price;

            // حساب الوارد (المشتريات)
            $product->incoming_quantity = $product->invoice_items
                ->where('type', 'purchase')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('quantity');
            $product->incoming_amount = $product->invoice_items
                ->where('type', 'purchase')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total');

            // حساب المنصرف (المبيعات)
            $product->outgoing_quantity = $product->invoice_items
                ->where('type', 'sale')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('quantity');
            $product->outgoing_amount = $product->invoice_items
                ->where('type', 'sale')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total');

            // حساب الكمية والمبالغ الصافية
            $product->net_quantity = $product->initial_quantity + $product->incoming_quantity - $product->outgoing_quantity;
            $product->net_amount = $product->initial_amount + $product->incoming_amount - $product->outgoing_amount;
        });

        // تمرير البيانات إلى الواجهة
        return view('reports.inventory.stock_report.trial_balance', compact(
            'products', 'categories', 'warehouses', 'startDate', 'endDate'
        ));
    }

    public function Inventory_mov_det_product(Request $request)
    {
        // جلب جميع الفلترات من الطلب
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $productId = $request->input('product');
        $categoryId = $request->input('category');
        $sourceType = $request->input('source_type');
        $brand = $request->input('brand');
        $currency = $request->input('currency');
        $warehouseId = $request->input('warehouse');

        // جلب البيانات الأساسية للفلترات
        $products = Product::all();
        $categories = Category::all();
        $brands = Product::distinct('brand')->pluck('brand');
        $warehouses = StoreHouse::all();

        // بناء الاستعلام لجلب تفاصيل حركة المخزون
        $movementsQuery = InvoiceItem::query();

        // فلترة حسب المنتج
        if ($productId) {
            $movementsQuery->where('product_id', $productId);
        }

        // فلترة حسب التصنيف
        if ($categoryId) {
            $movementsQuery->whereHas('product', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        // فلترة حسب المصدر
        if ($sourceType) {
            $movementsQuery->where('type', $sourceType);
        }

        // فلترة حسب العلامة التجارية
        if ($brand) {
            $movementsQuery->whereHas('product', function ($query) use ($brand) {
                $query->where('brand', $brand);
            });
        }

        // فلترة حسب العملة (إذا كانت العملة مدعومة في البيانات)
        if ($currency) {
            // يمكنك إضافة فلترة العملة هنا إذا كانت موجودة في البيانات
        }

        // فلترة حسب المستودع
        if ($warehouseId) {
            $movementsQuery->where('store_house_id', $warehouseId);
        }

        // فلترة حسب الفترة الزمنية
        if ($startDate && $endDate) {
            $movementsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // جلب تفاصيل الحركة بعد التصفية
        $movements = $movementsQuery->with(['product', 'storeHouse'])->get();

        // تمرير البيانات إلى الواجهة
        return view('reports.inventory.stock_report.Inventory_mov_det_product', compact(
            'products', 'categories', 'brands', 'warehouses', 'movements', 'startDate', 'endDate'
        ));
    }
public function disbursingInventory(Request $request){
return view('reports.inventory.stock_report.disbursing_inventory');
}
}
