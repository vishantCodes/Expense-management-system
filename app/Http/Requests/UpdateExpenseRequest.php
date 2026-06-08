<?php

namespace App\Http\Requests;

use App\Enums\ExpenseRequestTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateExpenseRequest extends FormRequest
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
            'expense_request_type_id'   => ['sometimes', 'exists:expense_request_types,id'],
            'expense_category_id'       => ['sometimes', 'required', 'exists:expense_categories,id'],
            'department_id'             => ['sometimes', 'required', 'exists:departments,id'],
            'amount'                    => ['sometimes', 'required', 'numeric', 'min:0', 'decimal:0,2'],
            'description'               => ['nullable', 'string'],
            'justification'             => ['sometimes', 'required', 'string'],
            'is_pre_authorized'         => ['sometimes', 'boolean'],
            'payment_method'            => ['nullable', 'in:any,online,cash,cheque'],
            'vendor_id'                 => ['sometimes', 'required', 'exists:vendors,id'],
            'transaction_reference'     => ['nullable', 'string'],
            'payment_date'              => ['sometimes', 'required', 'date'],
            'attachments'               => ['nullable', 'array'],
            'attachments.*'             => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:10240'],
        ];
    }
}
