<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class indexController extends Controller
{
   
    public function index()
    {
        $photo = DB::table('image')->get();
        $result = DB::table('rooms')
            ->select(
                'rooms.*',
                'rt.name as room_type'
            )
            ->where([
                ['rooms.recommended', '=', 1],
                ['rooms.status', '=', 1],
            ])
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->get();
        return view('index', [
            'photo' => $photo,
            'results' => $result
        ]);
    }
  
}
