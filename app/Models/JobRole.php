<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    use HasFactory;
    protected $table = 'job_roles';
    protected $guarded = [];

    public static $job_roles = [
        'sales_add_invoices',
        'sales_add_own_invoices',
        'Issue_an_invoice_to_a_customer_who_has_a_debt',
        'Edit_Client',
        'Delete_Client',
        'sales_edit_delete_all_invoices',
        'sales_edit_delete_own_invoices',
        'sales_view_own_invoices',
        'sales_view_all_invoices',
        'sales_create_tax_report',
        'sales_change_seller',
        'sales_invoice_all_products',
        'sales_view_invoice_profit',
        'sales_add_credit_notice_all',
        'sales_add_credit_notice_own',
        'sales_edit_invoice_date',
        'sales_add_payments_all',
        'sales_add_payments_own',
        'sales_edit_payment_options',
        'sales_edit_delete_all_payments',
        'sales_edit_delete_own_payments',
        'sales_add_quote_all',
        'sales_add_quote_own',
        'sales_view_all_quotes',
        'sales_view_own_quotes',
        'sales_edit_delete_all_quotes',
        'sales_edit_delete_own_quotes',
        'sales_view_all_sales_orders',
        'sales_view_own_sales_orders',
        'sales_add_sales_order_all',
        'sales_add_sales_order_own',
        'sales_edit_delete_all_sales_orders',
        'sales_edit_delete_own_sales_orders',
        'sales_edit_delete_all_credit_notices',
        'sales_edit_delete_own_credit_notices',
        'sales_view_all_credit_notices',
        'sales_view_own_credit_notices',
        'points_sale_edit_product_prices',
        'points_sale_add_discount',
        'points_sale_open_sessions_all',
        'points_sale_open_sessions_own',
        'points_sale_close_sessions_all',
        'points_sale_close_sessions_own',
        'points_sale_view_all_sessions',
        'points_sale_view_own_sessions',
        'points_sale_confirm_close_sessions_all',
        'points_sale_confirm_close_sessions_own',
        'customer_loyalty_points_managing_customer_bases',
        'customer_loyalty_points_redeem_loyalty_points',
        'targeted_sales_commissions_manage_sales_periods',
        'targeted_sales_commissions_view_all_sales_commissions',
        'targeted_sales_commissions_view_own_sales_commissions',
        'targeted_sales_commissions_manage_commission_rules',
        'products_add_product',
        'products_view_all_products',
        'products_view_own_products',
        'products_edit_delete_all_products',
        'products_edit_delete_own_products',
        'products_view_price_groups',
        'products_add_edit_price_groups',
        'products_delete_price_groups',
        'sending_invoices_to_the_tax_authority',
        'management_of_insurance_agents',
        'client_follow_up_add_notes_attachments_appointments_all',
        'client_follow_up_add_notes_attachments_appointments_own',
        'client_follow_up_edit_delete_notes_attachments_appointments_all',
        'client_follow_up_edit_delete_notes_attachments_appointments_own',
        'client_follow_up_view_notes_attachments_appointments_all',
        'client_follow_up_view_notes_attachments_appointments_assigned',
        'client_follow_up_view_notes_attachments_appointments_own',
        'client_follow_up_assign_clients_to_employees',
        'clients_add_client',
        'clients_view_all_clients',
        'clients_view_own_clients',
        'clients_edit_delete_all_clients',
        'clients_edit_delete_own_clients',
        'clients_view_all_activity_logs',
        'clients_view_own_activity_log',
        'clients_edit_client_settings',
        'clients_view_all_reports',
        'clients_view_own_reports',
        'points_credits_packages_manage',
        'points_credits_credit_recharge_manage',
        'points_credits_credit_usage_manage',
        'points_credits_credit_settings_manage',
        'membership_management',
        'membership_setting_management',
        'customer_attendance_display',
        'customer_attendance_manage',
        'employees_add',
        'employees_edit_delete',
        'employees_roles_add',
        'employees_roles_edit',
        'employees_view_profile',
        'hr_system_management',
        'salaries_loans_manage',
        'salaries_payroll_view',
        'salaries_payroll_create',
        'salaries_payroll_approve',
        'salaries_payroll_edit',
        'salaries_payroll_delete',
        'salaries_contracts_notifications',
        'salaries_contracts_view_own',
        'salaries_contracts_edit_delete_own',
        'salaries_payroll_settings_manage',
        'salaries_payroll_view_own',
        'salaries_payroll_delete_all',
        'salaries_payroll_payment',
        'salaries_contracts_receive_notifications',
        'salaries_contracts_view_all',
        'salaries_contracts_edit_delete_all',
        'salaries_contracts_create',
        'staff_attendance_online',
        'staff_attendance_pull_from_device',
        'staff_attendance_view_all',
        'staff_attendance_settings_manage',
        'staff_attendance_delete',
        'staff_attendance_edit_days',
        'staff_attendance_view_own',
        'staff_attendance_change_status',
        'staff_attendance_report_view',
        'staff_leave_requests_edit_delete_own',
        'staff_leave_requests_view_own',
        'staff_leave_requests_approve_reject',
        'staff_attendance_self_registration',
        'staff_attendance_import',
        'staff_attendance_view_own_records',
        'staff_inventory_permissions_manage',
        'staff_attendance_calculate_days',
        'staff_attendance_create_book',
        'staff_attendance_view_other_books',
        'staff_attendance_delete_books',
        'staff_leave_requests_add',
        'staff_leave_requests_edit_delete_all',
        'staff_leave_requests_view_all',
        'orders_management',
        'orders_setting_management',
        'inv_manage_inventory_permission_add',
        'inv_manage_inventory_permission_view',
        'inv_manage_inventory_permission_edit',
        'inv_manage_inventory_price_edit',
        'inv_manage_inventory_view_price',
        'inv_manage_purchase_invoices_view_own',
        'inv_manage_purchase_invoice_add',
        'inv_manage_purchase_invoice_edit_delete_own',
        'inv_manage_purchase_invoice_edit_delete_all',
        'inv_manage_purchase_invoices_view_all',
        'inv_manage_suppliers_add',
        'inv_manage_suppliers_view_all',
        'inv_manage_suppliers_edit_delete_all',
        'inv_manage_suppliers_edit_delete_own',
        'inv_manage_suppliers_view_created',
        'inv_manage_inventory_edit_quantity',
        'inv_manage_inventory_transfer',
        'inv_manage_allow_sale_below_min_price',
        'inv_manage_inventory_monitor',
        'purchase_cycle_orders_manage',
        'purchase_cycle_quotes_manage',
        'purchase_cycle_quotes_to_orders',
        'purchase_cycle_order_to_invoice',
        'purchase_cycle_orders_approve_reject',
        'purchase_cycle_quotes_approve_reject',
        'purchase_cycle_orders_manage_orders',
        'supply_orders_view_all',
        'supply_orders_add',
        'supply_orders_edit_delete_all',
        'supply_orders_edit_delete_own',
        'supply_orders_update_status',
        'supply_orders_view_own',
        'track_time_add_employee_work_hours',
        'track_time_edit_other_employees_work_hours',
        'track_time_view_other_employees_work_hours',
        'track_time_edit_delete_all_projects',
        'track_time_add_new_project',
        'track_time_edit_delete_all_activities',
        'track_time_add_new_activity',
        'rental_unit_view_booking_orders',
        'rental_unit_manage_booking_orders',
        'rental_unit_manage_rental_settings',
        'g_a_d_r_add_new_assets',
        'g_a_d_r_view_cost_centers',
        'g_a_d_r_manage_cost_centers',
        'g_a_d_r_manage_closed_periods',
        'g_a_d_r_view_closed_periods',
        'g_a_d_r_manage_journal_entries',
        'g_a_d_r_view_all_journal_entries',
        'g_a_d_r_view_own_journal_entries',
        'g_a_d_r_add_edit_delete_all_journal_entries',
        'g_a_d_r_add_edit_delete_own_journal_entries',
        'g_a_d_r_add_edit_delete_draft_journal_entries',
        'finance_add_expense',
        'finance_edit_delete_all_expenses',
        'finance_edit_delete_own_expenses',
        'finance_view_all_expenses',
        'finance_view_own_expenses',
        'finance_add_edit_delete_draft_expenses',
        'finance_edit_default_cashbox',
        'finance_view_own_cashboxes',
        'finance_add_revenue',
        'finance_edit_delete_all_receipts',
        'finance_edit_delete_own_receipts',
        'finance_view_all_receipts',
        'finance_view_own_receipts',
        'finance_add_edit_delete_draft_revenue',
        'finance_add_revenue_expense_category',
        'check_cycle_add_checkbook',
        'check_cycle_view_checkbook',
        'check_cycle_edit_delete_checkbook',
        'check_cycle_manage_received_checks',
        'settings_edit_general_settings',
        'settings_edit_tax_settings',
        'settings_view_own_reports',
        'online_store_content_management',
        'employee_staffmark_own_attendance_online',
        'employee_staffview_own_attendance_books',
        'employee_staffedit_delete_own_leave_requests',
        'employee_staffview_own_attendance_logs',
        'employee_staffadd_leave_request',
        'employee_staffview_own_leave_requests',
        'employee_view_his_salary_slip',
        'employee_orders_management',
        'work_cycle',
        'templates',
        'branches',
    ];
}
