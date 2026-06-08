<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Expense;

class Vendor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'gst_no',
        'bank_name',
        'account_number',
        'ifsc',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'is_active',
    ];
    public function expenserequests(): HasMany
    {
        return $this->hasMany(Expense::class, 'department_id');
    }
}
