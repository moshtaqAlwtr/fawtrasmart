<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentsProcess extends Model
{
    protected $table = 'payments_process';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['clients_id', 'purchases_id', 'invoice_id', 'employee_id', 'treasury_id','installment_id','type', 'payment_date', 'amount', 'payment_status', 'payment_method', 'reference_number', 'payment_data', 'notes', 'attachments'];

    protected $casts = [
        'invoice_id' => 'integer',
        'amount' => 'float',
        'payment_date' => 'datetime',
        'employee_id' => 'integer',
        'clients_id' => 'integer',
        'purchases_id' => 'integer',
        'treasury_id' => 'integer',
        'payment_status' => 'integer',
        'payment_method' => 'integer',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'clients_id');
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchases_id');
    }

    public function treasury()
    {
        return $this->belongsTo(Treasury::class, 'treasury_id');
    }
}
