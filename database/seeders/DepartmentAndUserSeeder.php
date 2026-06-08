<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class DepartmentAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'super@gmail.com',
        ]);
        $superAdmin->assignRole('super-admin');

        // Finance Department
        $financeDepartment = Department::create([
            'title' => 'Finance',
            'budget' => 1000000,
        ]);

        $financeManager = User::factory()->create([
            'name' => 'Finance Manager',
            'username' => 'finance_manager',
            'email' => 'finance@gmail.com',
            'department_id' => $financeDepartment->id,
        ]);

        $financeManager->assignRole('manager');

        $financeDepartment->update([
            'manager_id' => $financeManager->id,
        ]);

        // Operations Department
        $operationsDepartment = Department::create([
            'title' => 'Operations',
            'budget' => 1000000,
        ]);

        $operationsManager = User::factory()->create([
            'name' => 'Operations Manager',
            'username' => 'operations_manager',
            'email' => 'operations@gmail.com',
            'department_id' => $operationsDepartment->id,
        ]);

        $operationsManager->assignRole('manager');

        $operationsDepartment->update([
            'manager_id' => $operationsManager->id,
        ]);

        // Human Resources Department
        $hrDepartment = Department::create([
            'title' => 'Human Resources',
            'budget' => 1000000,
        ]);

        $hrManager = User::factory()->create([
            'name' => 'HR Manager',
            'username' => 'hr_manager',
            'email' => 'hr@gmail.com',
            'department_id' => $hrDepartment->id,
        ]);

        $hrManager->assignRole('manager');

        $hrDepartment->update([
            'manager_id' => $hrManager->id,
        ]);

        // Laravel Department
        $laravelDepartment = Department::create([
            'title' => 'Laravel',
            'budget' => 1000000,
        ]);

        $laravelManager = User::factory()->create([
            'name' => 'Laravel Manager',
            'username' => 'laravel_manager',
            'email' => 'laravel@gmail.com',
            'department_id' => $laravelDepartment->id,
        ]);

        $laravelManager->assignRole('manager');

        $laravelDepartment->update([
            'manager_id' => $laravelManager->id,
        ]);

        // Node JS Department
        $nodeDepartment = Department::create([
            'title' => 'Node JS',
            'budget' => 1000000,
        ]);

        $nodeManager = User::factory()->create([
            'name' => 'Node Manager',
            'username' => 'node_manager',
            'email' => 'node@gmail.com',
            'department_id' => $nodeDepartment->id,
        ]);

        $nodeManager->assignRole('manager');

        $nodeDepartment->update([
            'manager_id' => $nodeManager->id,
        ]);

        // QA Department
        $qaDepartment = Department::create([
            'title' => 'QC and QA',
            'budget' => 1000000,
        ]);

        $qaManager = User::factory()->create([
            'name' => 'QA Manager',
            'username' => 'qa_manager',
            'email' => 'qa@gmail.com',
            'department_id' => $qaDepartment->id,
        ]);

        $qaManager->assignRole('manager');

        $qaDepartment->update([
            'manager_id' => $qaManager->id,
        ]);

        // Accounts Users
        $accounts1 = User::factory()->create([
            'name' => 'Accounts 1',
            'username' => 'accounts1',
            'email' => 'accounts1@gmail.com',
            'department_id' => $financeDepartment->id,
        ]);

        $accounts1->assignRole('accounts');

        $accounts2 = User::factory()->create([
            'name' => 'Accounts 2',
            'username' => 'accounts2',
            'email' => 'accounts2@gmail.com',
            'department_id' => $financeDepartment->id,
        ]);

        $accounts2->assignRole('accounts');

        // Staff - Finance
        User::factory(5)
            ->create(['department_id' => $financeDepartment->id])
            ->each(fn($user) => $user->assignRole('staff'));

        // Staff - Operations
        User::factory(5)
            ->create(['department_id' => $operationsDepartment->id])
            ->each(fn($user) => $user->assignRole('staff'));

        // Staff - HR
        User::factory(5)
            ->create(['department_id' => $hrDepartment->id])
            ->each(fn($user) => $user->assignRole('staff'));

        // Staff - Laravel
        User::factory(5)
            ->create(['department_id' => $laravelDepartment->id])
            ->each(fn($user) => $user->assignRole('staff'));

        // Staff - Node JS
        User::factory(5)
            ->create(['department_id' => $nodeDepartment->id])
            ->each(fn($user) => $user->assignRole('staff'));

        // Staff - QA
        User::factory(5)
            ->create(['department_id' => $qaDepartment->id])
            ->each(fn($user) => $user->assignRole('staff'));
    }
}
