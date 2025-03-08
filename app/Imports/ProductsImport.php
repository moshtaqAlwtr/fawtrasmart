<?php
namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // التحقق من وجود المفتاح 'category_id' في المصفوفة
        if (!isset($row['category_id'])) {
            return null; // تخطي الصف إذا كان المفتاح غير موجود
        }

        // تحويل category_id من نص إلى رقم
        $categoryId = intval($row['category_id']);

        // إذا كانت category_id غير رقمية أو أقل من أو تساوي الصفر، قم بتخطي الصف
        if (!is_numeric($row['category_id']) || $row['category_id'] <= 0) {
            return null;
        }

        // إذا كانت category_id غير موجودة أو فارغة، قم بتخطي الصف
        if (empty($categoryId)) {
            return null;
        }

        // التحقق من وجود category_id في جدول categories
        if (!Category::where('id', $categoryId)->exists()) {
            return null; // تجاوز السطر إذا لم يكن التصنيف موجودًا
        }

        // إنشاء نموذج Product جديد
        return new Product([
            'name' => $row['name'] ?? null,
            'description' => $row['description'] ?? null,
            'category_id' => $categoryId, // تأكد من أن category_id ليست null
            'serial_number' => $row['serial_number'] ?? null,
            'brand' => $row['brand'] ?? null,
            'supplier_id' => $row['supplier_id'] ?? null,
            'low_stock_thershold' => $row['low_stock_thershold'] ?? 0,
            'barcode' => $row['barcode'] ?? null,
            'sales_cost_account' => $row['sales_cost_account'] ?? null,
            'sales_account' => $row['sales_account'] ?? null,
            'available_online' => $row['available_online'] ?? 0,
            'featured_product' => $row['featured_product'] ?? 0,
            'track_inventory' => $row['track_inventory'] ?? 0,
            'inventory_type' => $row['inventory_type'] ?? null,
            'low_stock_alert' => $row['low_stock_alert'] ?? 0,
            'Internal_notes' => $row['internal_notes'] ?? null,
            'tags' => $row['tags'] ?? null,
            'images' => $row['images'] ?? null,
            'status' => $row['status'] ?? 'active',
            'purchase_price' => $row['purchase_price'] ?? 0,
            'sale_price' => $row['sale_price'] ?? 0,
            'tax1' => $row['tax1'] ?? 0,
            'tax2' => $row['tax2'] ?? 0,
            'min_sale_price' => $row['min_sale_price'] ?? 0,
            'discount' => $row['discount'] ?? 0,
            'discount_type' => $row['discount_type'] ?? null,
            'profit_margin' => $row['profit_margin'] ?? 0,
            'type' => $row['type'] ?? null,
            'created_by' => auth()->id() ?? null,
        ]);
    }
}
