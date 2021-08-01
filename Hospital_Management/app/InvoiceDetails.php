<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    public function getServiceName(){
        return $this->hasOne(Services::class, 'id', 'service_id');
    }

    public function getInvoiceInfo(){
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }
}
