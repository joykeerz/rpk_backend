<?php

namespace App\Livewire\Payment;

use App\Models\PaymentOption as ModelsPaymentOption;
use App\Models\PaymentTerm;
use App\Models\RekeningTujuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.temp')]
class PaymentOption extends Component
{
    use WithPagination;

    /// Ui Variables
    public $search;
    public $isOpen = false;
    public $perPage = 5;

    /// Input Variables
    public $rekeningTujuanId;
    public $paymentTermId;
    public $paymentType;

    /// Database Variables
    public $companyId;

    public function mount()
    {
        $this->companyId = Auth::user()->company_id;
    }

    public function render()
    {
        $paymentOptions = DB::table('payment_options')
            ->join('rekening_tujuan', 'rekening_tujuan.id', 'payment_options.rekening_tujuan_id')
            ->join('payment_terms', 'payment_terms.id', 'payment_options.payment_term_id')
            ->select(
                'payment_options.id',
                'rekening_tujuan.name as rekening_name',
                'rekening_tujuan.bank_acc_number',
                'payment_terms.name as term_name',
                'payment_options.payment_type'
            )
            ->where('payment_options.company_id', $this->companyId)
            ->where('rekening_tujuan.bank_acc_number', 'ilike', "%{$this->search}%")
            ->paginate($this->perPage);

        $rekeningTujuanList = RekeningTujuan::all();

        $paymentTerms = PaymentTerm::all();

        return view('livewire.payment.payment-option', [
            'paymentOptions' => $paymentOptions,
            'paymentTerms' => $paymentTerms,
            'rekeningTujuanList' => $rekeningTujuanList,
        ]);
    }

    public function addPayment()
    {
        $this->validate([
            'rekeningTujuanId' => 'required',
            'paymentTermId' => 'required',
            'paymentType' => 'required'
        ], [
            'rekeningTujuanId.required' => 'rekening tujuan tidak boleh kosong',
            'paymentTermId.required' => 'payment term tidak boleh kosong',
            'paymentType.required' => 'tipe payment tidak boleh kosong',
        ]);

        $paymentOptions = ModelsPaymentOption::create([
            'company_id' => $this->companyId,
            'rekening_tujuan_id' => $this->rekeningTujuanId,
            'payment_term_id' => $this->paymentTermId,
            'payment_type' => $this->paymentType
        ]);

        $this->reset(['rekeningTujuanId', 'paymentTermId', 'paymentType']);

        session()->flash('message', 'payment option berhasil dibuat');

        $this->closeModal();

        $this->resetPage();
    }

    public function delete($id)
    {
        DB::table('payment_options')->where('id', $id)->delete();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
}
