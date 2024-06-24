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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Obuchmann\OdooJsonRpc\Odoo;

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
        $statusVerifikasi = $request->status_verifikasi;

        // if the user is penjual pusat or super admin, get customer selindo
        if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3) {
            /* Query Customer Tanpa Master Daerah */
            // $customer = DB::table('biodata')
            //     ->join('users', 'users.id', '=', 'biodata.user_id')
            //     ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
            //     ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
            //     ->where('users.role_id', '=', 5)
            //     ->when($search, function ($query, $search) {
            //         $query->where('name', 'ilike', '%' . $search . '%')
            //             ->orWhere('nama_rpk', 'ilike', '%' . $search . '%')
            //             ->orWhere('email', 'ilike', '%' . $search . '%');
            //     })
            //     ->orderby('biodata.created_at')
            //     ->paginate(15);

            $customer = DB::table('biodata')
                ->join('users', 'users.id', '=', 'biodata.user_id')
                ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
                ->join('provinsi', 'provinsi.id', '=', 'alamat.provinsi_id')
                ->join('kabupaten', 'kabupaten.id', '=', 'alamat.kabupaten_id')
                ->join('kecamatan', 'kecamatan.id', '=', 'alamat.kecamatan_id')
                ->join('kelurahan', 'kelurahan.id', '=', 'alamat.kelurahan_id')
                ->select(
                    'users.*',
                    'biodata.*',
                    'alamat.*',
                    'provinsi.display_name as provinsi_name',
                    'provinsi.id as provinsi_id',
                    'kabupaten.display_name as kabupaten_name',
                    'kabupaten.id as kabupaten_id',
                    'kecamatan.display_name as kecamatan_name',
                    'kecamatan.id as kecamatan_id',
                    'kelurahan.display_name as kelurahan_name',
                    'kelurahan.id as kelurahan_id',
                    'biodata.id as bid',
                    'users.id as uid',
                    'alamat.id as aid',
                    'biodata.created_at as cat'
                )
                ->where('users.role_id', '=', 5)
                ->when($search, function ($query, $search) {
                    $query->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('nama_rpk', 'ilike', '%' . $search . '%')
                        ->orWhere('email', 'ilike', '%' . $search . '%');
                })
                ->when($statusVerifikasi !== null, function ($query) use ($statusVerifikasi) {
                    $query->where('users.isVerified', '=', (int) $statusVerifikasi);
                })
                ->orderby('biodata.created_at','desc')
                ->paginate(15);
        } elseif (Auth::user()->role_id == 4) {
            $currentEntity = DB::table('companies')
                ->join('branches', 'branches.company_id', '=', 'companies.id')
                ->join('users', 'users.company_id', '=', 'companies.id')
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
                    ->orderby('biodata.created_at','desc')
                    ->paginate(15);

                return view('customer.index', ['customer' => $customer, 'currentEntity' => $currentEntity, 'isProvinsi' => $isProvinsi, 'provinsi' => $request->provinsi]);
            } else {
                /* Query Customer Tanpa Master Daerah */
                // $customer = DB::table('biodata')
                //     ->join('users', 'users.id', '=', 'biodata.user_id')
                //     ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
                //     ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
                //     ->where('users.role_id', '=', 5)
                //     ->where('biodata.branch_id', '=', $currentEntity->bid)
                //     ->when($search, function ($query, $search) {
                //         $query->where(function ($subquery) use ($search) {
                //             $subquery->where('name', 'ilike', '%' . $search . '%')
                //                 ->orWhere('nama_rpk', 'ilike', '%' . $search . '%')
                //                 ->orWhere('email', 'ilike', '%' . $search . '%')
                //                 ->orWhere('kota_kabupaten', 'ilike', '%' . $search . '%');
                //         });
                //     })
                //     ->orderBy('biodata.created_at')
                //     ->paginate(15);

                $customer = DB::table('biodata')
                    ->join('users', 'users.id', '=', 'biodata.user_id')
                    ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
                    ->join('provinsi', 'provinsi.id', '=', 'alamat.provinsi_id')
                    ->join('kabupaten', 'kabupaten.id', '=', 'alamat.kabupaten_id')
                    ->join('kecamatan', 'kecamatan.id', '=', 'alamat.kecamatan_id')
                    ->join('kelurahan', 'kelurahan.id', '=', 'alamat.kelurahan_id')
                    ->select(
                        'users.*',
                        'biodata.*',
                        'alamat.*',
                        'provinsi.display_name as provinsi_name',
                        'provinsi.id as provinsi_id',
                        'kabupaten.display_name as kabupaten_name',
                        'kabupaten.id as kabupaten_id',
                        'kecamatan.display_name as kecamatan_name',
                        'kecamatan.id as kecamatan_id',
                        'kelurahan.display_name as kelurahan_name',
                        'kelurahan.id as kelurahan_id',
                        'biodata.id as bid',
                        'users.id as uid',
                        'alamat.id as aid',
                        'biodata.created_at as cat'
                    )
                    ->where('users.role_id', '=', 5)
                    ->where('biodata.branch_id', '=', $currentEntity->bid)
                    ->when($search, function ($query, $search) {
                        $query->where(function ($subquery) use ($search) {
                            $subquery->where('name', 'ilike', '%' . $search . '%')
                                ->orWhere('nama_rpk', 'ilike', '%' . $search . '%');
                        });
                    })
                    ->when($statusVerifikasi !== null, function ($query) use ($statusVerifikasi) {
                        $query->where('users.isVerified', '=', (int) $statusVerifikasi);
                    })
                    ->orderby('biodata.created_at','desc')
                    ->paginate(15);
            }
        }

        return view('customer.index', ['customer' => $customer, 'currentEntity' => $currentEntity, 'isProvinsi' => $isProvinsi]);
    }

    public function show($id)
    {
        $entitas = DB::table('companies')->get();
        $cabang = DB::table('branches')->get();

        /* Query Customer Tanpa Master Daerah */
        // $customer = DB::table('biodata')
        //     ->join('users', 'users.id', '=', 'biodata.user_id')
        //     ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
        //     ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
        //     ->where('biodata.id', '=', $id)
        //     ->first();

        $customer = DB::table('biodata')
            ->join('users', 'users.id', '=', 'biodata.user_id')
            ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
            ->join('provinsi', 'provinsi.id', '=', 'alamat.provinsi_id')
            ->join('kabupaten', 'kabupaten.id', '=', 'alamat.kabupaten_id')
            ->join('kecamatan', 'kecamatan.id', '=', 'alamat.kecamatan_id')
            ->join('kelurahan', 'kelurahan.id', '=', 'alamat.kelurahan_id')
            ->select(
                'users.*',
                'biodata.*',
                'alamat.*',
                'provinsi.display_name as provinsi_name',
                'provinsi.id as provinsi_id',
                'kabupaten.display_name as kabupaten_name',
                'kabupaten.id as kabupaten_id',
                'kecamatan.display_name as kecamatan_name',
                'kecamatan.id as kecamatan_id',
                'kelurahan.display_name as kelurahan_name',
                'kelurahan.id as kelurahan_id',
                'biodata.id as bid',
                'users.id as uid',
                'alamat.id as aid',
                'biodata.created_at as cat'
            )
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
            'tb_img_npwp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tb_img_nib' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            'tb_img_npwp.required' => 'Foto NPWP tidak boleh kosong',
            'tb_img_npwp.image' => 'Foto NPWP harus berupa gambar',
            'tb_img_npwp.max' => 'Foto NPWP maksimal 2MB',
            'tb_img_nib.required' => 'Foto NIB tidak boleh kosong',
            'tb_img_nib.image' => 'Foto NIB harus berupa gambar',
            'tb_img_nib.max' => 'Foto NIB maksimal 2MB',
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
        $user->company_id = DB::table('companies')->where('kode_company', $request->cb_kode_company)->value('id');
        $user->name = $request->tb_nama_user;
        $user->email = $request->tb_email_user;
        $user->no_hp = $request->tb_hp_user;
        $user->password = Hash::make($request->tb_password_user);
        $user->isVerified = false;
        $user->save();

        $alamat = new Alamat;
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_2;
        $alamat->blok = $request->tb_blok;
        $alamat->nomor = $request->tb_nomor;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi_id = $request->tb_prov;
        $alamat->provinsi = DB::table('provinsi')->where('id', $request->tb_prov)->value('display_name');
        $alamat->kabupaten_id = $request->tb_kota;
        $alamat->kota_kabupaten = DB::table('kabupaten')->where('id', $request->tb_kota)->value('display_name');
        $alamat->kecamatan_id = $request->tb_kecamatan;
        $alamat->kecamatan = DB::table('kecamatan')->where('id', $request->tb_kecamatan)->value('display_name');
        $alamat->kelurahan_id = $request->tb_kelurahan;
        $alamat->kelurahan = DB::table('kelurahan')->where('id', $request->tb_kelurahan)->value('display_name');
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kodepos;
        $alamat->save();

        $customer = new Biodata;
        $customer->user_id = $user->id;
        $customer->alamat_id = $alamat->id;
        $customer->kode_customer = $request->tb_kode_customer;
        $customer->nama_rpk = $request->tb_nama_rpk;
        $customer->no_ktp = $request->tb_ktp_rpk;
        if ($request->hasFile('tb_img_ktp')) {
            $filePath = $request->file('tb_img_ktp')->store('images/ktp', 'public');
            $validatedData['tb_img_ktp'] = $filePath;
            $customer->ktp_img = $filePath;
        }
        if ($request->hasFile('tb_img_npwp')) {
            $filePath = $request->file('tb_img_npwp')->store('images/npwp', 'public');
            $validatedData['tb_img_npwp'] = $filePath;
            $customer->npwp_img = $filePath;
        }
        if ($request->hasFile('tb_img_nib')) {
            $filePath = $request->file('tb_img_nib')->store('images/nib', 'public');
            $validatedData['tb_img_nib'] = $filePath;
            $customer->nib_img = $filePath;
        }

        if ($request->has('cb_kode_company')) {
            $customer->kode_company = $request->cb_kode_company;
        }
        $customer->branch_id = $request->cb_branch_id;
        $customer->save();

        $daftarAlamat = DaftarAlamat::create([
            'user_id' => $user->id,
            'alamat_id' => $alamat->id,
            'isActive' => true
        ]);

        return redirect()->route('customer.index')->with('message', 'Data customer berhasil ditambahkan');
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
            'tb_img_npwp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tb_img_nib' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'tb_img_npwp.image' => 'Foto NPWP harus berupa gambar',
            'tb_img_npwp.max' => 'Foto NPWP maksimal 2MB',
            'tb_img_nib.image' => 'Foto NIB harus berupa gambar',
            'tb_img_nib.max' => 'Foto NIB maksimal 2MB',
        ]);

        $customer = Biodata::findOrfail($id);

        $customer->kode_customer = $request->tb_kode_customer;
        $customer->nama_rpk = $request->tb_nama_rpk;
        $customer->no_ktp = $request->tb_ktp_rpk;
        // $kodeCompany = Company::find($request->cb_kode_company);
        // $customer->kode_company = $kodeCompany->kode_company;
        $customer->kode_company = $request->cb_kode_company;
        $customer->branch_id = $request->cb_branch_id;

        if ($request->hasFile('tb_img_ktp')) {
            $filePath = $request->file('tb_img_ktp')->store('images/ktp', 'public');
            $validatedData['tb_img_ktp'] = $filePath;
            if (!empty($customer->ktp_img) && Storage::disk('public')->exists($customer->ktp_img) && $customer->ktp_img != 'images/ktp/default.png') {
                Storage::disk('public')->delete($customer->ktp_img);
            }
            $customer->ktp_img = $filePath;
        }
        if ($request->hasFile('tb_img_npwp') && Storage::disk('public')->exists($customer->npwp_img) && $customer->npwp_img != 'images/npwp/default.png') {
            $filePath = $request->file('tb_img_npwp')->store('images/npwp', 'public');
            $validatedData['tb_img_npwp'] = $filePath;
            if (!empty($customer->npwp_img)) {
                Storage::disk('public')->delete($customer->npwp_img);
            }
            $customer->npwp_img = $filePath;
        }
        if ($request->hasFile('tb_img_nib') && Storage::disk('public')->exists($customer->nib_img) && $customer->nib_img != 'images/nib/default.png') {
            $filePath = $request->file('tb_img_nib')->store('images/nib', 'public');
            $validatedData['tb_img_nib'] = $filePath;
            if (!empty($customer->nib_img)) {
                Storage::disk('public')->delete($customer->nib_img);
            }
            $customer->nib_img = $filePath;
        }
        $customer->save();

        $alamat = Alamat::where('id', '=', $customer->alamat_id)->first();
        if ($alamat == null) {
            abort(404);
        }

        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_2;
        $alamat->blok = $request->tb_blok;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi_id = $request->tb_prov;
        $alamat->provinsi = DB::table('provinsi')->where('id', $request->tb_prov)->value('display_name');
        $alamat->kabupaten_id = $request->tb_kota;
        $alamat->kota_kabupaten = DB::table('kabupaten')->where('id', $request->tb_kota)->value('display_name');
        $alamat->kecamatan_id = $request->tb_kecamatan;
        $alamat->kecamatan = DB::table('kecamatan')->where('id', $request->tb_kecamatan)->value('display_name');
        $alamat->kelurahan_id = $request->tb_kelurahan;
        $alamat->kelurahan = DB::table('kelurahan')->where('id', $request->tb_kelurahan)->value('display_name');
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kodepos;
        $alamat->save();

        $user = User::where('id', '=', $customer->user_id)->first();
        if ($user == null) {
            abort(404);
        }

        $user->name = $request->tb_nama_user;
        $user->email = $request->tb_email_user;
        $user->no_hp = $request->tb_hp_user;
        $user->company_id = DB::table('companies')->where('kode_company', $request->cb_kode_company)->value('id');
        $user->save();

        return redirect()->route('customer.index')->with('message', 'Data customer berhasil diubah');
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $customer = Biodata::findOrFail($id);
            $alamat = Alamat::findOrFail($customer->alamat_id);
            $user = User::findOrFail($customer->user_id);

            DaftarAlamat::where('user_id', $customer->user_id)->delete();
            $customer->delete();
            $alamat->delete();
            $user->delete();
        });

        return redirect()->route('customer.index')->with('message', 'Data customer berhasil dihapus');
    }


    public function verify($id, Odoo $odoo)
    {
        $userData = User::find($id);
        $userData->isVerified = 1;

        $biodata = Biodata::where('user_id', $id)->first();

        $alamat = Alamat::find($biodata->alamat_id);

        $this->addToErp($userData, $biodata, $alamat, $odoo);

        $userData->save();

        return redirect()->route('customer.index')->with('message', 'Customer berhasil diverifikasi');
    }

    public function reject($id)
    {
        $userData = User::find($id);
        $userData->isVerified = 2;
        $userData->save();
        return redirect()->back()->with('message', "Akun {$userData->name} berhasil diverifikasi");
    }

    public function addToErp($user, $biodata, $alamat, Odoo $odoo)
    {
        Log::info("adding to erp");
        $KtpImageContent = Storage::disk('public')->get($biodata->ktp_img);
        $base64KtpImage = base64_encode($KtpImageContent);
        $npwpImageContent = Storage::disk('public')->get($biodata->npwp_img);
        $base64NpwpImage = base64_encode($npwpImageContent);
        $nibImageContent = Storage::disk('public')->get($biodata->nib_img);
        $base64NibImage = base64_encode($nibImageContent);

        $resPartner = $odoo->create('res.partner', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->no_hp,
            'mobile' => $user->no_hp,
            'login_user' => $user->no_hp,
            'nama_id_rpk' => $biodata->nama_rpk,
            'ktp' => $biodata->no_ktp,
            'attachment_ktp' => $base64KtpImage,
            'attachment_npwp' => $base64NpwpImage,
            'attachment_skt' => $base64NibImage,
            'cabang_terdaftar' => $biodata->branch_id,
            'jenis_partner' => 2,
            'street' => $alamat->jalan,
            'street2' => $alamat->jalan_ext,
            'blok' => $alamat->blok,
            'nomor' => $alamat->nomor,
            'rt' => $alamat->rt,
            'rw' => $alamat->rw,
            'zip' => $alamat->kode_pos,
            'country_id' => 100,
            'state_id' => $alamat->provinsi_id,
            'kabupaten_id' => $alamat->kabupaten_id,
            'kecamatan_id' => $alamat->kecamatan_id,
            'kelurahan_id' => $alamat->kelurahan_id,
            'is_rpk_partner' => true,
            'customer' => true,
            'default_warehouse_id' => 1804,
            'warehouse_company_id' => 115,
            'team_ids' => [[6, 0, [11]]],  // Correct format for many-to-many relationship
            'penjualan_type_ids' => [[6, 0, [2]]],
        ]);

        if (!$resPartner) {
            return redirect()->route('customer.index')->with('error', 'Data customer gagal dimasukan ke erp');
        }
        Log::info("done adding to erp");
        Log::info("updating current user id with erp");

        // $user = User::find($user->id);
        // $user->external_user_id = $resPartner;
        // $user->save();

        $biodata = Biodata::where('user_id', $user->id)->first();
        $biodata->kode_customer = $resPartner;
        $biodata->kode_customer = $resPartner . '-' . $biodata->nama_rpk;
        $biodata->save();

        Log::info("updating done");
        return redirect()->back()->with('message', "Akun $user->name dengan id $user->id berhasil diverifikasi");
    }
}
