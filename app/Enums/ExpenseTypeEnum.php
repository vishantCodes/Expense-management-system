<?php

namespace App\Enums;

enum ExpenseTypeEnum: string
{
    case PAY_TO_VENDOR = 'Pay to Vendor';
    case PAY_TO_SELF = 'Pay to Self';
    case REIMBURMENT_TO_STAFF = 'Reimbursement to Staff';
}
