<?php

namespace Database\Seeders;

use App\Models\GeneralClientSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralClientSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'image',
                'name' => 'صورة',
                'is_active' => true,
            ],
            [
                'key' => 'type',
                'name' => 'النوع',
                'is_active' => true,
            ],
            [
                'key' => 'birth_date',
                'name' => 'تاريخ الميلاد',
                'is_active' => true,
            ],
            [
                'key' => 'location',
                'name' => 'الموقع على الخريطة',
                'is_active' => true,
            ],
            [
                'key' => 'opening_balance',
                'name' => 'الرصيد الافتتاحي',
                'is_active' => true,
            ],
            [
                'key' => 'credit_limit',
                'name' => 'الحد الائتماني',
                'is_active' => true,
            ],
            [
                'key' => 'credit_duration',
                'name' => 'المدة الائتمانية',
                'is_active' => true,
            ],
            [
                'key' => 'national_id',
                'name' => 'رقم الهوية الوطنية',
                'is_active' => true,
            ],
            [
                'key' => 'addresses',
                'name' => 'عناوين متعددة',
                'is_active' => true,
            ],
            [
                'key' => 'link',
                'name' => 'الرابط',
                'is_active' => true,
            ],
        ];

        foreach ($settings as $setting) {
            GeneralClientSetting::create($setting);
        }
    }
}
