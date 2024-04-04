<?php

namespace App\Livewire\Payment;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.temp')]
class PaymentOption extends Component
{
    public $isEdit = false;
    public function render()
    {
        return view('livewire.payment.payment-option');
    }
}
