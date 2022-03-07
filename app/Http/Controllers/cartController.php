<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\loginAuth;
use DateTime;

class cartController extends Controller
{

    public function add()
    {
        list($y, $m, $d) = array_pad(explode('-', request()->c_in, 3), 3, 0);
        list($y1, $m1, $d1) = array_pad(explode('-', request()->c_out, 3), 3, 0);
        if (!ctype_digit("$y$m$d") || !ctype_digit("$y1$m1$d1")) {
            return "<div class='alert alert-danger'>
            <ul>
                <li>Fecha no valida</li>
            </ul>
            </div>";
        }
        if (!checkdate($m, $d, $y) || !checkdate($m1, $d1, $y1)) {
            return "<div class='alert alert-danger'>
            <ul>
                <li>Fecha no valida</li>
            </ul>
            </div>";
        }
        //request()->session()->flush();
        // request()->session()->forget('cart',"2");
        //  request()->session()->pull('cart',2);
        // unset($_COOKIE['cart'][5]);
        // request()->session()->forget('cart.');
        //return session('cart');
        /*foreach (session('cart') as $key => $value) {
            if($value === ""){
            }
          }*/
        //$value = request()->session()->pull('cart');
        // unset($value[]);
        //request()->session()->push('cart', $value);
        /* $cart = session()->pull('cart', []); // Second argument is a default value
        if (($key = array_search(2, $cart)) !== false) {
            unset($cart[$key]);
        }
        session()->put('cart', $cart);*/
        // if (session('user') ==! null) {
        //return view('shop');
        //  return"good done!";
        //} else {z

        if (session('cart') !== null) {
            if (in_array(request()->id, session('cart'), true)) {
                return "<div class='alert alert-danger'>
                        <ul>
                            <li>La habitacion ya fue agregada al carrito</li>
                        </ul>
                        </div>";
            }
        }
        if (isset(request()->c_in) && isset(request()->c_out)) {
            $da = strtotime($y . $m . $d);
            $da = date("Y-m-d", $da);
            date_default_timezone_set("America/Asuncion");
            if (date("Y-m-d") > $da) {
                return "<div class='alert alert-danger'>
                        <ul>
                            <li>La fecha no debe ser menor a este dia</li>
                        </ul>
                        </div>";
            }
            if (request()->c_in <= request()->c_out) {

                $exists = DB::table('booking')
                    ->whereRaw('id_rooms = ' . request()->id . ' AND ((check_in BETWEEN "' . request()->c_in . '" AND "' . request()->c_out . '"
                OR check_out BETWEEN "' . request()->c_in . '" AND "' . request()->c_out . '") OR ("' . request()->c_in . '" BETWEEN check_in AND check_out 
                OR "' . request()->c_out . '" BETWEEN check_in AND check_out))')->exists();

                if ($exists) {
                    return "<div class='alert alert-danger'>
                                    <ul>
                                        <li>La habitación ya fue reservada para las fechas especificadas</li>
                                    </ul>
                                    </div>";
                }

                request()->session()->push('cart', request()->id);
                request()->session()->put('check_in' . request()->id, request()->c_in);
                request()->session()->put('check_out' . request()->id, request()->c_out);
                return "<div class='alert alert-success'>
                        <ul>
                            <li>Habitacion agregada al carrito</li>
                        </ul>
                        </div>";
            } else {
                return "<div class='alert alert-danger'>
                                    <ul>
                                        <li>Fecha de entrada no puede ser mayor a fecha de salida</li>
                                    </ul>
                                    </div>";
            }
        } else {
            return "<div class='alert alert-danger'>
                        <ul>
                            <li>Fecha de entrada o fecha de salida están vacías</li>
                        </ul>
                        </div>";
        }
        //}
        //  return view('shop');  
        // return request()->id;
        // dd(session('cart'));
        //return session('cart');
        //return gettype(session('cart'));
    }

    public function delete()
    {
        $cart = session()->pull('cart', []);
        if (($key = array_search(request()->id, $cart)) !== false) {
            request()->session()->forget('check_in' . request()->id);
            request()->session()->forget('check_out' . request()->id);
            unset($cart[$key]);
        }
        if (count($cart)) {
            session()->put('cart', $cart);
        }
    }

    public function getCart()
    {
        if (session('cart') !== null) {
            $result = null;
            $result3['count'] = 0;
            $total = 0;
            foreach (session('cart') as $key => $value) {
                $result3['count']++;
                $room = DB::table('rooms')
                    ->select(
                        'rooms.*',
                        'rt.name as room_type'
                    )
                    ->where('rooms.id', '=', $value)
                    ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
                    ->get();
                // $result .= $room[0]->title;
                $result .= '<div class="single-cart-item">
                    <a href="' . route('shop.detail', [$room[0]->id]) . '" class="product-image">
                        <img src="/img/product-img/' . $room[0]->photo . '" class="cart-thumb" alt="">
                        <!-- Cart Item Desc -->
                        <div class="cart-item-desc">
                            <span class="product-remove" id="cart_remove" path="' . route('cart.delete') . '" room="' . $room[0]->id . '" style="top:1px;right:5px"><i class="fa fa-close" aria-hidden="true"></i></span>
                            <span class="badge">' . $room[0]->room_type . '</span>
                            <h6 style="margin-bottom:0">' . $room[0]->title . '</h6>
                            <p class="price" style="margin-top:0">$' . number_format($room[0]->price,0,'','.') . '</p>
                        </div>
                    </a>
                </div>
                ';
                $check_in = new DateTime(session('check_in' . $room[0]->id));
                $check_out = new DateTime(session('check_out' . $room[0]->id));
                $interval = $check_in->diff($check_out);
                $day = (int) $interval->days;
                ($day !== 0) ?: $day = 1;
                $total += ($day * ((int) $room[0]->price));
            }
            $result1 = '<div class="cart-list">';
            $result2 = '</div>';
            $result1 .= $result . $result2;
            $result3['details'] = $result1;
            $result3['summary'] = '<li><span>subtotal:</span> <span>$'.number_format($total,0,'','.').'</span></li>
            <li><span>total:</span> <span>$'.number_format($total,0,'','.').'</span></li>';
            return $result3;
        } else {
            $result['details'] = "";
            $result['count'] = "";
            $result['summary'] = '<li><span>subtotal:</span> <span>$'."0".'</span></li>
            <li><span>total:</span> <span>$'."0".'</span></li>';
            return $result;
        }
    }
}
