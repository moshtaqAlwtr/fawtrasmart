<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
class SittingInvoiceController extends Controller
{
    public function index()
    {
        return view('sales.sitting.index');
    }

    // public function bill_designs()
    // {
       
    //     return view('sales.sitting.bill_designs');
    // }
    public function bill_designs()
{
    $templates = Template::where('type', 'invoice')->get();
    return view('templates.index', compact('templates'));
}


public function preview(Request $request)
{
    try {
        $content = $request->input('content');
        
        // تنظيف المحتوى من أي أكواد غير مرغوب فيها
        $content = $this->sanitizeTemplateContent($content);
        
        $dummyData = $this->generateDummyData();
        
        // استبدال &lt; و &gt; بالرموز الحقيقية قبل التصيير
        $content = htmlspecialchars_decode($content);
        
        // معالجة القالب يدويًا قبل تمريره لـ Blade
        $processedContent = $this->preprocessTemplate($content);
        
        $html = Blade::render($processedContent, $dummyData);
        
        return response()->json(['html' => $html]);
        
    } catch (\Throwable $e) {
        return response()->json([
            'error' => 'خطأ في المعاينة: ' . $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}

private function sanitizeTemplateContent($content)
{
    // إزالة أي أكواد PHP خطيرة
    $content = preg_replace('/<\?php.*?\?>/s', '', $content);
    
    // استبدال HTML entities
    $content = str_replace(
        ['&lt;?', '?&gt;', '&amp;'], 
        ['<?', '?>', '&'], 
        $content
    );
    
    return $content;
}

private function preprocessTemplate($content)
{
    // استبدال المتغيرات المعقدة بعلامات مؤقتة
    $replacements = [
        '/@php(.*?)@endphp/s' => '<?php $1 ?>',
        '/\{\!!(.*?)!!\}/' => '<?php echo $1 ?>'
    ];
    
    return preg_replace(
        array_keys($replacements),
        array_values($replacements),
        $content
    );
}

private function generateDummyData()
{
    return [
        'invoice' => (object)[
            'id' => rand(1000, 9999),
            'invoice_date' => now(),
            'discount_amount' => 50,
            'advance_payment' => 100,
            'due_value' => 450,
            'shipping_cost' => 30,
            'grand_total' => 500,
            'payment_status' => 0,
            'returned_payment' => 0,
            'items' => collect([
                (object)['item' => 'منتج تجريبي 1', 'quantity' => 2, 'unit_price' => 100, 'discount' => 10, 'total' => 190],
                (object)['item' => 'منتج تجريبي 2', 'quantity' => 1, 'unit_price' => 200, 'discount' => 0, 'total' => 200]
            ]),
            'client' => (object)[
                'trade_name' => 'شركة تجريبية',
                'first_name' => 'محمد',
                'last_name' => 'علي',
                'street1' => 'شارع الملك فهد',
                'street2' => 'الرياض',
                'tax_number' => '1234567890',
                'phone' => '0501234567',
                'code' => 'CL001',
                'mobile' => '0501234567'
            ]
        ],
        'account_setting' => (object)[
            'currency' => 'SAR',
            'user_id' => auth()->id()
        ],
        'qrCodeSvg' => '<svg width="100" height="100"><rect width="100" height="100" fill="#000"/></svg>',
        'TaxsInvoice' => collect([])
    ];
}

public function edit(Template $template)
{
    return view('templates.edit', compact('template'));
}

public function update(Request $request, Template $template)
{
    $request->validate(['content' => 'required']);
    
    $template->update(['content' => $request->content]);
    
    return redirect()->route('SittingInvoice.bill_designs')->with('success', 'تم تحديث القالب');
}

public function reset(Template $template)
{
    $template->update(['content' => $template->default_content]);
    
    return back()->with('success', 'تم استعادة القالب الافتراضي');
}

}
