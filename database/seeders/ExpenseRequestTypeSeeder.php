<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseRequestType;
use App\Enums\ExpenseRequestTypeEnum;

class ExpenseRequestTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'title' => 'pay_to_vendor',
                'label' => 'Pay To Vendor',
            ],
            [
                'title' => 'pay_to_self',
                'label' => 'Pay To Self',
            ],
            [
                'title' => 'reimbursement_to_staff',
                'label' => 'Reimbursement To Staff',
            ],
        ];

        foreach ($types as $type) {
            ExpenseRequestType::updateOrCreate(
                ['title' => $type['title']],
                ['label' => $type['label']]
            );
        }
    }
}
