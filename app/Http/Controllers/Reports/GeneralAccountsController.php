<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PurchaseInvoice;
use Illuminate\Http\Request;

class GeneralAccountsController extends Controller
{
    // دالة لعرض الحسابات العامة
    public function index()
    {

        return view('reports.general_accounts.index'); // يعرض الملف الذي يحتوي على الحسابات العامة
    }
    public function taxReport(Request $request)
    {
        // جلب فواتير المبيعات
        $salesInvoices = Invoice::where('type', 'normal')->get();

        // جلب فواتير المرتجعات
        $returnInvoices = Invoice::where('type', 'returned')->get();

        // جلب فواتير المشتريات
        $purchaseInvoices = PurchaseInvoice::all();

        $taxData = [
            'sales' => $salesInvoices,
            'returns' => $returnInvoices,
            'purchases' => $purchaseInvoices,
        ];

        return view('reports.general_accounts.accountGeneral.tax_report', compact('taxData'));
    }


}
