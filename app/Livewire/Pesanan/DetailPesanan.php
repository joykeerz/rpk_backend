<?php

namespace App\Livewire\Pesanan;

use App\Models\Company;
use App\Models\Kurir;
use App\Models\OrderLine;
use App\Models\Pesanan;
use App\Models\RekeningTujuan;
use App\Models\SalesOrder;
use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Obuchmann\OdooJsonRpc\Odoo;
use stdClass;

#[Layout('layouts.temp')]
class DetailPesanan extends Component
{
    public $transactionId;
    public $gudangId;
    public $isEdit = false;

    //input variables
    public $tipePembayaran;
    public $statusPembayaran;
    public $statusPemesanan;
    public $kurir;

    //database variables

    public function mount($id)
    {
        $this->transactionId = $id;
    }

    public function render()
    {
        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->join('alamat', 'alamat.id', '=', 'pesanan.alamat_id')
            ->join('kurir', 'kurir.id', '=', 'pesanan.kurir_id')
            ->where('transaksi.id', '=', $this->transactionId)
            ->select('transaksi.*', 'pesanan.*', 'users.*', 'alamat.*', 'kurir.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid', 'alamat.id as aid', 'kurir.id as kid', 'transaksi.created_at as cat')
            ->first();

        $detailPesanan = DB::table('detail_pesanan')
            ->join('produk', 'produk.id', '=', 'detail_pesanan.produk_id')
            ->join('pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->where('pesanan.id', '=', $transaksi->pesanan_id)
            ->select('detail_pesanan.*', 'produk.*', 'detail_pesanan.id as did', 'produk.id as pid')
            ->get();

        $salesOrders = SalesOrder::where('transaksi_id', $this->transactionId)->get();
        foreach ($salesOrders as $salesOrder) {
            $salesOrder->load('orderLines');
        }
        $statusPemesananOpt = ['menunggu verifikasi', 'diproses', 'dikirim', 'selesai', 'batal'];

        $kurirOpt = Kurir::all();

        $this->gudangId = $transaksi->gudang_id;

        return view('livewire.pesanan.detail-pesanan', [
            'transaksi' => $transaksi,
            'detailPesanan' => $detailPesanan,
            'statusPemesananOpt' => $statusPemesananOpt,
            'kurirOpt' => $kurirOpt,
            'salesOrders' => $salesOrders
        ]);
    }

    public function toggleEdit($id)
    {
        if ($this->isEdit == true) {
            $this->update($id);
        } else {
            $transaksi = Transaksi::find($id);
            $pesanan = Pesanan::find($transaksi->pesanan_id);
            $this->tipePembayaran = $transaksi->tipe_pembayaran;
            $this->statusPembayaran = $transaksi->status_pembayaran;
            $this->statusPemesanan = $pesanan->status_pemesanan;
            $this->kurir = $pesanan->kurir_id;
        }
        $this->isEdit = !$this->isEdit;
    }

    public function update($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->tipe_pembayaran = $this->tipePembayaran;
        $transaksi->status_pembayaran = $this->statusPembayaran;
        $transaksi->save();

        $pesanan = Pesanan::find($transaksi->pesanan_id);
        $pesanan->status_pemesanan = $this->statusPemesanan;
        $pesanan->kurir_id = $this->kurir;
        $pesanan->save();

        if ($pesanan->status_pemesanan == 'diproses') {
            $detailPesananList = DB::table('detail_pesanan')->where('pesanan_id', $pesanan->id)->get();
            foreach ($detailPesananList as $key => $detailPesanan) {
                $currentStok = Stok::where('gudang_id', $this->gudangId)->where('produk_id', $detailPesanan->produk_id)->first();
                if ($currentStok->jumlah_stok == 0 || $currentStok->jumlah_stok < $detailPesanan->qty) {
                    session()->flash('error', 'Pesanan gagal ditambahkan, stok tidak mencukupi');
                } else {
                    $currentStok->decrement('jumlah_stok', $detailPesanan->qty);
                    $currentStok->save();
                }
            }
        }

        $this->clearInput();
    }

    public function clearInput()
    {
        $this->reset('tipePembayaran', 'statusPembayaran', 'statusPemesanan', 'kurir');
    }

    public function debugOdoo(Odoo $odoo)
    {
        // $soFromErp = $odoo->model('account.journal')->where('id', '=', '40851')->first();
        // $soFromErp = $odoo->model('account.payment.term')->where('id', '=', '1')->first();
        // $soFromErp = $odoo->model('res.company')->where('id', '=', '137')->first();
        // $soFromErp = $odoo->model('sale.order')->where('id', '=', '998103')->first();
        // $res = $odoo->model('sale.order.line')->where('id', '=', '1153486')->first();
        // dd($soFromErp);

        $detailPesananToPush = [];
        $companyId = Auth::user()->company_id;
        $pricelistId = Company::find($companyId)->pluck('pricelist_id')->first();
        $rekeningTujuan = RekeningTujuan::where('name', 'NOT ILIKE', '%cod%')->where('company_id', $companyId)->pluck('id')->first();

        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->join('biodata', 'biodata.user_id', 'users.id')
            ->join('alamat', 'alamat.id', '=', 'pesanan.alamat_id')
            ->join('kurir', 'kurir.id', '=', 'pesanan.kurir_id')
            ->where('transaksi.id', '=', $this->transactionId)
            ->select('biodata.branch_id', 'biodata.kode_customer', 'transaksi.*', 'pesanan.*', 'users.*', 'alamat.*', 'kurir.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid', 'alamat.id as aid', 'kurir.id as kid', 'transaksi.created_at as cat')
            ->first();

        $parts = explode('-', $transaksi->kode_customer);
        $kodeCustomer = intval($parts[0]);

        $detailPesanan = DB::table('detail_pesanan')
            ->join('produk', 'produk.id', '=', 'detail_pesanan.produk_id')
            ->join('pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->where('pesanan.id', '=', $transaksi->pesanan_id)
            ->select('detail_pesanan.*', 'produk.*', 'detail_pesanan.id as did', 'produk.id as pid')
            ->get();

        foreach ($detailPesanan as $key => $itemPesanan) {
            $detail = new stdClass();
            $detail->product_id = $itemPesanan->pid;
            $detail->product_uom_qty = intval($itemPesanan->qty);
            $detail->price_unit = intval($itemPesanan->harga);
            $detailPesananToPush[] = [0, 0, $detail];
        }

        $id = $odoo->create('sale.order', [
            'partner_id' => $kodeCustomer,
            'branch_id' => intval($transaksi->branch_id),
            'warehouse_id' => intval($this->gudangId),
            'penjualan_type_id' => 2,
            'pricelist_id' => $pricelistId,
            'analytic_account_id' => 2582, //analytic account
            'team_id' => 11, // sub saluran penjualan
            'origin' => "mobile rpk",
            'payment_term_id' => 1,
            'cara_pembayaran' => $transaksi->tipe_pembayaran,
            'sale_type' => 'komersial',
            'pso_type' => 30,
            'order_line' => $detailPesananToPush,
            'journal_id' => $rekeningTujuan, // ini nomor rekening
        ]);

        $soFromErp = $odoo->model('sale.order')->where('id', '=', $id)->first();
        $salesOrder = new SalesOrder;
        $salesOrder->transaksi_id = $this->transactionId;
        $salesOrder->erp_sale_order_id = $id;
        $salesOrder->sale_order_code = $soFromErp->name;
        $salesOrder->sale_order_status = $soFromErp->state;
        $salesOrder->save();

        foreach ($soFromErp->order_line as $key => $orderLineId) {
            $orderLineDetail = $odoo->model('sale.order.line')->where('id', '=', $orderLineId)->first();

            $newOrderLine = new OrderLine;
            $newOrderLine->sales_order_id = $salesOrder->id;
            $newOrderLine->produk_id = $orderLineDetail->product_id[0];
            $newOrderLine->qty_done = $orderLineDetail->product_uom_qty;
            $newOrderLine->uom = $orderLineDetail->sh_sec_uom[1];
            $newOrderLine->save();
        }

        $isConfirmSo = $this->confirmSalesOrder($id);

        if ($isConfirmSo) {
            $soFromErp = $odoo->model('sale.order')->where('id', '=', $id)->first();
            $salesOrder->sale_order_code = $soFromErp->name;
            $salesOrder->sale_order_status = $soFromErp->state;
            $salesOrder->save();
        }
    }

    public function confirmSalesOrder($id)
    {
        $odooUrl = 'http://10.254.222.80:8069/web/session/authenticate';

        $database = 'beras_erp_dev';
        $username = 'admin';
        $password = 'admin';

        $loginPayload = [
            'jsonrpc' => '2.0',
            'method' => 'call',
            'params' => [
                'login' => $username,
                'password' => $password,
                'db' => $database,
            ],
            'id' => 1,
        ];

        $loginResponse = Http::post($odooUrl, $loginPayload);

        if ($loginResponse->successful()) {
            $odooUrl = 'http://10.254.222.80:8069/web/dataset/call_kw';

            $sessionId = $loginResponse->json()['result']['session_id'];

            $executePayload = [
                'jsonrpc' => '2.0',
                'method' => 'call',
                'id' => 2,
                'params' => [
                    'context' => [],
                    'model' => 'sale.order',
                    'method' => 'action_confirm',
                    'args' => [$id],
                    'kwargs' => [
                        'context' => []
                    ]
                ]
            ];

            $executeResponse = Http::withHeaders(['Cookie' => 'session_id=' . $sessionId])->post($odooUrl, $executePayload);

            if ($executeResponse->successful()) {
                $result = $executeResponse->json()['result'];
                return $result;
            } else {
                $errorMessage = $executeResponse->json()['error']['message'];
                dump($id);
                dump($errorMessage);
            }
        } else {
            $errorMessage = $loginResponse->json()['error']['message'];
            dump($id);
            dump($errorMessage);
        }
    }
}
