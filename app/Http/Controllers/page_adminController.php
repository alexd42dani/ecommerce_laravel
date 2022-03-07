<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\image_admin_Store;
use App\Http\Requests\rooms_admin_Update;
use App\room;
use Illuminate\Support\Facades\Hash;

class page_adminController extends Controller
{

    function auth()
    {
        if (session('s_admin') !== null || session('admin') !== null) {
            return true;
        }
        return false;
    }

    public function create_image()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        return view('imagen_admin_create');
    }

    public function store_image(image_admin_Store $request)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $imageName = 'index.' . $request->photo->extension();

        DB::table('image')->delete();

        $id = DB::table('image')->insert(
            [
                'name' => $imageName
            ]
        );

        $request->photo->move(public_path('\img\bg-img\\'), $imageName);

        $request->session()->flash('success', 'Imagen agregada con éxito!');

        return redirect()->route('image.create');
    }

    public function create_recommended()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $result = DB::table('rooms')
            ->select(
                'rooms.*',
                'rt.name'
            )
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->get();

        return view('recommended_admin', ['results' => $result]);
    }

    public function store_recommended()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }
        
        DB::table('rooms')
        ->where('id', request()->id)
        ->update(
            [
                'recommended' => (int)request()->check
            ]
        );

        return (int)request()->check;
    }


}
