<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Categroy;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index(){
        $products_count = Product::count();
        $categories_count = Categroy::count();
        $users_count = User::whereRoleIs('admin')->count();
        $clients_count = Client::count();
        $sales_data = Order::select(
            \DB::raw('YEAR(created_at) as year'),
            \DB::raw('MONTH(created_at) as month'),
            \DB::raw('SUM(total_price) as total_price')

        )->groupBy('month')->get();
        return view('dashboard.welcome',get_defined_vars());


    }


}
