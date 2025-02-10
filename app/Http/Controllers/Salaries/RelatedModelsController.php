<?php

namespace App\Http\Controllers\Salaries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RelatedModelsController extends Controller
{
public function index()
{
    return view('salaries.sitting.related_models.index');
}
public function create()
{
    return view('salaries.sitting.related_models.create');

}

}
