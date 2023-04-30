<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Categroy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products  = Product::when($request->search,function($query) use($request){
            $query->where('name->ar','like','%'.$request->search.'%');
            $query->orWhere('name->en','like','%'.$request->search.'%');
        })->when($request->cat_id,function($query) use($request){
            $query->where('cat_id',$request->cat_id);
        })->latest()->paginate(5);
        return view('dashboard.products.index',compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categroy::all();
        return view('dashboard.products.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product_data = $request->except(['product_id','image']);
        if($request->image){
            Image::make($request->image)->resize(300,null,function($constraint){
                // aspectRatio function this function aspectRat width and hight
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/'.$request->image->hashName()));
            $product_data['image'] = $request->image->hashName();
        }//end of if
        Product::create($product_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Categroy::all();
        return view('dashboard.products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product_data = $request->except(['product_id']);
        if($request->image && $product->image != 'default.png'){
            Storage::disk('public_uploads',)->delete('/products/'.$product->image);
            Image::make($request->image)->resize(300,null,function($constraint){
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/'.$request->image->hashName()));
            $product_data['image'] = $request->image->hashName();
        }//end of if
        $product->update($product_data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
