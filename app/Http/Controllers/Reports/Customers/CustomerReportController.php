<?php

namespace App\Http\Controllers\Reports\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index()
    {
        return view("reports.customers.index");
    }
    // عرض تقرير أعمار الديون (الفواتير)
    public function agingInvoices()
    {
        return view('reports.customers.aging-invoices');
    }

    // عرض تقرير أعمار الديون (حساب الأستاذ)
    public function agingLedger()
    {
        return view('reports.customers.aging-ledger');
    }

    // عرض دليل العملاء
    public function customerDirectory()
    {
        return view('reports.customers.customer-directory');
    }

    // عرض أرصدة العملاء
    public function customerBalances()
    {
        return view('reports.customers.customer-balances');
    }

    // عرض مبيعات العملاء
    public function customerSales()
    {
        return view('reports.customers.customer-sales');
    }

    // عرض مدفوعات العملاء
    public function customerPayments()
    {
        return view('reports.customers.customer-payments');
    }

    // عرض كشف حساب العملاء
    public function customerStatements()
    {
        return view('reports.customers.customer-statements');
    }

    // عرض مواعيد العملاء
    public function customerAppointments()
    {
        return view('reports.customers.customer-appointments');
    }

    // عرض أقساط العملاء
    public function customerInstallments()
    {
        return view('reports.customers.customer-installments');
    }
}
