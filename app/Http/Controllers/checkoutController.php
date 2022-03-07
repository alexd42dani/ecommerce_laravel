<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\loginAuth;
use DateTime;

class checkoutController extends Controller
{
    public function index()
    {
        if (session('cart') !== null) {
            $result = DB::table('rooms')
                ->select(
                    'rooms.*',
                    'rt.name as room_type'
                )
                ->whereIn('rooms.id', session('cart'))
                ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
                ->get();
            $total = 0;
            $item = [];
            foreach ($result as $key => $value) {
                $check_in = new DateTime(session('check_in' . $result[$key]->id));
                $check_out = new DateTime(session('check_out' . $result[$key]->id));
                $interval = $check_in->diff($check_out);
                $day = (int) $interval->days;
                ($day !== 0) ?: $day = 1;
                $total += ($day * ((int) $result[$key]->price));
                $item[] = array('name' => $result[$key]->title, 'unit_amount' => array('value' => $result[$key]->price, 'currency_code' => 'USD'), 'quantity' => $day);
                //$item[$key]= "{name:'".$result[$key]->title."' ,unit_amount:{value:'".$result[$key]->price."', currency_code: 'USD'} ,quantity:'1'}";
                //$item[]= (['name' => ''.$result[$key]->title.'', 'unit_amount' => '{value:'.''.$result[$key]->price.''.', currency_code:'.''.'USD'.''.' }','quantity'=>'1']);
                //$item[]= (['name' => ''.$result[$key]->title.'', 'unit_amount' => '{value:'.$result[$key]->price.', currency_code:'.'USD'.' }','quantity'=>'1']);
                if (session('user') !== null) {
                    $data[] = [
                        'id_room' => $value->id,
                        'email_customer' => session('user'),
                        'check_in' => $check_in,
                        'check_out' => $check_out
                    ];
                }
            }
            if (isset($data)) {
                DB::table('cart')->where('email_customer', session('user'))->delete();
                DB::table('cart')->insert($data);
            }
            //dump($result);
            //dd(json_encode($item));
            return view('checkout', [
                'results' => $result,
                'total' => $total,
                'items' => $item
            ]);
        }
        return view('checkout', ['total' => 0, 'items' => ""]);
    }

    public function payment()
    {
        if (isset(request()->id) && isset(request()->email) && session('user') !== null) {
            $id_customer = DB::table('customer')
                ->select('customer.id')->where('email', '=', session('user'))->get();

            $cart = DB::table('cart')
                ->select('cart.*')->where('email_customer', '=', session('user'))->get();

            $id = DB::table('sales')->insertGetId(
                [
                    'id_customer' => $id_customer[0]->id, 'date' => now(),
                    'paypal' => request()->id
                ]
            );

            foreach ($cart as $key => $value) {
                $check_in = new DateTime($value->check_in);
                $check_out = new DateTime($value->check_out);
                $interval = $check_in->diff($check_out);
                $day = (int) $interval->days;
                ($day !== 0) ?: $day = 1;
                $room = DB::table('rooms')
                ->select(
                    'rooms.price'
                )
                ->where('rooms.id', $value->id_room)
                ->get();
                $price = ($day*((int)$room[0]->price));
                $data[] = [
                    'id_rooms' => $value->id_room,
                    'check_in' => $value->check_in,
                    'check_out' => $value->check_out,
                    'id_sales' => $id,
                    'days' => $day,
                    'price' => $room[0]->price,
                    'total' => $price
                ];
                request()->session()->forget('check_in' . $value->id_room);
                request()->session()->forget('check_out' . $value->id_room);
            }

            request()->session()->forget('cart');

            DB::table('cart')->where('email_customer', session('user'))->delete();
            DB::table('booking')->insert($data);

            request()->session()->flash('success', 'Transacción completada. Id de transacción = ' . request()->id . ' Email: ' . request()->email);

            return "completed";
        } else {
            return "error";
        }
    }
}
