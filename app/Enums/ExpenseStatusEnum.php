<?php

namespace App\Enums;

enum ExpenseStatusEnum: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case PARTIALLY_APPROVED = 'partially_approved';
    case REJECTED = 'rejected';
    case QUERY_RAISED = 'query_raised';
    case CANCELLED = 'cancelled';
}
