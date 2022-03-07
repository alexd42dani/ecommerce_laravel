<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\rooms_admin_Store;
use App\Http\Requests\rooms_admin_Update;
use App\room;
use Illuminate\Support\Facades\Hash;

class rooms_adminController extends Controller
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
                'rooms.*',
                'rt.name'
            )
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->get();

        return view('rooms_admin', ['results' => $result]);
    }

    public function create()
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }
        $types = DB::table('rooms_type')->get();
        $characteristics = DB::table('characteristics')->get();

        return view('rooms_admin_create', [
            'types' => $types,
            'characteristics' => $characteristics,
        ]);
    }

    public function store(rooms_admin_Store $request)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $imageName = '1-' . $request->photo->getClientSize() . '-' . time() . '.' . $request->photo->extension();
        $imageName1 = '2-' . $request->photo1->getClientSize() . '-' . time() . '.' . $request->photo1->extension();
        $id = DB::table('rooms')->insertGetId(
            [
                'title' => request()->title, 'description' => request()->description,
                'photo' => $imageName, 'photo1' => $imageName1, 'price' => request()->price,
                'status' => request()->estado, 'id_type' => request()->type
            ]
        );
        $request->photo->move(public_path('\img\product-img\\'), $imageName);
        $request->photo1->move(public_path('\img\product-img\\'), $imageName1);
        //$request->photo->storeAs(public_path().'\img\product-img\\', $imageName);

        foreach ($request->input as $key => $value) {
            $data[] = [
                'id_room' => $id,
                'id_characteristic' => $value
            ];
        }
        DB::table('room_characteristics')->insert($data);

        $request->session()->flash('success', 'Habitación creada con éxito!');

        return redirect()->route('rooms_admin.index');
    }

    public function edit(room $room)
    {
        $id = $room->id;
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }
        $results = DB::table('rooms')
            ->select('rooms.*', 'rt.name as name')
            ->where('rooms.id', '=', $id)
            ->leftJoin('rooms_type as rt', 'rooms.id_type', '=', 'rt.id')
            ->get();

        $chara = DB::table('room_characteristics')
            ->select('room_characteristics.*', 'c.name as name')
            ->where('id_room', '=', $id)
            ->leftJoin('characteristics as c', 'room_characteristics.id_characteristic', '=', 'c.id')
            ->get();

        $types = DB::table('rooms_type')->get();
        $characteristics = DB::table('characteristics')->get();

        return view('rooms_admin_edit', [
            'result' => $results,
            'chara' => $chara,
            'types' => $types,
            'characteristics' => $characteristics,
        ]);
    }

    public function update(rooms_admin_Update $request, $id)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        DB::table('rooms')
            ->where('id', $id)
            ->update(
                [
                    'title' => request()->title, 'description' => request()->description,
                    'price' => request()->price,
                    'status' => request()->estado, 'id_type' => request()->type
                ]
            );

        DB::table('room_characteristics')->where('id_room', $id)->delete();

        foreach ($request->input as $key => $value) {
            $data[] = [
                'id_room' => $id,
                'id_characteristic' => $value
            ];
        }
        DB::table('room_characteristics')->insert($data);

        if (request()->photo !== null) {
            $imageName = '1-' . $request->photo->getClientSize() . '-' . time() . '.' . $request->photo->extension();
            DB::table('rooms')
                ->where('id', $id)
                ->update(
                    [
                        'photo' => $imageName
                    ]
                );
            $request->photo->move(public_path('\img\product-img\\'), $imageName);
        }
        if (request()->photo1 !== null) {
            $imageName1 = '2-' . $request->photo1->getClientSize() . '-' . time() . '.' . $request->photo1->extension();
            DB::table('rooms')
                ->where('id', $id)
                ->update(
                    [
                        'photo1' => $imageName1
                    ]
                );
            $request->photo1->move(public_path('\img\product-img\\'), $imageName1);
        }

        $request->session()->flash('success', 'Habitación actualizada con éxito!');

        return redirect()->route('rooms_admin.index');
    }

    public function destroy(room $room)
    {
        if (!$this->auth()) {
            return redirect()->route('login_admin');
        }

        $id = $room->id;

        try {

            DB::table('room_characteristics')->where('id_room', $id)->delete();
            DB::table('rooms')->where('id', $id)->delete();
        } catch (\Exception $e) {
            request()->session()->flash('error_', $e->getMessage());

            return redirect()->route('rooms_admin.index');
        }

        request()->session()->flash('success', 'Habitación eliminada con éxito!');

        return redirect()->route('rooms_admin.index');
    }
}
