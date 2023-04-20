<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Dashboard\UserRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware(['permission:users-read'])->only(['index']);
        $this->middleware(['permission:users-create'])->only(['create']);
        $this->middleware(['permission:users-update'])->only(['edit']);
        $this->middleware(['permission:users-delete'])->only(['destroy']);

    }
    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->where(function($query) use($request){
          return  $query->when($request->search,function($q) use($request){

            return    $q->where('first_name','like','%'.$request->search.'%')
                ->orwhere('last_name','like','%'.$request->search.'%');
            });
        })->latest()->paginate(5);
        return view('dashboard.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request )
    {
        $user_data = $request->except(['password','password_confirmation','permissions','image']);
        $user_data['password'] = bcrypt($request->password);

        if($request->image){
            Image::make($request->image)->resize(300,null,function($constraint){
                // aspectRatio function this function aspectRat width and hight
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/'.$request->image->hashName()));
            $user_data['image'] = $request->image->hashName();
        }//end of if

        $user = User::create($user_data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user_data = $request->except(['permissions']);
        if($request->image && $user->image != 'default.png'){
            Storage::disk('public_uploads',)->delete('/users/'.$user->image);
            Image::make($request->image)->resize(300,null,function($constraint){
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/'.$request->image->hashName()));
            $user_data['image'] = $request->image->hashName();
        }//end of if
        $user->update($user_data);
        $user->syncPermissions($request->permissions);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->image != 'default.png'){
            Storage::disk('public_uploads',)->delete('/users/'.$user->image);
        }
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');

    }
}
