<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\loginAuth;

class loginController extends Controller
{
   
    public function index()
    {
        //dump(session()->get('user'));
        //dump(session('user'));
        if(session('user') !== null){
            return view('index');
        }
        return view('login');
    }

    public function auth(loginAuth $request){
        /*$customer = DB::table('customer')->where('email', request()->email)->exists();
        //$customer1 = DB::table('customer')->where('email', request()->email)->count();
        //dd($customer,$customer1);
        if($customer){
            $hashedPassword = DB::table('customer')->select('password')->get();
            if (Hash::check(request()->pass, $hashedPassword)) {
                return view('index');
            }else{
                dd('pass');
            }
        }else{
            dd("correo");
        }*/

        $request->session()->put('user', request()->email);

        if(session('cart') !== null){
            return redirect()->route('checkout');
        }
        return redirect()->route('index');
    }

    public function logout(request $request){
        $request->session()->forget('user');
        return view('login');
    }
  
}
