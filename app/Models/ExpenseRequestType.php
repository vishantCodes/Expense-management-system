<?php

namespace App\Models;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseRequestType extends Model
{
    protected $guarded = ['id'];
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'expense_request_type_id');
    }
}
