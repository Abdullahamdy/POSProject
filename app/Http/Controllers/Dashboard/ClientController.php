<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {


        $this->middleware(['permission:clients-read'])->only(['index']);
        $this->middleware(['permission:clients-create'])->only(['create']);
        $this->middleware(['permission:clients-update'])->only(['edit']);
        $this->middleware(['permission:clients-delete'])->only(['destroy']);
    }

    public function index(Request $request){
        $clients = Client::when($request->search,function($query) use($request){
            return $query->where('name','like','%'.$request->search.'%');

        })->latest()->paginate(5);
        return view('dashboard.clients.index',compact('clients'));
    } //end of index

    public function create(){
        return view('dashboard.clients.create');
    }//end of create

    public function store(ClientRequest $request){
        $request_data = $request->all();
        $request_data['phone'] = array_filter($request->phone);
        Client::create($request_data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');
    }//end of store

    public function edit(Client $client){
        return view('dashboard.clients.edit',compact('client'));

    } //end of edit

    public function update(ClientRequest $request, Client $client){
        $request_data = $request->all();
        $request_data['phone'] = array_filter($request->phone);
        $client->update($request_data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');

    }//end of update

    public function destroy(Client $client){
        $client->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');

    } //end of destroy


}
