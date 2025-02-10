<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class SalesReportsController extends Controller
{
        // تقارير المبيعات
        public function index()
        {
            return view('Reports.sals.index');
        }
    
        public function byCustomer()
        {
            return view('reports.sals.by_Customer');
        }
    
        public function byEmployee()
        {
            return view('reports.sals.by_Employee');
        }
    
        public function byRepresentative()
        {
            return view('reports.sals.by_Representative');
        }
        public function byProduct()
        {
            return view('reports.sals.by_Product');
        }
        public function WeeklybyProduct()
        {
            return view('reports.sals.Weekly_by_Product');
        }
        public function monthlybyProduct() 
        {
            return view('reports.sals.Monthly_by_Product');
        }
        public function AnnualbyProduct()
        {
            return view('reports.sals.Annual_by_Product');
        }
        public function Dsales()
        {
            return view('reports.sals.D_Sales');
        }
        public function Wsales()
        {
            return view('reports.sals.W_Sales');
        }
        public function Msales()
        {
            return view('reports.sals.M_Sales');
        }
        public function Asales()
        {
            return view('reports.sals.A_Sales');
        }
        public Function byCust()
        {
            return view('reports.sals.Payments_by_Customer');
        }
        public Function byembl()
        {
            return view('reports.sals.Payments_by_Employee');
        }
        public Function bypay()
        {
            return view('reports.sals.Payments_by_Payment_Method');
        }
        public Function DailyPayments()
        {
            return view('reports.sals.Daily_Payments');
        }
        public Function WeeklyPayments()
        {
            return view('reports.sals.Weekly_Payments');
        }
        public Function MonthlyPayments()
        {
            return view('reports.sals.Monthly_Payments');
        }
        public Function productsprofit()
        {
            return view('reports.sals.products_profit');
        }
        public Function CustomerProfit()
        {
            return view('reports.sals.Customer_Profit');
        }
        public Function EmployeeProfit()
        {
            return view('reports.sals.Employee_Profit');
        }
        public Function ManagerProfit()
        {
            return view('reports.sals.Manager_Profit');
        }
        public Function DailyProfits()
        {
            return view('reports.sals.Daily_Profits');
        }
        public Function WeeklyProfits()
        {
            return view('reports.sals.Weekly_Profits');
        }
        public Function AnnualProfits()
        {
            return view('reports.sals.Annual_Profits');
        }
        public function ItemSalesByItem()
        {
            return view('reports.sals.Sales_By_Item');
        }
    
        public function ItemSalesByCategory()
        {
            return view('reports.sals.Sales_By_Category');
        }
    
        public function ItemSalesByBrand()
        {
            return view('reports.sals.Sales_By_Brand');
        }
    
        public function ItemSalesByEmployee()
        {
            return view('reports.sals.Sales_By_Employee');
        }
    
        public function ItemSalesBySalesRep()
        {
            return view('reports.sals.Sales_By_SalesRep');
        }
    
        public function ItemSalesByCustomer()
        {
            return view('reports.sals.Sales_By_Customer');
        }
       
}
