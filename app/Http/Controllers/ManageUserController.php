<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Biodata;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\VarDumper\VarDumper;

use function PHPUnit\Framework\isEmpty;

class ManageUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newUser()
    {
        $roles = Role::all();
        return view('manage.user.create', ['roles' => $roles]);
    }

    public function index()
    {
        $allUsers = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.*', 'roles.id as rid', 'users.id as uid')
            ->where('users.role_id', '!=', 1)
            ->get();
        return view('manage.user.index', ['usersData' => $allUsers]);
    }

    public function verify($id)
    {
        $userData = User::find($id);
        $userData->isVerified = 1;
        $userData->save();
        return redirect()->route('manage.user.index')->with('message', "Akun {$userData->name} berhasil diverifikasi");
    }


    public function reject($id)
    {
        $userData = User::find($id);
        $userData->isVerified = 2;
        $userData->save();
        return redirect()->route('manage.user.index')->with('message', "Akun {$userData->name} telah ditolak");
    }

    public function edit($id)
    {
        $userData = DB::table('users')
            ->where('users.id', '=', $id)
            ->first();
        // return view('manage.user.details', ['userData' => $userData, 'userProfile' => $userProfile, 'userAlamat' => $userAlamat]);
        return view('manage.user.details', ['userData' => $userData]);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'tb_nama_user' => 'required',
            'tb_email_user' => 'required',
            'tb_hp_user' => 'required',
        ]);

        $userData = User::find($id);
        $userData->name = $request->tb_nama_user;
        $userData->email = $request->tb_email_user;
        $userData->no_hp = $request->tb_hp_user;

        return redirect()->route('manage.user.edit', ['id' => $id])->with('message', 'Akun berhasil diupdate');
    }

    public function changePassword(Request $request, $id)
    {
        $userData = User::find($id);
        if (!empty($request->tb_password_user)) {
            $userData->password = Hash::make($request->tb_password_user);
        }
        $userData->save();
        return redirect()->route('manage.user.edit', ['id' => $id])->with('message', 'Password berhasil diganti');
    }

    public function StoreNewAccount(Request $request)
    {
        $user = new User;
        $user->role_id = $request->cb_role;
        $user->name = $request->tb_nama_user;
        $user->email = $request->tb_email_user;
        $user->password = Hash::make($request->tb_password_user);
        $user->no_hp = $request->tb_hp_user;
        $user->save();

        return redirect()->route('manage.user.index')->with('message', "Akun berhasil dibuat");
    }
}
