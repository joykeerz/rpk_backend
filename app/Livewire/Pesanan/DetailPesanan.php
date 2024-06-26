<?php

namespace App\Livewire\Pesanan;

use App\Models\Company;
use App\Models\Kurir;
use App\Models\OrderLine;
use App\Models\OutDocument;
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
    public $isDocumentOut = true;
    public $SoCode;

    //input variables
    public $tipePembayaran;
    public $statusPembayaran;
    public $statusPemesanan;
    public $kurir;

    //database variables

    public function mount($id)
    {
        $this->transactionId = $id;
        $checkSo = SalesOrder::where('transaksi_id', $this->transactionId)->first();
        if ($checkSo) {
            $this->isDocumentOut = false;
            $this->SoCode = $checkSo->sale_order_code;
        }
    }

    public function render()
    {
        // dd($this->isDocumentOut);
        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->join('kurir', 'kurir.id', '=', 'pesanan.kurir_id')
            ->join('alamat', 'alamat.id', '=', 'pesanan.alamat_id')
            ->join('provinsi', 'provinsi.id', '=', 'alamat.provinsi_id')
            ->join('kabupaten', 'kabupaten.id', '=', 'alamat.kabupaten_id')
            ->join('kecamatan', 'kecamatan.id', '=', 'alamat.kecamatan_id')
            ->join('kelurahan', 'kelurahan.id', '=', 'alamat.kelurahan_id')
            ->where('transaksi.id', '=', $this->transactionId)
            ->select(
                'transaksi.*',
                'pesanan.*',
                'users.*',
                'alamat.*',
                'kurir.*',
                'transaksi.id as tid',
                'pesanan.id as pid',
                'users.id as uid',
                'alamat.id as aid',
                'kurir.id as kid',
                'transaksi.created_at as cat'
            )
            ->first();

        $detailPesanan = DB::table('detail_pesanan')
            ->join('produk', 'produk.id', '=', 'detail_pesanan.produk_id')
            ->join('pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->where('pesanan.id', '=', $transaksi->pesanan_id)
            ->select('detail_pesanan.*', 'produk.*', 'detail_pesanan.id as did', 'produk.id as pid')
            ->get();

        $paymentOptionInfo = DB::table('payment_options')
            ->join('rekening_tujuan', 'rekening_tujuan.id', 'payment_options.rekening_tujuan_id')
            ->join('payment_terms', 'payment_terms.id', 'payment_options.payment_term_id')
            ->join('payment_types', 'payment_types.id', 'payment_options.payment_type_id')
            ->where('payment_options.id', $transaksi->payment_option_id)
            ->select(
                'payment_options.id as payment_options_id',
                'payment_options.payment_type',
                'rekening_tujuan.display_name',
                'rekening_tujuan.bank_acc_number',
                'payment_terms.name',
                'payment_types.display_name as payment_type_display'
            )
            ->first();

        /* Alternate Query*/
        // $salesOrders = SalesOrder::where('transaksi_id', $this->transactionId)->get();
        // foreach ($salesOrders as $salesOrder) {
        //     $salesOrder->load('orderLines.produk');
        //     $salesOrder->load('outDocuments');
        // }

        /* Alternate Query 2*/
        // $salesOrders = SalesOrder::where('transaksi_id', $this->transactionId)
        //     ->with(['orderLines.produk', 'outDocuments'])
        //     ->get();

        $salesOrders = SalesOrder::where('transaksi_id', $this->transactionId)
            ->with([
                'orderLines' => function ($query) {
                    $query->with('produk');
                },
                'outDocuments' => function ($query) {
                    $query->with([
                        'orderLines' => function ($query) {
                            $query->with('produk');
                        }
                    ]);
                }
            ])
            ->get();
            dd($salesOrders);

        $statusPemesananOpt = ['menunggu verifikasi', 'terverifikasi', 'diproses', 'dikirim', 'selesai', 'batal', 'diterima'];

        $kurirOpt = Kurir::all();

        $this->gudangId = $transaksi->gudang_id;

        return view('livewire.pesanan.detail-pesanan', [
            'transaksi' => $transaksi,
            'detailPesanan' => $detailPesanan,
            'statusPemesananOpt' => $statusPemesananOpt,
            'kurirOpt' => $kurirOpt,
            'salesOrders' => $salesOrders,
            'paymentOptionInfo' => $paymentOptionInfo
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
                    // $currentStok->decrement('jumlah_stok', $detailPesanan->qty);
                    // $currentStok->save();
                }
            }
        }

        if ($pesanan->status_pemesanan == 'dikirim') {
            $pesanan->is_delivered = true;
            $pesanan->save();
        }

        if ($pesanan->status_pemesanan == 'selesai') {
            // code
        }

        if ($pesanan->status_pemesanan == 'batal') {
            // code
        }

        $this->clearInput();
        session()->flash('message', 'Detail pesanan berhasil diupdate');
    }

    public function clearInput()
    {
        $this->reset('tipePembayaran', 'statusPembayaran', 'statusPemesanan', 'kurir');
    }

    public function generateSalesOrder(Odoo $odoo)
    {
        /* Initiate data */
        $detailPesananToPush = [];
        $companyId = Auth::user()->company_id;
        $pricelistId = Company::find($companyId)->pluck('pricelist_id')->first();

        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'pesanan.id', '=', 'transaksi.pesanan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->join('biodata', 'biodata.user_id', 'users.id')
            ->join('alamat', 'alamat.id', '=', 'pesanan.alamat_id')
            ->join('kurir', 'kurir.id', '=', 'pesanan.kurir_id')
            ->where('transaksi.id', '=', $this->transactionId)
            ->select('biodata.branch_id', 'biodata.kode_customer', 'transaksi.*', 'pesanan.*', 'users.*', 'alamat.*', 'kurir.*', 'transaksi.id as tid', 'pesanan.id as pid', 'users.id as uid', 'alamat.id as aid', 'kurir.id as kid', 'transaksi.created_at as cat')
            ->first();

        $paymentOptionData = DB::table('payment_options')
            ->join('rekening_tujuan', 'rekening_tujuan.id', 'payment_options.rekening_tujuan_id')
            ->join('payment_terms', 'payment_terms.id', 'payment_options.payment_term_id')
            ->join('payment_types', 'payment_types.id', 'payment_options.payment_type_id')
            ->where('payment_options.id', $transaksi->payment_option_id)
            ->select(
                'payment_options.id as payment_options_id',
                'rekening_tujuan.id as rekening_tujuan_id',
                'payment_terms.id as payment_terms_id',
                'payment_types.id as payment_type_id',
                'payment_types.display_name',
                'payment_types.type_name',
            )
            ->first();

        $kodeCustomerParts = explode('-', $transaksi->kode_customer);
        $kodeCustomer = intval($kodeCustomerParts[0]);

        $detailPesanan = DB::table('detail_pesanan')
            ->join('produk', 'produk.id', '=', 'detail_pesanan.produk_id')
            ->join('pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->where('pesanan.id', '=', $transaksi->pesanan_id)
            ->select('detail_pesanan.*', 'produk.*', 'detail_pesanan.id as did', 'produk.id as pid')
            ->get();

        /* Prepare detail pesanan for sending to ERP */
        foreach ($detailPesanan as $key => $itemPesanan) {
            $detail = new stdClass();
            $detail->product_id = $itemPesanan->pid;
            $detail->product_uom_qty = intval($itemPesanan->qty);
            $detail->price_unit = intval($itemPesanan->harga);
            $detail->warehouse_id = intval($this->gudangId);
            $detailPesananToPush[] = [0, 0, $detail];
        }

        /* Create SO in ERP */
        $id = $odoo->create('sale.order', [
            'partner_id' => $kodeCustomer,
            'branch_id' => intval($transaksi->branch_id),
            'company_id' => intval($companyId),
            'warehouse_id' => intval($this->gudangId),
            'penjualan_type_id' => 2,
            'is_from_rpk_mobile' => 't', // ini value true
            'pricelist_id' => $pricelistId,
            'analytic_account_id' => 2582, //analytic account
            'team_id' => 11, // sub saluran penjualan
            'origin' => "mobile rpk",
            'payment_term_id' => $paymentOptionData->payment_terms_id,
            'cara_pembayaran' => $paymentOptionData->type_name,
            'sale_type' => 'komersial',
            'pso_type' => 30,
            'order_line' => $detailPesananToPush,
            'journal_id' => $paymentOptionData->rekening_tujuan_id, // ini nomor rekening
        ]);

        /* Create SO in RPK Backend from ERP result */
        $soFromErp = $odoo->model('sale.order')->where('id', '=', $id)->first();
        $salesOrder = new SalesOrder;
        $salesOrder->transaksi_id = $this->transactionId;
        $salesOrder->erp_sale_order_id = $id;
        $salesOrder->sale_order_code = $soFromErp->name;
        $salesOrder->sale_order_status = $soFromErp->state;
        $salesOrder->save();

        /* Create order lines in RPK Backend from ERP result */
        foreach ($soFromErp->order_line as $key => $orderLineId) {
            $orderLineDetail = $odoo->model('sale.order.line')->where('id', '=', $orderLineId)->first();
            $newOrderLine = new OrderLine;
            $newOrderLine->sales_order_id = $salesOrder->id;
            $newOrderLine->produk_id = $orderLineDetail->product_id[0];
            $newOrderLine->ordered_quantity = $orderLineDetail->product_uom_qty;
            $newOrderLine->qty_done = 0;
            $newOrderLine->uom = $orderLineDetail->sh_sec_uom[1];
            $newOrderLine->save();
        }

        /* Trigger confirm So in ERP */
        $isConfirmSo = $this->confirmSalesOrder($id);

        /* If SO confirmation successful */
        if ($isConfirmSo) {
            /* Update SO in backend with generated name and status from ERP result */
            $soFromErp = $odoo->model('sale.order')->where('id', '=', $id)->first();
            $salesOrder->sale_order_code = $soFromErp->name;
            $salesOrder->sale_order_status = $soFromErp->state;
            $salesOrder->save();

            /* Create document out in backend from ERP result */
            $outDocumentErp  = $odoo->model('stock.picking')->where('id', '=', $soFromErp->picking_ids[0])->first();
            $outDocument = new OutDocument;
            $outDocument->sales_order_id = $salesOrder->id;
            $outDocument->out_document_code = $outDocumentErp->name;
            $outDocument->out_document_status = $outDocumentErp->state;
            $outDocument->scheduled_date = $outDocumentErp->scheduled_date;
            $outDocument->plat_number = $outDocumentErp->plat_number ? $outDocumentErp->plat_number : 'none';
            $outDocument->driver = $outDocumentErp->driver ? $outDocumentErp->driver : 'none';
            $outDocument->save();

            $allOrderLines = OrderLine::where('sales_order_id', $salesOrder->id)->update([
                "out_document_id" => $outDocument->id,
            ]);
        }

        /* Update pesanan status in backend */
        $pesanan = Pesanan::where('id', $transaksi->pesanan_id)->first();
        $pesanan->status_pemesanan = 'diproses';
        $pesanan->save();

        /* Set isDocumentOut state to true in livewire component */
        $this->isDocumentOut = true;
        $this->SoCode = $soFromErp->name;
        session()->flash('message', 'SO berhasil ditambahkan ke ERP. Code : ' . $soFromErp->name);
    }

    public function confirmSalesOrder($id)
    {
        // $odooUrl = 'http://10.254.222.80:8069/web/session/authenticate'; /// dev
        $odooUrl = 'http://10.254.223.80:8069/web/session/authenticate'; /// test

        // $database = 'beras_erp_dev'; /// dev
        $database = 'beras_erp_06122023'; /// test
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
            // $odooUrl = 'http://10.254.222.80:8069/web/dataset/call_kw'; /// dev
            $odooUrl = 'http://10.254.223.80:8069/web/dataset/call_kw'; /// test

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

    public function closeAlert()
    {
        session()->forget('message');
    }
}
