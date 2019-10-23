<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YarnOrderController extends Controller
{
    public function showForm()
    {
        return view('order.yarn.show-form');
    }
}
