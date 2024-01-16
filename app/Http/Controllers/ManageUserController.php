<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Biodata;
use App\Models\Company;
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
        $companies = Company::all();
        return view('manage.user.create', ['roles' => $roles, 'companies' => $companies]);
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $allUsers = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.*', 'roles.id as rid', 'users.id as uid')
            ->when($search, function ($query, $search) {
                $query->where('name', 'ilike', '%' . $search . '%')
                    ->orWhere('email', 'ilike', '%' . $search . '%')
                    ->orWhere('no_hp', 'ilike', '%' . $search . '%');
            })
            ->where('users.role_id', '!=', 1)
            ->paginate(15);
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
        $roles = Role::all();
        // return view('manage.user.details', ['userData' => $userData, 'userProfile' => $userProfile, 'userAlamat' => $userAlamat]);
        return view('manage.user.details', ['userData' => $userData, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'tb_nama_user' => 'required',
            'tb_email_user' => 'required',
            'tb_hp_user' => 'required',
        ]);

        $userData = User::find($id);
        $userData->role_id = $request->cb_role;
        $userData->name = $request->tb_nama_user;
        $userData->email = $request->tb_email_user;
        $userData->no_hp = $request->tb_hp_user;
        $userData->external_user_id = $request->tb_external_id;
        $userData->save();

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
        $request->validate([
            'tb_nama_user' => 'required',
            'tb_email_user' => 'required|email|unique:users,email',
            'tb_password_user' => 'required',
            'tb_hp_user' => 'required|numeric|unique:users,no_hp',
        ], [
            'tb_nama_user.required' => 'Nama tidak boleh kosong',
            'tb_email_user.required' => 'Email tidak boleh kosong',
            'tb_password_user.required' => 'Password tidak boleh kosong',
            'tb_hp_user.required' => 'Nomor HP tidak boleh kosong',
            'tb_email_user.email' => 'Email tidak valid',
            'tb_email_user.unique' => 'Email sudah terdaftar',
            'tb_hp_user.unique' => 'Nomor HP sudah terdaftar',
            'tb_hp_user.numeric' => 'Nomor HP harus numeric',
        ]);

        $user = new User;
        $user->role_id = $request->cb_role;
        $user->company_id = $request->cb_company;
        $user->name = $request->tb_nama_user;
        $user->email = $request->tb_email_user;
        $user->password = Hash::make($request->tb_password_user);
        $user->no_hp = $request->tb_hp_user;
        $user->external_user_id = $request->tb_external_id;
        $user->save();

        return redirect()->route('manage.user.index')->with('message', "Akun berhasil dibuat");
    }
}
