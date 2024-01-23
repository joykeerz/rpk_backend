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
        Log::info('Partner Import Job Running');

        $erpPartner = $odoo->model('res.partner')
            ->fields(['id', 'name', 'phone', 'email', 'login', 'company_id', 'street', 'street2', 'blok', 'nomor', 'rt', 'rw', 'city_id', 'state_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'zip', 'ktp'])
            ->where('is_rpk_partner', '=', true)
            ->get();

        Log::info('User data retrieved from ERP');
        Log::info('Looping through user data');

        DB::beginTransaction();

        try {
            foreach ($erpPartner as $user) {
                $company_id = $user->company_id[0] ?? 1;
                $city_id = $user->city_id[1] ?? 'KOTA JAKARTA SELATAN';
                $state_id = $user->state_id[1] ?? 'DKI JAKARTA';
                $kecamatan_id = $user->kecamatan_id[1] ?? 'SETIA BUDI';
                $kelurahan_id = $user->kelurahan_id[1] ?? 'KARET KUNINGAN';

                $data = [
                    'role_id' => 5,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt('default123'),
                    'no_hp' => $user->phone,
                    'company_id' => $company_id,
                ];

                if (!DB::table('users')->where('id', $user->id)->exists()) {
                    $data['id'] = $user->id;
                    $insertUserGetId = DB::table('users')->insertGetId($data);

                    $insertAlamatGetId = DB::table('alamat')->insertGetId([
                        'jalan' => $user->street,
                        'jalan_ext' => $user->street2,
                        'blok' => $user->blok,
                        'rt' => $user->rt,
                        'rw' => $user->rw,
                        'kode_pos' => $user->nomor,
                        'provinsi' => Str::upper($state_id),
                        'kota_kabupaten' => Str::upper($city_id),
                        'kecamatan' => Str::upper($kecamatan_id),
                        'kelurahan' => Str::upper($kelurahan_id),
                        'negara' => 'Indonesia',
                    ]);

                    DB::table('biodata')->insert([
                        'user_id' => $insertUserGetId,
                        'alamat_id' => $insertAlamatGetId,
                        'kode_customer' => $user->id . '-' . $user->name,
                        'nama_rpk' => $user->name,
                        'no_ktp' => $user->ktp,
                        'kode_company' => $company_id,
                    ]);
                } else {
                    $alamatId = DB::table('biodata')->where('user_id', $user->id)->value('alamat_id');

                    DB::table('users')->where('id', $user->id)->update($data);

                    DB::table('biodata')->where('user_id', $user->id)->update([
                        'kode_customer' => $user->id . '-' . $user->name,
                        'nama_rpk' => $user->name,
                        'no_ktp' => $user->ktp,
                        'kode_company' => $company_id,
                    ]);

                    DB::table('alamat')->where('id', $alamatId)->update([
                        'jalan' => $user->street,
                        'jalan_ext' => $user->street2,
                        'blok' => $user->blok,
                        'rt' => $user->rt,
                        'rw' => $user->rw,
                        'kode_pos' => $user->nomor,
                        'provinsi' => Str::upper($state_id),
                        'kota_kabupaten' => Str::upper($city_id),
                        'kecamatan' => Str::upper($kecamatan_id),
                        'kelurahan' => Str::upper($kelurahan_id),
                        'negara' => 'Indonesia',
                    ]);
                }
            }

            DB::commit();
            Log::info('Partner Import Job Finished');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error importing partners: ' . $e->getMessage());
        }
    }


    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        $this->importPartner($odoo);
    }
}
