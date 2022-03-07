<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\login_adminAuth;

class login_adminController extends Controller
{

    public function index()
    {
        //dump(session()->get('user'));
        //dump(session('user'));
        if (session('user') !== null) {
            return redirect()->route('index');
        }
        if (session('admin') !== null || session('s_admin') !== null) {
            return redirect()->route('index_admin');
        }
        return view('login_admin');
    }

    public function auth(login_adminAuth $request)
    {
        $level = DB::table('admins')
            ->select('level')
            ->where('email', '=', request()->email)
            ->get();
        if (count($level)) {
            if ($level[0]->level === 0) {
                $request->session()->put('admin', request()->email);
            } else {
                $request->session()->put('s_admin', request()->email);
            }
        }
        return redirect()->route('index_admin');
    }

    public function logout(request $request)
    {
        $request->session()->forget('admin');
        $request->session()->forget('s_admin');
        if (session('user') !== null) {
            return redirect()->route('index');
        }
        return view('login_admin');
    }
}
