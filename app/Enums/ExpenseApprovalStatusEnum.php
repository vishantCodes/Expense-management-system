<?php

namespace App\Enums;

enum ExpenseApprovalStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case QUERY_RAISED = 'query_raised';
}
