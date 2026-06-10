<?php

namespace App\Models;

use App\Enums\ExpenseTypeEnum;
use App\Models\Department;
use App\Models\ExpenseApprovals;
use App\Models\ExpenseComments;
use App\Models\ExpenseQuery;
use App\Models\ExpenseRejection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    public $fillable  = [
        'expense_request_type_id',
        'user_id',
        'status',
        'expense_category_id',
        'department_id',
        'amount',
        'description',
        'justification',
        'is_pre_authorized',
        'payment_method',
        'vendor_id',
        'transaction_reference',
        'payment_date'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function requestType(): BelongsTo
    {
        return $this->belongsTo(ExpenseRequestType::class, 'expense_request_type_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ExpenseAttachements::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(ExpenseApprovals::class, 'expense_id');
    }

    public function rejections(): HasMany
    {
        return $this->hasMany(ExpenseRejection::class, 'expense_id');
    }

    public function queries(): HasMany
    {
        return $this->hasMany(ExpenseQuery::class, 'expense_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ExpenseComments::class, 'expense_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
