<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->tinyInteger('role_type');
            # المبيعات sales
            $table->tinyInteger('sales_add_invoices')->default(0); // إضافة فواتير لكل العملاء
            $table->tinyInteger('sales_add_own_invoices')->default(0); // إضافة فواتير للعملاء الخاصة به
            $table->tinyInteger('sales_edit_delete_all_invoices')->default(0); // تعديل وحذف كل الفواتير
            $table->tinyInteger('sales_edit_delete_own_invoices')->default(0); // تعديل وحذف الفواتير الخاصة به
            $table->tinyInteger('sales_view_own_invoices')->default(0); // عرض الفواتير الخاصة به
            $table->tinyInteger('sales_view_all_invoices')->default(0); // عرض جميع الفواتير
            $table->tinyInteger('sales_create_tax_report')->default(0); // إنشاء تقرير ضرائب
            $table->tinyInteger('sales_change_seller')->default(0); // تغيير البائع
            $table->tinyInteger('sales_invoice_all_products')->default(0); // فوترة جميع المنتجات
            $table->tinyInteger('sales_view_invoice_profit')->default(0); // عرض ربح الفاتورة
            $table->tinyInteger('sales_add_credit_notice_all')->default(0); // إضافة إشعار مدين جديد لجميع العملاء
            $table->tinyInteger('sales_add_credit_notice_own')->default(0); // إضافة إشعار مدين جديد لعملائه فقط
            $table->tinyInteger('sales_edit_invoice_date')->default(0); // تعديل تاريخ الفاتورة
            $table->tinyInteger('sales_add_payments_all')->default(0); // إضافة عمليات دفع لكل الفواتير
            $table->tinyInteger('sales_add_payments_own')->default(0); // إضافة عمليات دفع للفواتير الخاصة به
            $table->tinyInteger('sales_edit_payment_options')->default(0); // تعديل خيارات الدفع
            $table->tinyInteger('sales_edit_delete_all_payments')->default(0); // حذف وتعديل جميع المدفوعات
            $table->tinyInteger('sales_edit_delete_own_payments')->default(0); // حذف وتعديل المدفوعات الخاصة به
            $table->tinyInteger('sales_add_quote_all')->default(0); // إضافة عرض سعر لكل العملاء
            $table->tinyInteger('sales_add_quote_own')->default(0); // إضافة عرض سعر للعملاء الخاصة به
            $table->tinyInteger('sales_view_all_quotes')->default(0); // عرض جميع عروض الأسعار
            $table->tinyInteger('sales_view_own_quotes')->default(0); // عرض عروض الأسعار الخاصة به
            $table->tinyInteger('sales_edit_delete_all_quotes')->default(0); // تعديل وحذف جميع عروض الأسعار
            $table->tinyInteger('sales_edit_delete_own_quotes')->default(0); // تعديل وحذف عروض الأسعار الخاصة به
            $table->tinyInteger('sales_view_all_sales_orders')->default(0); // عرض جميع أوامر البيع
            $table->tinyInteger('sales_view_own_sales_orders')->default(0); // عرض أوامر البيع الخاصة به
            $table->tinyInteger('sales_add_sales_order_all')->default(0); // إضافة أمر بيع جديد لجميع العملاء
            $table->tinyInteger('sales_add_sales_order_own')->default(0); // إضافة أمر بيع جديد لعملائه فقط
            $table->tinyInteger('sales_edit_delete_all_sales_orders')->default(0); // تعديل وحذف جميع أوامر البيع
            $table->tinyInteger('sales_edit_delete_own_sales_orders')->default(0); // تعديل وحذف أوامر البيع الخاصة به فقط
            $table->tinyInteger('sales_edit_delete_all_credit_notices')->default(0); // تعديل وحذف جميع الإشعارات المدينة
            $table->tinyInteger('sales_edit_delete_own_credit_notices')->default(0); // تعديل وحذف الإشعارات المدينة الخاصة به فقط
            $table->tinyInteger('sales_view_all_credit_notices')->default(0); // عرض جميع الإشعارات المدينة
            $table->tinyInteger('sales_view_own_credit_notices')->default(0); // عرض الإشعارات المدينة الخاصة به فقط
            # نقاط البيع points_sale
            $table->tinyInteger('points_sale_edit_product_prices')->default(0); // تعديل أسعار المنتجات
            $table->tinyInteger('points_sale_add_discount')->default(0); // إضافة خصم
            $table->tinyInteger('points_sale_open_sessions_all')->default(0); // فتح جلسات لجميع المستخدمين
            $table->tinyInteger('points_sale_open_sessions_own')->default(0); // فتح جلسات لنفسه
            $table->tinyInteger('points_sale_close_sessions_all')->default(0); // إغلاق جلسات جميع المستخدمين
            $table->tinyInteger('points_sale_close_sessions_own')->default(0); // إغلاق الجلسات الخاصة
            $table->tinyInteger('points_sale_view_all_sessions')->default(0); // عرض جميع الجلسات
            $table->tinyInteger('points_sale_view_own_sessions')->default(0); // عرض الجلسات الخاصة به فقط
            $table->tinyInteger('points_sale_confirm_close_sessions_all')->default(0); // تأكيد إغلاق جميع الجلسات
            $table->tinyInteger('points_sale_confirm_close_sessions_own')->default(0); // تأكيد إغلاق الجلسات الخاصة به
            # نقاط ولاء العملاء customer_loyalty_points
            $table->tinyInteger('customer_loyalty_points_managing_customer_bases')->default(0); // أدارة قواعد العملاء
            $table->tinyInteger('customer_loyalty_points_redeem_loyalty_points')->default(0); // صرف نقاط الولاء
            # المبيعات المستهدفة والعمولات targeted_sales_commissions
            $table->tinyInteger('targeted_sales_commissions_manage_sales_periods')->default(0); // إدارة فترات المبيعات
            $table->tinyInteger('targeted_sales_commissions_view_all_sales_commissions')->default(0); // عرض جميع عمولات المبيعات
            $table->tinyInteger('targeted_sales_commissions_view_own_sales_commissions')->default(0); // عرض عمولات المبيعات الخاصة به
            $table->tinyInteger('targeted_sales_commissions_manage_commission_rules')->default(0); // إدارة قواعد العمولة
            # المنتجات products
            $table->tinyInteger('products_add_product')->default(0); // إضافة منتج
            $table->tinyInteger('products_view_all_products')->default(0); // عرض كل المنتجات
            $table->tinyInteger('products_view_own_products')->default(0); // عرض المنتجات الخاصة به
            $table->tinyInteger('products_edit_delete_all_products')->default(0); // تعديل وحذف كل المنتجات
            $table->tinyInteger('products_edit_delete_own_products')->default(0); // تعديل وحذف المنتجات الخاصة به
            $table->tinyInteger('products_view_price_groups')->default(0); // عرض مجموعة الأسعار
            $table->tinyInteger('products_add_edit_price_groups')->default(0); // إضافة وتعديل مجموعة أسعار
            $table->tinyInteger('products_delete_price_groups')->default(0); // حذف مجموعة أسعار
            # الفاتورة الألكترونية السعودية Saudi electronic invoice
            $table->tinyInteger('sending_invoices_to_the_tax_authority')->default(0); // أرسال الفواتير ألى هيئة الضرائب
            # التأمينات insurances
            $table->tinyInteger('management_of_insurance_agents')->default(0); // أدارة وكلاء التأمين
            # متابعه العميل client_follow_up
            $table->tinyInteger('client_follow_up_add_notes_attachments_appointments_all')->default(0); // إضافة ملاحظات / مرفقات / مواعيد لجميع العملاء
            $table->tinyInteger('client_follow_up_add_notes_attachments_appointments_own')->default(0); // إضافة ملاحظات / مرفقات / مواعيد لعملائه المعينين
            $table->tinyInteger('client_follow_up_edit_delete_notes_attachments_appointments_all')->default(0); // تعديل وحذف جميع الملاحظات / المرفقات / المواعيد لجميع العملاء
            $table->tinyInteger('client_follow_up_edit_delete_notes_attachments_appointments_own')->default(0); // تعديل وحذف ملاحظاته / مرفقاته / مواعيده الخاصة
            $table->tinyInteger('client_follow_up_view_notes_attachments_appointments_all')->default(0); // عرض جميع الملاحظات / المرفقات / المواعيد لجميع العملاء
            $table->tinyInteger('client_follow_up_view_notes_attachments_appointments_assigned')->default(0); // عرض جميع الملاحظات / المرفقات / المواعيد لعملائه المعينين
            $table->tinyInteger('client_follow_up_view_notes_attachments_appointments_own')->default(0); // عرض كافة ملاحظاته / مرفقاته / مواعيده الخاصة
            $table->tinyInteger('client_follow_up_assign_clients_to_employees')->default(0); // تعيين العملاء إلى الموظفين
            # العملاء clients
            $table->tinyInteger('clients_add_client')->default(0); // إضافة عميل جديد
            $table->tinyInteger('clients_view_all_clients')->default(0); // عرض جميع العملاء
            $table->tinyInteger('clients_view_own_clients')->default(0); // عرض عملائه
            $table->tinyInteger('clients_edit_delete_all_clients')->default(0); // تعديل وحذف جميع العملاء
            $table->tinyInteger('clients_edit_delete_own_clients')->default(0); // تعديل وحذف عملائه
            $table->tinyInteger('clients_view_all_activity_logs')->default(0); // عرض جميع سجلات الأنشطة
            $table->tinyInteger('clients_view_own_activity_log')->default(0); // عرض سجل نشاطه
            $table->tinyInteger('clients_edit_client_settings')->default(0); // تعديل إعدادات العملاء
            $table->tinyInteger('clients_view_all_reports')->default(0); // عرض تقارير كل العملاء
            $table->tinyInteger('clients_view_own_reports')->default(0); // عرض تقارير العملاء الخاصة به
            # النقاط والأرصدة points_credits
            $table->tinyInteger('points_credits_packages_manage')->default(0); // إدارة الباقات
            $table->tinyInteger('points_credits_credit_recharge_manage')->default(0); // إدارة شحن الأرصدة
            $table->tinyInteger('points_credits_credit_usage_manage')->default(0); // إدارة استهلاك الأرصدة
            $table->tinyInteger('points_credits_credit_settings_manage')->default(0); // إدارة إعدادات الأرصدة
            # العضويه membership
            $table->tinyInteger('membership_management')->default(0); // أدارة العضويات
            $table->tinyInteger('membership_setting_management')->default(0); // إدارة إعدادات العضويات
            # حضور العملاء customer attendance
            $table->tinyInteger('customer_attendance_display')->default(0); // عرض حضور العملاء
            $table->tinyInteger('customer_attendance_manage')->default(0); // إدارة حضور العملاء
            # الموظفين employees
            $table->tinyInteger('employees_add')->default(0); // إضافة موظف جديد
            $table->tinyInteger('employees_edit_delete')->default(0); // تعديل وحذف موظف
            $table->tinyInteger('employees_roles_add')->default(0); // إضافة دور وظيفي جديد
            $table->tinyInteger('employees_roles_edit')->default(0); // تعديل الدور الوظيفي
            $table->tinyInteger('employees_view_profile')->default(0); // إظهار الملف الشخصي للموظف
            # الهيكل التنظيمي organizational_structure
            $table->tinyInteger('hr_system_management')->default(0); // أدارة نظام الموارد البشرية
            # المرتبات salaries
            $table->tinyInteger('salaries_loans_manage')->default(0); // إدارة السلفيات والأقساط
            $table->tinyInteger('salaries_payroll_view')->default(0); // عرض مسير الرواتب
            $table->tinyInteger('salaries_payroll_create')->default(0); // إنشاء مسير رواتب
            $table->tinyInteger('salaries_payroll_approve')->default(0); // موافقة قسائم الرواتب
            $table->tinyInteger('salaries_payroll_edit')->default(0); // تعديل قسائم الرواتب
            $table->tinyInteger('salaries_payroll_delete')->default(0); // مسح مدفوعات مسير الرواتب
            $table->tinyInteger('salaries_contracts_notifications')->default(0); // إشعارات العقد
            $table->tinyInteger('salaries_contracts_view_own')->default(0); // عرض عقوده الخاصة
            $table->tinyInteger('salaries_contracts_edit_delete_own')->default(0); // تعديل / مسح العقود الخاصة به
            $table->tinyInteger('salaries_payroll_settings_manage')->default(0); // إدارة إعدادات المرتبات
            $table->tinyInteger('salaries_payroll_view_own')->default(0); // عرض قسيمة الراتب الخاصة به
            $table->tinyInteger('salaries_payroll_delete_all')->default(0); // مسح مسير الرواتب
            $table->tinyInteger('salaries_payroll_payment')->default(0); // دفع قسائم الرواتب
            $table->tinyInteger('salaries_contracts_receive_notifications')->default(0); // استلام إشعارات العقود
            $table->tinyInteger('salaries_contracts_view_all')->default(0); // عرض جميع العقود
            $table->tinyInteger('salaries_contracts_edit_delete_all')->default(0); // تعديل / مسح جميع العقود
            $table->tinyInteger('salaries_contracts_create')->default(0); // إنشاء عقود
            # حضور الموظفين staff attendance
            $table->tinyInteger('staff_attendance_online')->default(0); // تسجيل حضور الموظفين (أونلاين)
            $table->tinyInteger('staff_attendance_pull_from_device')->default(0); // سحب سجل الحضور من الجهاز
            $table->tinyInteger('staff_attendance_view_all')->default(0); // عرض كل سجلات الحضور
            $table->tinyInteger('staff_attendance_settings_manage')->default(0); // إدارة إعدادات الحضور
            $table->tinyInteger('staff_attendance_delete')->default(0); // مسح سجل الحضور
            $table->tinyInteger('staff_attendance_edit_days')->default(0); // تعديل أيام الحضور
            $table->tinyInteger('staff_attendance_view_own')->default(0); // عرض دفاتر الحضور الخاصة به
            $table->tinyInteger('staff_attendance_change_status')->default(0); // تغيير حالة دفاتر الحضور
            $table->tinyInteger('staff_attendance_report_view')->default(0); // عرض تقرير الحضور
            $table->tinyInteger('staff_leave_requests_edit_delete_own')->default(0); // تعديل / حذف طلبات إجازاته فقط
            $table->tinyInteger('staff_leave_requests_view_own')->default(0); // عرض طلبات إجازاته فقط
            $table->tinyInteger('staff_leave_requests_approve_reject')->default(0); // الموافقة على / رفض طلبات الإجازة
            $table->tinyInteger('staff_attendance_self_registration')->default(0); // تسجيل الحضور بنفسه أونلاين
            $table->tinyInteger('staff_attendance_import')->default(0); // استيراد سجل الحضور
            $table->tinyInteger('staff_attendance_view_own_records')->default(0); // عرض كل سجلات الحضور الخاصة به
            $table->tinyInteger('staff_inventory_permissions_manage')->default(0); // إدارة الأذونات المخزنية
            $table->tinyInteger('staff_attendance_calculate_days')->default(0); // حساب أيام الحضور
            $table->tinyInteger('staff_attendance_create_book')->default(0); // إنشاء دفتر حضور
            $table->tinyInteger('staff_attendance_view_other_books')->default(0); // عرض دفاتر الحضور الأخرى
            $table->tinyInteger('staff_attendance_delete_books')->default(0); // مسح دفاتر الحضور
            $table->tinyInteger('staff_leave_requests_add')->default(0); // إضافة طلب إجازة
            $table->tinyInteger('staff_leave_requests_edit_delete_all')->default(0); // تعديل / حذف جميع طلبات الإجازات
            $table->tinyInteger('staff_leave_requests_view_all')->default(0); // عرض جميع طلبات الإجازة
            # الطلبات orders
            $table->tinyInteger('orders_management')->default(0); // أدارة الطلبات
            $table->tinyInteger('orders_setting_management')->default(0); // إدارة إعدادات الطلبات
            # أدارة المخزون inventory_management
            $table->tinyInteger('inv_manage_inventory_permission_add')->default(0); // إضافة إذن مخزني
            $table->tinyInteger('inv_manage_inventory_permission_view')->default(0); // عرض الإذن المخزني
            $table->tinyInteger('inv_manage_inventory_permission_edit')->default(0); // تعديل الإذن المخزني
            $table->tinyInteger('inv_manage_inventory_price_edit')->default(0); // تعديل سعر حركة المخزون
            $table->tinyInteger('inv_manage_inventory_view_price')->default(0); // عرض سعر حركة المخزون
            $table->tinyInteger('inv_manage_purchase_invoices_view_own')->default(0); // عرض فواتير الشراء الخاصة به
            $table->tinyInteger('inv_manage_purchase_invoice_add')->default(0); // إضافة فاتورة شراء جديدة
            $table->tinyInteger('inv_manage_purchase_invoice_edit_delete_own')->default(0); // تعديل أو حذف فواتير الشراء الخاصة به
            $table->tinyInteger('inv_manage_purchase_invoice_edit_delete_all')->default(0); // تعديل أو حذف كل فواتير الشراء
            $table->tinyInteger('inv_manage_purchase_invoices_view_all')->default(0); // عرض كل فواتير الشراء
            $table->tinyInteger('inv_manage_suppliers_add')->default(0); // إضافة موردين جدد
            $table->tinyInteger('inv_manage_suppliers_view_all')->default(0); // عرض كل الموردين
            $table->tinyInteger('inv_manage_suppliers_edit_delete_all')->default(0); // تعديل وحذف كل الموردين
            $table->tinyInteger('inv_manage_suppliers_edit_delete_own')->default(0); // تعديل وحذف الموردين الخاصين به
            $table->tinyInteger('inv_manage_suppliers_view_created')->default(0); // عرض الموردين الذين تم إنشاؤهم
            $table->tinyInteger('inv_manage_inventory_edit_quantity')->default(0); // تعديل عدد المنتجات بالمخزون
            $table->tinyInteger('inv_manage_inventory_transfer')->default(0); // نقل المخزون
            $table->tinyInteger('inv_manage_allow_sale_below_min_price')->default(0); // السماح للبيع بأقل من السعر الأدنى للمنتج
            $table->tinyInteger('inv_manage_inventory_monitor')->default(0); // متابعة المخزون
            # دورة المشتريات procurement_cycle
            $table->tinyInteger('purchase_cycle_orders_manage')->default(0); // إدارة طلبات الشراء
            $table->tinyInteger('purchase_cycle_quotes_manage')->default(0); // إدارة عروض أسعار المشتريات
            $table->tinyInteger('purchase_cycle_quotes_to_orders')->default(0); // تحويل عروض أسعار المشتريات إلى أوامر الشراء
            $table->tinyInteger('purchase_cycle_order_to_invoice')->default(0); // تحويل أمر الشراء إلى فاتورة شراء
            $table->tinyInteger('purchase_cycle_orders_approve_reject')->default(0); // موافقة/رفض طلبات الشراء
            $table->tinyInteger('purchase_cycle_quotes_approve_reject')->default(0); // موافقة/رفض عروض أسعار المشتريات
            $table->tinyInteger('purchase_cycle_orders_manage_orders')->default(0); // إدارة أوامر الشراء
            # أدارة أوامر التوريد supply order management
            $table->tinyInteger('supply_orders_view_all')->default(0); // عرض جميع أوامر التوريد
            $table->tinyInteger('supply_orders_add')->default(0); // إضافة أوامر شغل
            $table->tinyInteger('supply_orders_edit_delete_all')->default(0); // تعديل وحذف جميع أوامر التوريد
            $table->tinyInteger('supply_orders_edit_delete_own')->default(0); // تعديل وحذف أوامر التوريد الخاصة به
            $table->tinyInteger('supply_orders_update_status')->default(0); // تحديث حالة أمر التوريد
            $table->tinyInteger('supply_orders_view_own')->default(0); // عرض أوامر التوريد
            # تتبع الوقت track_time
            $table->tinyInteger('track_time_add_employee_work_hours')->default(0); // إضافة ساعات عمل الموظف
            $table->tinyInteger('track_time_edit_other_employees_work_hours')->default(0); // تعديل ساعات عمل الموظفين الآخرين
            $table->tinyInteger('track_time_view_other_employees_work_hours')->default(0); // عرض ساعات عمل الموظفين الآخرين
            $table->tinyInteger('track_time_edit_delete_all_projects')->default(0); // تعديل وحذف كل المشاريع
            $table->tinyInteger('track_time_add_new_project')->default(0); // إضافة مشروع جديد
            $table->tinyInteger('track_time_edit_delete_all_activities')->default(0); // تعديل وحذف كل الأنشطة
            $table->tinyInteger('track_time_add_new_activity')->default(0); // إضافة نشاط جديد
            # أدارة الأجارات والوحدات Rental and unit management
            $table->tinyInteger('rental_unit_view_booking_orders')->default(0); // عرض أوامر الحجز
            $table->tinyInteger('rental_unit_manage_booking_orders')->default(0); // اداره أوامر الحجز
            $table->tinyInteger('rental_unit_manage_rental_settings')->default(0); // إدارة إعدادات الأيجارات
            # الحسابات العامه & القيود اليومية General accounts & daily restrictions
            $table->tinyInteger('g_a_d_r_add_new_assets')->default(0); // إضافة أصول جديدة
            $table->tinyInteger('g_a_d_r_view_cost_centers')->default(0); // عرض مراكز التكلفة
            $table->tinyInteger('g_a_d_r_manage_cost_centers')->default(0); // إدارة مراكز التكلفة
            $table->tinyInteger('g_a_d_r_manage_closed_periods')->default(0); // إدارة الفترات المقفلة
            $table->tinyInteger('g_a_d_r_view_closed_periods')->default(0); // عرض الفترات المقفلة
            $table->tinyInteger('g_a_d_r_manage_journal_entries')->default(0); // إدارة حسابات القيود
            $table->tinyInteger('g_a_d_r_view_all_journal_entries')->default(0); // عرض جميع القيود
            $table->tinyInteger('g_a_d_r_view_own_journal_entries')->default(0); // عرض القيود الخاصة به
            $table->tinyInteger('g_a_d_r_add_edit_delete_all_journal_entries')->default(0); // إضافة/تعديل/مسح جميع القيود
            $table->tinyInteger('g_a_d_r_add_edit_delete_own_journal_entries')->default(0); // إضافة/تعديل/مسح القيود الخاصة به
            $table->tinyInteger('g_a_d_r_add_edit_delete_draft_journal_entries')->default(0); // إضافة/تعديل/مسح القيود المسودة
            # المالية finance
            $table->tinyInteger('finance_add_expense')->default(0); // إضافة مصروف
            $table->tinyInteger('finance_edit_delete_all_expenses')->default(0); // تعديل وحذف كل المصروفات
            $table->tinyInteger('finance_edit_delete_own_expenses')->default(0); // تعديل وحذف المصروفات الخاصة به
            $table->tinyInteger('finance_view_all_expenses')->default(0); // مشاهدة كل المصروفات
            $table->tinyInteger('finance_view_own_expenses')->default(0); // مشاهدة المصروفات التي أنشأها
            $table->tinyInteger('finance_add_edit_delete_draft_expenses')->default(0); // إضافة/تعديل/مسح مصروفات مسودة
            $table->tinyInteger('finance_edit_default_cashbox')->default(0); // تعديل الخزينة الافتراضية
            $table->tinyInteger('finance_view_own_cashboxes')->default(0); // عرض خزائنه الخاصة
            $table->tinyInteger('finance_add_revenue')->default(0); // إضافة إيراد
            $table->tinyInteger('finance_edit_delete_all_receipts')->default(0); // تعديل وحذف كل سندات القبض
            $table->tinyInteger('finance_edit_delete_own_receipts')->default(0); // تعديل وحذف سندات القبض الخاص به
            $table->tinyInteger('finance_view_all_receipts')->default(0); // عرض كل سندات القبض
            $table->tinyInteger('finance_view_own_receipts')->default(0); // عرض سندات القبض التي أنشأها
            $table->tinyInteger('finance_add_edit_delete_draft_revenue')->default(0); // إضافة/تعديل/مسح إيرادات مسودة
            $table->tinyInteger('finance_add_revenue_expense_category')->default(0); // إضافة تصنيف إيرادات/مصروفات
            # دورة الشيكات check_cycle
            $table->tinyInteger('check_cycle_add_checkbook')->default(0); // إضافة دفتر الشيكات
            $table->tinyInteger('check_cycle_view_checkbook')->default(0); // عرض دفتر الشيكات
            $table->tinyInteger('check_cycle_edit_delete_checkbook')->default(0); // تعديل وحذف دفتر الشيكات
            $table->tinyInteger('check_cycle_manage_received_checks')->default(0); // إدارة الشيكات المستلمة
            # الإعدادات settings
            $table->tinyInteger('settings_edit_general_settings')->default(0); // تعديل الإعدادات العامة
            $table->tinyInteger('settings_edit_tax_settings')->default(0); // تعديل إعدادات الضرائب
            $table->tinyInteger('settings_view_own_reports')->default(0); // عرض تقاريره الخاصة
            # المتجر الألكتروني online store
            $table->tinyInteger('online_store_content_management')->default(0); // أدارة محتوى المتجر الألكتروني
            # حضور الموظفين employee_staff attendance
            $table->tinyInteger('employee_staffmark_own_attendance_online')->default(0); // تسجيل الحضور بنفسه أونلاين
            $table->tinyInteger('employee_staffview_own_attendance_books')->default(0); // عرض دفاتر الحضور الخاصة به
            $table->tinyInteger('employee_staffedit_delete_own_leave_requests')->default(0); // تعديل/حذف طلبات إجازاته فقط
            $table->tinyInteger('employee_staffview_own_attendance_logs')->default(0); // عرض كل سجلات الحضور الخاصة به
            $table->tinyInteger('employee_staffadd_leave_request')->default(0); // إضافة طلب إجازة
            $table->tinyInteger('employee_staffview_own_leave_requests')->default(0); // عرض طلبات إجازاته فقط
            # المرتبات employee_salaries
            $table->tinyInteger('employee_view_his_salary_slip')->default(0); // عرض قسيمة الراتب الخاصة به
            # الطلبات employee_orders
            $table->tinyInteger('employee_orders_management')->default(0); // أدارة الطلبات

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_roles');
    }
};
