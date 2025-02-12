<?php

namespace App\Http\Controllers\SupplyOrders;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Employee;
use App\Models\SupplyOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class SupplyOrdersController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::all();
        $employees = Employee::all();

        // Count for each filter
        $totalCount = SupplyOrder::count();
        $resultsCount = SupplyOrder::orderBy('created_at', 'desc')->count();
        $openCount = SupplyOrder::where('status', 1)->count();
        $closedCount = SupplyOrder::where('status', 2)->count();

        // Start with base query
        $query = SupplyOrder::with(['client', 'employee']);

        // Filter based on request parameters
        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'results':
                    // Example: Most recent or high-value orders
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'open':
                    $query->where('status', 1); // Open status
                    break;
                case 'closed':
                    $query->where('status', 2); // Closed status
                    break;
            }
        }

        // Additional filtering options
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->input('order_number') . '%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->input('employee_id'));
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->input('assigned_to'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Date filters
        if ($request->filled('from_date_1')) {
            $query->where('start_date', '>=', $request->input('from_date_1'));
        }

        if ($request->filled('to_date_1')) {
            $query->where('start_date', '<=', $request->input('to_date_1'));
        }

        if ($request->filled('from_date_2')) {
            $query->where('end_date', '>=', $request->input('from_date_2'));
        }

        if ($request->filled('to_date_2')) {
            $query->where('end_date', '<=', $request->input('to_date_2'));
        }

        // Sorting
        $query->latest();

        // Paginate results
        $supplyOrders = $query->paginate(10);

        // Prepare additional data for filtering dropdowns
        $filterClients = Client::whereHas('supplyOrders')->get();
        $filterEmployees = Employee::whereHas('supplyOrders')->get();

        // Prepare filter counts for each client and employee
        $clientCounts = Client::withCount('supplyOrders')->get();
        $employeeCounts = Employee::withCount('supplyOrders')->get();

        return view('supplyOrders.index', compact('clients', 'employees', 'supplyOrders', 'filterClients', 'filterEmployees', 'clientCounts', 'employeeCounts', 'totalCount', 'resultsCount', 'openCount', 'closedCount'));
    }
    protected function generateOrderNumber()
    {
        // Get the maximum existing order number, or start from 1 if no orders exist
        $lastOrderNumber = SupplyOrder::max('order_number');

        // If no previous orders, start from 1
        // Otherwise, increment the last number
        return $lastOrderNumber ? $lastOrderNumber + 1 : 1;
    }

    // Increment the last order's ID

    public function create()
    {
        $clients = Client::all();
        $employees = Employee::all();
        $tags = ['مشروع جديد', 'تجديد', 'صيانة', 'استشارات', 'أخرى'];

        // Generate order number for the new form
        $supply_order_number = $this->generateOrderNumber();

        return view('supplyOrders.create', compact('clients', 'employees', 'tags', 'supply_order_number'));
    }

    public function store(Request $request)
    {
        // If no order number is provided, generate one
        $orderNumber = $request->input('supply_order_number') ?? $this->generateOrderNumber();
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'supply_order_number' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'client_id' => 'nullable|exists:clients,id',
            'employee_id' => 'nullable|exists:employees,id',
            'tag' => 'nullable|string',
            'show_employees' => 'nullable|boolean',
            'budget' => 'nullable|numeric|min:0',
            'currency' => 'nullable|in:1,2,3,4,5',
            'product_details' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'tracking_number' => 'nullable|string',
            'shipping_policy_file' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('shipping_policy_file')) {
            $file = $request->file('shipping_policy_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('shipping_policies', $filename, 'public');
            $validatedData['shipping_policy_file'] = $path;
        }

        // Rename keys to match database column names
        $validatedData['order_number'] = $orderNumber;
        unset($validatedData['supply_order_number']);

        $supplyOrder = SupplyOrder::create($validatedData);

        return redirect()->route('SupplyOrders.index')->with('success', 'تم إنشاء أمر التوريد بنجاح');
    }

    public function edit($id)
    {
        $clients = Client::all();
        $employees = Employee::all();
        $supply_order = SupplyOrder::findOrFail($id);
        $supply_order_number = $this->generateOrderNumber();
        $tags = ['مشروع جديد', 'تجديد', 'صيانة', 'استشارات', 'أخرى'];

        return view('supplyOrders.edit', compact('supply_order', 'clients', 'employees', 'tags', 'supply_order_number'));
    }

    public function update(Request $request, $id)
{
    // البحث عن أمر التوريد المطلوب
    $supplyOrder = SupplyOrder::findOrFail($id);

    // إذا لم يتم تقديم رقم أمر، استخدم الرقم الحالي
    $orderNumber = $request->input('supply_order_number') ?? $supplyOrder->order_number;

    // التحقق من البيانات المدخلة
    $validatedData = $request->validate([
        'name' => 'nullable|string|max:255',
        'supply_order_number' => 'nullable|string|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'description' => 'nullable|string',
        'client_id' => 'nullable|exists:clients,id',
        'employee_id' => 'nullable|exists:employees,id',
        'tag' => 'nullable|string',
        'show_employees' => 'nullable|boolean',
        'budget' => 'nullable|numeric|min:0',
        'currency' => 'nullable|in:1,2,3,4,5',
        'product_details' => 'nullable|string',
        'shipping_address' => 'nullable|string',
        'tracking_number' => 'nullable|string',
        'shipping_policy_file' => 'nullable|file|max:10240', // 10MB max
    ]);

    // التعامل مع رفع الملف (إذا تم تقديم ملف جديد)
    if ($request->hasFile('shipping_policy_file')) {
        // حذف الملف القديم إذا كان موجودًا
        if ($supplyOrder->shipping_policy_file && Storage::disk('public')->exists($supplyOrder->shipping_policy_file)) {
            Storage::disk('public')->delete($supplyOrder->shipping_policy_file);
        }

        // رفع الملف الجديد
        $file = $request->file('shipping_policy_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('shipping_policies', $filename, 'public');
        $validatedData['shipping_policy_file'] = $path;
    }

    // إعادة تسمية الحقول لتتناسب مع أسماء الأعمدة في قاعدة البيانات
    $validatedData['order_number'] = $orderNumber;
    unset($validatedData['supply_order_number']);

    // تحديث البيانات
    $supplyOrder->update($validatedData);

    // إعادة التوجيه مع رسالة نجاح
    return redirect()->route('SupplyOrders.index')->with('success', 'تم تحديث أمر التوريد بنجاح');
}
    public function show($id)
    {
        // جلب أمر توريد واحد
        $supplyOrder = SupplyOrder::findOrFail($id);

        // جلب جميع المواعيد (إذا كنت تحتاجها)
        $appointments = Appointment::all();

        // جلب جميع أوامر التوريد (إذا كنت تريد عرضها في الجدول)
        $supplyOrders = SupplyOrder::all(); // أو أي استعلام آخر

        return view('supplyOrders.show', compact('supplyOrder', 'appointments', 'supplyOrders'));
    }

    public function destroy($id)
    {
        $supply_order = SupplyOrder::findOrFail($id);

        // Delete file if exists
        if ($supply_order->shipping_policy_file) {
            Storage::disk('public')->delete($supply_order->shipping_policy_file);
        }

        $supply_order->delete();
        return redirect()->route('SupplyOrders.index')->with('success', 'تم حذف أمر التوريد ');
    }


    /******  f231f3e4-6f6f-43f5-9bef-d91e01b979a8  *******/
    public function edit_status()
    {
        return view('supplyOrders.edit_status');
    }
}
