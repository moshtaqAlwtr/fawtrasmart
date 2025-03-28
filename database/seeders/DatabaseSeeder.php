<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            UserSeeder::class,
            ApplicationSettingsSeeder::class,
            PaymentMethodSeeder::class,
            AccountSeeder::class,

            $this->call(ClientsTableSeeder::class);
        ]);
    }
}
