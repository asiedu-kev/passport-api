<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class TodoControllerTest extends TestCase
{
  use RefreshDatabase;

    protected $user;

  public function setUp() : void {
    parent ::setUp();

    $this->user = factory(User::class)->create();
    $this->actingAs($this->user, 'api');
  }
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function test_user_can_add_todo()
   {
      $formData =[
        'title'=>'first task',   
        'description'=>'first task description',
      ];
      $response = $this->post('/api/todos',$formData);
      $response->assertStatus(200);
   }
   public function test_user_can_edit_todo()
   {
      
   }
   public function test_user_can_show_todo()
   {
       
   }

   public function test_user_can_delete_todo()
   {

   }
}
