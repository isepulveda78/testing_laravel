<?php

namespace Tests\Feature;

use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    use RefreshDatabase; // give you a free database after each test
    /** @test */
    public function a_contact_can_be_added()
    {
        $this->withoutExceptionHandling();
        
        $this->post('/api/contacts', [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '07/12/1978',
            'company' => 'ABC String',
            ]);

        $contact = Contact::first();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('07/12/1978', $contact->birthday);
        $this->assertEquals('ABC String', $contact->company);
    } //first test for inserting data

    /** @test */
    public function a_name_is_required()
    {
        
        $response = $this->post('/api/contacts', [
            'email' => 'test@email.com',
            'birthday' => '07/12/1978',
            'company' => 'ABC String',
            ]);

        $contact = Contact::first();
        
        $response->assertSessionHasErrors('name');
        $this->assertCount(0, Contact::all());

    } //second we test for validation. In this function, we test for 'name'.

    /** @test */
    public function an_email_is_required()
    {
          
        $response = $this->post('/api/contacts', [
            'name' => 'Test Name',
            'birthday' => '07/12/1978',
            'company' => 'ABC String',
            ]);

        $contact = Contact::first();
        
        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }
}
