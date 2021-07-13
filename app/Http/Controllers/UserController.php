<?php

namespace App\Http\Controllers;

use App\sysmenu;
use App\sysuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $categories = sysmenu::where('sysmenu_id', '=', '0')
            ->with('childrenCategories')
            ->get();
        return view('master.user', ['data_menu' => $categories]);
        // return view('master.user');
    }

    public function list(Request $request)
    {
        $data = sysuser::select('id', 'uname', 'namalengkap', 'email')->get();
        $tabel['draw']                 = '1';
        $tabel['recordsTotal']         =  count($data);
        $tabel['recordsFiltered']  =  count($data);
        $tabel['data']                 = $data;
        return json_encode($tabel);
    }

    public function tambah(Request $request)
    {
        $categories = sysmenu::where('sysmenu_id', '=', '0')
            ->with('childrenCategories')
            ->get();
        return view('master.useradd', ['data_menu' => $categories]);
        // return view('master.useradd');
    }

    public function simpan(Request $request)
    {
        $user = new sysuser;
        $user->namalengkap = $request->txtnama;
        $user->email = $request->txtemail;
        $user->uname = $request->txtuname;
        $user->upass = $request->txtupass;
        $user->save();
        return view('master.user');
    }

    public function edit(Request $request)
    {
        $categories = sysmenu::where('sysmenu_id', '=', '0')
            ->with('childrenCategories')
            ->get();
        $id = $request->id;
        $data = sysuser::where('id', $id)->first();
        return view('master.useredit', ['user' => $data, 'data_menu' => $categories]);
        // return view('master.useredit', []);
    }

    public function update(Request $request)
    {
        $id     = $request->txtid;
        $sysuser = new sysuser;
        $sysuser->where('id', $id)
            ->update([
                'namalengkap' => $request->txtnama,
                'email' => $request->txtemail,
                'uname' => $request->txtuname,
                'upass' => $request->txtupass,
            ]);
        return view('master.user');
    }
}
