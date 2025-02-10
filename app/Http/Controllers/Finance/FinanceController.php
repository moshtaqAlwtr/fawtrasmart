<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        return view("finance.index");
    }

    public function create(Request $request)
    {
        return view("finance.create");
    }
    public function treasuries_bank_accounts(Request $request)
    {
        return view("finance.treasuries_bank_accounts");
    }
    public function actions_page(Request $request)
    {
        return view("finance.actions_page");
    }
    public function add_treasury(Request $request)
    {
        return view("finance.add_treasury");
    }
    public function add_bank_account(Request $request)
    {
        return view("finance.add_bank_account");
    }
    public function add_receipt(Request $request)
    {
        return view("finance.add_receipt");
    }
    public function settings(Request $request)
    {
        return view("finance.settings");
    }
    public function receipt_voucher_categories(Request $request)
    {
        return view("finance.receipt_voucher_categories");
    }
    public function expense_categories(Request $request)
    {
        return view("finance.expense_categories");

    }
    public function employee_safes(Request $request)
    {
        return view("finance.employee_safes");
    }
}
