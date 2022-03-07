<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\registerStore;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller
{

    public function index()
    {
        if (session('user') !== null) {
            return view('index');
        }
        return view('register');
    }

    public function store(registerStore $request)
    {
        // dump(request()->all());

        /* $validatedData = $request->validate([
            'nya' => 'required|max:100',
            'email' => 'unique:customer',
            'direccion' => 'nullable'
        ]);*/

        $code = bin2hex(random_bytes(15));

        $id = DB::table('customer')->insertGetId(
            [
                'name' => request()->name." ".request()->lastname, 'email' => request()->email,
                'password' => Hash::make(request()->pass), 'address' => request()->direccion,
                'contact' => request()->tel, 'code' => $code,
                'created' => now()
            ]
        );
/*
        $subject = 'Verificacion de cuenta';

        $message = '
                    <html>
                    <head>
                    <title>Verificacion de cuenta</title>
                    </head>
                    <body>
                    <h3>Gracias por registrarte!</h3>
                    <p>Activa tu cuenta presionando el link de abajo</p>
                    <a href="http://localhost/ecommerce/activate?code=' . $code . '&user=' . $id . '>Activar Cuenta</a>
                    </body>
                    </html>
                    ';

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        mail(request()->email, $subject, $message, implode("\r\n", $headers));*/

        $request->session()->flash('success', 'Cuenta creada con exito, revisa tu email para activarla.');

        return redirect()->route('register');
    }

    public function activate()
    {
//dd(request()->code);
        if (request()->code == !null && request()->user == !null) {

            $customer = DB::table('customer')
                ->where([
                    ['code', '=', request()->code],
                    ['id', '=', request()->user],
                ])->exists();

            if (!$customer) {
                $err = "Codigo no valido";

                return view('login', ["err"=>$err]);
            } else {

                DB::table('customer')
                    ->where('id', request()->user)
                    ->update(
                        [
                            'status' => 1
                        ]
                    );

                $activate = "La cuenta ha sido activada";

                return view('login', ["activate"=>$activate]);
            }
        } else {
            $err = "Error al activar cuenta";

            return view('login', ["err"=>$err]);
        }
    }
}
