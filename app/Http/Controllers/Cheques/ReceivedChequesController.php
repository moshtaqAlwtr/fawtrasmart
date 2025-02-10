<?php

namespace App\Http\Controllers\Cheques;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReceivedChequeRequest;
use App\Models\ReceivedCheque;
use Illuminate\Http\Request;

class ReceivedChequesController extends Controller
{
    public function index()
    {
        $received_cheques = ReceivedCheque::select()->orderBy('id', 'desc')->get();
        return view('cheques.received_cheques.index', compact('received_cheques'));
    }

    public function create()
    {
        return view('cheques.received_cheques.create');
    }

    public function store(ReceivedChequeRequest $request)
    {
        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'rar', 'zip', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'];
            $maxFileSize = 5 * 1024 * 1024;

            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            if (!in_array(strtolower($extension), $allowedExtensions)) {
                return back()->withErrors(['attachment' => 'نوع الملف غير مدعوم.']);
            }

            if ($fileSize > $maxFileSize) {
                return back()->withErrors(['attachment' => 'حجم الملف يجب أن لا يتجاوز 5 ميجابايت.']);
            }

            $attachmentPath = $file->store('assets/uploads/cheques/attachments', 'public');
        }

        ReceivedCheque::create([
            'amount' => $request->amount,
            'cheque_number' => $request->cheque_number,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'endorsement' => $request->endorsement,
            'collection_account_id' => $request->collection_account_id,
            'recipient_account_id' => $request->recipient_account_id,
            'attachment' => $attachmentPath,
            'description' => $request->description,
            'payee_name' => $request->payee_name,
            'name' => $request->name
        ]);

        return redirect()->route('received_cheques.index')->with(['success' => 'تم إضافة الشيك المستلم بنجاح']);
    }

    public function edit($id)
    {
        $received_cheque = ReceivedCheque::findOrFail($id);
        return view('cheques.received_cheques.edit', compact('received_cheque'));
    }

    public function update(ReceivedChequeRequest $request, $id)
    {
        $received_cheque = ReceivedCheque::findOrFail($id);

        $received_cheque->amount = $request->amount;
        $received_cheque->cheque_number = $request->cheque_number;
        $received_cheque->issue_date = $request->issue_date;
        $received_cheque->due_date = $request->due_date;
        $received_cheque->endorsement = $request->endorsement;
        $received_cheque->collection_account_id = $request->collection_account_id;
        $received_cheque->recipient_account_id = $request->recipient_account_id;
        $received_cheque->description = $request->description;
        $received_cheque->payee_name = $request->payee_name;
        $received_cheque->name = $request->name;

        if ($request->hasFile('attachment')) {
            $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'rar', 'zip', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'];
            $maxFileSize = 5 * 1024 * 1024;

            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            if (!in_array(strtolower($extension), $allowedExtensions)) {
                return back()->withErrors(['attachment' => 'نوع الملف غير مدعوم.']);
            }

            if ($fileSize > $maxFileSize) {
                return back()->withErrors(['attachment' => 'حجم الملف يجب أن لا يتجاوز 5 ميجابايت.']);
            }

            $attachmentPath = $file->store('assets/uploads/cheques/attachments', 'public');
            $received_cheque->attachment = $attachmentPath;
        }

        $received_cheque->update();

        return redirect()->route('received_cheques.index')->with(['success' => 'تم تعديل الشيك المستلم بنجاح']);
    }

    public function show($id)
    {
        $received_cheque = ReceivedCheque::findOrFail($id);
        return view('cheques.received_cheques.show', compact('received_cheque'));
    }


}
