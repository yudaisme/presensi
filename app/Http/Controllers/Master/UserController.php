<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Validator;

use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['users'] = User::with(['role'])->where('role_id', '!=', 1)->orderBy('created_at', 'DESC')->get();
        $data['roles'] = Role::where('id', '!=', 1)->orderBy('name', 'ASC')->get()->toArray();

        return Inertia::render('Master/Users/Index', $data);
    }

    public function storeOrUpdate(Request $request)
    {
        $emailRule = '';
        $passwordRule = '';

        if ($request->has('id') && $request->id != null) {
            $emailRule = 'required|max:100|unique:users,email,'.$request->id;
            $passwordRule = 'min:8';
        } else {
            $emailRule = 'required|max:100|unique:users,email';
            $passwordRule = 'required|max:100|min:8';
        }
        
        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => $emailRule,
            'password' => $passwordRule,
            'photo' => 'mimes:jpg,jpeg,png',
        ]);

        $data = $request->except(['id','password','photo','old_photo']);
        $data['role_id'] = 2;
        if ($request->has('id') && $request->id != null) {
            if ($request->has('password') && $request->password != null) {
                $data['password'] = bcrypt($request->password);
            }

            if ($request->hasFile('photo') && $request->file('photo') != null) {
                if (is_file(public_path($request->old_photo))) {
                    unlink(public_path($request->old_photo));
                }

                $file = $request->file('photo');
                $ext = $file->getClientOriginalExtension();
                $filename = time().".".$ext;
                $file->move(public_path('/images/users'), $filename);
                $data['photo'] = '/images/users/'.$filename;
            }

            $update = User::findOrFail($request->id)->update($data);
            if ($update) {
                return redirect()->back()->with('success', 'User updated');
            } else {
                return redirect()->back()->with('error', 'Failed to update user');
            }
        } else {
            if ($request->has('password') && $request->password != null) {
                $data['password'] = bcrypt($request->password);
            }

            if ($request->hasFile('photo') && $request->file('photo') != null) {
                $file = $request->file('photo');
                $ext = $file->getClientOriginalExtension();
                $filename = time().".".$ext;
                $file->move(public_path('/images/users'), $filename);
                $data['photo'] = '/images/users/'.$filename;
            }
            $store = User::create($data);
            if ($store) {
                return redirect()->back()->with('success', 'User created');
            } else {
                return redirect()->back()->with('error', 'Failed to create user');
            }
        }
    }
}
