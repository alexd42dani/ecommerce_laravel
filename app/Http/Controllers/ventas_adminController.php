<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\users_admin_Update;
use App\admin;
use Illuminate\Support\Facades\Hash;

class ventas_adminController extends Controller
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

        $sales = DB::table('sales')
            ->select(
                'sales.*',
                'c.name as name'
            )
            ->leftJoin('customer as c', 'sales.id_customer', '=', 'c.id')
            ->orderBy('sales.id', 'desc')
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

        return view('ventas_admin', [
            'sales' => $sales,
            'details' => $details,
            'totals' => $totals,
            'id' => request()->id
        ]);
    }
}
