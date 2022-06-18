<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function getAnalytics()
    {
        $service = request('service', 1);

        if($service != 'all')
        {
            $orders = Order::where('service', '=', $service)->selectRaw('status as st')->get();
        } else
        {
            $orders = Order::selectRaw('status as st')->get();
        }

        //ёбаная порнуха, переделать!!! мне не нравится эта мешанина переменных!!!

        $open_orders = $orders->where('st', 1)->count();

        $orders_in_work = $orders->where('st', 2)->count();

        $orders_waiting = $orders->whereIn('st', [3, 4])->count();

        $finished_orders = $orders->where('st', 5)->count();

        $closed_orders = $orders->where('st', 6)->count();

        $canceled_orders = $orders->where('st', 7)->count();

        return [
            'labels' => [ 'Новый', 'В работе', 'На согласовании/Ждет запчасть', 'Готов', 'Закрыт', 'Отказ'],
            'datasets' => array([
                'label' => 'Статистика заказов',
                'backgroundColor' => ['#3f83f8', '#0e9f6e', '#facc15', '#1f2937', '#4b5563', '#9ca3af'],
                'data' => [$open_orders, $orders_in_work, $orders_waiting, $finished_orders, $closed_orders, $canceled_orders]
            ])
        ];
    }
}
