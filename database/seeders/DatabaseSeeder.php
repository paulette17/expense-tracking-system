<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed departments
        $managementDept = Department::firstOrCreate(['name' => 'Management']);
        $financeDept = Department::firstOrCreate(['name' => 'Finance']);
        $hrDept = Department::firstOrCreate(['name' => 'Human Resources']);

        // Seed categories
        $this->seedCategories();

        // Seed users
        $this->seedUsers($managementDept, $financeDept, $hrDept);

        // Seed sample expenses
        $this->seedExpenses();
    }

    /**
     * Seed expense categories
     */
    private function seedCategories(): void
    {
        $categories = [
            [
                'name' => 'Office Supplies',
                'description' => 'Items like pens, paper, and staplers',
                'monthly_limit' => 5000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Transportation',
                'description' => 'Bus, train, and fuel expenses',
                'monthly_limit' => 3000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Meals',
                'description' => 'Food and dining expenses',
                'monthly_limit' => 2000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Equipment and repairs',
                'monthly_limit' => 4000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Travel',
                'description' => 'Business trips, lodging, or airfare',
                'monthly_limit' => 12000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Utilities',
                'description' => 'Electricity, water, and internet',
                'monthly_limit' => 6000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Client entertainment and team events',
                'monthly_limit' => 8000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Healthcare',
                'description' => 'Medical and wellness expenses',
                'monthly_limit' => 5000.00,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'monthly_limit' => $category['monthly_limit'],
                    'is_active' => $category['is_active'],
                ]
            );
        }
    }

    /**
     * Seed users
     */
    private function seedUsers($managementDept, $financeDept, $hrDept): void
    {
        // Test user
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'department_id' => $financeDept->id,
                'role' => 'employee',
            ]);
        }

        // Admin accounts
        $adminAccounts = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => 'admin',
                'department_id' => $managementDept->id,
        
            
                'department_id' => $hrDept->id,
            ],
        ];

        foreach ($adminAccounts as $admin) {
            if (!User::where('email', $admin['email'])->exists()) {
                User::create([
                    'name' => $admin['name'],
                    'email' => $admin['email'],
                    'password' => Hash::make($admin['password']),
                    'role' => $admin['role'],
                    'email_verified_at' => now(),
                    'department_id' => $admin['department_id'],
                ]);
            }
        }

        // Finance Staff Accounts
        $financeStaff = [
            [
                'name' => 'kim mingyu',
                'email' => 'minguy@gmail.com',
                'password' => '000000',
                'role' => 'finance_staff',
                'department_id' => $financeDept->id,
            ]
        ];

        foreach ($financeStaff as $staff) {
            if (!User::where('email', $staff['email'])->exists()) {
                User::create([
                    'name' => $staff['name'],
                    'email' => $staff['email'],
                    'password' => Hash::make($staff['password']),
                    'role' => $staff['role'],
                    'email_verified_at' => now(),
                    'department_id' => $staff['department_id'],
                ]);
            }
        }

        // Regular Employee Accounts
        $employees = [
            [
                'name' => 'pau',
                'email' => 'paulettesantor17@gmail.com',
                'password' => '123456789',
                'role' => 'employee',
                'department_id' => $managementDept->id,
            ],
            
            
            
        ];

        foreach ($employees as $employee) {
            if (!User::where('email', $employee['email'])->exists()) {
                User::create([
                    'name' => $employee['name'],
                    'email' => $employee['email'],
                    'password' => Hash::make($employee['password']),
                    'role' => $employee['role'],
                    'email_verified_at' => now(),
                    'department_id' => $employee['department_id'],
                ]);
            }
        }
    }

    /**
     * Seed sample expenses
     */
    private function seedExpenses(): void
    {
        $expenses = [
            [
                'user_id' => 3,
                'category_id' => 2,
                'title' => 'Grab/Taxi Fare',
                'description' => 'Travel cost for meeting with client in Makati.',
                'amount' => 450.00,
                'expense_date' => '2025-08-07',
                'status' => 'approved',
                'notes' => 'Client meeting',
            ],
            [
                'user_id' => 3,
                'category_id' => 4,
                'title' => 'Laptop Repair',
                'description' => 'Replacement of damaged laptop battery',
                'amount' => 3000.00,
                'expense_date' => '2025-08-01',
                'status' => 'approved',
                'notes' => null,
            ],
            [
                'user_id' => 3,
                'category_id' => 3,
                'title' => 'Team Lunch',
                'description' => 'Lunch out for staff after project completion.',
                'amount' => 2000.00,
                'expense_date' => '2025-10-01',
                'status' => 'approved',
                'notes' => null,
            ],
            [
                'user_id' => 3,
                'category_id' => 1,
                'title' => 'Printer Ink & Paper',
                'description' => 'Purchase of printing materials for reports and forms.',
                'amount' => 1200.00,
                'expense_date' => '2025-07-06',
                'status' => 'approved',
                'notes' => null,
            ],
            [
                'user_id' => 3,
                'category_id' => 2,
                'title' => 'Gasoline',
                'description' => 'Fuel refill for company car used in deliveries.',
                'amount' => 2300.00,
                'expense_date' => '2025-09-03',
                'status' => 'approved',
                'notes' => null,
            ],
            [
                'user_id' => 3,
                'category_id' => 3,
                'title' => 'Client Meeting Snacks',
                'description' => 'Coffee and snacks served during client presentation.',
                'amount' => 800.00,
                'expense_date' => '2025-08-17',
                'status' => 'rejected',
                'notes' => null,
            ],
            [
                'user_id' => 3,
                'category_id' => 1,
                'title' => 'Office chairs',
                'description' => 'New ergonomic chair for accounting staff.',
                'amount' => 4800.00,
                'expense_date' => '2025-11-01',
                'status' => 'rejected',
                'notes' => 'needed',
            ],
            [
                'user_id' => 3,
                'category_id' => 2,
                'title' => 'Taxi fare',
                'description' => 'morning commute home to office',
                'amount' => 500.00,
                'expense_date' => '2025-11-03',
                'status' => 'approved',
                'notes' => '499',
            ],
            [
                'user_id' => 3,
                'category_id' => 3,
                'title' => 'lunch meeting',
                'description' => 'for 10 people',
                'amount' => 1500.00,
                'expense_date' => '2025-11-06',
                'status' => 'rejected',
                'notes' => 'totoo to hindi kita tinatarantado',
            ],
            [
                'user_id' => 3,
                'category_id' => 1,
                'title' => 'Office Supplies Purchase',
                'description' => 'Purchased pens, paper, and folders for the accounting department.',
                'amount' => 1500.00,
                'expense_date' => '2025-11-02',
                'status' => 'approved',
                'notes' => null,
            ],
            [
                'user_id' => 1,
                'category_id' => 6,
                'title' => 'Electricity Bill',
                'description' => '1 month bill',
                'amount' => 4500.00,
                'expense_date' => '2025-11-20',
                'status' => 'pending',
                'notes' => null,
            ],
            [
                'user_id' => 3,
                'category_id' => 6,
                'title' => 'Internet Bill',
                'description' => '1 month internet expenses',
                'amount' => 2000.00,
                'expense_date' => '2025-10-02',
                'status' => 'pending',
                'notes' => null,
            ],
            [
                'user_id' => 8,
                'category_id' => 3,
                'title' => 'Team Snacks',
                'description' => 'Office snacks for team meeting',
                'amount' => 300.00,
                'expense_date' => '2025-11-20',
                'status' => 'approved',
                'notes' => null,
            ],
            [
                'user_id' => 3,
                'category_id' => 2,
                'title' => 'Fare',
                'description' => 'Daily commute fare',
                'amount' => 55.00,
                'expense_date' => '2025-11-19',
                'status' => 'rejected',
                'notes' => null,
            ],
            [
                'user_id' => 14,
                'category_id' => 5,
                'title' => 'Conference Registration',
                'description' => 'Annual business conference',
                'amount' => 5000.00,
                'expense_date' => '2025-12-01',
                'status' => 'pending',
                'notes' => 'Team development',
            ],
        ];

        foreach ($expenses as $expense) {
            Expense::firstOrCreate(
                [
                    'user_id' => $expense['user_id'],
                    'title' => $expense['title'],
                    'expense_date' => $expense['expense_date'],
                ],
                $expense
            );
        }
    }
}