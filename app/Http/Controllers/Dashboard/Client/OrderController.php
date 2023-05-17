<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Models\Client;
use App\Models\Product;
use App\Models\Categroy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        $orders = Order::paginate(5);
        $categories = Categroy::with('product')->get();
        return view('dashboard.clients.orders.create',compact('categories','client','orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        $this->attach_order($request, $client);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.orders.index');

    }//

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function attach_order($request, $client)
    {
        $order = $client->orders()->create([]);


        $order->products()->attach($request->products);

        $total_price = 0;
        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);

        }//end of foreach

        $order->update([
            'total_price' => $total_price
        ]);

    }//end of attach order


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function edit(Client $client ,Order $order){
        $categories = Categroy::with('product')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.edit',compact('client','order','categories','orders'));

     }
     public function update(Request $request,Client $client,Order $order){
        $request->validate([
            'products' => 'required|array',
        ]);
        $this->detach_order($order);
        $this->attach_order($request ,$client);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
     }

     private function detach_order($order){
        foreach($order->products as $product){
            $product->update([
              'stock'=> $product->stock + $product->pivot->quantity,
            ]);
          }
          $order->delete();

     }
    public function destroy($id)
    {
        //
    }
}
