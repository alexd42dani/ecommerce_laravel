<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\users_admin_Update;
use App\admin;
use Illuminate\Support\Facades\Hash;

class users_adminController extends Controller
{

    function auth()
    {
        if (session('s_admin') !== null) {
            return true;
        }
        return false;
    }

    public function index()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $result = DB::table('admins')
            ->select(
                'admins.*'
            )
            ->get();

        // dd($estadia);

        return view('users_admin', ['results' => $result]);
    }

    public function edit(admin $admin)
    {
        $id = $admin->id;
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }
        $results = DB::table('admins')
            ->select('admins.*')
            ->where('id', '=', $id)
            ->get();

        return view('users_admin_edit', [
            'results' => $results
        ]);
    }

    public function update(users_admin_Update $request, $id)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }
        //dd($request->nya);
        DB::table('admins')
            ->where('id', $id)
            ->update(
                [
                    'name' => request()->name." ".request()->lastname, 'created' => now(),
                    'status' => request()->estado, 'level' => request()->nivel
                ]
            );

        if (request()->pass !== null) {
            DB::table('admins')
                ->where('id', $id)
                ->update(
                    [
                        'password' => Hash::make(request()->pass)
                    ]
                );
        }

        $request->session()->flash('success', 'Usuario actualizado con éxito!');

        return redirect()->route('users_admin');
    }

    public function destroy(admin $admin)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $id = $admin->id;

        DB::table('admins')->where('id', $id)->delete();

        request()->session()->flash('success', 'Usuario eliminado con éxito!');

        return redirect()->route('users_admin');
    }
}
