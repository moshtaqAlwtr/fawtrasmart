<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSourcesSeeder extends Seeder
{
    public function run()
    {
        DB::table('permission_sources')->insert([
            [  'name' => 'إذن إضافة مخزن',                  'category' => 'إضافة'],
            ['name' => 'إذن صرف مخزن',                    'category' => 'صرف'],
            ['name' => 'أمر تصنيع المنتج الرئيسي',          'category' => 'تصنيع'],
            ['name' => 'أمر تصنيع طلب توريد المواد الهالكة', 'category' => 'تصنيع'],
            ['name' => 'ورقة جرد منصرف',                  'category' => 'جرد'],
            ['name' => 'ورقة جرد وارد',                   'category' => 'جرد'],
            ['name' => 'فاتورة مبيعات',                          'category' => 'مبيعات'],
            ['name' => 'فاتورة مرتجعة',                   'category' => 'مرتجع مبيعات'],
            ['name' => 'إشعار دائن',                      'category' => 'مبيعات'],
            ['name' => 'فاتورة شراء',                     'category' => 'مشتريات'],
            ['name' => 'مرتجع مشتريات',                   'category' => 'مرتجع مشتريات'],
            ['name' => 'اشعار مدين المشتريات',             'category' => 'مشتريات'],
            ['name' => 'تحويل يدوي',                      'category' => 'تحويل'],
            ['name' => 'POS Shift Outbound',               'category' => 'تحويل'],
            ['name' => 'POS Shift Inbound',                'category' => 'تحويل'],
            ['name' => 'أمر تصنيع البنود المرتجعة',         'category' => 'تصنيع'],
            ['name' => 'أمر تصنيع لصرف المواد',             'category' => 'تصنيع'],
        ]);
    }
}
