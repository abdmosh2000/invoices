<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded=[];

    public function section(){
return $this->belongsTo(sections::class,'section_id')->withDefault();
    }
    public function invoiceDetails(){
        return $this->hasOne(invoices_details::class,'invoice_id');
    }
}
