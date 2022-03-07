<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\image_admin_Store;
use App\Http\Requests\rooms_admin_Update;
use App\room;
use Illuminate\Support\Facades\Hash;

class calendar_adminController extends Controller
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

        $result = DB::table('rooms')
            ->select(
                'rooms.*'
            )
            ->get();
        return view('calendar_admin', ['results' => $result, 'id_selected' => request()->habi, 
                                    'item' => null]);
    }

    public function index_()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $result = DB::table('rooms')
            ->select(
                'rooms.*'
            )
            ->get();

        $result_ = DB::table('booking')
            ->select(
                'booking.*'
            )
            ->where('booking.id_rooms', request()->habi)
            ->get();
        $item = "";
        if (count($result)) {
            foreach ($result_ as $key => $result1) {
                if ($key == 0) {
                    $item .= json_encode(array('title' => ' - Reserva','url'=> route('ventas_admin',['id'=>$result1->id_sales]),'start' => $result1->check_in.'T13:00:00', 'end' => $result1->check_out.'T23:59:59'));
                } else {
                    $item .= "," . json_encode(array('title' => ' - Reserva','url'=> route('ventas_admin',['id'=>$result1->id_sales]) , 'start' => $result1->check_in.'T13:00:00', 'end' => $result1->check_out.'T23:59:59'));
                }
            }
        }
        //dd($item);

        return view('calendar_admin', [
            'results' => $result, 'id_selected' => request()->habi,
            'item' => $item
        ]);
    }
}
