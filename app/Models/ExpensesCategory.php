<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesCategory extends Model
{
    use HasFactory;
    protected $table = 'expenses_categories';
    protected $fillable = ['id', 'name', 'status', 'description', 'created_at', 'updated_at'];
}
