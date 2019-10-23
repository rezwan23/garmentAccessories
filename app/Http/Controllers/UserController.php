<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\User;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:user-create')->only('create');
        $this->middleware('can:user-edit')->only('edit');
        $this->middleware('can:user-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('user.index', [
            'users' => User::paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.create', ['roles'=>Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' =>  'required|unique:users',
            'password'  =>  'required|min:8|confirmed',
            'role_id'   =>  'required',
            'company_id'    =>  '',
        ]);
        $data['company_id'] = auth()->user()->company->id;
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('user.index')->with('success-message', 'User created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(User $user)
    {
        return view('user.edit', ['user'=>$user, 'roles'=>Role::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'name'=>'required',
            'email' =>  'required|unique:users,email,'.$user->id,
            'role_id'   =>  'required',
        ]);
        $user->update($data);
        return redirect()->route('user.index')->with('success-message', 'User Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(User $user)
    {

    }

    public function inactive(User $user)
    {
        $user->update(['status'=>0]);
        return redirect()->route('user.index')->with('success-message', 'User Set to Inactive');
    }

    public function active(User $user)
    {
        $user->update(['status'=>1]);
        return redirect()->route('user.index')->with('success-message', 'User Set to Inactive');
    }

    public function changePassword(Request $request, User $admin)
    {
        $this->validate($request,[
            'password'  =>  'required|confirmed',
        ]);
        if(Hash::check($request->old_password, $admin->password)){
            $admin->update(['password'=>Hash::make($request->password)]);
            return back()->with('success-message', 'Password Changed!');
        }else{
            return back()->withErrors(['error-message'=>'Old Password Didn\'t matched']);
        }
    }

    public function profile()
    {
        return view('user.profile', ['user'=>auth()->user()]);
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        $user->update(['name'=>$request->name, 'email'=>$request->email]);
        return back()->with('success-message', 'Profile Updated!');
    }

    public function passwordForm(User $admin)
    {
        return view('user.change-pass', ['user'=>$admin]);
    }

    public function changePass(Request $request, User $admin)
    {
        $this->validate($request, [
            'password'=> 'required|min:8|confirmed',
        ]);
        $admin->update(['password'=>Hash::make($request->password)]);
        return back()->with('success-message', 'Password Changed Successfully!');
    }
}
