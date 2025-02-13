<?php

namespace App\Http\Controllers\Installments;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Installment; // إضافة نموذج الأقساط
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstallmentsController extends Controller
{
    public function index(Request $request)
    {
        // Initialize the query
        $query = Installment::with('invoice.client');

        // Apply filters based on the request
        if ($request->filled('status') && $request->status != 'الكل') {
            // Assuming 1 for مكتمل and 2 for غير مكتمل
            if ($request->status == '1') {
                $query->whereHas('invoice', function($q) {
                    $q->where('status', 'مكتمل'); // Adjust based on your actual field
                });
            } elseif ($request->status == '2') {
                $query->whereHas('invoice', function($q) {
                    $q->where('status', 'غير مكتمل'); // Adjust based on your actual field
                });
            }
        }

        if ($request->filled('identifier')) {
            $query->where('id', $request->identifier);
        }

        if ($request->filled('client')) {
            $query->whereHas('invoice.client', function($q) use ($request) {
                $q->where('trade_name', 'like', '%' . $request->client . '%'); // Adjust based on your actual field
            });
        }

        if ($request->filled('fromDate')) {
            $query->where('due_date', '>=', $request->fromDate);
        }

        if ($request->filled('toDate')) {
            $query->where('due_date', '<=', $request->toDate);
        }

        // Retrieve filtered installments
        $installments = $query->get();

        // Calculate status for each installment
        foreach ($installments as $installment) {
            $installment->status = $this->calculateInstallmentStatus($installment);
        }

        // Return a view with the installments data
        return view('installments.index', compact('installments'));
    }

    // Method to calculate the status of the installment
    private function calculateInstallmentStatus($installment)
    {
        $totalPaid = $installment->invoice->installments()->sum('amount'); // Total paid so far
        $remainingBalance = $installment->invoice->grand_total - $totalPaid; // Remaining balance

        if ($remainingBalance > 0) {
            // Check if the due date is in the past
            if (Carbon::parse($installment->due_date)->isPast()) {
                return 'متأخر'; // Late
            }
            return 'غير مكتمل'; // Incomplete
        }
        return 'مكتمل'; // Complete
    }
    public function create(Request $request)
    {
        $id = $request->query('id'); // الحصول على id من الـ query parameters
        Log::info('Invoice ID: ' . $id); // تسجيل قيمة $id
        $clients = Client::all();
        $invoice = Invoice::findOrFail($id);
        return view('installments.create', compact('clients', 'invoice'));
    }

    public function store(Request $request)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'nullable|numeric',
            'installment_number' => 'nullable|integer',
'payment_rate'=>'nullable|integer',
            'due_date' => 'nullable|date',
        ]);

        // إنشاء قسط جديد
        Installment::create($request->all());

        return redirect()->route('installments.index')->with('success', 'تم إضافة القسط بنجاح.');
    }
    public function edit($id)
    {
        // Retrieve the specific installment along with its related invoice and client
        $installment = Installment::with('invoice.client')->findOrFail($id);
        $clients = Client::all(); // Assuming you have a Client model to get all clients
        $invoice = $installment->invoice; // Get the related invoice

        // Return the edit view with the installment data
        return view('installments.edit', compact('installment', 'clients', 'invoice'));
    }
    public function update(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'nullable|numeric',
            'installment_number' => 'nullable|integer', // Number of installments
            'payment_rate'=>'nullable|integer',
            'due_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        // Update the installment

        $installment = Installment::findOrFail($id);

        // Update only the fields that are allowed to be changed
        $installment->update([
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'payment_rate'=>$request->payment_rate,
            'installment_number'=>$request->installment_number,
            'note' => $request->note,
        ]);

        return redirect()->route('installments.index')->with('success', 'تم تحديث القسط بنجاح.');
    }

    public function destroy($id)
    {
        $installment = Installment::findOrFail($id);
        $installment->delete();

        return redirect()->route('installments.index')->with('success', 'تم حذف القسط بنجاح.');
    }

    public function agreement(Request $request)
    {
        // Initialize the query
        $query = Installment::with('invoice.client');

        // Apply filters based on the request
        if ($request->filled('status') && $request->status != 'الكل') {
            // Assuming 1 for مكتمل and 2 for غير مكتمل
            if ($request->status == '1') {
                $query->whereHas('invoice', function($q) {
                    $q->where('status', 'مكتمل'); // Adjust based on your actual field
                });
            } elseif ($request->status == '2') {
                $query->whereHas('invoice', function($q) {
                    $q->where('status', 'غير مكتمل'); // Adjust based on your actual field
                });
            }
        }

        if ($request->filled('identifier')) {
            $query->where('id', $request->identifier);
        }

        if ($request->filled('client')) {
            $query->whereHas('invoice.client', function($q) use ($request) {
                $q->where('trade_name', 'like', '%' . $request->client . '%'); // Adjust based on your actual field
            });
        }

        if ($request->filled('fromDate')) {
            $query->where('due_date', '>=', $request->fromDate);
        }

        if ($request->filled('toDate')) {
            $query->where('due_date', '<=', $request->toDate);
        }

        // Retrieve filtered installments
        $installments = $query->get();

        // Calculate status for each installment
        foreach ($installments as $installment) {
            $installment->status = $this->calculateInstallmentStatus($installment);
        }

        // Return a view with the installments data
        return view('installments.installments_detites.agreement_installments', compact('installments'));
    }

    public function show($id)
    {
        $installment = Installment::with('payment')->findOrFail($id); // تحميل الدفع مع القسط
        $invoice = Invoice::findOrFail($installment->invoice_id); // استرجاع الفاتورة المرتبطة

        return view('installments.show', compact('installment', 'invoice'));
    }
}
