<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'log_details',
        'controller_name',
        'function_name',
        'location',
        'ip_address',
    ];

    public function users(){
        return $this->hasOne(User::class, 'id','user_id');
    }


}
