<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\VarDumper\VarDumper;

class ManageUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $allUsers = User::all();
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
        $userData = User::find($id);
        $userProfile = Biodata::where('user_id', $id);
        return view('manage.user.details', ['userData' => $userData, 'userProfile' => $userProfile]);
    }

    public function update(Request $request, $id)
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

    public function changePassword(Request $request, $id)
    {
        $userData = User::find($id);
        if (!empty($request->tb_password_user)) {
            $userData->password = Hash::make($request->tb_password_user);
        }
        $userData->save();
        return redirect()->route('manage.user.edit', ['id' => $id])->with('message', 'Password berhasil diganti');
    }

    public function storeBiodata(Request $request)
    {
        $validateData = $request->validate([
            'tb_nama_rpk' => 'required',
            'tb_no_ktp' => 'required',
        ]);

        $dataBiodata = new Biodata;
        $dataBiodata->user_id = Auth::user()->id;
        $dataBiodata->nama_rpk = $request->tb_nama_rpk;
        $dataBiodata->no_ktp = $request->tb_no_ktp;
        $dataBiodata->save();
        dump('biodata added');
    }

    public function storeAlamat(Request $request, $id)
    {
        $validateData = $request->validate([
            'tb_alamat' => 'required',
            'tb_jalan_ext' => 'required',
            'tb_blok' => 'required',
            'tb_rt' => 'required',
            'tb_rw' => 'required',
            'tb_provinsi' => 'required',
            'tb_kota_kabupaten' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kelurahan' => 'required',
            'tb_negara' => 'required',
            'tb_kode_pos' => 'required',
        ]);

        $dataAlamat = new Alamat;
        $dataAlamat->biodata_id = $id;
        $dataAlamat->jalan = $request->tb_alamat;
        $dataAlamat->jalan_ext = $request->tb_jalan_ext;
        $dataAlamat->blok = $request->tb_blok;
        $dataAlamat->rt = $request->tb_rt;
        $dataAlamat->rw = $request->tb_rw;
        $dataAlamat->provinsi = $request->tb_provinsi;
        $dataAlamat->kota_kabupaten = $request->tb_kota_kabupaten;
        $dataAlamat->kecamatan = $request->tb_kecamatan;
        $dataAlamat->kelurahan = $request->tb_kelurahan;
        $dataAlamat->negara = $request->tb_negara;
        $dataAlamat->kode_pos = $request->tb_kode_pos;
        dump('Alamat added');
    }

    public function StoreNewAccount(Request $request){

        $validateData = $request->validate([
            'tb_nama_user' => 'required',
            'tb_email_user' => 'required',
            'tb_password_user' => 'required',
            'tb_hp_user' => 'required',
        ]);

        User::create([
            'name' => $request->tb_nama_user,
            'email' => $request->tb_email_user,
            'password' => Hash::make($request->tb_password_user),
            'no_hp' => $request->tb_hp_user,
        ]);
        dump('user berhasil dibuat');
    }
}
