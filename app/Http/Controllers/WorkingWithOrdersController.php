<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Story;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class WorkingWithOrdersController extends Controller
{
    public function openOrder($id)
    {
        $order = Order::with('services')->find($id);

        return response()->json($order);
    }

    public function addOrder(Request $req)
    {
        $today = date("Y-m-d H:i:s", time()+60*60*24*4);

        //creating array for db insert from request
        $new_order = [
            'code' => \Stuff::generateOrderCode(),
            'client_login' => $req->order['client_login'],
            'appearance' => $req->order['appearance'],
            'client_phone' => $req->order['client_phone'],
            'malfunction' => $req->order['malfunction'],
            'marks' => $req->order['marks'],
            'model' => $req->order['model'],
            'model_full_name' => $req->order['model_full_name'],
            'product' => $req->order['product'],
            'product_complection' => $req->order['product_complection'],
            'status' => 1,
            //temporary
            'manager_id' => $req->order['manager_id'],
            'service' => Auth::user()->service_id,
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        ];
        Order::insert($new_order);
        $order = Order::orderBy('id', 'desc')->first();
        $story = [
            'user_id' => $req->order['manager_id'],
            'order_id' => $order->id,
            'event' => 1,
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        ];
        Story::insert($story);
        return response()->json("Заказ успешно добавлен");
    }

    public function searchLogin()
    {
    	$key = \Request::get('q');
        $unit = Order::where('client_login','LIKE',"%{$key}%")
        ->select('id', 'client_login', 'client_phone')
        ->orderBy('id', 'desc')
        ->limit(15)
        ->get();

    	return response()->json([ 'client' => $unit ], Response::HTTP_OK);
    }

    public function getStory($id)
    {
        $story = Story::with(['statuses', 'users'])
        ->where('order_id', '=', $id)
        ->get();

        return response()->json($story);
    }

    public function updateOrder(Request $req)
    {
        $order = Order::find($req->ord_id);

        $order->appearance = $req->order['appearance'];
        $order->client_login = $req->order['client_login'];
        $order->client_phone = $req->order['client_phone'];
        $order->updated_at = date("Y-m-d H:i:s");
        $order->malfunction = $req->order['malfunction'];
        $order->marks = $req->order['marks'];
        $order->model = $req->order['model'];
        $order->model_full_name = $req->order['model_full_name'];
        $order->product = $req->order['product'];
        $order->product_complection = $req->order['product_complection'];

        $order->save();

        return response()->json('Заказ успешно обновлен!');
    }

    public function massDelete($orders)
    {
        $orderArray = explode(',', $orders);

        Order::whereKey($orderArray)->delete();

        return response()->noContent();
    }

    public function selectAll()
    {
        $selected_service = request('service', Auth::user()->service_id);
        $filter = $selected_service == 'all' ? '' : $selected_service;

        return Order::
        when($filter, function($query) use ($filter) {
            $query->where('service', $filter);
        })
        ->orderBy('id', 'desc')
        ->pluck('id');
    }

}
