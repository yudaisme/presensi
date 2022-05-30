<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Validator;

use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['roles'] = Role::where('id', '!=', 1)->orderBy('created_at', 'DESC')->get();

        return Inertia::render('Master/Roles/Index', $data);
    }

    public function storeOrUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);

        $data = $request->except(['id']);
        if ($request->has('id') && $request->id != null) {
            $update = Role::findOrFail($request->id)->update($data);
            if ($update) {
                return redirect()->back()->with('success', 'Role updated');
            } else {
                return redirect()->back()->with('error', 'Failed to update role');
            }
        } else {
            $store = Role::create($data);
            if ($store) {
                return redirect()->back()->with('success', 'Role created');
            } else {
                return redirect()->back()->with('error', 'Failed to create role');
            }
        }
    }

    public function delete($id)
    {
        try {
            Role::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Role deleted');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
