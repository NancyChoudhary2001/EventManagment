<?php

namespace Tests\Unit;

use Tests\TestCase;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator; 
 // Import the correct namespace for UserController
use App\Http\Requests\RegistrationRequest; 
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendEmailJob; 

// use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    
    public function test_user_sign_up_()
    {
        
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john876542@example.com',
            'phonenumber' => '1765767890',
        ];

        $response = $this->post('api/signup', $data);

        $response->assertStatus(200);

        $response->assertJson([
            'status' => true,
            'message' => 'User registered Successfully, Password sent via email',
        ]);

        // Queue::fake();
        // Queue::assertPushed(SendEmailJob::class, 1);


        $this->assertDatabaseHas('users', [
            'email' => 'john.2e@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }
    public function test_first_last_name_validation_invalid()
    {
        $data = [
            // 'firstname' = '',
            // 'lastname' = '',
            'email' => 'nancy567@gmail.com',
            'phonenumber' => '1456779342',
        ];

        $response = $this->post('api/signup', $data);

        // dd($response->json());

        $response->assertStatus(412);

        $response->assertJson([
            'success' => false,
            'message' => [
                'firstname' => 'The firstname field is required.',
                'lastname' => 'The lastname field is required.',
            ],
        ]);
    }

    public function test_email_validation_invalid()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            // 'email' => 'john.2e@example.com',
            'phonenumber' => '1777567790',
        ];

        $response = $this->post('api/signup', $data);

        $response->assertStatus(412);

        $response->assertJson([
            'success' => false,
            'message' => [
                'email' => 'The email field is required.',
            ],
        ]);
    }

    public function test_phonenumber_validation_invalid()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.2e@example.com',
            // 'phonenumber' => '1777567790',
        ];

        $response = $this->post('api/signup', $data);

        $response->assertStatus(412);

        $response->assertJson([
            'success' => false,
            'message' => [
                'phonenumber' => 'The phonenumber field is required.',
            ],
        ]);
    }
    public function test_email_duplicate_validation_invalid()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.2e@example.com',
            'phonenumber' => '1777567790',
        ];

        $response = $this->post('api/signup', $data);

        $response->assertStatus(412);

        $response->assertJson([
            'success' => false,
            'message' => [
                'email' => 'The email has already been taken.',
                // 'phonenumber' => 'The phonenumber has already been taken.',
            ],
        ]);
    }
    public function test_phonenumber_duplicate_validation_invalid()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.2e@example.com',
            'phonenumber' => '1777767890',
        ];

        $response = $this->post('api/signup', $data);

        $response->assertStatus(412);

        $response->assertJson([
            'success' => false,
            'message' => [
                
                'phonenumber' => 'The phonenumber has already been taken.',
            ],
        ]);
    }
    public function test_phonenumber_digits_count_validation_invalid()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.e@example.com',
            'phonenumber' => '17777678904',
        ];

        $response = $this->post('api/signup', $data);

        $response->assertStatus(412);

        $response->assertJson([
            'success' => false,
            'message' => [
                
                'phonenumber' => 'The phonenumber field must be 10 digits.',
            ],
        ]);
    }
    public function test_email_valid_validation_invalid()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.eexample.com',
            'phonenumber' => '17777678904',
        ];

        $response = $this->post('api/signup', $data);

        $response->assertStatus(412);

        $response->assertJson([
            'success' => false,
            'message' => [
                
                'email' => 'The email field must be a valid email address.',
            ],
        ]);
    }

}