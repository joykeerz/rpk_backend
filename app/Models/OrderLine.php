<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }

    public function outDocument()
    {
        return $this->belongsTo(OutDocument::class, 'out_document_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
