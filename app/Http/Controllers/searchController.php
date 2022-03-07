<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\loginAuth;
use App\room;

class searchController extends Controller
{

    public function search()
    {
        $order = request()->order;
        $order_ = null;
        switch ($order) {
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
                ['title', 'like', '%' . request()->search . '%'],
                ['rooms.status', '=', 1],
            ])
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->get();

        $count = (int) count($result);
        $pages = ceil($count / 9);
        $limit = 9;
        $start = 0;
        $page = ((int) request()->page);
        if ($page > $pages) $page = $pages;
        if (request()->page !== null && request()->page !== "0") {
            $start = ($page * $limit) - $limit;
        }

        $result = DB::table('rooms')
            ->select(
                'rooms.*',
                'rt.name as room_type'
            )
            ->where([
                ['title', 'like', '%' . request()->search . '%'],
                ['rooms.status', '=', 1],
            ])
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->orderBy($order, $order_)
            ->skip($start)->take($limit)
            ->get();

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
            'nro_type' => null,
            'count' => $count,
            'order' => null
        ]);
    }
}
