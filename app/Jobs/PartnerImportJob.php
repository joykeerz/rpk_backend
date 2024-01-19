<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Obuchmann\OdooJsonRpc\Odoo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PartnerImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function importPartner(Odoo $odoo)
    {
        log::info('partner Import Job Running');
        $erpPartner = $odoo->model('res.partner')
            ->fields(['id', 'name', 'phone', 'email', 'login', 'company_id', 'street', 'street2', 'blok', 'nomor', 'rt', 'rw',  'city_id', 'state_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'zip', 'ktp'])
            ->where('is_rpk_partner', '=', true)
            ->get();

        Log::info('user data retrieved from erp');
        Log::info('looping through user data');

        foreach ($erpPartner as $user) {
            if (!DB::table('users')->where('id', $user->id)->exists()) {
                if ($user->company_id == false) {
                    $user->company_id[0] = 1;
                }

                if ($user->city_id == false) {
                    $user->city_id[1] = 'KOTA JAKARTA SELATAN';
                }

                if ($user->state_id == false) {
                    $user->state_id[1] = 'DKI JAKARTA';
                }

                if ($user->kecamatan_id == false) {
                    $user->kecamatan_id[1] = 'SETIA BUDI';
                }

                if ($user->kelurahan_id == false) {
                    $user->kelurahan_id[1] = 'KARET KUNINGAN';
                }

                $insertUserGetId = DB::table('users')->insertGetId(
                    [
                        'id' => $user->id,
                        'role_id' => 5,
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => bcrypt('default123'),
                        'no_hp' => $user->phone,
                        'company_id' => $user->company_id[0],
                    ]
                );

                $insertAlamatGetId = DB::table('alamat')->insertGetId([
                    'jalan' => $user->street,
                    'jalan_ext' => $user->street2,
                    'blok' => $user->blok,
                    'rt' => $user->rt,
                    'rw' => $user->rw,
                    'kode_pos' => $user->nomor,
                    'provinsi' => Str::Upper($user->state_id[1]),
                    'kota_kabupaten' => Str::Upper($user->city_id[1]),
                    'kecamatan' => Str::Upper($user->kecamatan_id[1]),
                    'kelurahan' => Str::Upper($user->kelurahan_id[1]),
                    'negara' => 'Indonesia',
                ]);

                DB::table('biodata')->insert(
                    [
                        'user_id' => $insertUserGetId,
                        'alamat_id' => $insertAlamatGetId,
                        'kode_customer' => $user->id . '-' . $user->name,
                        'nama_rpk' => $user->name,
                        'no_ktp' => $user->ktp,
                        'kode_company' => $user->company_id[0],
                    ]
                );
            } else {
                if ($user->company_id == false) {
                    $user->company_id[0] = 1;
                }

                if ($user->city_id == false) {
                    $user->city_id[1] = 'KOTA JAKARTA SELATAN';
                }

                if ($user->state_id == false) {
                    $user->state_id[1] = 'DKI JAKARTA';
                }

                if ($user->kecamatan_id == false) {
                    $user->kecamatan_id[1] = 'SETIA BUDI';
                }

                if ($user->kelurahan_id == false) {
                    $user->kelurahan_id[1] = 'KARET KUNINGAN';
                }

                $insertBiodata = DB::table('biodata')->where('user_id', $user->id)->first();
                $insertBiodata->update(
                    [
                        'kode_customer' => $user->id . '-' . $user->name,
                        'nama_rpk' => $user->name,
                        'no_ktp' => $user->ktp,
                        'kode_company' => $user->company_id[0],
                    ]
                );

                $insertUserGetId = DB::table('users')->where('id', $user->id)->update(
                    [
                        'role_id' => 5,
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => bcrypt('default123'),
                        'no_hp' => $user->phone,
                        'company_id' => $user->company_id[0],
                    ]
                );

                $insertAlamatGetId = DB::table('alamat')->where('id', $insertBiodata->alamat_id)->update([
                    'jalan' => $user->street,
                    'jalan_ext' => $user->street2,
                    'blok' => $user->blok,
                    'rt' => $user->rt,
                    'rw' => $user->rw,
                    'kode_pos' => $user->nomor,
                    'provinsi' => Str::Upper($user->state_id[1]),
                    'kota_kabupaten' => Str::Upper($user->city_id[1]),
                    'kecamatan' => Str::Upper($user->kecamatan_id[1]),
                    'kelurahan' => Str::Upper($user->kelurahan_id[1]),
                    'negara' => 'Indonesia',
                ]);
            }
        }

        Log::info('Partner Import Job Finished');
    }

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        $this->importPartner($odoo);
    }
}
