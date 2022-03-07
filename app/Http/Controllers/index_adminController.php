<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class index_adminController extends Controller
{
    public function index()
    {
        date_default_timezone_set("America/Asuncion");
        $year = date('Y');

        $result = DB::table('booking')
            ->selectRaw('MONTH(check_in) AS mth, SUM(total) as sum_total')
            ->where(DB::raw('YEAR(check_in)'), '=', $year)
            ->groupBy(DB::raw('mth'))
            ->get();

        $fec = date('Y-m-d');

        $habi_ocu = DB::table('booking')
            ->whereRaw('("' . $fec . '" BETWEEN check_in AND check_out 
                And check_out != "' . $fec . '") or (check_in="' . $fec . '")')->count();

        $habi_dis = DB::table('rooms')->count();

        if (session('user') !== null) {
            return redirect()->route('index');
        }
        if (session('admin') !== null) {
            return view('index_admin', [
                'results' => $result, 'occupied' => $habi_ocu, 'vacant' => $habi_dis-$habi_ocu
            ]);
        }
        if (session('s_admin') !== null) {
            return view('index_admin', [
                'results' => $result, 'occupied' => $habi_ocu, 'vacant' => $habi_dis-$habi_ocu
            ]);
        }

        return view('login_admin');
    }
}
