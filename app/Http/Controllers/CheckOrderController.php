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

    public function getOrderForChecking($id)
    {
        $order = Order::with(['statuses', 'users'])
        ->where('id', $id)
        ->first();

        return response()->json($order);
    }
}
