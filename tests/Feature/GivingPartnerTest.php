<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;

use Tests\TestCase;

use App\Models\Country;
use App\Models\GivingOption;
use App\Models\GivingPartner;
use App\Models\User;

class GivingPartnerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        Country::factory()->create(['code' => 'US', 'name' => 'United States', 'phone_code' => '+1']);
        GivingOption::factory()->create();
    }

    public function test_can_create_giving_partner()
    {
        Mail::fake();

        $data = [
            'firstname' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'country_code' => 'US',
            'giving_option_id' => GivingOption::first()->id,
            'recurrent' => false,
            'amount' => 100.00,
            'prayer_point' => 'Please pray for my family'
        ];

        $response = $this->postJson('/api/giving_partners', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Thank you for partnering with us! Your information has been saved.'
                 ]);

        $this->assertDatabaseHas('giving_partners', [
            'email' => 'john.doe@example.com',
            'amount' => 100.00
        ]);
    }

    public function test_recurrent_donation_requires_recurrent_type()
    {
        $data = [
            'firstname' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'country_code' => 'US',
            'giving_option_id' => GivingOption::first()->id,
            'recurrent' => true,
            'amount' => 100.00,
        ];

        $response = $this->postJson('/api/giving_partners', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['recurrent_type']);
    }

    public function test_cannot_create_duplicate_recurrent_email()
    {
        // Create first recurrent partner
        GivingPartner::factory()->create([
            'email' => 'john.doe@example.com',
            'recurrent' => true,
            'recurrent_type' => 'Monthly'
        ]);

        $data = [
            'firstname' => 'Jane',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '9876543210',
            'country_code' => 'US',
            'giving_option_id' => GivingOption::first()->id,
            'recurrent' => true,
            'recurrent_type' => 'Yearly',
            'amount' => 200.00,
        ];

        $response = $this->postJson('/api/giving_partners', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_can_create_duplicate_one_time_email()
    {
        // Create first one-time partner
        GivingPartner::factory()->create([
            'email' => 'john.doe@example.com',
            'recurrent' => false
        ]);

        $data = [
            'firstname' => 'Jane',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '9876543210',
            'country_code' => 'US',
            'giving_option_id' => GivingOption::first()->id,
            'recurrent' => false,
            'amount' => 200.00,
        ];

        $response = $this->postJson('/api/giving_partners', $data);

        $response->assertStatus(201);
    }

    public function test_authenticated_user_can_view_partners()
    {
        /** @var User $user */
        $user = User::factory()->create();
        GivingPartner::factory()->count(5)->create();

        $response = $this->actingAs($user)
                         ->getJson('/api/giving_partners');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => [
                             'id',
                             'firstname',
                             'surname',
                             'email',
                             'amount'
                         ]
                     ],
                     'pagination'
                 ]);
    }

    public function test_can_filter_partners_by_recurrent_status()
    {
        /** @var User $user */
        $user = User::factory()->create();
        GivingPartner::factory()->recurrent()->count(3)->create();
        GivingPartner::factory()->oneTime()->count(2)->create();

        $response = $this->actingAs($user)
                         ->getJson('/api/giving_partners?recurrent=true');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_can_get_giving_statistics()
    {
        /** @var User $user */
        $user = User::factory()->create();
        GivingPartner::factory()->recurrent()->count(3)->create(['amount' => 100]);
        GivingPartner::factory()->oneTime()->count(2)->create(['amount' => 50]);

        $response = $this->actingAs($user)
                         ->getJson('/api/giving_partners/statistics');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'total_partners',
                         'recurrent_partners',
                         'one_time_partners',
                         'total_amount',
                         'recurrent_amount',
                         'monthly_recurrent',
                         'yearly_recurrent'
                     ]
                 ]);
    }
}
