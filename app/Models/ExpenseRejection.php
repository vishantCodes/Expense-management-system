<?php

namespace App\Models;

use App\Models\ExpenseRejectionCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseRejection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'expense_id',
        'rejecter_id',
        'rejection_category_id',
        'remarks',
    ];

    public function rejecter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejecter_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseRejectionCategory::class, 'rejection_category_id');
    }
}
