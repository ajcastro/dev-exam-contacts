<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\ContactController
 */
class ContactControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        Contact::factory()->count(30)->create();

        $response = $this->getJson(route('contact.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                Contact::getModelVisibleFields(),
            ]
        ]);
    }


    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $phone = $this->faker->phoneNumber();

        $response = $this->postJson(route('contact.store'), [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ]);


        $response->assertCreated();

        $contacts = Contact::where([
                'name' => $name,
                'email' => $email,
            ])
            ->get();

        $this->assertCount(1, $contacts);

        $response->assertJsonStructure([
            'data' => ['name', 'email']
        ]);
    }

    /**
     * @test
     */
    public function store_should_require_fields()
    {
        $response = $this->postJson(route('contact.store'), [
        ]);

        $response->assertStatus(422);

        $response->assertJsonFragment([
            'message' => 'The name field is required. (and 2 more errors)',
            'errors' => [
                'name' => [
                     'The name field is required.'
                ],
                'email' => [
                     'The email field is required.'
                ],
                'phone' => [
                     'The phone field is required.'
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function store_state_should_require_2_characters()
    {
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $phone = $this->faker->phoneNumber();
        $state = 'A';

        $response = $this->postJson(route('contact.store'), [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'state' => $state,
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The state should be 2 characters.',
            'errors' => [
                'state' => [
                    'The state should be 2 characters.'
                ]
            ]
        ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $contact = Contact::factory()->create();

        $response = $this->getJson(route('contact.show', $contact));

        $response->assertOk();
        $response->assertJsonStructure(['data' => Contact::getModelVisibleFields()]);
    }


    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $contact = Contact::factory()->create();
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $phone = $this->faker->phoneNumber();

        $response = $this->put(route('contact.update', $contact), [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ]);

        $contact->refresh();

        $response->assertOk();
        $response->assertJsonStructure(['data' => Contact::getModelVisibleFields()]);

        $this->assertEquals($name, $contact->name);
        $this->assertEquals($email, $contact->email);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $contact = Contact::factory()->create();

        $response = $this->delete(route('contact.destroy', $contact));

        $response->assertNoContent();

        $this->assertSoftDeleted($contact);
    }
}
