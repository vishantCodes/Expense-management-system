<?php

namespace App\Http\Requests;

use App\Enums\ExpenseRequestTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'expense_request_type_id' => ['required', 'exists:expense_request_types,id'],
            'expense_category_id'     => ['required', 'exists:expense_categories,id'],
            'department_id'           => ['required', 'exists:departments,id'],
            'amount'                  => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'description'             => ['nullable'],
            'justification'           => ['required'],
            'is_pre_authorized'       => ['required', 'boolean'],
            'payment_method'          => ['nullable', 'in:any,online,cash,cheque'],
            'vendor_id'               => ['required', 'exists:vendors,id'],
            'transaction_reference'   => ['nullable'],
            'payment_date'            => ['required', 'date'],
            'attachments'             => ['nullable', 'array'],
            'attachments.*'           => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:10240'],
        ];
    }
}
