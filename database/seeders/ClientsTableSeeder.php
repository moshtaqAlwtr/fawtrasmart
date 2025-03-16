<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // احصل على employee_id للموظف الواحد
        $employeeId = DB::table('employees')->value('id'); // الحصول على id الموظف الأول
        $branchIds = DB::table('branches')->pluck('id')->toArray(); // الحصول على branch_id المتاحة
        $userIds = DB::table('users')->pluck('id')->toArray(); // الحصول على user_id المتاحة

        for ($i = 0; $i < 1500; $i++) {
            DB::table('clients')->insert([
                'employee_id' => $employeeId, // تعيين employee_id للموظف الواحد
                'branch_id' => $faker->randomElement($branchIds), // استخدام قيم موجودة
                'trade_name' => $faker->company,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone' => $faker->phoneNumber,
                'mobile' => $faker->phoneNumber,
                'city' => $faker->city,
                'region' => $faker->state,
                'street1' => $faker->streetAddress,
                'street2' => $faker->secondaryAddress,
                'postal_code' => $faker->postcode,
                'country' => $faker->country,
                'user_id' => $faker->randomElement($userIds), // استخدام قيم موجودة
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}