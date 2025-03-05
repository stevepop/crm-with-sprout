<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organisations = Organisation::all();

        if ($organisations->isEmpty()) {
            $this->command->error('No organisations found. Please run OrganisationSeeder first.');
            return;
        }

        foreach ($organisations as $organisation) {
            $this->command->info("Creating contacts for {$organisation->name}");

            // Get users for this organisation
            $users = User::where('organisation_id', $organisation->id)->get();

            if ($users->isEmpty()) {
                $this->command->warn("No users found for {$organisation->name}. Skipping contact creation for this organisation.");
                continue;
            }

            // Number of contacts to create per organisation
            $contactCount = 12; // Fixed number for consistency across organisations

            // Distribution of statuses
            $statusCounts = [
                'lead' => 5,      // 5 leads
                'customer' => 5,  // 5 customers
                'inactive' => 2   // 2 inactive
            ];

            // Sample contact data
            $contacts = $this->getSampleContacts($contactCount);
            $currentIndex = 0;

            // Create contacts for each status
            foreach ($statusCounts as $status => $count) {
                for ($i = 0; $i < $count; $i++) {
                    if ($currentIndex >= count($contacts)) {
                        break;
                    }

                    $contactData = $contacts[$currentIndex];
                    $currentIndex++;

                    // Determine assigned user - distribute evenly
                    $assignedUser = $users[$i % count($users)];

                    // Determine last_contacted_at based on status
                    if ($status === 'customer') {
                        $lastContactedAt = Carbon::now()->subDays(rand(0, 14));
                    } elseif ($status === 'lead') {
                        $lastContactedAt = Carbon::now()->subDays(rand(7, 30));
                    } else { // inactive
                        $lastContactedAt = Carbon::now()->subDays(rand(60, 120));
                    }

                    // Create the contact - explicitly setting organisation_id for tenant relation
                    $contact = new Contact([
                        'name' => $contactData['name'],
                        'email' => $contactData['email'],
                        'phone' => $contactData['phone'],
                        'status' => $status,
                        'assigned_user_id' => $assignedUser->id,
                        'last_contacted_at' => $lastContactedAt,
                    ]);

                    // Set the organisation directly
                    $contact->organisation()->associate($organisation);
                    $contact->save();

                    // Add notes to all contacts for better testing
                    $noteCount = rand(1, 3);
                    for ($j = 0; $j < $noteCount; $j++) {
                        $note = new Note([
                            'content' => $this->getRandomNote($contact->name, $status),
                            'user_id' => $users->random()->id,
                        ]);

                        // Associate with the contact
                        $note->contact()->associate($contact);
                        $note->save();
                    }
                }
            }

            $this->command->info("Finished creating contacts for {$organisation->name}");
        }

        $this->command->info('Contact seeding completed successfully!');
    }

    /**
     * Get sample contact data.
     *
     * @param int $count
     * @return array
     */
    private function getSampleContacts($count): array
    {
        $contacts = [
            ['name' => 'John Smith', 'email' => 'john.smith@example.com', 'phone' => '555-123-4567'],
            ['name' => 'Jane Doe', 'email' => 'jane.doe@example.com', 'phone' => '555-234-5678'],
            ['name' => 'Michael Johnson', 'email' => 'michael.johnson@example.com', 'phone' => '555-345-6789'],
            ['name' => 'Emily Davis', 'email' => 'emily.davis@example.com', 'phone' => '555-456-7890'],
            ['name' => 'Robert Wilson', 'email' => 'robert.wilson@example.com', 'phone' => '555-567-8901'],
            ['name' => 'Sarah Brown', 'email' => 'sarah.brown@example.com', 'phone' => '555-678-9012'],
            ['name' => 'David Miller', 'email' => 'david.miller@example.com', 'phone' => '555-789-0123'],
            ['name' => 'Jennifer Taylor', 'email' => 'jennifer.taylor@example.com', 'phone' => '555-890-1234'],
            ['name' => 'James Anderson', 'email' => 'james.anderson@example.com', 'phone' => '555-901-2345'],
            ['name' => 'Lisa Thomas', 'email' => 'lisa.thomas@example.com', 'phone' => '555-012-3456'],
            ['name' => 'Daniel Jackson', 'email' => 'daniel.jackson@example.com', 'phone' => '555-123-4567'],
            ['name' => 'Michelle White', 'email' => 'michelle.white@example.com', 'phone' => '555-234-5678'],
            ['name' => 'Christopher Harris', 'email' => 'christopher.harris@example.com', 'phone' => '555-345-6789'],
            ['name' => 'Amanda Martin', 'email' => 'amanda.martin@example.com', 'phone' => '555-456-7890'],
            ['name' => 'Matthew Thompson', 'email' => 'matthew.thompson@example.com', 'phone' => '555-567-8901'],
            ['name' => 'Laura Garcia', 'email' => 'laura.garcia@example.com', 'phone' => '555-678-9012'],
        ];

        // Ensure we have enough contacts
        while (count($contacts) < $count) {
            $contacts = array_merge($contacts, $contacts);
        }

        // Shuffle and take the requested count
        shuffle($contacts);
        return array_slice($contacts, 0, $count);
    }

    /**
     * Get a random note based on contact name and status.
     *
     * @param string $name
     * @param string $status
     * @return string
     */
    private function getRandomNote(string $name, string $status): string
    {
        $notes = [
            'customer' => [
                "Had a great call with {$name} today. They're very happy with our service.",
                "{$name} renewed their subscription for another year. Great customer!",
                "Met with {$name} to discuss expansion opportunities. They're interested in additional services.",
                "Helped {$name} troubleshoot an issue with their account. Issue resolved successfully.",
                "Quarterly review with {$name} went well. They provided positive feedback."
            ],
            'lead' => [
                "Initial discovery call with {$name}. They seem very interested in our premium plan.",
                "Sent proposal to {$name}, awaiting feedback.",
                "{$name} requested a demo next week. Need to prepare a customized presentation.",
                "Following up with {$name} regarding the quote I sent last week.",
                "{$name} is comparing our offering with competitors. Emphasized our unique advantages."
            ],
            'inactive' => [
                "Attempted to reach {$name} but couldn't get through. Will try again next week.",
                "{$name} hasn't responded to emails in 3 months. Consider moving to inactive list.",
                "Last interaction with {$name} was 6 months ago. Should we attempt to re-engage?",
                "{$name} mentioned they went with a competitor. Keep on file for future opportunities.",
                "Company restructuring at {$name}'s organization. Will revisit in Q3."
            ]
        ];

        // Default to lead notes if status not found
        $statusNotes = $notes[$status] ?? $notes['lead'];

        return $statusNotes[array_rand($statusNotes)];
    }
}
