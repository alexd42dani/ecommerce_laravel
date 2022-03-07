<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\profileUpdate;
use App\Http\Requests\loginAuth;
use App\customer;

class profileControler extends Controller
{

    function auth()
    {
        if (session('user') !== null) {
            return true;
        }
        return false;
    }

    public function index()
    {
        if (!$this->auth()) {
            return redirect()->route('login');
        }
        $result = DB::table('customer')
            ->select(
                'customer.*'
            )
            ->where('customer.email', '=', session('user'))
            ->get();

        $sales = DB::table('sales')
            ->select(
                'sales.*'
            )
            ->where('id_customer', '=', $result[0]->id)
            ->orderBy('id', 'desc')
            ->get();

        $details = null;
        $total = 0;
        if (isset($sales)) {
            foreach ($sales as $key => $value) {
                $details[$value->id] = DB::table('booking')
                    ->select(
                        'booking.*',
                        'r.title as title'
                    )
                    ->where('id_sales', '=', $value->id)
                    ->leftJoin('rooms as r', 'booking.id_rooms', '=', 'r.id')
                    ->get();
                foreach ($details[$value->id] as $key => $value1) {
                    $total += $value1->total;
                }
                $totals[$value->id] = $total;
                $total = 0;
            }   
        }
        return view('profile', [
            'results' => $result,
            'sales' => $sales,
            'details' => $details,
            'totals' => $totals
        ]);
    }

    public function edit()
    {
        if (!$this->auth()) {
            return redirect()->route('login');
        }
        $results = DB::table('customer')
            ->select('customer.*')
            ->where('email', '=', session('user'))
            ->get();

        return view('profile_edit', [
            'results' => $results
        ]);
    }

    public function update(profileUpdate $request, $id)
    {
        if (!$this->auth()) {
            return redirect()->route('login');
        }
        //dd($request->nya);
        DB::table('customer')
            ->where('id', $id)
            ->update(
                [
                    'name' => request()->name." ".request()->lastname, 'created' => now(),
                    'address' => request()->direccion, 'contact' => request()->tel
                ]
            );

        if (request()->pass !== null) {
            DB::table('customer')
                ->where('id', $id)
                ->update(
                    [
                        'password' => Hash::make(request()->pass)
                    ]
                );
        }

        $request->session()->flash('success', 'Usuario actualizado con éxito!');

        return redirect()->route('profile');
    }
}
