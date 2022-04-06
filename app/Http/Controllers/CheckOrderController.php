<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckOrderController extends Controller
{
    public function index()
    {
        return view('client.checking_order_status');
    }

    public function getOrderForChecking($code)
    {
        $order = Order::with(['statuses', 'services'])
        ->where('code', $code)
        ->first();

        return response()->json($order);
    }
}
