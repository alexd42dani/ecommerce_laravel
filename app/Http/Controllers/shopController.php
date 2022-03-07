<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\loginAuth;
use App\room;

class shopController extends Controller
{

    public function index()
    {
        //dump(session()->get('user'));
        //dump(session('user'));
        /*  if(session('user') ==! null){
            return view('shop');
        }*/
        //return view('shop');

        $order = request()->order;
        $order_ = null;
        switch($order){
            case 1:
                $order = "id";
                $order_ = "asc";
            break;
            case 2:
                $order = "id";
                $order_ = "desc";
            break;
            case 3:
                $order = "price";
                $order_ = "asc";
            break;
            case 4: 
                $order = "price";
                $order_ = "desc";
            break;
            default:
            $order = "id";
            $order_ = "asc";
        }
        
        $result = DB::table('rooms')
            ->select(
                'rooms.*',
                'rt.name as room_type'
            )
            ->where([
                ['rooms.id_type', '=', request()->type],
                ['rooms.status', '=', 1],
            ])
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->get();

        $nro_type = null;    
        if (count($result)) {
            $nro_type = request()->type;
        }

        if (!count($result)) {
            $result = DB::table('rooms')
                ->select(
                    'rooms.*',
                    'rt.name as room_type'
                )
                ->where('rooms.status', '=', 1)
                ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
                ->get();
        }

        $count = (int) count($result);
        $pages = ceil($count / 9);
        $limit = 9;
        $start = 0;
        $page = ((int) request()->page);
        if ($page > $pages) $page = $pages;
        if (request()->page !== null && request()->page !== "0") {
            $start = ($page * $limit) - $limit;
        }
        if ($page === 0) $page = 1;
        //  dd($result);

        $result = DB::table('rooms')
            ->select(
                'rooms.*',
                'rt.name as room_type'
            )
            ->where([
                ['rooms.id_type', '=', request()->type],
                ['rooms.status', '=', 1],
            ])
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->orderBy($order, $order_)
            ->skip($start)->take($limit)   
            ->get();

        if (!count($result)) {
            $result = DB::table('rooms')
                ->select(
                    'rooms.*',
                    'rt.name as room_type'
                )
                ->where('rooms.status', '=', 1)
                ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
                ->orderBy($order, $order_)
                ->skip($start)->take($limit)
                ->get();
        }

        $types = DB::table('rooms_type')
            ->select(
                'rooms_type.*'
            )
            ->get();

        return view('shop', [
            'results' => $result,
            'pages' => $pages,
            'selected' => $page,
            'types' => $types,
            'nro_type' => $nro_type,
            'count' => $count,
            'order' => request()->order
        ]);
    }

    public function detail(room $room)
    {
        $id = $room->id;
        $room1 = DB::table('rooms')
            ->select(
                'rooms.*',
                'rt.name as room_type'
            )
            ->where('rooms.id', '=', $id)
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->get();

        $charact = DB::table('room_characteristics')
            ->select(
                'c.*'
            )
            ->where('id_room', '=', $id)
            ->leftJoin('characteristics as c', 'c.id', '=', 'room_characteristics.id_characteristic')
            ->get();

        /*return view('detail', ['rooms' => $rooms,
                            'rooms_type' => $rooms_type]);*/
        return view('detail', [
            'rooms' => $room1,
            'characteristics' => $charact
        ]);
    }
}
