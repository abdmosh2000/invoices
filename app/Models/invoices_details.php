<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='invoices_details';


    public function invoice(){
    return $this->belongsTo(invoices::class,'invoice_id');
    }
}

