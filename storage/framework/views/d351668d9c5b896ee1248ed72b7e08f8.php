<?php
    $getLocal = App::getLocale();
?>

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">فوترة</h2>
                </a>
            </li>

            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                        class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                        data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>

    <div class="shadow-bottom"></div>

    <div class="main-menu-content">

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            
            <li class=" nav-item <?php echo e(request()->is("$getLocal/dashboard/*") ? 'active open' : ''); ?>">
                <a href="index.html"><i class="feather icon-home"></i><span class="menu-title"
                        data-i18n="Dashboard"><?php echo e(trans('main_trans.Dashboards')); ?></span><span
                        class="badge badge badge-warning badge-pill float-right mr-2">2</span></a>
                <ul class="menu-content">
                    <li><a href="<?php echo e(route('dashboard_sales.index')); ?>"><i
                                class="feather icon-circle <?php echo e(request()->is("$getLocal/dashboard/sales/index") ? 'active' : ''); ?>"></i><span
                                class="menu-item" data-i18n="eCommerce"><?php echo e(trans('main_trans.sales')); ?></span></a>
                    </li>
                    <li><a href="dashboard-analytics.html"><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="Analytics"><?php echo e(trans('main_trans.Human_Resources')); ?></span></a>
                    </li>
                </ul>
            </li>

            
            <?php if(auth()->user()->hasAnyPermission([
                        'sales_add_invoices',
                        'sales_add_own_invoices',
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
                    ])): ?>
                <?php
                    // جلب جميع الإعدادات من جدول application_settings
                    $settings = \App\Models\ApplicationSetting::pluck('status', 'key')->toArray();
                ?>

                <?php if(isset($settings['sales']) && $settings['sales'] === 'active'): ?>
                    <li class="nav-item <?php echo e(request()->is("$getLocal/sales/*") ? 'active open' : ''); ?>">
                        <a href="index.html"><i class="feather icon-align-justify">
                            </i><span class="menu-title" data-i18n="Dashboard"><?php echo e(trans('main_trans.sales')); ?></span>
                        </a>
                        <ul class="menu-content">

                                <li><a href="<?php echo e(route('invoices.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/sales/invoices/index") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.invoice_management')); ?></span></a>
                                </li>


                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_add_invoices')): ?>
                                <li><a href="<?php echo e(route('invoices.create')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/sales/invoices/create") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.creaat_invoice')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_view_all_quotes')): ?>
                                <li><a href="<?php echo e(route('questions.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/sales/questions/index") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Quotation_Management')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_add_quote_all')): ?>
                                <li><a href="<?php echo e(route('questions.create')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/sales/questions/create") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Create_quote')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_view_all_credit_notices')): ?>
                                <li><a href="<?php echo e(route('CreditNotes.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/sales/CreditNotes/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Credit_notes')); ?></span></a>
                                </li>
                            <?php endif; ?>


                                <li><a href="<?php echo e(route('ReturnIInvoices.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/sales/invoices/invoices_returned") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Returned_invoices')); ?></span></a>
                                </li>


                                <li><a href="<?php echo e(route('periodic_invoices.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/sales/periodic-invoices/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Periodic_invoices')); ?></span></a>
                                </li>


                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_add_payments_all')): ?>
                                <li><a href="<?php echo e(route('paymentsClient.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/sales/paymentsClient/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Customer_payments')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales_edit_payment_options')): ?>
                                <li><a href="<?php echo e(route('SittingInvoice.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sales_Settings')); ?></span></a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->role != 'employee'): ?>
                            <li><a href="<?php echo e(route('templates.test_print')); ?>"><i class="feather icon-circle"></i><span
                                class="menu-item"
                                data-i18n="eCommerce">اختبار  الطباعة على الفواتير</span></a>
                         </li>
                            <?php endif; ?>
                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>

        
            <li class="nav-item">
                        <a href="#">
                            <i class="feather icon-monitor"></i>
                            <span class="menu-title">اعدادات الاحصائيات</span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <a href="<?php echo e(route('employee_targets.index')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                        data-i18n="Start Sale">اضافة الاهداف للمناديب</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('target.show')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                        data-i18n="Sessions">اضافة الهدف الشهري للمناديب</span>
                                </a>
                            </li>
                             <li>
                                <a href="<?php echo e(route('target.client.create')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                        data-i18n="Sessions">اضافة الهدف  للعملاء</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('target.client')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                        data-i18n="POS Reports">احصائيات وتصنيف العملاء</span>
                                </a>
                            </li>
                           
                        </ul>
                    </li>


            <!-- نقاط  البيع -->
            <?php if(auth()->user()->hasAnyPermission([
                        'points_sale_edit_product_prices',
                        'points_sale_add_discount',
                        'points_sale_open_sessions_all',
                        'points_sale_open_sessions_own',
                        'points_sale_close_sessions_all',
                        'points_sale_close_sessions_own',
                        'points_sale_view_all_sessions',
                        'points_sale_confirm_close_sessions_all',
                        'points_sale_confirm_close_sessions_own',
                        'points_sale_confirm_close_sessions_own',
                    ])): ?>
                
                <?php if(isset($settings['pos']) && $settings['pos'] === 'active'): ?>
                    <li class="nav-item">
                        <a href="#">
                            <i class="feather icon-monitor"></i>
                            <span class="menu-title" data-i18n="POS"><?php echo e(trans('main_trans.Point_of_Sale')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <a href="<?php echo e(route('POS.sales_start.index')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                        data-i18n="Start Sale"><?php echo e(trans('main_trans.Start_Sale')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('pos.sessions.index')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                        data-i18n="Sessions"><?php echo e(trans('main_trans.Sessions')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('pos_reports.index')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                        data-i18n="POS Reports"><?php echo e(trans('main_trans.POS_Reports')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('pos.settings.index')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                        data-i18n="POS Settings"><?php echo e(trans('main_trans.POS_Settings')); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('online_store_content_management')): ?>
                <?php if(isset($settings['ecommerce']) && $settings['ecommerce'] === 'active'): ?>
                    <li class=" nav-item <?php echo e(request()->is("$getLocal/online_store/*") ? 'active open' : ''); ?>"><a
                            href="index.html">
                            <i class="feather icon-shopping-cart">
                            </i><span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Online_store')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <li><a href="<?php echo e(route('content_management.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/online_store/content-management/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Content_management')); ?></span></a>
                            </li>
                            <li><a href="<?php echo e(route('store_settings.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/online_store/store_settings/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('online_store_content_management')): ?>
                <?php if(isset($settings['manufacturing']) && $settings['manufacturing'] === 'active'): ?>
                    <li class="nav-item <?php echo e(request()->is("$getLocal/Manufacturing/*") ? 'active open' : ''); ?>">
                        <a href="index.html">
                            <i class="feather icon-layers"></i>
                            <span class="menu-title" data-i18n="Dashboard"><?php echo e(trans('main_trans.Manufacturing')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <a href="<?php echo e(route('BOM.index')); ?>">
                                    <i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/Manufacturing/BOM/*") ? 'active' : ''); ?>"></i>
                                    <span class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Bill_of_Materials')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('manufacturing.orders.index')); ?>">
                                    <i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/Manufacturing/Orders/*") ? 'active' : ''); ?>"></i>
                                    <span class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Manufacturing_Orders')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('manufacturing.indirectcosts.index')); ?>">
                                    <i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/Manufacturing/indirectcosts/*") ? 'active' : ''); ?>"></i>
                                    <span class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Indirect_Costs')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('manufacturing.workstations.index')); ?>">
                                    <i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/Manufacturing/Workstations/*") ? 'active' : ''); ?>"></i>
                                    <span class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Workstations')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('Manufacturing.settings.index')); ?>">
                                    <i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/Manufacturing/Settings/*") ? 'active' : ''); ?>"></i>
                                    <span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- إدارة الحجوزات -->
            <?php if(auth()->user()->hasAnyPermission([
                        'rental_unit_view_booking_orders',
                        'rental_unit_manage_booking_orders',
                        'rental_unit_manage_rental_settings',
                    ])): ?>
                <?php if(isset($settings['booking_management']) && $settings['booking_management'] === 'active'): ?>
                    <li class="nav-item"><a href="#">
                            <i class="feather icon-bookmark"></i> <!-- أيقونة الحجز -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Reservations')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rental_unit_view_booking_orders')): ?>
                                <li><a href="<?php echo e(route('Reservations.create')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Add_reservation')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rental_unit_manage_booking_orders')): ?>
                                <li><a href="<?php echo e(route('Reservations.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Manage_reservations')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rental_unit_manage_rental_settings')): ?>
                                <li><a href="<?php echo e(route('Reservations.Booking_Settings')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Booking_Settings')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <!-- إدارة الأقساط -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salaries_loans_manage')): ?>
                <?php if(isset($settings['installments_management']) && $settings['installments_management'] === 'active'): ?>
                    <li class="nav-item"><a href="index.html">
                            <i class="feather icon-credit-card"></i> <!-- أيقونة الأقساط -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Installment_Management')); ?></span>
                        </a>
                        <ul class="menu-content">

                            <li><a href="<?php echo e(route('installments.index')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Installment_agreements')); ?></span></a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salaries_loans_manage')): ?>
                                <li><a href="<?php echo e(route('installments.agreement_installments')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Installments')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- إدارة المبيعات المستهدفة والعمولات -->
            <?php if(auth()->user()->hasAnyPermission([
                        'targeted_sales_commissions_manage_commission_rules',
                        'targeted_sales_commissions_view_all_sales_commissions',
                        'targeted_sales_commissions_manage_sales_periods',
                    ])): ?>
                <?php if(isset($settings['target_sales_commissions']) && $settings['target_sales_commissions'] === 'active'): ?>
                    <li class="nav-item"><a href="index.html">
                            <i class="feather icon-pie-chart"></i> <!-- أيقونة المبيعات والعمولات -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Targeted_sales_and_commissions')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('targeted_sales_commissions_manage_commission_rules')): ?>
                                <li><a href="<?php echo e(route('CommissionRules.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Commission_rules')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('targeted_sales_commissions_view_all_sales_commissions')): ?>
                                <li><a href="<?php echo e(route('SalesCommission.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sales_commissions')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('targeted_sales_commissions_manage_sales_periods')): ?>
                                <li><a href="<?php echo e(route('SalesPeriods.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sales_periods')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- إدارة الوحدات والإيجارات -->
            <?php if(Auth::user()->hasAnyPermission([
                    'rental_unit_view_booking_orders',
                    'rental_unit_manage_booking_orders',
                    'rental_unit_manage_rental_settings',
                ])): ?>
                <?php if(isset($settings['rental_management']) && $settings['rental_management'] === 'active'): ?>
                    <li class="nav-item"><a href="index.html">
                            <i class="feather icon-home"></i> <!-- أيقونة الوحدات والإيجارات -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Units_and_Rentals_Management')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rental_unit_view_booking_orders')): ?>
                                <li><a href="<?php echo e(route('rental_management.units.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Units')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rental_unit_manage_booking_orders')): ?>
                                <li><a href="<?php echo e(route('rental_management.orders.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Seizure_orders')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('rental_management.rental_price_rule.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Pricing_rules')); ?></span></a>
                            </li>
                            <li><a href="<?php echo e(route('rental_management.seasonal-prices.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Seasonal_Prices')); ?></span></a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rental_unit_manage_rental_settings')): ?>
                                <li><a href="<?php echo e(route('rental_management.settings.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- أوامر التوريد -->

            <?php if(Auth::user()->hasAnyPermission(['supply_orders_view_all', 'supply_orders_add'])): ?>
                <?php if(isset($settings['work_orders']) && $settings['work_orders'] === 'active'): ?>
                    <li class="nav-item"><a href="<?php echo e(route('SupplyOrders.index')); ?>">
                            <i class="feather icon-truck"></i> <!-- أيقونة أوامر التوريد -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Supply_orders')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supply_orders_view_all')): ?>
                                <li><a href="<?php echo e(route('SupplyOrders.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Supply_orders')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supply_orders_add')): ?>
                                <li><a href="<?php echo e(route('SupplyOrders.create')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Add_a_job_order')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('SupplySittings.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Supply_Orders_Settings')); ?></span></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>



            <?php if(auth()->user()->hasAnyPermission(['work_cycle'])): ?>
                <!-- دورات العمل -->
                <?php if(isset($settings['workflow']) && $settings['workflow'] === 'active'): ?>
                    <li class="nav-item"><a href="">
                            <i class="feather icon-refresh-ccw"></i> <!-- أيقونة دورات العمل -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Business_cycles')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Sittings')); ?></span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <!-- العملاء -->
            <?php if(auth()->user()->hasAnyPermission([
                        'clients_view_all_clients',
                        'client_follow_up_add_notes_attachments_appointments_all',
                        'clients_edit_client_settings',
                    ])): ?>
                <?php if(isset($settings['customers']) && $settings['customers'] === 'active'): ?>
                    <li class="nav-item">
                        <a href="#">
                            <i class="feather icon-user"></i> <!-- أيقونة العملاء -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Customers')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('clients_view_all_clients')): ?>
                                <li><a href="<?php echo e(route('clients.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Customer_management')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('clients_add_client')): ?>
                                <li><a href="<?php echo e(route('clients.create')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Add_a_new_customer')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client_follow_up_add_notes_attachments_appointments_all')): ?>
                                <li><a href="<?php echo e(route('appointments.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Appointments')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('clients.contacts')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Contact_list')); ?></span>
                                </a>
                            </li>

                            <li><a href="<?php echo e(route('clients.mang_client')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Customer_relationship_management')); ?></span>
                                </a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('clients_edit_client_settings')): ?>
                                <li><a href="<?php echo e(route('clients.setting')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Client_settings')); ?></span>
                                    </a>
                                </li>
                                 

                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- نقاط الارصدة -->
            <?php if(auth()->user()->hasAnyPermission([
                        'points_credits_credit_recharge_manage',
                        'points_credits_credit_usage_manage',
                        'points_credits_packages_manage',
                        'points_credits_transactions_manage',
                    ])): ?>
                <?php if(isset($settings['points_balances']) && $settings['points_balances'] === 'active'): ?>
                    <li class="nav-item">
                        <a href="#">
                            <i class="feather icon-layers"></i> <!-- أيقونة نقاط الارصدة -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Points_and_credits')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('points_credits_credit_recharge_manage')): ?>
                                <li><a href="<?php echo e(route('MangRechargeBalances.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Managing_balance_transfers')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('points_credits_credit_usage_manage')): ?>
                                <li><a href="<?php echo e(route('ManagingBalanceConsumption.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Managing_consumption_balances')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('points_credits_packages_manage')): ?>
                                <li><a href="<?php echo e(route('PackageManagement.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Package_management')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('points_credits_credit_settings_manage')): ?>
                                <li><a href="<?php echo e(route('sitting.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- نقاط الولاء -->
            <?php if(auth()->user()->hasAnyPermission([
                        'customer_loyalty_points_managing_customer_bases',
                        'customer_loyalty_points_redeem_loyalty_points',
                    ])): ?>
                <?php if(isset($settings['customer_loyalty_points']) && $settings['customer_loyalty_points'] === 'active'): ?>
                    <li class="nav-item">
                        <a href="#">
                            <i class="feather icon-layers"></i> <!-- أيقونة نقاط الولاء -->
                            <span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Loyalty_points')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_loyalty_points_managing_customer_bases')): ?>
                                <li><a href="<?php echo e(route('loyalty_points.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Customer_loyalty_rules')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_loyalty_points_redeem_loyalty_points')): ?>
                                <li><a href="<?php echo e(route('sittingLoyalty.sitting')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>









            
            <?php if(auth()->user()->hasAnyPermission(['membership_management', 'membership_setting_management'])): ?>
                <?php if(isset($settings['membership']) && $settings['membership'] === 'active'): ?>
                    <li class="nav-item">
                        <a href="index.html">
                            <i class="feather icon-users"></i>
                            <span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Memberships')); ?>

                            </span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('membership_management')): ?>
                                <li>
                                    <a href="<?php echo e(route('Memberships.index')); ?>">
                                        <i class="feather icon-circle"></i>
                                        <span class="menu-item" data-i18n="Analytics">
                                            <?php echo e(trans('main_trans.Membership_management')); ?>

                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>


                            <li>
                                <a href="<?php echo e(route('Memberships.subscriptions')); ?>">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item" data-i18n="eCommerce">
                                        <?php echo e(trans('main_trans.Subscription_management')); ?>

                                    </span>
                                </a>


                                


                                

                                

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('membership_setting_management')): ?>
                                <li>
                                    <a href="<?php echo e(route('SittingMemberships.index')); ?>">
                                        <i class="feather icon-circle"></i>
                                        <span class="menu-item" data-i18n="eCommerce">
                                            <?php echo e(trans('main_trans.Sittings')); ?>

                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_attendance_display')): ?>
                <?php if(isset($settings['customer_attendance']) && $settings['customer_attendance'] === 'active'): ?>
                    <li class=" nav-item"><a href="index.html">
                            <i class="feather icon-user-check">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Customer_attendance')); ?></span>

                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_attendance_display')): ?>
                                <li><a href="<?php echo e(route('customer_attendance.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Customer_attendance_records')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(Auth::user()->hasAnyPermission(['management_of_insurance_agents'])): ?>
                
                <?php if(isset($settings['insurance']) && $settings['insurance'] === 'active'): ?>
                    <li class=" nav-item"><a href="index.html">
                            <i class="feather icon-users">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Insurance_Agents')); ?></span>

                        </a>
                        <ul class="menu-content">
                            <li><a href="<?php echo e(route('Insurance_Agents.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Insurance_Agents_Management')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('Insurance_Agents.create')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Add_Insurance_Company')); ?></span></a>
                            </li>
                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(Auth::user()->hasAnyPermission([
                    'products_add_product',
                    'products_view_all_products',
                    'products_view_own_products',
                    'products_edit_delete_all_products',
                    'products_edit_delete_own_products',
                    'products_view_price_groups',
                    'products_add_edit_price_groups',
                    'products_delete_price_groups',
                ])): ?>
                <?php if(isset($settings['inventory_management']) && $settings['inventory_management'] === 'active'): ?>
                    <li class=" nav-item <?php echo e(request()->is("$getLocal/stock/*") ? 'active open' : ''); ?>"><a
                            href="">
                            <i class="feather icon-box">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Stock')); ?></span>

                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_view_all_products')): ?>
                                <li><a href="<?php echo e(route('products.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/stock/products/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item" data-i18n="Analytics">
                                            <?php echo e(trans('main_trans.products_management')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inv_manage_inventory_permission_view')): ?>
                                <li><a href="<?php echo e(route('store_permits_management.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/stock/store_permits_management/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Store_permissions_management')); ?></span></a>
                                </li>
                            <?php endif; ?>


                            <li><a href="<?php echo e(route('products.traking')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.product_tracking')); ?></span></a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_view_price_groups')): ?>
                                <li><a href="<?php echo e(route('price_list.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/stock/price_list/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.price_lists')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            
                            <li><a href="<?php echo e(route('storehouse.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/stock/storehouse/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.warehouses')); ?></span></a>
                            </li>
                            

                            <li><a href="<?php echo e(route('inventory_management.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/stock/inventory_management/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.inventory_Management')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('inventory_settings.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/stock/inventory_settings/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.inventory_settings')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('product_settings.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/stock/product_settings/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item" data-i18n="eCommerce">
                                        <?php echo e(trans('main_trans.products_Settings')); ?></span></a>
                            </li>

                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(auth()->user()->hasAnyPermission(['purchase_cycle_orders_manage_orders'])): ?>
                <?php if(isset($settings['purchase_cycle']) && $settings['purchase_cycle'] === 'active'): ?>
                    <li class=" nav-item"><a href="index.html">
                            <i class="fa fa-shopping-cart">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Purchases')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase_cycle_orders_manage_orders')): ?>
                                <li><a href="<?php echo e(route('OrdersPurchases.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Analytics"> <?php echo e(trans('main_trans.Purchase_Orders')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('Quotations.index')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Quotation_Requests')); ?>


                                    </span></a>
                            </li>

                            <li><a href="<?php echo e(route('pricesPurchase.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce">
                                        <?php echo e(trans('main_trans.Purchase_Quotations')); ?></span></a>
                            </li>
                            <li><a href="<?php echo e(route('OrdersRequests.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce">أوامر الشراء</span></a>
                            </li>
                            <li><a href="<?php echo e(route('invoicePurchases.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Purchase_Invoices')); ?>

                                    </span></a>
                            </li>
                            <li><a href="<?php echo e(route('ReturnsInvoice.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Purchase_Returns')); ?></span></a>
                            </li>
                            <li><a href="<?php echo e(route('CityNotices.index')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item" data-i18n="eCommerce">
                                        <?php echo e(trans('main_trans.Creditor_notices')); ?></span></a>
                            </li>
                            <li><a href="<?php echo e(route('SupplierManagement.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"> <?php echo e(trans('main_trans.Supplier_Management')); ?>

                                    </span></a>
                            </li>
                            <li><a href="<?php echo e(route('PaymentSupplier.indexPurchase')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce">
                                        <?php echo e(trans('main_trans.Supplier_Payments')); ?>


                                    </span></a>
                            </li>
                            <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce">
                                        <?php echo e(trans('main_trans.Purchase_Invoices_Settings')); ?></span></a>
                            </li>
                            <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce">
                                        <?php echo e(trans('main_trans.Supplier_Settings')); ?></span></a>

                            </li>
                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if(auth()->user()->hasAnyPermission(['track_time_view_other_employees_work_hours'])): ?>
                <?php if(isset($settings['time_tracking']) && $settings['time_tracking'] === 'active'): ?>
                    <li class=" nav-item"><a href="index.html">
                            <i class="feather icon-watch">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Time_Tracking')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <li><a href="<?php echo e(route('TrackTime.index')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Time_Tracking')); ?></span></a>
                            </li>
                            <li><a href="<?php echo e(route('TrackTime.create_invoice_time')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Create_Invoice')); ?></span></a>
                            </li>

                            <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Time_Tracking_Settings')); ?></span></a>
                            </li>
                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(auth()->user()->hasAnyPermission([
                        'finance_view_all_expenses',
                        'finance_view_all_receipts',
                        'finance_view_own_cashboxes',
                        'finance_edit_default_cashbox',
                    ])): ?>
                <?php if(isset($settings['finance']) && $settings['finance'] === 'active'): ?>
                    <li class=" nav-item <?php echo e(request()->is("$getLocal/finance/*") ? 'active open' : ''); ?>">
                        <a href="index.html">
                            <i class="feather icon-dollar-sign">
                            </i><span class="menu-title"
                                data-i18n="Dashboard"><?php echo e(trans('main_trans.Financial')); ?></span>
                        </a>

                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('finance_view_all_expenses')): ?>
                                <li><a href="<?php echo e(route('expenses.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/finance/expenses/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Expenses')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('finance_view_all_receipts')): ?>
                                <li><a href="<?php echo e(route('incomes.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/finance/incomes/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Receipts')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('finance_view_own_cashboxes')): ?>
                                <li><a href="<?php echo e(route('treasury.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item" data-i18n="eCommerce">
                                            <?php echo e(trans('main_trans.Cash_and_Bank_Accounts')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('finance_edit_default_cashbox')): ?>
                                <li><a href="<?php echo e(route('finance_settings.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/finance/finance_settings/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Financial_Settings')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if(auth()->user()->hasAnyPermission([
                        'g_a_d_r_view_all_journal_entries',
                        'g_a_d_r_add_edit_delete_all_journal_entries',
                        'g_a_d_r_manage_journal_entries',
                        'g_a_d_r_view_cost_centers',
                        'g_a_d_r_add_new_assets',
                    ])): ?>
                <?php if(isset($settings['general_accounts_journal_entries']) && $settings['general_accounts_journal_entries'] === 'active'): ?>
                    <li class=" nav-item <?php echo e(request()->is("$getLocal/Accounts/*") ? 'active open' : ''); ?>"><a
                            href="index.html">
                            <i class="feather icon-pie-chart">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.General_Accounts')); ?></span>
                        </a>

                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('g_a_d_r_view_all_journal_entries')): ?>
                                <li><a href="<?php echo e(route('journal.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Journal_Entries')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('g_a_d_r_add_edit_delete_all_journal_entries')): ?>
                                <li><a href="<?php echo e(route('journal.create')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Add_Entry')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('g_a_d_r_manage_journal_entries')): ?>
                                <li><a href="<?php echo e(route('accounts_chart.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/Accounts/accounts_chart/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item" data-i18n="eCommerce">
                                            <?php echo e(trans('main_trans.Chart_of_Accounts')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('g_a_d_r_view_cost_centers')): ?>
                                <li><a href="<?php echo e(route('cost_centers.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/Accounts/cost_centers/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Cost_Centers')); ?></span></a>
                                </li>
                                 <li><a href=""><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/finance/expenses/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics">حساب الاستاذ</span></a>
                                </li>

                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('g_a_d_r_add_new_assets')): ?>
                                <li><a href="<?php echo e(route('Assets.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item" data-i18n="eCommerce">
                                            <?php echo e(trans('main_trans.Assets')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('accounts_settings.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.General_Accounts_Settings')); ?></span></a>
                            </li>
                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if(auth()->user()->hasAnyPermission(['check_cycle_view_checkbook', 'check_cycle_manage_received_checks'])): ?>
                <?php if(isset($settings['cheque_cycle']) && $settings['cheque_cycle'] === 'active'): ?>
                    <li class=" nav-item <?php echo e(request()->is("$getLocal/cheques*") ? 'active open' : ''); ?>"><a
                            href="index.html">
                            <i class="feather icon-dollar-sign">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Cheques_Cycle')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('check_cycle_view_checkbook')): ?>
                                <li><a href="<?php echo e(route('payable_cheques.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/cheques/payable_cheques*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Paid_Cheques')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('check_cycle_manage_received_checks')): ?>
                                <li><a href="<?php echo e(route('received_cheques.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/cheques/received_cheques*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Received_Cheques')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if(auth()->user()->hasAnyPermission(['orders_management', 'orders_setting_management'])): ?>
                <?php if(isset($settings['orders']) && $settings['orders'] === 'active'): ?>
                    <li class=" nav-item"><a href="index.html">
                            <i class="feather icon-briefcase">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Orders')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders_management')): ?>
                                <li><a href="<?php echo e(route('orders.management.mangame')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Order_Management')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders_setting_management')): ?>
                                <li><a href="<?php echo e(route('orders.Settings.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if(auth()->user()->hasAnyPermission(['employees_view_profile', 'employees_roles_add'])): ?>
                <?php if(isset($settings['employees']) && $settings['employees'] === 'active'): ?>
                    <li class=" nav-item <?php echo e(request()->is("$getLocal/hr/*") ? 'active open' : ''); ?>">
                        <a href="index.html">
                            <i class="fa fa-users"></i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Employees')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employees_view_profile')): ?>
                                <li><a href="<?php echo e(route('employee.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/hr/employee/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Employee_Management')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employees_roles_add')): ?>
                                <li><a href="<?php echo e(route('managing_employee_roles.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/hr/managing_employee_roles/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Employee_Roles_Management')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('shift_management.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/hr/shift_management/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Shift_Management')); ?></span></a>
                            </li>

                            <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span></a>
                            </li>
                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hr_system_management')): ?>
                <?php if(isset($settings['organizational_structure']) && $settings['organizational_structure'] === 'active'): ?>
                    <li
                        class=" nav-item <?php echo e(request()->is("$getLocal/OrganizationalStructure/*") ? 'active open' : ''); ?>">
                        <a href="index.html">
                            <i class="feather icon-layers">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Organizational_Structure')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <li><a href="<?php echo e(route('JobTitles.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/OrganizationalStructure/JobTitles/*") ? 'active open' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Job_Titles_Management')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('department.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/OrganizationalStructure/department/*") ? 'active open' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Departments_Management')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('ManagingFunctionalLevels.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/OrganizationalStructure/ManagingFunctionalLevels/*") ? 'active open' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Job_Levels_Management')); ?></span></a>
                            </li>
                            <li><a href="<?php echo e(route('ManagingJobTypes.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/OrganizationalStructure/ManagingJobTypes/*") ? 'active open' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Job_Types_Management')); ?></span></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if(auth()->user()->hasAnyPermission([
                        'staff_attendance_view_all',
                        'staff_attendance_edit_days',
                        'staff_attendance_view_other_books',
                        'staff_attendance_import',
                        'staff_attendance_settings_manage',
                    ])): ?>
                <?php if(isset($settings['employee_attendance']) && $settings['employee_attendance'] === 'active'): ?>
                    <li class="nav-item <?php echo e(request()->is("$getLocal/presence/*") ? 'active open' : ''); ?>"><a
                            href="index.html">

                            <i class="feather icon-user-check">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Attendance')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff_attendance_view_all')): ?>
                                <li><a href="<?php echo e(route('attendance_records.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/presence/attendance-records/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item" data-i18n="Analytics">
                                            <?php echo e(trans('main_trans.Attendance_Records')); ?></span></a>

                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff_attendance_edit_days')): ?>
                                <li><a href="<?php echo e(route('attendanceDays.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/presence/attendanceDays/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Attendance_Days')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff_attendance_view_other_books')): ?>
                                <li><a href="<?php echo e(route('attendance_sheets.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/presence/attendance-sheets/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Attendance_Books')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('leave_permissions.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/presence/leave-permissions/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Leave_Permissions')); ?></span></a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff_leave_requests_view_all')): ?>
                                <li><a href="<?php echo e(route('attendance.leave_requests.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Leave_Requests')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('shift_management.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/presence/shift_management/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Shift_Management')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('custom_shifts.index')); ?>"><i
                                        class="feather icon-circle <?php echo e(request()->is("$getLocal/presence/custom-shifts/*") ? 'active' : ''); ?>"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Custom_Shifts')); ?></span></a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff_attendance_import')): ?>
                                <li><a href="<?php echo e(route('Attendance.attendance-sessions-record.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Attendance_Sessions_Log')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff_attendance_settings_manage')): ?>
                                <li><a href="<?php echo e(route('attendance.settings.index')); ?>"><i
                                            class="feather icon-circle <?php echo e(request()->is("$getLocal/presence/settings/*") ? 'active' : ''); ?>"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if(auth()->user()->hasAnyPermission([
                        'salaries_contracts_view_all',
                        'salaries_payroll_view',
                        'salaries_payroll_approve',
                        'salaries_payroll_settings_manage',
                        'salaries_loans_manage',
                    ])): ?>
                <?php if(isset($settings['salaries']) && $settings['salaries'] === 'active'): ?>
                    <li class=" nav-item"><a href="index.html">
                            <i class="feather icon-dollar-sign">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Salaries')); ?></span>
                        </a>
                        <ul class="menu-content">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salaries_contracts_view_all')): ?>
                                <li><a href="<?php echo e(route('Contracts.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="Analytics"><?php echo e(trans('main_trans.Contracts')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salaries_payroll_view')): ?>
                                <li><a href="<?php echo e(route('PayrollProcess.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Payroll')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salaries_payroll_approve')): ?>
                                <li><a href="<?php echo e(route('salarySlip.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item" data-i18n="eCommerce">
                                            <?php echo e(trans('main_trans.Salary_Slips')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salaries_loans_manage')): ?>
                                <li><a href="<?php echo e(route('ancestor.index')); ?>"><i class="feather icon-circle"></i><span
                                            class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Advances')); ?></span></a>
                                </li>
                            <?php endif; ?>

                            <li><a href="<?php echo e(route('SalaryItems.index')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Salary_Items')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('SalaryTemplates.index')); ?>"><i
                                        class="feather icon-circle"></i><span class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Salary_Templates')); ?></span></a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('salaries_payroll_settings_manage')): ?>
                                <li><a href="<?php echo e(route('SalarySittings.index')); ?>"><i
                                            class="feather icon-circle"></i><span class="menu-item"
                                            data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            
            <li class=" nav-item"><a href="index.html">
                    <i class="feather icon-file-text">
                    </i><span class="menu-title" data-i18n="Dashboard">
                        <?php echo e(trans('main_trans.Reports')); ?></span>

                </a>
                <ul class="menu-content">
                    <li><a href="<?php echo e(route('salesReports.index')); ?>"><i class="feather icon-circle"></i><span
                                class="menu-item" data-i18n="Analytics">
                                <?php echo e(trans('main_trans.Sales_Report')); ?></span></a>
                    </li>

                    <li><a href="<?php echo e(route('ReportsPurchases.index')); ?>"><i class="feather icon-circle"></i><span
                                class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Purchases_Report')); ?></span></a>
                    </li>
                    <li><a href="<?php echo e(route('GeneralAccountReports.index')); ?>"><i
                                class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.General_Accounts_Report')); ?></span></a>
                    </li>

                    <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Cheques_Report')); ?></span></a></li>

                    <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.SMS_Report')); ?></span></a>
                    </li>

                    <li><a href="<?php echo e(route('ClientReport.BalancesClient')); ?>"><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Points_and_Balances_Report')); ?></span></a>
                    </li>

                    <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Employees_Report')); ?></span></a></li>

                    <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Attendance_Report')); ?></span></a></li>

                    <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Achievements_Report')); ?></span></a></li>

                    <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Work_Cycle_Report')); ?></span></a></li>

                    <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Supply_Orders_Report')); ?></span></a></li>

                    <li><a href="<?php echo e(route('ClientReport.index')); ?>"><i class="feather icon-circle"></i><span
                                class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Customers_Report')); ?></span></a></li>

                    <li><a href="<?php echo e(route('StorHouseReport.index')); ?>"><i class="feather icon-circle"></i><span
                                class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Stock_Report')); ?></span></a></li>

                    <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Units_Tracking_Report')); ?></span></a></li>

                    <li><a href="<?php echo e(route('logs.index')); ?>"><i class="feather icon-circle"></i><span
                                class="menu-item"
                                data-i18n="eCommerce"><?php echo e(trans('main_trans.Account_Activity_Log')); ?></span></a></li>


                </ul>

            </li>


            <?php if(auth()->user()->hasAnyPermission(['branches'])): ?>
                

                <?php if(isset($settings['branches']) && $settings['branches'] === 'active'): ?>
                    <li class=" nav-item"><a href="index.html">
                            <i class="feather  icon-briefcase">
                            </i><span class="menu-title" data-i18n="Dashboard">
                                <?php echo e(trans('main_trans.Branches')); ?></span>

                        </a>
                        <ul class="menu-content">
                            <li><a href="<?php echo e(route('branches.index')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="Analytics"><?php echo e(trans('main_trans.Branch_Management')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('branches.create')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Add_Branch')); ?></span></a>
                            </li>

                            <li><a href="<?php echo e(route('branches.settings')); ?>"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.Sittings')); ?></span></a>
                            </li>


                        </ul>

                    </li>
                <?php endif; ?>
            <?php endif; ?>


            <?php if(auth()->user()->hasAnyPermission(['templates'])): ?>
                
                <li class=" nav-item"><a href="index.html">
                        <i class="feather icon-dollar-sign">
                        </i><span class="menu-title" data-i18n="Dashboard">
                            <?php echo e(trans('main_trans.Templates')); ?></span>

                    </a>
                    <ul class="menu-content">
                        <li><a href="dashboard-analytics.html"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="Analytics"><?php echo e(trans('main_trans.Print_Templates')); ?></span></a>
                        </li>

                        <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Ready_Invoice_Templates')); ?></span></a>
                        </li>
                        <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Emails')); ?></span></a>
                        </li>
                        <?php if(isset($settings['sms']) && $settings['sms'] === 'active'): ?>
                            <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span
                                        class="menu-item"
                                        data-i18n="eCommerce"><?php echo e(trans('main_trans.SMS_Models')); ?></span></a>
                            </li>
                        <?php endif; ?>
                        <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Terms_and_Conditions')); ?></span></a>
                        </li>
                        <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.File_Management_and_Documents')); ?></span></a>
                        </li>
                        <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Auto_Send_Rules')); ?></span></a>
                        </li>


                    </ul>

                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('settings_edit_general_settings')): ?>
            <li class="nav-item">
                <a href="#">
                    <i class="feather icon-check-circle"></i>
                    <span class="menu-title" data-i18n="Dashboard">
                        <?php echo e(trans('main_trans.tasks')); ?>

                    </span>
                </a>
                <ul class="menu-content">
                    <!-- إدارة المهام -->
                    <li>
                        <a href="">
                            <i class="feather icon-list"></i>
                            <span class="menu-item" data-i18n="Analytics">
                                <?php echo e(trans('main_trans.management_Tasks')); ?>

                            </span>
                        </a>
                    </li>

                    <!-- إنشاء مهمة جديدة -->
                    <li>
                        <a href="">
                            <i class="feather icon-plus"></i>
                            <span class="menu-item" data-i18n="Analytics">
                                <?php echo e(trans('main_trans.create_Task')); ?>

                            </span>
                        </a>
                    </li>

                    <!-- إدارة المشاريع -->
                    <li>
                        <a href="">
                            <i class="feather icon-folder"></i>
                            <span class="menu-item" data-i18n="eCommerce">
                                <?php echo e(trans('main_trans.Management_Projects')); ?>

                            </span>
                        </a>
                    </li>

                    <!-- التقويم -->
                    <li>
                        <a href="">
                            <i class="feather icon-calendar"></i>
                            <span class="menu-item" data-i18n="eCommerce">
                                <?php echo e(trans('main_trans.Calendar')); ?>

                            </span>
                        </a>
                    </li>

                    <!-- الفئات (الأقسام) -->
                    <li>
                        <a href="">
                            <i class="feather icon-tag"></i>
                            <span class="menu-item" data-i18n="eCommerce">
                                <?php echo e(trans('main_trans.Task_Categories')); ?>

                            </span>
                        </a>
                    </li>
                    <!-- الإعدادات -->
                    <li>
                        <a href="">
                            <i class="feather icon-settings"></i>
                            <span class="menu-item" data-i18n="eCommerce">
                                <?php echo e(trans('main_trans.Task_Settings')); ?>

                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('settings_edit_general_settings')): ?>
                <li class=" nav-item"><a href="index.html">
                        <i class="feather icon-settings">
                        </i><span class="menu-title" data-i18n="Dashboard">
                            <?php echo e(trans('main_trans.Sittings')); ?></span>
                    </a>
                    <ul class="menu-content">
                        <li><a href="<?php echo e(route('AccountInfo.index')); ?>"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Analytics">
                                    <?php echo e(trans('main_trans.Account_Information')); ?></span></a>
                        </li>

                        <li><a href="<?php echo e(route('SittingAccount.index')); ?>"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Account_Settings')); ?></span></a>
                        </li>
                        <li><a href="<?php echo e(route('SMPT.index')); ?>"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.SMTP_Settings')); ?></span></a>
                        </li>

                        <li><a href="<?php echo e(route('PaymentMethods.index')); ?>"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Payment_Methods')); ?></span></a></li>

                        <li><a href="<?php echo e(route('Sms.index')); ?>"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.SMS_Settings')); ?></span></a></li>

                        <li><a href="<?php echo e(route('SequenceNumbering.index', 'section')); ?>"><i
                                    class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Sequential_Numbering_Settings')); ?></span></a>
                        </li>
                        <li><a href="<?php echo e(route('TaxSitting.index')); ?>"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Tax_Settings')); ?></span></a>
                        </li>
                        <li><a href="<?php echo e(route('Application.index')); ?>"><i class="feather icon-circle"></i><span
                                    class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.Applications_Management')); ?></span></a>
                        </li>

                        <li><a href="<?php echo e(route('AccountInfo.backgroundColor')); ?>"><i
                                    class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.System_Logo_and_Colors')); ?></span></a>
                        </li>

                        <li><a href=""><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="eCommerce"><?php echo e(trans('main_trans.API')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</div>
<?php $__env->startSection('scripts'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // عناصر واجهة المستخدم
            const statusElement = document.getElementById('location-status');
            const lastUpdateElement = document.getElementById('last-update');
            const nearbyClientsElement = document.getElementById('nearby-clients');
            const startTrackingBtn = document.getElementById('start-tracking');
            const stopTrackingBtn = document.getElementById('stop-tracking');

            // متغيرات التتبع
            let watchId = null;
            let lastLocation = null;
            let isTracking = false;
            let trackingInterval = null;

            // ========== دوال الواجهة ========== //

            // تحديث حالة الواجهة
            function updateUI(status, message) {
                statusElement.textContent = message;
                statusElement.className = `alert alert-${status}`;
                lastUpdateElement.textContent = new Date().toLocaleTimeString();
            }

            // عرض العملاء القريبين
            function displayNearbyClients(count) {
                if (count > 0) {
                    nearbyClientsElement.innerHTML = `
                <div class="alert alert-info mt-3">
                    <i class="feather icon-users mr-2"></i>
                    يوجد ${count} عميل قريب من موقعك الحالي
                </div>
            `;
                } else {
                    nearbyClientsElement.innerHTML = '';
                }
            }

            // ========== دوال التتبع ========== //

            // إرسال بيانات الموقع إلى الخادم
            async function sendLocationToServer(position) {
                const {
                    latitude,
                    longitude,
                    accuracy
                } = position.coords;

                try {
                    const response = await fetch("<?php echo e(route('visits.storeLocationEnhanced')); ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                        },
                        body: JSON.stringify({
                            latitude,
                            longitude,
                            accuracy: accuracy || null
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        updateUI('success', 'تم تحديث موقعك بنجاح');
                        displayNearbyClients(data.nearby_clients || 0);
                        return true;
                    } else {
                        throw new Error(data.message || 'خطأ في الخادم');
                    }
                } catch (error) {
                    console.error('❌ خطأ في إرسال الموقع:', error);
                    updateUI('danger', `خطأ في تحديث الموقع: ${error.message}`);
                    return false;
                }
            }

            // معالجة أخطاء الموقع
            function handleGeolocationError(error) {
                let errorMessage;
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = "تم رفض إذن الوصول إلى الموقع. يرجى تفعيله في إعدادات المتصفح.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = "معلومات الموقع غير متوفرة حالياً.";
                        break;
                    case error.TIMEOUT:
                        errorMessage = "انتهت مهلة طلب الموقع. يرجى المحاولة مرة أخرى.";
                        break;
                    case error.UNKNOWN_ERROR:
                        errorMessage = "حدث خطأ غير معروف أثناء محاولة الحصول على الموقع.";
                        break;
                }

                updateUI('danger', errorMessage);
                if (isTracking) stopTracking();
            }

            // بدء تتبع الموقع
            function startTracking() {
                if (!navigator.geolocation) {
                    updateUI('danger', 'المتصفح لا يدعم ميزة تحديد الموقع');
                    return;
                }

                updateUI('info', 'جاري طلب إذن الموقع...');

                // طلب الموقع الحالي أولاً
                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                            const {
                                latitude,
                                longitude
                            } = position.coords;
                            lastLocation = {
                                latitude,
                                longitude
                            };

                            // إرسال الموقع الأولي
                            await sendLocationToServer(position);

                            // بدء التتبع المستمر
                            watchId = navigator.geolocation.watchPosition(
                                async (position) => {
                                        const {
                                            latitude,
                                            longitude
                                        } = position.coords;

                                        // التحقق من تغير الموقع بشكل كافي (أكثر من 10 أمتار)
                                        if (!lastLocation ||
                                            getDistance(latitude, longitude, lastLocation.latitude,
                                                lastLocation.longitude) > 10) {

                                            lastLocation = {
                                                latitude,
                                                longitude
                                            };
                                            await sendLocationToServer(position);
                                        }
                                    },
                                    (error) => {
                                        console.error('❌ خطأ في تتبع الموقع:', error);
                                        handleGeolocationError(error);
                                    }, {
                                        enableHighAccuracy: true,
                                        timeout: 10000,
                                        maximumAge: 0,
                                        distanceFilter: 10 // تحديث عند التحرك أكثر من 10 أمتار
                                    }
                            );

                            // بدء التتبع الدوري (كل دقيقة)
                            trackingInterval = setInterval(async () => {
                                if (lastLocation) {
                                    const fakePosition = {
                                        coords: {
                                            latitude: lastLocation.latitude,
                                            longitude: lastLocation.longitude,
                                            accuracy: 20
                                        }
                                    };
                                    await sendLocationToServer(fakePosition);
                                }
                            }, 60000);

                            isTracking = true;
                            updateUI('success', 'جاري تتبع موقعك...');
                            if (startTrackingBtn) startTrackingBtn.disabled = true;
                            if (stopTrackingBtn) stopTrackingBtn.disabled = false;
                        },
                        (error) => {
                            console.error('❌ خطأ في الحصول على الموقع:', error);
                            handleGeolocationError(error);
                        }, {
                            enableHighAccuracy: true,
                            timeout: 15000,
                            maximumAge: 0
                        }
                );
            }

            // إيقاف تتبع الموقع
            function stopTracking() {
                if (watchId) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;
                }

                if (trackingInterval) {
                    clearInterval(trackingInterval);
                    trackingInterval = null;
                }

                isTracking = false;
                updateUI('warning', 'تم إيقاف تتبع الموقع');
                if (startTrackingBtn) startTrackingBtn.disabled = false;
                if (stopTrackingBtn) stopTrackingBtn.disabled = true;
                nearbyClientsElement.innerHTML = '';
            }

            // حساب المسافة بين موقعين (بالمتر)
            function getDistance(lat1, lon1, lat2, lon2) {
                const R = 6371000; // نصف قطر الأرض بالمتر
                const φ1 = lat1 * Math.PI / 180;
                const φ2 = lat2 * Math.PI / 180;
                const Δφ = (lat2 - lat1) * Math.PI / 180;
                const Δλ = (lon2 - lon1) * Math.PI / 180;

                const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                    Math.cos(φ1) * Math.cos(φ2) *
                    Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                return R * c;
            }

            // ========== تهيئة الأحداث ========== //

            // أحداث الأزرار
            if (startTrackingBtn) {
                startTrackingBtn.addEventListener('click', startTracking);
            }

            if (stopTrackingBtn) {
                stopTrackingBtn.addEventListener('click', stopTracking);
            }

            // بدء التتبع تلقائياً عند تحميل الصفحة
            startTracking();

            // إيقاف التتبع عند إغلاق الصفحة
            window.addEventListener('beforeunload', function() {
                if (isTracking) {
                    // إرسال بيانات الإغلاق إلى الخادم إذا لزم الأمر
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const fakePosition = {
                                coords: {
                                    latitude: position.coords.latitude,
                                    longitude: position.coords.longitude,
                                    accuracy: position.coords.accuracy,
                                    isExit: true
                                }
                            };
                            sendLocationToServer(fakePosition);
                        },
                        () => {}, {
                            enableHighAccuracy: true
                        }
                    );
                    stopTracking();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>