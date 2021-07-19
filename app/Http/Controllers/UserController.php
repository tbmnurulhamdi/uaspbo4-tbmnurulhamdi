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
    }

    public function simpan(Request $request)
    {
        $user = new sysuser;
        $user->namalengkap = $request->txtnama;
        $user->email = $request->txtemail;
        $user->uname = $request->txtuname;
        $user->upass = $request->txtupass;
        $user->save();
        $categories = sysmenu::where('sysmenu_id', '=', '0')
            ->with('childrenCategories')
            ->get();
        return view('master.user', ['data_menu' => $categories]);
    }

    public function edit(Request $request)
    {
        $categories = sysmenu::where('sysmenu_id', '=', '0')
            ->with('childrenCategories')
            ->get();
        $id = $request->id;
        $data = sysuser::where('id', $id)->first();
        return view('master.useredit', ['user' => $data, 'data_menu' => $categories]);
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
        $categories = sysmenu::where('sysmenu_id', '=', '0')
            ->with('childrenCategories')
            ->get();
        return view('master.user', ['data_menu' => $categories]);
    }
}
