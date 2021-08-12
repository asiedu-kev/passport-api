<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PassportAuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function test_user_can_login()
   {
       $data = [
         'email' => 'test@example.com',
         'password' => '12345'
       ];

       $response = $this->post('/api/login', $data);
       $response->assertStatus(401);

   }

   public function test_user_can_register()
   {
      $data = [
        'name' => 'Test Runner',
        'email' => 'test@test.com',
        'password' => '12345',
        'confirm_password' => '12345'
      ];
      $response = $this->post('/api/register', $data);
      $response->assertStatus(200);
   }
}
