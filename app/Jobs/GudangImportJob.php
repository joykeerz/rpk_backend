<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class GudangImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function ImportLocation()
    {
        Log::info('Fetching location data from ERP...');
    }

    public function importGudang(Odoo $odoo)
    {
        Log::info('Getting data from ERP');
        $warehouses = $odoo->model('stock.warehouse')
            ->fields(['id', 'name', 'code', 'mobile', 'company_id', 'branch_id', 'published_name', 'alamat_gudang'])
            ->where('is_published', '=', true)
            ->get();

        Log::info('Looping through data');
        foreach ($warehouses as $warehouse) {
            if (!$warehouse->mobile) {
                $warehouse->mobile = '-';
            }

            if (!DB::table('gudang')->where('id', $warehouse->id)->exists()) {
                $alamatID = DB::table('alamat')->insertGetId([
                    'jalan' => $warehouse->alamat_gudang,
                    'jalan_ext' => '(blank)',
                    'blok' => '(blank)',
                    'rt' => '0',
                    'rw' => '0',
                    'provinsi' => '(blank)',
                    'kota_kabupaten' => '(blank)',
                    'kecamatan' => '(blank)',
                    'kelurahan' => '(blank)',
                    'negara' => 'Indonesia',
                    'kode_pos' => '(blank)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }else{
                $alamatID = DB::table('gudang')->where('id', $warehouse->id)->value('alamat_id');
            }

            DB::table('gudang')->updateOrInsert(['id' => $warehouse->id], [
                'id' => $warehouse->id,
                'alamat_id' => $alamatID,
                'company_id' => $warehouse->company_id[0],
                'branch_id' => $warehouse->branch_id[0],
                'user_id' => 1,
                'nama_gudang' => $warehouse->published_name,
                'nama_gudang_erp' => $warehouse->name,
                'no_telp' => $warehouse->mobile,
            ]);
        }
    }

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        Log::info('Gudang Import Job Running');
        $this->importGudang($odoo);
        Log::info('Gudang Import Job Done');
    }
}
