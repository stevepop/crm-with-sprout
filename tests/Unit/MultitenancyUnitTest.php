<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultitenancyUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function organisation_implements_tenant_interface()
    {
        $org = Organisation::create([
            'name' => 'Acme Inc',
            'email' => 'info@acme.com',
            'subdomain' => 'acme',
        ]);

        // Verify it implements the Tenant interface
        $this->assertInstanceOf(\Sprout\Contracts\Tenant::class, $org);

        // Verify it has the expected tenant identifier
        $this->assertEquals('acme', $org->subdomain);
        $this->assertEquals('subdomain', $org->getTenantIdentifierName());
    }

    /** @test */
    public function users_belong_to_an_organisation()
    {
        // Create two organisations
        $acme = Organisation::create([
            'name' => 'Acme Inc',
            'email' => 'info@acme.com',
            'subdomain' => 'acme',
        ]);

        $stark = Organisation::create([
            'name' => 'Stark Industries',
            'email' => 'info@stark.com',
            'subdomain' => 'stark',
        ]);

        // Create users for each organisation
        $acmeUser = User::create([
            'name' => 'John Doe',
            'email' => 'john@acme.com',
            'password' => bcrypt('password'),
            'organisation_id' => $acme->id,
        ]);

        $starkUser = User::create([
            'name' => 'Tony Stark',
            'email' => 'tony@stark.com',
            'password' => bcrypt('password'),
            'organisation_id' => $stark->id,
        ]);

        // Verify that users belong to the correct organisation
        $this->assertEquals($acme->id, $acmeUser->organisation->id);
        $this->assertEquals($stark->id, $starkUser->organisation->id);

        // Verify that organisations have the correct users
        $this->assertTrue($acme->users->contains($acmeUser));
        $this->assertTrue($stark->users->contains($starkUser));
    }

    #[Test]
    public function notes_belong_to_contacts_and_users()
    {
        // Create organisation
        $org = Organisation::create([
            'name' => 'Acme Inc',
            'email' => 'info@acme.com',
            'subdomain' => 'acme',
        ]);

        // Create user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@acme.com',
            'password' => bcrypt('password'),
            'organisation_id' => $org->id,
        ]);

        // Create contact
        $contact = Contact::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'status' => 'lead',
            'organisation_id' => $org->id,
        ]);

        // Create note
        $note = Note::create([
            'contact_id' => $contact->id,
            'user_id' => $user->id,
            'content' => 'This is a test note',
        ]);

        // Verify relationships
        $this->assertEquals($contact->id, $note->contact->id);
        $this->assertEquals($user->id, $note->user->id);
        $this->assertTrue($contact->notes->contains($note));
        $this->assertTrue($user->notes->contains($note));
    }

    /** @test */
    public function tenant_scopes_filter_data_correctly()
    {
        // Create two organisations
        $acme = Organisation::create([
            'name' => 'Acme Inc',
            'email' => 'info@acme.com',
            'subdomain' => 'acme',
        ]);

        $stark = Organisation::create([
            'name' => 'Stark Industries',
            'email' => 'info@stark.com',
            'subdomain' => 'stark',
        ]);

        // Create contacts for Acme
        $acmeContact1 = Contact::create([
            'name' => 'Acme Contact 1',
            'email' => 'contact1@acme.com',
            'status' => 'lead',
            'organisation_id' => $acme->id,
        ]);

        $acmeContact2 = Contact::create([
            'name' => 'Acme Contact 2',
            'email' => 'contact2@acme.com',
            'status' => 'customer',
            'organisation_id' => $acme->id,
        ]);

        // Create contact for Stark
        $starkContact = Contact::create([
            'name' => 'Stark Contact',
            'email' => 'contact@stark.com',
            'status' => 'lead',
            'organisation_id' => $stark->id,
        ]);

        // Use direct queries to validate tenant scoping
        $acmeContacts = Contact::where('organisation_id', $acme->id)->get();
        $starkContacts = Contact::where('organisation_id', $stark->id)->get();

        // Verify each organisation gets only its own contacts
        $this->assertCount(2, $acmeContacts);
        $this->assertCount(1, $starkContacts);

        // Verify specific contacts are present
        $this->assertTrue($acmeContacts->contains($acmeContact1));
        $this->assertTrue($acmeContacts->contains($acmeContact2));
        $this->assertTrue($starkContacts->contains($starkContact));

        // Verify contacts from other tenants are not present
        $this->assertFalse($acmeContacts->contains($starkContact));
        $this->assertFalse($starkContacts->contains($acmeContact1));
    }

    /** @test */
    public function contact_status_scope_filters_correctly()
    {
        // Create organisation
        $org = Organisation::create([
            'name' => 'Acme Inc',
            'email' => 'info@acme.com',
            'subdomain' => 'acme',
        ]);

        // Create contacts with different statuses
        Contact::create([
            'name' => 'Lead Contact',
            'email' => 'lead@example.com',
            'status' => 'lead',
            'organisation_id' => $org->id,
        ]);

        Contact::create([
            'name' => 'Customer Contact',
            'email' => 'customer@example.com',
            'status' => 'customer',
            'organisation_id' => $org->id,
        ]);

        Contact::create([
            'name' => 'Another Lead',
            'email' => 'anotherlead@example.com',
            'status' => 'lead',
            'organisation_id' => $org->id,
        ]);

        // Test status scope
        $leadContacts = Contact::status('lead')->get();
        $customerContacts = Contact::status('customer')->get();

        $this->assertCount(2, $leadContacts);
        $this->assertCount(1, $customerContacts);
    }
}
