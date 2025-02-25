<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\PurchaseInvoice;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchasesReportController extends Controller
{
    public function index()
    {
        return view('reports.purchases.index');
    }
    public function bySupplier(Request $request)
    {
        // Get base data for dropdowns
        $suppliers = Supplier::all();
        $branches = Branch::all();

        // Default date range
        $fromDate = $request->input('from_date', now()->startOfMonth());
        $toDate = $request->input('to_date', now()->endOfMonth());

        // Determine report period
        $reportPeriod = $request->input('report_period', 'monthly');

        // Build the purchase invoice query with relationships
        $query = PurchaseInvoice::with(['supplier', 'creator', 'branch']);

        // Apply date filtering based on report period
        switch ($reportPeriod) {
            case 'daily':
                $fromDate = now()->startOfDay();
                $toDate = now()->endOfDay();
                break;
            case 'weekly':
                $fromDate = now()->startOfWeek();
                $toDate = now()->endOfWeek();
                break;
            case 'monthly':
                $fromDate = now()->startOfMonth();
                $toDate = now()->endOfMonth();
                break;
            case 'yearly':
                $fromDate = now()->startOfYear();
                $toDate = now()->endOfYear();
                break;
        }

        // Apply additional filters
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }

        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case '1': // Paid
                    $query->where('is_paid', 1);
                    break;
                case '0': // Unpaid
                    $query->where('is_paid', 0);
                    break;
                case '5': // Returned
                    $query->where('type', 'return');
                    break;
            }
        }

        // Apply date range filter
        $query->whereBetween('date', [$fromDate, $toDate]);

        // Get results
        $purchaseInvoices = $query->get();

        // Group purchase invoices by supplier
        $groupedPurchaseInvoices = $purchaseInvoices->groupBy('supplier_id');

        // Calculate totals
        $totals = [
            'paid_amount' => $purchaseInvoices->sum(function ($invoice) {
                return $invoice->is_paid == 1 ? $invoice->grand_total : $invoice->paid_amount;
            }),
            'unpaid_amount' => $purchaseInvoices->sum(function ($invoice) {
                return $invoice->is_paid == 0 ? $invoice->due_value : 0;
            }),
            'returned_amount' => $purchaseInvoices->sum(function ($invoice) {
                return $invoice->type == 'return' ? $invoice->grand_total : 0;
            }),
            'total_amount' => $purchaseInvoices->sum('grand_total'),
        ];

        // Prepare chart data
        $chartData = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($groupedPurchaseInvoices as $supplierId => $supplierInvoices) {
            $supplier = $supplierInvoices->first()->supplier;
            $chartData['labels'][] = $supplier->trade_name ?? 'مورد ' . $supplierId;
            $chartData['values'][] = $supplierInvoices->sum('grand_total');
        }

        return view('reports.purchases.purchaseReport.Purchase_By_Supplier', compact('groupedPurchaseInvoices', 'suppliers', 'branches', 'totals', 'chartData', 'fromDate', 'toDate', 'reportPeriod'));
    }
}
