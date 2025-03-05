<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test organisations
        $organisations = [
            [
                'name' => 'Acme Corporation',
                'email' => 'info@acme.test',
                'phone' => '555-123-4567',
                'subdomain' => 'acme'
            ],
            [
                'name' => 'Globex Industries',
                'email' => 'info@globex.test',
                'phone' => '555-987-6543',
                'subdomain' => 'globex'
            ],
            [
                'name' => 'Initech',
                'email' => 'hello@initech.test',
                'phone' => '555-456-7890',
                'subdomain' => 'initech'
            ],
            [
                'name' => 'Stark Enterprises',
                'email' => 'support@stark.test',
                'phone' => '555-789-0123',
                'subdomain' => 'stark'
            ],
            [
                'name' => 'Wayne Industries',
                'email' => 'contact@wayne.test',
                'phone' => '555-234-5678',
                'subdomain' => 'wayne'
            ]
        ];

        $this->command->info('Creating organisations...');

        foreach ($organisations as $orgData) {
            $org = Organisation::create($orgData);
            $this->command->info("Created organisation: {$orgData['name']} (subdomain: {$orgData['subdomain']})");
        }

        $this->command->info('Organisations created successfully!');
    }
}
