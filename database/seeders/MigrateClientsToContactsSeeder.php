<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferClientsToContactsSeeder extends Seeder
{
    public function run()
    {
        // 1. تعطيل فحص المفاتيح واللوجر لتحسين الأداء
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::disableQueryLog();

        // 2. إعداد شريط التقدم
        $totalClients = Client::count();
        $this->command->info("بدأ نقل بيانات {$totalClients} عميل إلى جدول جهات الاتصال...");
        $bar = $this->command->getOutput()->createProgressBar($totalClients);

        // 3. معالجة البيانات بدفعات
        Client::chunk(1000, function ($clients) use ($bar) {
            $contacts = [];

            foreach ($clients as $client) {
                $contacts[] = [
                    'client_id' => $client->id,
                    'name'      => $this->getClientName($client),
                    'email'     => $client->email,
                    'phone'     => $client->phone,
                    'mobile'    => $client->mobile,
                    'position'  => 'عميل رئيسي',
                    'created_at' => now(),
                    'updated_at' => now(),
                    // يمكنك إضافة حقول إضافية هنا
                ];

                $bar->advance();
            }

            // 4. إدراج دفعي
            Contact::insert($contacts);
        });

        // 5. إعادة الضبط
        $bar->finish();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("\nتم الانتهاء بنجاح!");
        $this->command->info("عدد جهات الاتصال المضافة: " . Contact::count());
    }

    protected function getClientName($client)
    {
        // دالة لإنشاء الاسم من البيانات المتاحة
        if ($client->trade_name) {
            return $client->trade_name;
        }

        if ($client->first_name || $client->last_name) {
            return trim($client->first_name . ' ' . $client->last_name);
        }

        return 'عميل ' . $client->id;
    }
}
