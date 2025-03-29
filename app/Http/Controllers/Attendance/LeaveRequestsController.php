<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveRequestsController extends Controller
{
    public function index()
    {
        return view('attendance.leave_requests.index');
    }
    public function create()    
    {
        $employees = Employee::all();
        return view('attendance.leave_requests.create', compact('employees'));
    }

    public function store(Request $request)
    {
        try {
            // التحقق من صحة البيانات الأساسية
            $validated = $request->validate(
                [
                    'employee_id' => 'required|exists:employees,id',
                    'request_type' => 'required|in:leave,emergency,sick',
                    'leave_type' => 'required|in:annual,casual,sick,unpaid',
                    'start_date' => 'required|date|after_or_equal:today',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'days' => 'required|integer|min:1',
                    'description' => 'nullable|string|max:1000',
                    'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                ],
                [
                    'employee_id.required' => 'حقل الموظف مطلوب',
                    'employee_id.exists' => 'الموظف المحدد غير موجود',
                    'start_date.after_or_equal' => 'تاريخ البدء يجب أن يكون اليوم أو بعده',
                    'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء',
                    'days.min' => 'عدد الأيام يجب أن يكون على الأقل يوم واحد',
                    'attachments.*.mimes' => 'يجب أن تكون المرفقات من نوع: pdf, jpg, jpeg, png',
                    'attachments.*.max' => 'حجم المرفق يجب أن لا يتجاوز 2 ميجابايت',
                ],
            );

            // التحقق من رصيد الإجازات
            $employee = Employee::findOrFail($validated['employee_id']);

            // حساب عدد الأيام إذا كان هناك تناقض بين التواريخ والأيام
            $start = new \DateTime($validated['start_date']);
            $end = new \DateTime($validated['end_date']);
            $calculatedDays = $start->diff($end)->days + 1;

            if ($calculatedDays != $validated['days']) {
                return back()->withInput()->with('error', 'عدد الأيام المدخل لا يتطابق مع الفترة بين تاريخي البدء والانتهاء');
            }

            // معالجة المرفقات

            // إنشاء طلب الإجازة
            try {
                $leaveRequest = LeaveRequest::create([
                    'employee_id' => $validated['employee_id'],
                    'request_type' => $validated['request_type'],
                    'leave_type' => $validated['leave_type'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'days' => $validated['days'],
                    'description' => $validated['description'],
                    'status' => 'pending',
                    'attachments' => null,
                ]);
                if ($request->hasFile('attachments')) {
                    $file = $request->file('attachments');
                    if ($file->isValid()) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('assets/uploads/'), $filename);
                        $leaveRequest->attachments = $filename;
                    }
                }
            } catch (\Exception $e) {
                // حذف المرفقات إذا فشل إنشاء الطلب

                return back()
                    ->withInput()
                    ->with('error', 'حدث خطأ أثناء حفظ طلب الإجازة: ' . $e->getMessage());
            }

            // إرسال إشعار للموظف

            return redirect()->route('attendance.leave_requests.index')->with('success', 'تم إرسال طلب الإجازة بنجاح وسيتم مراجعته قريباً');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ غير متوقع: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        return view('attendance.leave_requests.show', compact('leaveRequest'));
    }
    public function edit($id)
    {
        $employees = Employee::all();
        $leaveRequest = LeaveRequest::findOrFail($id);
        return view('attendance.leave_requests.edit', compact('leaveRequest', 'employees'));
    }

    public function update(Request $request, $id)
    {
        try {
            // العثور على طلب الإجازة المطلوب
            $leaveRequest = LeaveRequest::findOrFail($id);

            // التحقق من صحة البيانات الأساسية
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'request_type' => 'required|in:leave,emergency,sick',
                'leave_type' => 'required|in:annual,casual,sick,unpaid',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'days' => 'required|integer|min:1',
                'description' => 'nullable|string|max:1000',
                'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ], [
                'employee_id.required' => 'حقل الموظف مطلوب',
                'employee_id.exists' => 'الموظف المحدد غير موجود',
                'start_date.after_or_equal' => 'تاريخ البدء يجب أن يكون اليوم أو بعده',
                'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء',
                'days.min' => 'عدد الأيام يجب أن يكون على الأقل يوم واحد',
                'attachments.*.mimes' => 'يجب أن تكون المرفقات من نوع: pdf, jpg, jpeg, png',
                'attachments.*.max' => 'حجم المرفق يجب أن لا يتجاوز 2 ميجابايت'
            ]);

            // التحقق من رصيد الإجازات إذا لزم الأمر
            $employee = Employee::findOrFail($validated['employee_id']);

            // حساب عدد الأيام إذا كان هناك تناقض بين التواريخ والأيام
            $start = new \DateTime($validated['start_date']);
            $end = new \DateTime($validated['end_date']);
            $calculatedDays = $start->diff($end)->days + 1;

            if ($calculatedDays != $validated['days']) {
                return back()
                    ->withInput()
                    ->with('error', 'عدد الأيام المدخل لا يتطابق مع الفترة بين تاريخي البدء والانتهاء');
            }

            // معالجة المرفقات
            $attachments = $leaveRequest->attachments;

            if ($request->hasFile('attachments')) {
                // حذف المرفقات القديمة إذا وجدت
                if ($attachments && file_exists(public_path('assets/uploads/' . $attachments))) {
                    unlink(public_path('assets/uploads/' . $attachments));
                }

                // رفع المرفقات الجديدة
                $file = $request->file('attachments');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/'), $filename);
                    $attachments = $filename;
                }
            }

            // تحديث طلب الإجازة
            try {
                $leaveRequest->update([
                    'employee_id' => $validated['employee_id'],
                    'request_type' => $validated['request_type'],
                    'leave_type' => $validated['leave_type'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'days' => $validated['days'],
                    'description' => $validated['description'],
                    'attachments' => $attachments,
                    'status' => 'pending' // إعادة تعيين الحالة إلى pending عند التحديث
                ]);

                // إرسال إشعار للموظف إذا لزم الأمر

                return redirect()
                    ->route('attendance.leave_requests.index')
                    ->with('success', 'تم تحديث طلب الإجازة بنجاح وسيتم مراجعته قريباً');

            } catch (\Exception $e) {
                // حذف المرفقات إذا فشل التحديث
                if (isset($filename) && file_exists(public_path('assets/uploads/' . $filename))) {
                    unlink(public_path('assets/uploads/' . $filename));
                }

                return back()
                    ->withInput()
                    ->with('error', 'حدث خطأ أثناء تحديث طلب الإجازة: ' . $e->getMessage());
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ غير متوقع: ' . $e->getMessage());
        }
    }

public function destroy($id)
{
    try {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->delete();
        return redirect()->route('attendance.leave_requests.index')->with('success', 'تم حذف طلب الإجازة بنجاح');
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'حدث خطاء في حذف طلب الإجازة: ' . $e->getMessage());
    }
}
}
