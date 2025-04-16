<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Template;

class TemplatesSeeder extends Seeder
{
    public function run()
    {
        // مسح البيانات القديمة إذا وجدت
        Template::truncate();

        // إضافة قالب الفاتورة الحرارية
        Template::create([
            'name' => 'فاتورة حرارية',
            'type' => 'invoice',
            'content' => $this->getTemplateContent('thermal_invoice.html'),
            'default_content' => $this->getTemplateContent('thermal_invoice.html'),
            'is_default' => true
        ]);

        // يمكنك إضافة المزيد من القوالب هنا
        // Template::create([
        //     'name' => 'فاتورة تجارية',
        //     'type' => 'invoice',
        //     'content' => $this->getTemplateContent('commercial_invoice.html'),
        //     'default_content' => $this->getTemplateContent('commercial_invoice.html'),
        //     'is_default' => false
        // ]);
    }

    protected function getTemplateContent($filename)
    {
        $path = resource_path("views/templates/{$filename}");
        
        if (!File::exists($path)) {
            throw new \Exception("ملف القالب غير موجود: {$filename}");
        }

        return File::get($path);
    }
}