<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function getPatient(){
        return $this->hasOne(User::class, 'id', 'pataint_id');
    }

    public function getDoctor(){
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }

    public function getReference(){
        return $this->hasOne(References::class, 'id', 'reference_id');
    }

    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetails::class, 'invoice_id', 'id');
    }

    public function getCreatedUser(){
        return $this->hasOne(User::class, 'id', 'created_user');
    }
}
