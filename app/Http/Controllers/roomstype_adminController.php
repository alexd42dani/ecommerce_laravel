<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\roomstype_admin_Store;
use App\Http\Requests\rooms_admin_Update;
use App\type;
use Illuminate\Support\Facades\Hash;

class roomstype_adminController extends Controller
{

    function auth()
    {
        if (session('s_admin') !== null || session('admin') !== null) {
            return true;
        }
        return false;
    }

    public function index()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $result = DB::table('rooms_type')
            ->select(
                'rooms_type.*'
            )
            ->get();

        return view('roomstype_admin', ['results' => $result]);
    }

    public function create()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        return view('roomstype_admin_create');
    }

    public function store(roomstype_admin_Store $request)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $id = DB::table('rooms_type')->insertGetId(
            [
                'name' => request()->name
            ]
        );

        $request->session()->flash('success', 'tipo de habitación creada con éxito!');

        return redirect()->route('roomstype_admin.index');
    }

    public function edit(type $rooms_type)
    {
        $id = $rooms_type->id;
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }
        $results = DB::table('rooms_type')
            ->select('rooms_type.*')
            ->where('rooms_type.id', '=', $id)
            ->get();

        return view('roomstype_admin_edit', [
            'result' => $results
        ]);
    }

    public function update(roomstype_admin_Store $request, $id)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        DB::table('rooms_type')
            ->where('id', $id)
            ->update(
                [
                    'name' => request()->name
                ]
            );

        $request->session()->flash('success', 'Tipo de habitación actualizada con éxito!');

        return redirect()->route('roomstype_admin.index');
    }

    public function destroy(type $rooms_type)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $id = $rooms_type->id;

        DB::table('rooms_type')->where('id', $id)->delete();

        request()->session()->flash('success', 'Tipo de habitación eliminada con éxito!');

        return redirect()->route('roomstype_admin.index');
    }
}
