<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use App\Models\ExpenseQueryCategory;
use App\Models\ExpenseRejectionCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (
            [
                'Travel',
                'Food',
                'Accommodation',
                'Office Supplies',
                'Software & Subscriptions',
                'Fuel',
                'Marketing',
                'Training',
                'Utilities',
                'Miscellaneous',
                'Stationery'
            ] as $title
        ) {
            ExpenseCategory::firstOrCreate([
                'title' => $title,
            ]);
        }

        foreach (
            [
                'Insufficient Documentation',
                'Budget Exceeded',
                'Policy Violation',
                'Duplicate Request',
                'Vendor Verification Failed',
                'Incorrect Amount',
                'Missing Approval',
                'Other',
            ] as $title
        ) {
            ExpenseRejectionCategory::firstOrCreate([
                'title' => $title,
            ]);
        }

        foreach (
            [
                'Missing Invoice',
                'Amount Clarification',
                'Vendor Details Required',
                'Expense Justification',
                'Supporting Documents Required',
                'Approval Clarification',
                'Other',
            ] as $title
        ) {
            ExpenseQueryCategory::firstOrCreate([
                'title' => $title,
            ]);
        }
    }
}
