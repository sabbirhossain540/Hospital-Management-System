<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Expense extends Model
{
    public function getCreatedUser(){
        return $this->hasOne(User::class, 'id', 'created_user');
    }
}
