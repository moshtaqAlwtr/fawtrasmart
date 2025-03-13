<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SerialSetting;

class SerialSettingsSeeder extends Seeder
{
    public function run()
    {
        // قائمة بالأقسام وإعداداتها الافتراضية
        $sections = [
            'invoice' => [
                'name' => 'فاتورة',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'INV-',
                'mode' => 0,
            ],
            'customer' => [
                'name' => 'العميل',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'CUST-',
                'mode' => 0,
            ],
            'quotation' => [
                'name' => 'عروض الأسعار',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'QUOT-',
                'mode' => 0,
            ],
            'return-invoice' => [
                'name' => 'فاتورة مرتجعة',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'RET-',
                'mode' => 0,
            ],
            'credit-note' => [
                'name' => 'إشعار دائن',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'CRN-',
                'mode' => 0,
            ],
            'reservation' => [
                'name' => 'حجز',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'RES-',
                'mode' => 0,
            ],
            'purchase-invoice' => [
                'name' => 'فاتورة شراء',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PUR-',
                'mode' => 0,
            ],
            'purchase-return' => [
                'name' => 'مرتجع مشتريات',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PRET-',
                'mode' => 0,
            ],
            'supply-order' => [
                'name' => 'أمر التوريد',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'SUP-',
                'mode' => 0,
            ],
            'supplier' => [
                'name' => 'المورد',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'SUPP-',
                'mode' => 0,
            ],
            'entry' => [
                'name' => 'قيد',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'ENT-',
                'mode' => 0,
            ],
            'expense' => [
                'name' => 'مصروف',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'EXP-',
                'mode' => 0,
            ],
            'receipt-voucher' => [
                'name' => 'سندات القبض',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'RCV-',
                'mode' => 0,
            ],
            'warehouse-add' => [
                'name' => 'إذن إضافة مخزون',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'WADD-',
                'mode' => 0,
            ],
            'warehouse-dispose' => [
                'name' => 'إذن صرف مخزون',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'WDIS-',
                'mode' => 0,
            ],
            'transfer-request' => [
                'name' => 'طلب تحويل',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'TRANS-',
                'mode' => 0,
            ],
            'branch' => [
                'name' => 'الفروع',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'BRN-',
                'mode' => 0,
            ],
            'inventory-report' => [
                'name' => 'ورقة الجرد',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'INV-REP-',
                'mode' => 0,
            ],
            'products' => [
                'name' => 'المنتجات',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PROD-',
                'mode' => 0,
            ],
            'contracts' => [
                'name' => 'العقود',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'CONT-',
                'mode' => 0,
            ],
            'quotation-request' => [
                'name' => 'طلب عرض أسعار',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'QREQ-',
                'mode' => 0,
            ],
            'purchase-quotation' => [
                'name' => 'عرض سعر مشتريات',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PQUOT-',
                'mode' => 0,
            ],
            'purchase-order' => [
                'name' => 'أمر شراء',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PORD-',
                'mode' => 0,
            ],
            'origin' => [
                'name' => 'أصل',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'ORG-',
                'mode' => 0,
            ],
            'invoice-payment' => [
                'name' => 'مدفوعات الفواتير',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'INV-PAY-',
                'mode' => 0,
            ],
            'payment-return' => [
                'name' => 'دفع مبلغ مرتجع',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PAY-RET-',
                'mode' => 0,
            ],
            'purchase-refund' => [
                'name' => 'دفع فاتورة شراء',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PREF-',
                'mode' => 0,
            ],
            'sales-debit' => [
                'name' => 'إشعار مدين مبيعات',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'SDEB-',
                'mode' => 0,
            ],
            'products-custom' => [
                'name' => 'المنتجات المخصصة',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'CUST-PROD-',
                'mode' => 0,
            ],
            'purchase-refund-payment' => [
                'name' => 'دفع مرتجع المشتريات',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PREF-PAY-',
                'mode' => 0,
            ],
            'sales-debit-notes' => [
                'name' => 'إشعارات مدينة المبيعات',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'SDEB-NOTE-',
                'mode' => 0,
            ],
            'purchase-credit-notes' => [
                'name' => 'إشعارات دائنة المشتريات',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PCRN-NOTE-',
                'mode' => 0,
            ],
            'production-routes' => [
                'name' => 'مسارات الإنتاج',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PROD-ROUTE-',
                'mode' => 0,
            ],
            'workstations' => [
                'name' => 'محطات العمل',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'WORK-',
                'mode' => 0,
            ],
            'production-material-lists' => [
                'name' => 'قوائم مواد الإنتاج',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'MAT-LIST-',
                'mode' => 0,
            ],
            'manufacturing-orders' => [
                'name' => 'أوامر التصنيع',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'MFG-ORD-',
                'mode' => 0,
            ],
            'production-plan' => [
                'name' => 'خطة إنتاج',
                'current_number' => 0,
                'number_of_digits' => 5,
                'prefix' => 'PROD-PLAN-',
                'mode' => 0,
            ],
        ];

        // إضافة الإعدادات الافتراضية إلى قاعدة البيانات
        foreach ($sections as $key => $section) {
            SerialSetting::create([
                'section' => $key,
                'current_number' => $section['current_number'],
                'number_of_digits' => $section['number_of_digits'],
                'prefix' => $section['prefix'],
                'mode' => $section['mode'],
            ]);
        }

        $this->command->info('تم إضافة إعدادات الترقيم المتسلسل بنجاح!');
    }
}

