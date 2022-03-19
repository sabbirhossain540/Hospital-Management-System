<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseDetails extends Model
{
    public function getExpCategoryName(){
        return $this->hasOne(ExpenceCategory::class, 'id', 'exp_category');
    }

    public function getExpenseNo(){
        return $this->hasOne(Expense::class, 'id', 'exp_id');
    }
}
