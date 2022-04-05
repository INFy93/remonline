<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckOrderController extends Controller
{
    public function index()
    {
        return view('client.checking_order_status');
    }
}
