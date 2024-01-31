<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Biodata;
use App\Models\Company;
use App\Models\DaftarAlamat;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $currentEntity = [];
        $customer = '';
        $isProvinsi = false;
        $search = $request->search;
        // if the user is penjual pusat or super admin, get customer selindo
        if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3) {
            $customer = DB::table('biodata')
                ->join('users', 'users.id', '=', 'biodata.user_id')
                ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
                ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
                ->where('users.role_id', '=', 5)
                ->when($search, function ($query, $search) {
                    $query->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('nama_rpk', 'ilike', '%' . $search . '%')
                        ->orWhere('email', 'ilike', '%' . $search . '%');
                })
                ->orderby('biodata.created_at', 'desc')
                ->paginate(15);
        } elseif (Auth::user()->role_id == 4) {
            $currentEntity = DB::table('companies')
                ->join('branches', 'branches.company_id', '=', 'companies.id')
                ->join('users', 'users.id', '=', 'companies.user_id')
                ->join('alamat', 'alamat.id', '=', 'companies.alamat_id')
                ->select('alamat.provinsi', 'alamat.kota_kabupaten', 'branches.nama_branch', 'companies.nama_company', 'companies.id as cid', 'branches.id as bid')
                ->where('users.id', '=', Auth::user()->id)
                ->first();

            if (empty($currentEntity) && Auth::user()->role_id == 4) {
                return redirect()->route('home')->with('error', 'Anda belum terdaftar di entitas/company manapun, harap hubungi admin');
            }

            if ($request->has('provinsi')) {
                // if page has request of provinsi,
                $isProvinsi = true;
                $customer = DB::table('biodata')
                    ->join('users', 'users.id', '=', 'biodata.user_id')
                    ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
                    ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
                    ->where('users.role_id', '=', 5)
                    ->where('users.company_id', '=', $currentEntity->cid)
                    ->when($search, function ($query, $search) {
                        $query->where('name', 'ilike', '%' . $search . '%')
                            ->orWhere('nama_rpk', 'ilike', '%' . $search . '%')
                            ->orWhere('email', 'ilike', '%' . $search . '%');
                    })
                    ->orderby('biodata.created_at', 'desc')
                    ->paginate(15);

                return view('customer.index', ['customer' => $customer, 'currentEntity' => $currentEntity, 'isProvinsi' => $isProvinsi, 'provinsi' => $request->provinsi]);
            } else {
                $customer = DB::table('biodata')
                    ->join('users', 'users.id', '=', 'biodata.user_id')
                    ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
                    ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
                    ->where('users.role_id', '=', 5)
                    ->where('biodata.branch_id', '=', $currentEntity->bid)
                    ->when($search, function ($query, $search) {
                        $query->where(function ($subquery) use ($search) {
                            $subquery->where('name', 'ilike', '%' . $search . '%')
                                ->orWhere('nama_rpk', 'ilike', '%' . $search . '%')
                                ->orWhere('email', 'ilike', '%' . $search . '%')
                                ->orWhere('kota_kabupaten', 'ilike', '%' . $search . '%');
                        });
                    })
                    ->orderByDesc('biodata.created_at')
                    ->paginate(15);
            }
        }


        return view('customer.index', ['customer' => $customer, 'currentEntity' => $currentEntity, 'isProvinsi' => $isProvinsi]);
    }

    public function show($id)
    {
        $entitas = DB::table('companies')->get();
        $cabang = DB::table('branches')->get();

        $customer = DB::table('biodata')
            ->join('users', 'users.id', '=', 'biodata.user_id')
            ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
            ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
            ->where('biodata.id', '=', $id)
            ->first();

        if (empty($customer)) {
            abort(404);
        }

        return view('customer.show', ['customer' => $customer, 'entitas' => $entitas, 'cabang' => $cabang]);
    }

    public function create()
    {
        $entitas = DB::table('companies')->get();
        $cabang = DB::table('branches')->get();
        return view('customer.create', ['entitas' => $entitas, 'cabang' => $cabang]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tb_kode_customer' => 'required',
            'tb_nama_rpk' => 'required',
            'tb_ktp_rpk' => 'required',
            'tb_img_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tb_jalan' => 'required',
            'tb_prov' => 'required',
            'tb_kota' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kodepos' => 'required',
            'tb_nama_user' => 'required',
            'tb_email_user' => 'required|email|unique:users,email',
            'tb_password_user' => 'required',
            'tb_hp_user' => 'required|numeric|unique:users,no_hp',
        ], [
            'tb_kode_customer.required' => 'Kode customer tidak boleh kosong',
            'tb_nama_rpk.required' => 'Nama RPK tidak boleh kosong',
            'tb_ktp_rpk.required' => 'No KTP tidak boleh kosong',
            'tb_img_ktp.required' => 'Foto KTP tidak boleh kosong',
            'tb_img_ktp.image' => 'Foto KTP harus berupa gambar',
            'tb_img_ktp.max' => 'Foto KTP maksimal 2MB',
            'tb_jalan.required' => 'Jalan tidak boleh kosong',
            'tb_prov.required' => 'Provinsi tidak boleh kosong',
            'tb_kota.required' => 'Kota/Kabupaten tidak boleh kosong',
            'tb_kecamatan.required' => 'Kecamatan tidak boleh kosong',
            'tb_kodepos.required' => 'Kode pos tidak boleh kosong',
            'tb_nama_user.required' => 'Nama user tidak boleh kosong',
            'tb_email_user.required' => 'Email tidak boleh kosong',
            'tb_email_user.email' => 'Email tidak valid',
            'tb_email_user.unique' => 'Email sudah terdaftar',
            'tb_password_user.required' => 'Password tidak boleh kosong',
            'tb_hp_user.required' => 'No HP tidak boleh kosong',
            'tb_hp_user.numeric' => 'No HP harus berupa angka',
            'tb_hp_user.unique' => 'No HP sudah terdaftar',
        ]);

        $user = new User;
        $user->id = DB::table('users')->max('id') + 1;
        $user->role_id = 5;
        $user->name = $request->tb_nama_user;
        $user->email = $request->tb_email_user;
        $user->password = Hash::make($request->tb_password_user);
        $user->no_hp = $request->tb_hp_user;
        $user->save();

        $alamat = new Alamat;
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_2;
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

        $customer = new Biodata;
        $customer->user_id = $user->id;
        $customer->alamat_id = $alamat->id;
        $customer->kode_customer = $request->tb_kode_customer;
        $customer->branch_id = $request->cb_branch_id;
        $customer->nama_rpk = $request->tb_nama_rpk;
        $customer->no_ktp = $request->tb_ktp_rpk;
        if ($request->has('cb_kode_company')) {
            $customer->kode_company = $request->cb_kode_company;
        }

        if ($request->hasFile('tb_img_ktp')) {
            $filePath = $request->file('tb_img_ktp')->store('images/ktp', 'public');
            $validatedData['tb_img_ktp'] = $filePath;
            $customer->ktp_img = $filePath;
        }
        $customer->save();

        $daftarAlamat = DaftarAlamat::create([
            'user_id' => $user->id,
            'alamat_id' => $alamat->id,
            'isActive' => true
        ]);

        return redirect()->route('customer.index')->with('success', 'Data customer berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tb_kode_customer' => 'required',
            'tb_nama_rpk' => 'required',
            'tb_ktp_rpk' => 'required',
            'tb_jalan' => 'required',
            'tb_blok' => 'required',
            'tb_rt' => 'required',
            'tb_rw' => 'required',
            'tb_prov' => 'required',
            'tb_kota' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kelurahan' => 'required',
            'tb_kodepos' => 'required',
            'tb_img_ktp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tb_kode_customer.required' => 'Kode customer tidak boleh kosong',
            'tb_nama_rpk.required' => 'Nama RPK tidak boleh kosong',
            'tb_no_ktp.required' => 'No KTP tidak boleh kosong',
            'tb_jalan.required' => 'Jalan tidak boleh kosong',
            'tb_blok.required' => 'Blok tidak boleh kosong',
            'tb_rt.required' => 'RT tidak boleh kosong',
            'tb_rw.required' => 'RW tidak boleh kosong',
            'tb_prov.required' => 'Provinsi tidak boleh kosong',
            'tb_kota.required' => 'Kota/Kabupaten tidak boleh kosong',
            'tb_kecamatan.required' => 'Kecamatan tidak boleh kosong',
            'tb_kelurahan.required' => 'Kelurahan tidak boleh kosong',
            'tb_kodepos.required' => 'Kode pos tidak boleh kosong',
            'tb_img_ktp.image' => 'Foto KTP harus berupa gambar',
            'tb_img_ktp.max' => 'Foto KTP maksimal 2MB',
        ]);

        $customer = Biodata::findOrfail($id);
        if (empty($customer)) {
            abort(404);
        }
        $customer->kode_customer = $request->tb_kode_customer;
        $customer->nama_rpk = $request->tb_nama_rpk;
        $customer->no_ktp = $request->tb_ktp_rpk;
        $customer->kode_company = $request->cb_kode_company;
        $customer->branch_id = $request->cb_branch_id;

        if ($request->hasFile('tb_img_ktp')) {
            $filePath = $request->file('tb_img_ktp')->store('images/ktp', 'public');
            $validatedData['tb_img_ktp'] = $filePath;
            if (!empty($customer->ktp_img)) {
                Storage::disk('public')->delete($customer->ktp_img);
            }
            $customer->ktp_img = $filePath;
        }
        $customer->save();

        $alamat = Alamat::where('id', '=', $customer->alamat_id)->first();
        if (empty($alamat)) {
            abort(404);
        }
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_2;
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

        $user = User::where('id', '=', $customer->user_id)->first();
        if (empty($user)) {
            abort(404);
        }
        $user->name = $request->tb_nama_user;
        $user->email = $request->tb_email_user;
        $user->no_hp = $request->tb_hp_user;
        $user->save();

        return redirect()->route('customer.index')->with('message', 'Data customer berhasil diubah');
    }

    public function delete($id)
    {
        $customer = Biodata::findOrfail($id);
        if (empty($customer)) {
            abort(404);
        }

        $alamat = Alamat::where('id', '=', $customer->alamat_id)->first();
        if (empty($alamat)) {
            abort(404);
        }

        $user = User::where('id', '=', $customer->user_id)->first();
        $daftarAlamat = DaftarAlamat::where('user_id', $customer->user_id)->delete();
        $customer->delete();
        $alamat->delete();
        $user->delete();


        return redirect()->route('customer.index')->with('success', 'Data customer berhasil dihapus');
    }

    public function verify($id)
    {
        $userData = User::find($id);
        $userData->isVerified = 1;
        $userData->save();
        return redirect()->back()->with('success', "Akun {$userData->name} berhasil diverifikasi");
    }

    public function reject($id)
    {
        $userData = User::find($id);
        $userData->isVerified = 2;
        $userData->save();
        return redirect()->back()->with('success', "Akun {$userData->name} berhasil diverifikasi");
    }
}
