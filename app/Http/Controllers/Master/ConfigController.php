<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Config;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['config'] = Config::latest()->first();

        return Inertia::render('Master/Config/Index', $data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required|min:-180|max:180',
            'longitude' => 'required|max:180',
            'radius' => 'required|min:0|max:99999',
            'jam_hadir' => 'required',
            'jam_pulang' => 'required',
        ]);

        $data = $request->except(['id','jam_hadir','jam_pulang']);
        $data['jam_hadir'] = join(':', $request->jam_hadir);
        $data['jam_pulang'] = join(':', $request->jam_pulang);

        try {
            Config::findOrFail($request->id)->update($data);
            return redirect()->back()->with('success', 'Config Updated');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
