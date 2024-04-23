<?php

namespace App\Livewire\Payment;

use App\Models\PaymentType as ModelsPaymentType;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.temp')]
class PaymentType extends Component
{
    use WithPagination;

    ///UI Variables
    public $isOpen = false;

    public function render()
    {
        $paymentTypes = ModelsPaymentType::all();
        return view('livewire.payment.payment-type', [
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function createType()
    {
    }
}
