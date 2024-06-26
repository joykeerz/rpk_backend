<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutDocument extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class, 'out_document_id');
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }
}
