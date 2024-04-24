<?php

namespace App\Livewire\Payment;

use App\Models\PaymentType as ModelsPaymentType;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.temp')]
class PaymentType extends Component
{
    use WithPagination;

    /// UI Variables
    public $isInsert = false;
    public $isEdit = false;

    /// Input Variables
    public $paymentType;
    public $displayName;

    /// Edit Variables
    public $paymentTypeId;
    public $paymentTypeEdit;
    public $displayNameEdit;

    public function render()
    {
        $paymentTypes = ModelsPaymentType::all();
        return view('livewire.payment.payment-type', [
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function createType()
    {
        $this->validate([
            'paymentType' => 'required',
            'displayName' => 'required',
        ], [
            'paymentType.required' => 'Nama tipe tidak boleh kosong',
            'displayName.required' => 'Display name tidak boleh kosong',
        ]);

        $paymentType = ModelsPaymentType::create([
            'type_name' => $this->paymentType,
            'display_name' => $this->displayName,
        ]);

        $this->reset(['paymentType', 'displayName']);

        session()->flash('message', 'tipe payment berhasil dibuat');

        $this->closeInsert();

        $this->resetPage();
    }

    public function openInsert()
    {
        $this->isInsert = true;
    }

    public function closeInsert()
    {
        $this->isInsert = false;
    }

    public function openEdit($id)
    {
        $paymentType = ModelsPaymentType::find($id);
        $this->paymentTypeId = $id;
        $this->paymentTypeEdit = $paymentType->type_name;
        $this->displayNameEdit = $paymentType->display_name;
        $this->isEdit = true;
    }

    public function closeEdit()
    {
        $this->isEdit = false;
        $this->reset(['paymentTypeEdit', 'displayNameEdit', 'paymentTypeId']);
    }

    public function updateType()
    {
        $this->validate([
            'paymentTypeEdit' => 'required',
            'displayNameEdit' => 'required',
        ], [
            'paymentTypeEdit.required' => 'Nama tipe tidak boleh kosong',
            'displayNameEdit.required' => 'Display name tidak boleh kosong',
        ]);

        $paymentType = ModelsPaymentType::find($this->paymentTypeId);
        $paymentType->type_name = $this->paymentTypeEdit;
        $paymentType->display_name = $this->displayNameEdit;
        $paymentType->save();

        $this->closeEdit();
    }

    public function deleteType($id)
    {
        DB::table('payment_types')->where('id', $id)->delete();
    }
}
