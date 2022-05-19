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

        $open_orders = $orders->whereNotIn('st', [6, 7])->count();

        $finished_orders = $orders->where('st', 5)->count();

        $closed_orders = $orders->where('st', 6)->count();

        return [
            'labels' => [ 'Открытые заказы', 'Выполненные заказы', 'Закрытые заказы'],
            'datasets' => array([
                'label' => 'Статистика заказов',
                'backgroundColor' => ['#3f83f8', '#1f2937', '#4b5563'],
                'data' => [$open_orders, $finished_orders, $closed_orders]
            ])
        ];
    }
}
