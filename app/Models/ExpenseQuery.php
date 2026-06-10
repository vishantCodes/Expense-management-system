<?php

namespace App\Models;

use App\Models\ExpenseQueryCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseQuery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'expense_id',
        'requester_id',
        'expense_query_category_id',
        'status',
        'remarks',
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseQueryCategory::class, 'expense_query_category_id');
    }
}
