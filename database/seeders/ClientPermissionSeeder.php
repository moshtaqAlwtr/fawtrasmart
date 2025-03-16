<?php

namespace Database\Seeders;

use App\Models\ClientPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'key' => 'activate_client_registration',
                'name' => 'تفعيل تسجيل العميل',
                'is_active' => true,
            ],
            [
                'key' => 'view_client_profile',
                'name' => 'مشاهدة ملفه الشخصي',
                'is_active' => true,
            ],
            [
                'key' => 'edit_client_profile',
                'name' => 'تعديل ملفه الشخصي',
                'is_active' => true,
            ],
            [
                'key' => 'view_shared_notes_attachments',
                'name' => 'مشاهدة الملحوظات والمرفقات المشتركة',
                'is_active' => true,
            ],
            [
                'key' => 'view_and_pay_invoices',
                'name' => 'مشاهدة ودفع الفواتير',
                'is_active' => true,
            ],
            [
                'key' => 'view_and_approve_quotes',
                'name' => 'مشاهدة والموافقة على عروض الأسعار',
                'is_active' => true,
            ],
            [
                'key' => 'view_work_orders',
                'name' => 'عرض أوامر الشغل',
                'is_active' => true,
            ],
            [
                'key' => 'view_appointments',
                'name' => 'عرض المواعيد',
                'is_active' => true,
            ],
        ];

        foreach ($permissions as $permission) {
            ClientPermission::create($permission);
        }
    }
}
