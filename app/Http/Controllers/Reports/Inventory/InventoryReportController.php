<?php

namespace App\Http\Controllers\Reports\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    // عرض الصفحة الرئيسية لتقارير المخزون
    public function index()
    {
        return view('reports.inventory.index');
    }

    // تقرير ورقة الجرد
    public function inventoryCount()
    {
        return view('reports.inventory.inventoryCount');
    }

    // تقرير ملخص عمليات المخزون
    public function inventorySummary()
    {
        return view('reports.inventory.inventorySummary');
    }

    // تقرير الحركة التفصيلية للمخزون
    public function inventoryMovement()
    {
        return view('reports.inventory.inventoryMovement');
    }

    // تقرير قيمة المخزون
    public function inventoryValue()
    {
        return view('reports.inventory.inventoryValue');
    }

    // تقرير ملخص رصيد المخازن
    public function inventoryBalanceSummary()
    {
        return view('reports.inventory.inventoryBalanceSummary');
    }

    // تقرير ميزان مراجعة منتجات
    public function productTrialBalance()
    {
        return view('reports.inventory.productTrialBalance');
    }

    // تقرير تفاصيل حركات المخزون لكل منتج
    public function productMovementDetails()
    {
        return view('reports.inventory.productMovementDetails');
    }

    // تقرير تتبع المنتجات برقم الشحنة و تاريخ الانتهاء
    public function trackProductsByBatchAndExpiry()
    {
        return view('reports.inventory.trackProductsByBatchAndExpiry');
    }

    // تقرير تتبع المنتجات بالرقم المتسلسل
    public function trackProductsBySerialNumber()
    {
        return view('reports.inventory.trackProductsBySerialNumber');
    }

    // تقرير تتبع المنتجات برقم الشحنة
    public function trackProductsByBatch()
    {
        return view('reports.inventory.trackProductsByBatch');
    }

    // تقرير تتبع المنتجات باستخدام تاريخ الانتهاء
    public function trackProductsByExpiry()
    {
        return view('reports.inventory.trackProductsByExpiry');
    }
}
