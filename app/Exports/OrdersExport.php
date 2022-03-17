<?php

namespace App\Exports;

use App\Models\Order;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class OrdersExport implements WithHeadings, FromCollection, WithMapping
{
    use Exportable;
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {

        return Order::with(['statuses', 'services', 'users'])
        ->whereKey($this->orders)
        ->orderBy('id', 'desc')
        ->get();
    }

    public function map($ord) : array {
        return [
           $ord->id,
           $ord->statuses->name,
           $ord->users->name,
           $ord->created_at = date("d.m.Y H:i", strtotime($ord->created_at)),
           $ord->product,
           $ord->model,
           $ord->model_full_name,
           $ord->complection,
           $ord->malfunction,
           $ord->client_login,
           $ord->client_phone
        ] ;


    }

    public function headings(): array
    {
        return [
            '#',
            'Статус',
            'Создан',
            'Дата создания',
            'Изделие',
            'Модель',
            'Полная модель',
            'Комплектация',
            'Неисправность',
            'Клиент',
            'Телефон клиента',
        ];
    }
}
