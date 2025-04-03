<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard/sales/index';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
            Route::middleware('web')->group(base_path('routes/web.php'));
            Route::middleware('web')->group(base_path('routes/auth.php'));
            Route::middleware('web')->group(base_path('routes/stock.php'));
            Route::middleware('web')->group(base_path('routes/hr.php'));
            Route::middleware('web')->group(base_path('routes/branches.php'));
            Route::middleware('web')->group(base_path('routes/finance.php'));
            Route::middleware('web')->group(base_path('routes/accounts.php'));
            Route::middleware('web')->group(base_path('routes/reports.php'));
            Route::middleware('web')->group(base_path('routes/sales_reports.php'));
            Route::middleware('web')->group(base_path('routes/general_accounts.php'));
            Route::middleware('web')->group(base_path('routes/checks.php'));
            // Route::middleware('web')->group(base_path('routes/sms.php'));
            Route::middleware('web')->group(base_path('routes/balances.php'));
            Route::middleware('web')->group(base_path('routes/employees.php'));
            Route::middleware('web')->group(base_path('routes/memberships.php'));
            Route::middleware('web')->group(base_path('routes/rentals.php'));
            Route::middleware('web')->group(base_path('routes/organizational_structure.php'));
            Route::middleware('web')->group(base_path('routes/workflow.php'));
            Route::middleware('web')->group(base_path('routes/orders.php'));
            Route::middleware('web')->group(base_path('routes/customers.php'));
            Route::middleware('web')->group(base_path('routes/inventory.php'));
            Route::middleware('web')->group(base_path('routes/supply_orders.php'));
            Route::middleware('web')->group(base_path('routes/dashboard.php'));
            Route::middleware('web')->group(base_path('routes/time-tracking.php'));

            Route::middleware('web')->group(base_path('routes/orders.php'));
            Route::middleware('web')->group(base_path('routes/customers.php'));
            Route::middleware('web')->group(base_path('routes/inventory.php'));

            Route::middleware('web')->group(base_path('routes/attendance.php'));
            Route::middleware('web')->group(base_path('routes/track_time.php'));
            Route::middleware('web')->group(base_path('routes/salaries.php'));
            Route::middleware('web')->group(base_path('routes/supply_orders.php'));
            Route::middleware('web')->group(base_path('routes/dashboard.php'));
            Route::middleware('web')->group(base_path('routes/time-tracking.php'));

            Route::middleware('web')->group(base_path('routes/orders.php'));
            Route::middleware('web')->group(base_path('routes/customers.php'));
            Route::middleware('web')->group(base_path('routes/inventory.php'));
            Route::middleware('web')->group(base_path('routes/activity.php'));

            Route::middleware('web')->group(base_path('routes/track_time.php'));
            Route::middleware('web')->group(base_path('routes/purchases.php'));
            Route::middleware('web')->group(base_path('routes/reservations.php'));
            Route::middleware('web')->group(base_path('routes/cheques.php'));
            Route::middleware('web')->group(base_path('routes/targetSales.php'));
            Route::middleware('web')->group(base_path('routes/pointsAndBalances.php'));
            Route::middleware('web')->group(base_path('routes/memberships_subscriptions.php'));
            Route::middleware('web')->group(base_path('routes/sitting.php'));
            Route::middleware('web')->group(base_path('routes/installments.php'));
            Route::middleware('web')->group(base_path('routes/rental_management.php'));
            Route::middleware('web')->group(base_path('routes/Loyalty_Points.php'));
            Route::middleware('web')->group(base_path('routes/customer_attendance.php'));
            Route::middleware('web')->group(base_path('routes/insurance_agents.php'));
            Route::middleware('web')->group(base_path('routes/manufacturing.php'));
            Route::middleware('web')->group(base_path('routes/pos.php'));
            Route::middleware('web')->group(base_path('routes/online_store.php'));
            Route::middleware('web')->group(base_path('routes/orders.php'));

        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
