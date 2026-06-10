<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'manager_id',
        'budget',
    ];

    public function staff(): HasMany
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'department_id');
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(DepartmentBudget::class);
    }
}
