<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::paginate(5);
        // dd($orders);
        return view('dashboard.orders.index',compact('orders'));
    }
}
