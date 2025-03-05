<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organisation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all organisations
        $organisations = Organisation::all();

        if ($organisations->isEmpty()) {
            $this->command->error('No organisations found. Please run OrganisationSeeder first.');
            return;
        }

        $this->command->info('Creating users for each organisation...');

        // Create consistent test users for each organisation
        foreach ($organisations as $organisation) {
            // Create an admin user
            $admin = User::create([
                'name' => $organisation->name . ' Admin',
                'email' => 'admin@' . $organisation->subdomain . '.test',
                'password' => Hash::make('password123'),
                'organisation_id' => $organisation->id,
                'email_verified_at' => now(),
            ]);

            // Create a manager user
            $manager = User::create([
                'name' => $organisation->name . ' Manager',
                'email' => 'manager@' . $organisation->subdomain . '.test',
                'password' => Hash::make('password123'),
                'organisation_id' => $organisation->id,
                'email_verified_at' => now(),
            ]);

            // Create a regular user
            $user = User::create([
                'name' => $organisation->name . ' User',
                'email' => 'user@' . $organisation->subdomain . '.test',
                'password' => Hash::make('password123'),
                'organisation_id' => $organisation->id,
                'email_verified_at' => now(),
            ]);

            $this->command->info("Created users for {$organisation->name}:");
            $this->command->line(" - Admin: admin@{$organisation->subdomain}.test");
            $this->command->line(" - Manager: manager@{$organisation->subdomain}.test");
            $this->command->line(" - User: user@{$organisation->subdomain}.test");
        }

        // Create a super admin that isn't tied to any specific organisation
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Created Super Admin: superadmin@admin.test');
        $this->command->info('All users created with password: password123');
    }
}
