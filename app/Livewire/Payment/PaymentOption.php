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
    public $isOpen = false;
    public $isEdit = false;

    //query filters
    public $search;
    public $perPage = 5;
    public $statusFilter = '';
    public $sortBy = 'payment_options.created_at';
    public $sortDir = 'DESC';

    /// Input Variables
    public $rekeningTujuanId;
    public $paymentTermId;
    public $paymentType;

    // EditingVariable
    public $paymentOptionIdEdit;
    public $rekeningTujuanIdEdit;
    public $paymentTermIdEdit;
    public $paymentTypeEdit;

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
            ->orderBy($this->sortBy, $this->sortDir)
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

    public function setSortBy($sortByColumn)
    {
        if ($this->sortBy === $sortByColumn) {
            $this->sortDir = ($this->sortDir == "ASC" ? "DESC" : "ASC");
            return;
        }

        $this->sortBy = $sortByColumn;
        $this->sortDir = "DESC";
    }

    public function openEdit($id)
    {
        $paymentOption = ModelsPaymentOption::find($id);
        $this->paymentOptionIdEdit = $id;
        $this->rekeningTujuanIdEdit = $paymentOption->rekening_tujuan_id;
        $this->paymentTermIdEdit = $paymentOption->payment_term_id;
        $this->paymentTypeEdit = $paymentOption->payment_type;
        $this->isEdit = true;
    }

    public function saveEdit()
    {
        $this->validate([
            'rekeningTujuanIdEdit' => 'required',
            'paymentTermIdEdit' => 'required',
            'paymentTypeEdit' => 'required'
        ], [
            'rekeningTujuanIdEdit.required' => 'rekening tujuan tidak boleh kosong',
            'paymentTermIdEdit.required' => 'payment term tidak boleh kosong',
            'paymentTypeEdit.required' => 'tipe payment tidak boleh kosong',
        ]);

        $paymentOption = ModelsPaymentOption::find($this->paymentOptionIdEdit);
        $paymentOption->rekening_tujuan_id = $this->rekeningTujuanIdEdit;
        $paymentOption->payment_term_id = $this->paymentTermIdEdit;
        $paymentOption->payment_type = $this->paymentTypeEdit;
        $paymentOption->save();
        $this->reset(['paymentOptionIdEdit', 'rekeningTujuanIdEdit', 'paymentTermIdEdit', 'paymentTypeEdit']);
        $this->closeEdit();
    }

    public function closeEdit()
    {
        $this->reset(['rekeningTujuanIdEdit', 'paymentTermIdEdit', 'paymentTypeEdit']);
        $this->isEdit = false;
    }
}
