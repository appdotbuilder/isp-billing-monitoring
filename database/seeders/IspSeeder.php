<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class IspSeeder extends Seeder
{
    /**
     * Run the ISP database seeds.
     */
    public function run(): void
    {
        // Create Parent Company
        $parentCompany = Company::create([
            'name' => 'TechNet ISP Solutions',
            'slug' => 'technet-isp',
            'email' => 'admin@technet-isp.com',
            'phone' => '+1-555-0100',
            'address' => '123 Technology Boulevard, Tech City, TC 12345',
            'type' => 'parent',
            'parent_id' => null,
            'is_active' => true,
            'settings' => [
                'timezone' => 'UTC',
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'default_service_plans' => [
                    'Basic 10Mbps' => 29.99,
                    'Standard 25Mbps' => 49.99,
                    'Premium 50Mbps' => 79.99,
                    'Ultimate 100Mbps' => 129.99,
                ],
            ],
        ]);

        // Create Super Admin
        $superAdmin = User::create([
            'company_id' => null, // Super admin can access all companies
            'name' => 'Super Administrator',
            'email' => 'superadmin@technet-isp.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
            'permissions' => [
                'all_permissions' => true,
                'multi_tenant_access' => true,
                'self_healing' => true,
            ],
        ]);

        // Create Parent Company Admin
        $parentAdmin = User::create([
            'company_id' => $parentCompany->id,
            'name' => 'John Smith',
            'email' => 'john@technet-isp.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'permissions' => [
                'company_management' => true,
                'device_monitoring' => true,
                'customer_management' => true,
                'billing_access' => true,
                'employee_management' => true,
            ],
        ]);

        // Create Tenant Companies
        $tenantCompanies = [];
        
        $tenants = [
            [
                'name' => 'Metro Fiber Networks',
                'email' => 'admin@metro-fiber.com',
                'phone' => '+1-555-0200',
                'address' => '456 Metro Street, Metro City, MC 23456',
            ],
            [
                'name' => 'Rural Connect ISP',
                'email' => 'admin@ruralconnect.com',
                'phone' => '+1-555-0300',
                'address' => '789 Rural Route, Country Town, CT 34567',
            ],
            [
                'name' => 'City Wireless Solutions',
                'email' => 'admin@citywireless.com',
                'phone' => '+1-555-0400',
                'address' => '321 Wireless Way, Urban Center, UC 45678',
            ],
        ];

        foreach ($tenants as $tenantData) {
            $tenant = Company::create([
                'name' => $tenantData['name'],
                'slug' => str()->slug($tenantData['name']),
                'email' => $tenantData['email'],
                'phone' => $tenantData['phone'],
                'address' => $tenantData['address'],
                'type' => 'tenant',
                'parent_id' => $parentCompany->id,
                'is_active' => true,
                'settings' => [
                    'timezone' => 'America/New_York',
                    'currency' => 'USD',
                    'billing_cycle' => 'monthly',
                ],
            ]);

            $tenantCompanies[] = $tenant;

            // Create tenant admin
            User::create([
                'company_id' => $tenant->id,
                'name' => 'Admin ' . explode(' ', $tenantData['name'])[0],
                'email' => $tenantData['email'],
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'permissions' => [
                    'device_monitoring' => true,
                    'customer_management' => true,
                    'billing_access' => true,
                    'employee_management' => true,
                ],
            ]);

            // Create devices for each tenant
            Device::factory(8)->create(['company_id' => $tenant->id]);
            Device::factory(3)->online()->create(['company_id' => $tenant->id]);
            Device::factory(2)->offline()->create(['company_id' => $tenant->id]);

            // Create customers for each tenant
            $customers = Customer::factory(25)->create(['company_id' => $tenant->id]);
            Customer::factory(5)->suspended()->create(['company_id' => $tenant->id]);

            // Create employees for each tenant
            Employee::factory(8)->create(['company_id' => $tenant->id]);
            Employee::factory(2)->manager()->create(['company_id' => $tenant->id]);

            // Create billing records for customers
            foreach ($customers->take(20) as $customer) {
                Billing::factory(3)->create([
                    'company_id' => $tenant->id,
                    'customer_id' => $customer->id,
                ]);
                
                Billing::factory(2)->paid()->create([
                    'company_id' => $tenant->id,
                    'customer_id' => $customer->id,
                ]);
                
                Billing::factory(1)->overdue()->create([
                    'company_id' => $tenant->id,
                    'customer_id' => $customer->id,
                ]);
            }

            // Create some users for each tenant
            User::factory(3)->create([
                'company_id' => $tenant->id,
                'role' => 'technician',
            ]);
            
            User::factory(2)->create([
                'company_id' => $tenant->id,
                'role' => 'manager',
            ]);
        }

        // Create some parent company devices
        Device::factory(15)->create(['company_id' => $parentCompany->id]);
        Device::factory(5)->online()->create(['company_id' => $parentCompany->id]);
        Device::factory(3)->offline()->create(['company_id' => $parentCompany->id]);

        // Create parent company employees
        Employee::factory(12)->create(['company_id' => $parentCompany->id]);
        Employee::factory(3)->manager()->create(['company_id' => $parentCompany->id]);

        $this->command->info('ISP seeder completed successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: superadmin@technet-isp.com / password');
        $this->command->info('Parent Admin: john@technet-isp.com / password');
        $this->command->info('Tenant Admins: admin@metro-fiber.com / password');
        $this->command->info('               admin@ruralconnect.com / password');
        $this->command->info('               admin@citywireless.com / password');
    }
}