<?php namespace Tests\Feature\Api;

use App\Events\PersonCreated;
use App\Models\Person;
use App\Models\User;
use Database\Factories\PersonFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Laravel\Passport\Passport;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_try_to_create_a_person_without_authenticate()
    {
        $params = PersonFactory::new()->raw();
        $response = $this->post('api/sale', $params, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJsonStructure([
                    'message'
                ]
            );
    }

    public function test_create_a_person()
    {
        $this->userAuth();

        $params = PersonFactory::new()->raw();
        $response = $this->post('api/sale', $params, ['Accept' => 'application/json']);
        $response->assertStatus(201)
            ->assertJsonStructure([
                    'status',
                    'message'
                ]
            );
    }

    public function test_create_a_person_execute_event_created()
    {
        Event::fakeFor( function ()
        {
            $this->userAuth();
            $params = PersonFactory::new()->raw();
            $response = $this->post('api/sale', $params, ['Accept' => 'application/json']);
            $response->assertStatus(201)
                ->assertJsonStructure([
                        'status',
                        'message'
                    ]
                );
            Event::assertDispatched(PersonCreated::class);
            return $response;
        },[PersonCreated::class]);

    }

    public function test_get_all_people_by_auth_user()
    {
        $user = $this->userAuth();
        Person::factory()
            ->count(3)
            ->for($user)
            ->create();
        $response = $this->get('api/sale', ['Accept' => 'application/json']);
        $response->assertStatus(200)->assertJsonStructure(['data' => ['*'=>['id' , 'user_id' , 'name', 'email', 'description']]]);
    }

    private function userAuth()
    {
        $user =  User::factory()->create();
        Passport::actingAs($user);
        return $user;
    }


}
