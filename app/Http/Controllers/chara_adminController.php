<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\roomstype_admin_Store;
use App\Http\Requests\rooms_admin_Update;
use App\characteristic;
use Illuminate\Support\Facades\Hash;

class chara_adminController extends Controller
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

        $result = DB::table('characteristics')
            ->select(
                'characteristics.*'
            )
            ->get();

        return view('chara_admin', ['results' => $result]);
    }

    public function create()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        return view('chara_admin_create');
    }

    public function store(roomstype_admin_Store $request)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $id = DB::table('characteristics')->insertGetId(
            [
                'name' => request()->name
            ]
        );

        $request->session()->flash('success', 'Caracteristica creada con éxito!');

        return redirect()->route('chara_admin.index');
    }

    public function edit(characteristic $characteristics)
    {
        $id = $characteristics->id;
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }
        $results = DB::table('characteristics')
            ->select('characteristics.*')
            ->where('characteristics.id', '=', $id)
            ->get();

        return view('chara_admin_edit', [
            'result' => $results
        ]);
    }

    public function update(roomstype_admin_Store $request, $id)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        DB::table('characteristics')
            ->where('id', $id)
            ->update(
                [
                    'name' => request()->name
                ]
            );

        $request->session()->flash('success', 'Caracteristica actualizada con éxito!');

        return redirect()->route('chara_admin.index');
    }

    public function destroy(characteristic $characteristics)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $id = $characteristics->id;

        DB::table('characteristics')->where('id', $id)->delete();

        request()->session()->flash('success', 'Caracteristica eliminada con éxito!');

        return redirect()->route('chara_admin.index');
    }
}
