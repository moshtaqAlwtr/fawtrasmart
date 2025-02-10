<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartOfAccount;

class SalesAccountsSeeder extends Seeder
{
    public function run()
    {
        // حساب العملاء
        ChartOfAccount::create([
            'name' => 'حساب العملاء',
            'code' => '1200',
            'type' => 'asset',
            'operation' => 'sales_customers',
            'normal_balance' => 'debit',
            'level' => 1
        ]);

        // حساب المبيعات
        ChartOfAccount::create([
            'name' => 'المبيعات',
            'code' => '4100',
            'type' => 'revenue',
            'operation' => 'sales',
            'normal_balance' => 'credit',
            'level' => 1
        ]);

        // حساب ضريبة المبيعات
        ChartOfAccount::create([
            'name' => 'ضريبة المبيعات',
            'code' => '2200',
            'type' => 'liability',
            'operation' => 'sales_tax',
            'normal_balance' => 'credit',
            'level' => 1
        ]);
    }
}
