<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء أو تحديث المستخدم الأول (مدير)
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'عبدالمنعم',
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),
                'role' => 'manager',
                'phone' => '0966123456789'
            ]
        );

        // إنشاء أو تحديث المستخدم الثاني (مدير)
        $moshtaqUser = User::updateOrCreate(
            ['email' => 'moshtaq@gmail.com'],
            [
                'name' => 'مشتاق قايد الوتر',
                'email' => 'moshtaq@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'manager',
                'phone' => '0534781240'
            ]
        );

        // إنشاء أو تحديث المستخدم الثالث (owner)
        $ownerUser1 = User::updateOrCreate(
            ['email' => 'alrwies@gmail.com'],
            [
                'name' => 'محمد فالح العتيبي',
                'email' => 'alrwies@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'manager',
                'phone' => '0534781241'
            ]
        );

        // إنشاء أو تحديث المستخدم الرابع (owner)
        $ownerUser2 = User::updateOrCreate(
            ['email' => 'owner2@example.com'],
            [
                'name' => 'مالك اثنين',
                'email' => 'owner2@example.com',
                'password' => Hash::make('123456'),
                'role' => 'owner',
                'phone' => '0534781242'
            ]
        );

        // إنشاء الأدوار إذا لم تكن موجودة
        $managerRole = Role::updateOrCreate(['name' => 'manager']);
        $ownerRole = Role::updateOrCreate(['name' => 'owner']);

        // تعيين الأذونات للأدوار (إذا لزم الأمر)
        $permissions = Permission::pluck('id', 'id')->all();
        $managerRole->syncPermissions($permissions);
        $ownerRole->syncPermissions($permissions); // يمكنك تعديل الأذونات حسب الحاجة

        // تعيين الأدوار للمستخدمين
        $adminUser->assignRole([$managerRole->id]);
        $moshtaqUser->assignRole([$managerRole->id]);
        $ownerUser1->assignRole([$ownerRole->id]);
        $ownerUser2->assignRole([$ownerRole->id]);
    }
}
