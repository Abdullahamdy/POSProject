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
    }




    public function create(){
        return view('dashboard.clients.create');
    }

    public function store(ClientRequest $request){

        Client::create($request->validated());
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    public function edit(Client $client){
        return view('dashboard.clients.edit',compact('client'));

    }

    public function update(ClientRequest $request, Client $client){

        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');

    }


}
