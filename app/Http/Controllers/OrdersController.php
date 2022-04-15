<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        return view('orders');
    }
    public function getAllOrders()
    {
        $search_term = request('search', '');

        $selected_service = request('selectedService', Auth::user()->service_id);
        $filter = $selected_service == 'all' ? '' : $selected_service;
        $filter_by_open_orders =  request('openOrders') == 'false' ? false : true;

        $orders = Order::with(['statuses', 'services', 'users'])
        ->when($filter, function($query) use ($filter) {
            $query->where('service', $filter);
        })
        ->when($filter_by_open_orders, function($query) {
            $query->where('status', '!=', 6);
        })
        ->search(trim($search_term))
        ->orderBy('id', 'desc')
        ->paginate(30);
       // dd($orders);
        return response()->json($orders);
    }

    public function changeStatus(Request $req)
    {
        $order = Order::find($req->rem_id);
        $story = new Story();

        $order->status = $req->status_id;
        $story->event = $req->status_id;
        $story->user_id = $req->user_id;
        $story->order_id = $req->rem_id;
        $order->save();
        $story->save();
        return response()->json('Статус изменен');
    }


    public function getOpenOrders()
    {
        if (Auth::user()->is_admin)
        {
            $open_orders = Order::where([
                ['status', '!=', 6],
                ['status', '!=', 7]
            ])
            ->count();
        } else
        {
            $open_orders = Order::where([
                ['status', '!=', 6],
                ['status', '!=', 7],
                ['service', '=', Auth::user()->service_id]
            ])
            ->count();
        }


        return response()->json($open_orders);
    }

    public function export($orders)
    {
        $ordersArray = explode(',', $orders);

        return (new OrdersExport($ordersArray))->download('orders.xlsx');
    }
}
