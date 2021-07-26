<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempSales extends Model
{
    public function serviceName(){
        return $this->hasOne(Services::class, 'id', 'service_id');
    }
}
