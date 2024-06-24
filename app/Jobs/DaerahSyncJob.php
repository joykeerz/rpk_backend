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

class DaerahSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function syncProvinsi(Odoo $odoo)
    {
        Log::info('Provinsi Sync Job Running');

        $pageSize = 100; // Set the desired chunk size
        $offset = 0;

        do {
            $provincies = $odoo->model('res.country.state')
                ->fields(['id', 'code', 'display_name'])
                ->offset($offset)
                ->limit($pageSize)
                ->get();
            Log::info('Provinsi retrieved from erp');

            $dataToInsert = [];

            Log::info('looping through Provinsi data');
            foreach ($provincies as $provinsi) {
                $dataToInsert[] = [
                    'id' => $provinsi->id,
                    'state_code' => $provinsi->code,
                    'display_name' => $provinsi->display_name,
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('inserting provinsi to database :' . $offset);
                $this->insertDataProvinsi($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($provincies));

        Log::info('Provinsi Sync Job Finished');
    }

    private function insertDataProvinsi(array $dataToInsert)
    {
        DB::table('provinsi')->upsert($dataToInsert, ['id'], ['state_code', 'display_name']);
    }

    public function syncKabupaten(Odoo $odoo)
    {
        Log::info('Kabupaten Sync Job Running');

        $pageSize = 100; // Set the desired chunk size
        $offset = 0;

        do {
            $kabupatens = $odoo->model('res.kabupaten')
                ->fields(['id', 'state_id', 'display_name'])
                ->offset($offset)
                ->limit($pageSize)
                ->get();
            Log::info('Kabupaten retrieved from erp');

            $dataToInsert = [];

            Log::info('looping through kabupaten data');
            foreach ($kabupatens as $kabupaten) {
                $provinsiId = is_array($kabupaten->state_id) ? $kabupaten->state_id[0] : 0;

                $dataToInsert[] = [
                    'id' => $kabupaten->id,
                    'provinsi_id' => $provinsiId,
                    'display_name' => $kabupaten->display_name,
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('inserting Kabupaten to database :' . $offset);
                $this->insertDataKabupaten($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($kabupatens));

        Log::info('Kabupaten Sync Job Finished');
    }

    public function insertDataKabupaten(array $dataToInsert)
    {
        DB::table('kabupaten')->upsert($dataToInsert, ['id'], ['provinsi_id', 'display_name']);
    }

    public function syncKecamatan(Odoo $odoo)
    {
        Log::info('Kecamatan Sync Job Running');

        $pageSize = 100;
        $offset = 0;

        do {
            $kecamatans = $odoo->model('res.kecamatan')
                ->fields(['id', 'kabupaten_id', 'display_name'])
                ->offset($offset)
                ->limit($pageSize)
                ->get();
            Log::info('Kecamatan retrieved from erp');

            $dataToInsert = [];

            Log::info('looping through kecamatan data');
            foreach ($kecamatans as $kecamatan) {
                $dataToInsert[] = [
                    'id' => $kecamatan->id,
                    'kabupaten_id' => is_array($kecamatan->kabupaten_id) ? $kecamatan->kabupaten_id[0] : 0,
                    'display_name' => $kecamatan->display_name,
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('Inserting kecamatan to database :' . $offset);
                $this->insertDataKecamatan($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($kecamatans));

        Log::info('kecamatan sync job finished');
    }

    public function insertDataKecamatan(array $dataToInsert)
    {
        DB::table('kecamatan')->upsert($dataToInsert, ['id'], ['kabupaten_id', 'display_name']);
    }

    public function syncKelurahan(Odoo $odoo)
    {
        Log::info('Kelurahan Sync Job Running');

        $pageSize = 100; // Set the desired chunk size
        $offset = 0;

        do {
            $kelurahans = $odoo->model('res.kelurahan')
                ->fields(['id', 'kecamatan_id', 'display_name'])
                ->offset($offset)
                ->limit($pageSize)
                ->get();
            Log::info('Kelurahan retrieved from erp');

            $dataToInsert = [];

            Log::info('looping through kelurahan data');
            foreach ($kelurahans as $kelurahan) {
                $dataToInsert[] = [
                    'id' => $kelurahan->id,
                    'kecamatan_id' => is_array($kelurahan->kecamatan_id) ? $kelurahan->kecamatan_id[0] : 0,
                    'display_name' => $kelurahan->display_name,
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('Inserting kelurahan to database :' . $offset);
                $this->insertDataKelurahan($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($kelurahans));

        Log::info('Kelurahan sync job finished');
    }

    public function insertDataKelurahan(array $dataToInsert)
    {
        DB::table('kelurahan')->upsert($dataToInsert, ['id'], ['kecamatan_id', 'display_name']);
    }

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        $this->syncProvinsi($odoo);
        $this->syncKabupaten($odoo);
        $this->syncKecamatan($odoo);
        $this->syncKelurahan($odoo);
        Log::info('Daerah sync finished');
    }
}
