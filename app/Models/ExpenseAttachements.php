<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseAttachements extends Model
{
    use SoftDeletes;

    public $fillable  = [
        'file_path',
        'file_name',
        'uploaded_by'
    ];
    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }
}
