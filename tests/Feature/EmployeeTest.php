<?php

namespace Tests\Feature;

use App\Employee;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;


    /** @test */
    public function should_create_new_employee()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/employee/add', $this->bodyPost());
        $employess = Employee::all();
        $response->assertOk();
        $this->assertEquals(1, count($employess));
    }

    /** @test */
    public function should_error_when_name_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['name']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function should_error_when_email_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['email']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function should_error_when_address_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['address']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('address');
    }

    /** @test */
    public function should_error_when_hp_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['hp']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('hp');
    }

    private function bodyPost()
    {
        return [
            'name' => 'Ali agus hutapea',
            'email' => 'aliagushutapea@gmail.com',
            'address' => 'Jl.Mahkota Hidup Km.13',
            'hp' => '081260875288'
        ];
    }
}
