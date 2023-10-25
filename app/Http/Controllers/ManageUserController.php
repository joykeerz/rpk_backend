<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('manage.user.details', ['userData' => $userData]);
    }


}
