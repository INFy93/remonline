<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Exports\MonthOrdersExport;
use Illuminate\Http\Request;
use App\Models\Option;
class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function getTotalData()
    {
        $all_orders = Order::all()->count();

        $open_orders = Order::where([
            ['status', '!=', 6],
            ['status', '!=', 7]
        ])
        ->count();

        $current_orders = Order::where('status', 2)->count();

        $result = [
            'all' => $all_orders,
            'open' => $open_orders,
            'current' => $current_orders
        ];

        return response()->json($result);
    }

    public function getAllSettings()
    {
        return response()->json(Option::all());
    }

    public function exportMonth()
    {
        return (new MonthOrdersExport)->download('orders_month.xlsx');
    }

    public function getUsers()
    {
        return response()->json(User::with(['roles'])->get());
    }
}
