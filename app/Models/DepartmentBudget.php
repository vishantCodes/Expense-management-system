<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentBudget extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'year',
        'month',
        'amount',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
