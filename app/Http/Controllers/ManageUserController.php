<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $allUsers = User::all();
        return view('manage.user.index', ['usersData' => $allUsers]);
    }

    function verify($id)
    {
        $userData = User::find($id);
        $userData->isVerified = 1;
        $userData->save();
        return redirect()->route('manage.user.index')->with('message', "Akun {$userData->name} berhasil diverifikasi");
    }


    function reject($id)
    {
        $userData = User::find($id);
        $userData->isVerified = 2;
        $userData->save();
        return redirect()->route('manage.user.index')->with('message', "Akun {$userData->name} telah ditolak");
    }

    function edit($id)
    {
        $userData = User::find($id);
        $userProfile = Biodata::where('user_id', $id);
        // dd($userProfile);
        return view('manage.user.details', ['userData' => $userData, 'userProfile' => $userProfile]);
    }

    function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'tb_nama_user' => 'required',
            'tb_email_user' => 'required',
            'tb_hp_user' => 'required'
        ]);

        $userData = User::find($id);
        $userData->name = $request->tb_nama_user;
        $userData->email = $request->tb_email_user;
        $userData->no_hp = $request->tb_hp_user;
        $userData->save();
        return redirect()->route('manage.user.edit', ['id' => $id])->with('message', 'Akun berhasil diupdate');
    }

    function changePassword(Request $request, $id){
        $userData = User::find($id);
        if (!empty($request->tb_password_user)) {
            $userData->password = Hash::make($request->tb_password_user);
        }
        $userData->save();
        return redirect()->route('manage.user.edit', ['id' => $id])->with('message', 'Password berhasil diganti');
    }
}
