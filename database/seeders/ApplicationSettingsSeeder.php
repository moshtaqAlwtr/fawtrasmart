<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\ApplicationSetting;

class ApplicationSettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['name' => 'المبيعات', 'key' => 'sales'],
            ['name' => 'نقاط البيع', 'key' => 'pos'],
            ['name' => 'المبيعات المستهدفة و العمولات', 'key' => 'target_sales_commissions'],
            ['name' => 'إدارة الاقساط', 'key' => 'installments_management'],
            ['name' => 'العروض', 'key' => 'offers'],
            ['name' => 'التأمينات', 'key' => 'insurance'],
            ['name' => 'نقاط ولاء العملاء', 'key' => 'customer_loyalty_points'],
            ['name' => 'إدارة المخزون', 'key' => 'inventory_management'],
            ['name' => 'التصنيع', 'key' => 'manufacturing'],
            ['name' => 'دورة المشتريات', 'key' => 'purchase_cycle'],
            ['name' => 'المالية', 'key' => 'finance'],
            ['name' => 'الحسابات العامه & القيود اليومية', 'key' => 'general_accounts_journal_entries'],
            ['name' => 'دورة الشيكات', 'key' => 'cheque_cycle'],
            ['name' => 'أوامر الشغل', 'key' => 'work_orders'],
            ['name' => 'إدارة الإيجارات والوحدات', 'key' => 'rental_management'],
            ['name' => 'إدارة الحجوزات', 'key' => 'booking_management'],
            ['name' => 'تتبع الوقت', 'key' => 'time_tracking'],
            ['name' => 'دورة العمل', 'key' => 'workflow'],
            ['name' => 'العملاء', 'key' => 'customers'],
            ['name' => 'متابعة العميل', 'key' => 'customer_followup'],
            ['name' => 'النقاط و الأرصدة', 'key' => 'points_balances'],
            ['name' => 'العضوية', 'key' => 'membership'],
            ['name' => 'حضور العملاء', 'key' => 'customer_attendance'],
            ['name' => 'الموظفين', 'key' => 'employees'],
            ['name' => 'الهيكل التنظيمي', 'key' => 'organizational_structure'],
            ['name' => 'حضور الموظفين', 'key' => 'employee_attendance'],
            ['name' => 'المرتبات', 'key' => 'salaries'],
            ['name' => 'الطلبات', 'key' => 'orders'],
            ['name' => 'SMS', 'key' => 'sms'],
            ['name' => 'المتجر الإلكترونى', 'key' => 'ecommerce'],
            ['name' => 'الفروع', 'key' => 'branches'],
        ];

        foreach ($settings as $setting) {
            ApplicationSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
