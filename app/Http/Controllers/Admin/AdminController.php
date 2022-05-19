<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Exports\MonthOrdersExport;
use Illuminate\Http\Request;
use App\Models\Option;
use Illuminate\Support\Facades\Hash;
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
        return response()->json(User::with(['roles', 'services'])->get());
    }

    public function addUser(Request $req)
    {
        $user = [
            'name' => $req->user['userName'],
            'login' => $req->user['userLogin'],
            'email' => $req->user['userEmail'],
            'password' => Hash::make($req->user['userPass']),
            'service_id' => $req->service,
            'is_admin' => $req->user['userIsAdmin'] ? 1 : 0,
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        ];

        User::insert($user);

        return response()->json("Юзер успешно добавлен!");
    }

    public function blockUser($id)
    {
       $user = User::where('id', $id)->first();

       if ($user->blocked == 0)
       {
           $user->blocked = 1;
           $message = "Пользователь заблокирован.";
       } else
       {
           $user->blocked = 0;
           $message = "Пользователь разблокирован.";
       }

       $user->save();

       return response()->json($message);
    }

    public function editUser($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    public function updateUser(Request $req)
    {
        $user = User::where('id', '=', $req->user_id)->first();

        $user->name = $req->user['userName'];
        $user->login = $req->user['userLogin'];
        $user->email = $req->user['userEmail'];
        $user->service_id = $req->service;
        if ($req->user['userPass'] != '')
        {
            $user->password =  Hash::make($req->user['userPass']);
        }
        $user->is_admin = $req->user['userIsAdmin'] ? 1 : 0;
        $user->updated_at = date("Y-m-d H:i:s");

        $user->save();

        return response()->json($req);
    }

    public function switchService($order_id, $service_id)
    {
        $order = Order::find($order_id);

        $order->service = $service_id;

        $order->save();

        return response()->noContent();
    }
}
