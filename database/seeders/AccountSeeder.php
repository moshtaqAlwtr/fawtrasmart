<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الحسابات الرئيسية
        $assets = $this->createMainAccount('الأصول', '1', 'debit');
        $liabilities = $this->createMainAccount('الخصوم', '2', 'credit');
        $equity = $this->createMainAccount('رأس المال وحقوق الملكية', '3', 'credit');
        $revenues = $this->createMainAccount('الإيرادات', '4', 'credit');
        $expenses = $this->createMainAccount('المصروفات', '5', 'debit');

        // إضافة الحسابات الفرعية للأصول
        $fixedAssets = $this->createSubAccount($assets->id, 'الأصول الثابتة');
        $currentAssets = $this->createSubAccount($assets->id, 'الأصول المتداولة');

        // إضافة حسابات فرعية تحت "الأصول الثابتة"
        $this->createSubAccount($fixedAssets->id, 'أثاث');
        $this->createSubAccount($fixedAssets->id, 'الأجهزة والمعدات');
        $this->createSubAccount($fixedAssets->id, 'وسائل النقل');
        $this->createSubAccount($fixedAssets->id, 'مباني');
        $this->createSubAccount($fixedAssets->id, 'أراضي');

        // إضافة حسابات فرعية تحت "الأصول المتداولة"
        $treasury = $this->createSubAccount($currentAssets->id, 'الخزينة');
        $this->createSubAccount($treasury->id, 'الخزينة الرئيسية');

        // إنشاء حساب البنك وحساباته الفرعية
        $this->createSubAccount($currentAssets->id, 'البنك');
        // إنشاء حساب المخزون وحساباته الفرعية
        $this->createSubAccount($currentAssets->id, 'المخزون');

        // إنشاء حساب المدينون وحساباته الفرعية
        $debtors = $this->createSubAccount($currentAssets->id, 'المدينون');

        // إنشاء حساب العملاء وحساباته الفرعية
        $customers = $this->createSubAccount($debtors->id, 'العملاء');
        $this->createSubAccount($customers->id, 'POS Client');

        // باقي حسابات المدينون
        $this->createSubAccount($debtors->id, 'اطراف مدينية اخرى');
        // إنشاء حساب عهد الموظفين وحساباته الفرعية
        $this->createSubAccount($currentAssets->id, 'عهد الموظفين');
        // إنشاء حساب أوراق القبض وحساباته الفرعية
        $this->createSubAccount($currentAssets->id, 'أوراق القبض');
        // إنشاء حساب عجز وزيادة الصندوق وحساباته الفرعية
        $this->createSubAccount($currentAssets->id, 'عجز و زيادة الصندوق');
        $this->createSubAccount($currentAssets->id, 'تغيير عملة');
        $this->createSubAccount($currentAssets->id, 'المشتريات');

        // إضافة الحسابات الفرعية للخصوم
        $longTermLiabilities = $this->createSubAccount($liabilities->id, 'الخصوم المتدوالة ');
        $shortTermLiabilities = $this->createSubAccount($liabilities->id, 'الخصوم طويلة الامد');

        // إضافة حسابات فرعية تحت "الخصوم المتدوالة "
        $creditors = $this->createSubAccount($longTermLiabilities->id, 'الدائنون');
        $this->createSubAccount($creditors->id, 'الموردون');
        $companyCreditors = $this->createSubAccount($creditors->id, 'شركات الشحن');
        $this->createSubAccount($companyCreditors->id, 'شحن مبيعات');
        $this->createSubAccount($creditors->id, 'شحن مبيعات');
        $this->createSubAccount($creditors->id, 'أطراف دائنة أخرى');

        // باقي الحسابات
        $this->createSubAccount($longTermLiabilities->id, 'اوراق الدفع');
        $this->createSubAccount($longTermLiabilities->id, 'مجمع الاهلاك');
        $RequiredAddedValue = $this->createSubAccount($longTermLiabilities->id, 'القيمة المضافة المطلوبة');
        $this->createSubAccount($RequiredAddedValue->id, 'القيمة المضافة المحصلة');
        $this->createSubAccount($longTermLiabilities->id, 'أرصدة افتتاحية');

        // إضافة حسابات فرعية تحت "الخصوم طويلة الامد"
        $this->createSubAccount($shortTermLiabilities->id, 'الموردين');
        $this->createSubAccount($shortTermLiabilities->id, 'الذمم الدائنة');

        // إضافة الحسابات الفرعية لرأس المال وحقوق الملكية
        $this->createSubAccount($equity->id, 'رأس المال');
        $this->createSubAccount($equity->id, 'الأرباح و خسائر مرحلة ');

        // إضافة الحسابات الفرعية للإيرادات
        $salesRevenue = $this->createSubAccount($revenues->id, 'إيرادات المبيعات');
        $this->createSubAccount($salesRevenue->id, 'المبيعات');
        $this->createSubAccount($salesRevenue->id, 'مردودات المبيعات');

        // إنشاء حساب الإيرادات الأخرى وحساباته الفرعية
        $otherRevenue = $this->createSubAccount($revenues->id, 'إيرادات أخرى');
        $this->createSubAccount($otherRevenue->id, 'إيرادات أخرى');
        $this->createSubAccount($otherRevenue->id, 'أرباح وخسائر رأسمالية');

        // إضافة الحسابات الفرعية للمصروفات
        $salesCost = $this->createSubAccount($expenses->id, 'تكلفة المبيعات');
        $this->createSubAccount($salesCost->id, 'تكلفة المبيعات');
        $this->createSubAccount($salesCost->id, 'شحن مشتريات');
        $this->createSubAccount($salesCost->id, 'خصم مسموح به');

        // إنشاء حساب المصروفات الإدارية والعمومية وحساباته الفرعية
        $adminExpenses = $this->createSubAccount($expenses->id, 'مصروفات ادارية وعمومية');
        $this->createSubAccount($adminExpenses->id, 'إيجار');
        $this->createSubAccount($adminExpenses->id, 'كهرباء');
        $this->createSubAccount($adminExpenses->id, 'هاتف وانترنت');
        $this->createSubAccount($adminExpenses->id, 'صيانة');
        $this->createSubAccount($adminExpenses->id, 'مياه');
        $this->createSubAccount($adminExpenses->id, 'مصاريف حكومية');

        // حساب مصروفات الاهلاك
        $this->createSubAccount($expenses->id, 'مصروفات الاهلاك');

        $otherExpenses = $this->createSubAccount($expenses->id, 'مصروفات اخرى');
        $this->createSubAccount($otherExpenses->id, 'مصروفات أخرى');
        $this->createSubAccount($otherExpenses->id, 'الديون المعدومة');
        $this->createSubAccount($otherExpenses->id, 'عجز وزيادة المخزون');
        $this->createSubAccount($otherExpenses->id, 'إعادة تقييم');
    }

    /**
     * إنشاء حساب رئيسي.
     *
     * @param string $name
     * @param string $code
     * @param string $balanceType
     * @return Account
     */
    private function createMainAccount(string $name, string $code, string $balanceType): Account
    {
        return Account::create([
            'name' => $name,
            'code' => $code,
            'type' => 'main',
            'balance_type' => $balanceType,
            'balance' => 0.0,
            'is_active' => true,
        ]);
    }

    /**
     * إنشاء حساب فرعي تلقائيًا.
     *
     * @param int $parentId
     * @param string $name
     * @return Account
     */
    private function createSubAccount(int $parentId, string $name): Account
    {
        $parentAccount = Account::findOrFail($parentId);
        $lastChild = Account::where('parent_id', $parentId)->orderBy('code', 'desc')->first();

        // توليد الكود التالي
        $newCode = $lastChild ? $this->generateNextCode($lastChild->code) : $parentAccount->code . '1';

        // إنشاء الحساب الفرعي
        return Account::create([
            'name' => $name,
            'code' => $newCode,
            'type' => 'sub',
            'parent_id' => $parentId,
            'balance_type' => $parentAccount->balance_type,
            'balance' => 0.0,
            'is_active' => true,
        ]);
    }

    /**
     * توليد الكود التالي للحساب الفرعي.
     *
     * @param string $lastChildCode
     * @return string
     */
    private function generateNextCode(string $lastChildCode): string
    {
        // استخراج الرقم الأخير من الكود
        $lastNumber = intval(substr($lastChildCode, -1));
        // زيادة الرقم الأخير بمقدار 1
        $newNumber = $lastNumber + 1;
        // إعادة بناء الكود مع الرقم الجديد
        return substr($lastChildCode, 0, -1) . $newNumber;
    }
}
