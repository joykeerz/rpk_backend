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
        ->join('roles','users.role_id','=','roles.id')
        ->select('users.*','roles.*','roles.id as rid','users.id as uid')
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
        ->join('biodata','users.id','=','biodata.user_id')
        ->join('alamat','alamat.id','=','biodata.alamat_id')
        ->select('users.*','biodata.*','alamat.*','biodata.id as bid','alamat.id as aid','users.id as uid')
        ->where('users.id','=',$id)
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
            'tb_nama_rpk' => 'required',
            'tb_ktp_rpk' => 'required',
        ]);

        $userData = User::find($id);
        $userData->name = $request->tb_nama_user;
        $userData->email = $request->tb_email_user;
        $userData->no_hp = $request->tb_hp_user;

        $userProfile = Biodata::where('user_id', $id)->first();
        $userProfile->nama_rpk = $request->tb_nama_rpk;
        $userProfile->no_ktp = $request->tb_ktp_rpk;
        $userProfile->save();

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

    public function changeAlamat(Request $request, $id)
    {
        $Alamat = Alamat::find($id);
        $Alamat->jalan = $request->tb_jalan;
        $Alamat->jalan_ext = $request->tb_jalan_2;
        $Alamat->blok = $request->tb_blok;
        $Alamat->rt = $request->tb_rt;
        $Alamat->rw = $request->tb_rw;
        $Alamat->provinsi = $request->tb_prov;
        $Alamat->kota_kabupaten = $request->tb_kota;
        $Alamat->kecamatan = $request->tb_kecamatan;
        $Alamat->kelurahan = $request->tb_kelurahan;
        $Alamat->negara = 'indonesia';
        $Alamat->kode_pos = $request->tb_kodepos;
        $Alamat->save();

        return redirect()->route('manage.user.edit', ['id' => $request->tb_hidden_uid])->with('message', 'Alamat akun berhasil diupdate');
    }

    public function StoreNewAccount(Request $request)
    {
        // $validateData = $request->validate([
        //     'tb_nama_user' => 'required',
        //     'tb_email_user' => 'required',
        //     'tb_password_user' => 'required',
        //     'tb_hp_user' => 'required',
        //     'tb_nama_rpk' => 'required',
        //     'tb_no_ktp' => 'required',
        //     'tb_alamat' => 'required',
        //     'tb_jalan_ext' => 'required',
        //     'tb_blok' => 'required',
        //     'tb_rt' => 'required',
        //     'tb_rw' => 'required',
        //     'tb_provinsi' => 'required',
        //     'tb_kota_kabupaten' => 'required',
        //     'tb_kecamatan' => 'required',
        //     'tb_kelurahan' => 'required',
        //     'tb_negara' => 'required',
        //     'tb_kode_pos' => 'required',
        // ]);

        $user = new User;
        $user->role_id = $request->cb_role;
        $user->name = $request->tb_nama_user;
        $user->email = $request->tb_email_user;
        $user->password = Hash::make($request->tb_password_user);
        $user->no_hp = $request->tb_hp_user;
        $user->save();

        $alamat = new Alamat;
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_ext;
        $alamat->blok = $request->tb_blok;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi = $request->tb_prov;
        $alamat->kota_kabupaten = $request->tb_kota;
        $alamat->kecamatan = $request->tb_kecamatan;
        $alamat->kelurahan = $request->tb_kelurahan;
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kodepos;
        $alamat->save();

        $rpk = new Biodata;
        $rpk->user_id = $user->id;
        $rpk->alamat_id = $alamat->id;
        $rpk->nama_rpk = $request->tb_nama_rpk;
        $rpk->no_ktp = $request->tb_ktp_rpk;
        $rpk->save();

        return redirect()->route('manage.user.index')->with('message', "Akun berhasil dibuat");
    }
}
