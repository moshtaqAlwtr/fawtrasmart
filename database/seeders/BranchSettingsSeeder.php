<?php

namespace Database\Seeders;

use App\Models\BranchSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            ['name' => 'مشاركة مركز التكلفة', 'key' => 'share_cost_center'],
            ['name' => 'مشاركة العملاء', 'key' => 'share_customers'],
            ['name' => 'مشاركة المنتجات', 'key' => 'share_products'],
            ['name' => 'مشاركة الموردين', 'key' => 'share_suppliers'],
            ['name' => 'تخصيص الحسابات في شجرة الحسابات', 'key' => 'account_tree']
        ];

        foreach ($permissions as $permission) {
            BranchSetting::firstOrCreate([
                'name' => $permission['name'],
                'key' => $permission['key'],
                'is_active' => 1,
            ]);
        }
    }
}
