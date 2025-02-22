<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            ['name' => 'كاش', 'description' => 'الدفع نقدًا عند الاستلام', 'status' => 'active', 'is_online' => 'active','type' => 'normal'],
            ['name' => 'شيك', 'description' => 'الدفع عن طريق الشيك', 'status' => 'active', 'is_online' => 'active','type' => 'normal'],
            ['name' => 'تحويل بنكي', 'description' => 'الدفع عن طريق التحويل البنكي', 'status' => 'active', 'is_online' => 'active','type' => 'normal'],
            ['name' => 'أون لاين', 'description' => 'الدفع عبر الإنترنت', 'status' => 'active', 'is_online' => 'active','type' => 'normal'],
            ['name' => 'أخرى', 'description' => 'طرق دفع أخرى', 'status' => 'active', 'is_online' => 'active','type' => 'normal'],

            ['name' => 'Paypal Standard', 'description' => 'طرق دفع أخرى', 'status' => 'active', 'is_online' => 'active','type' => 'electronic'],
            ['name' => 'Paypal Express', 'description' => 'طرق دفع أخرى', 'status' => 'active', 'is_online' => 'active','type' => 'electronic'],
            ['name' => 'Square', 'description' => 'طرق دفع أخرى', 'status' => 'active', 'is_online' => 'active','type' => 'electronic'],
            ['name' => 'Tamara Pay', 'description' => 'طرق دفع أخرى', 'status' => 'active', 'is_online' => 'active','type' => 'electronic'],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}
