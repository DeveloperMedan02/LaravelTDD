<?php

namespace Tests\Feature;

use App\Children;
use App\Employee;
use Illuminate\Database\Eloquent\Collection;
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
    public function should_error_when_full_name_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['full_name']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('full_name');
    }

    /** @test */
    public function should_error_when_first_name_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['first_name']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function should_error_when_last_name_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['last_name']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('last_name');
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
    public function should_error_when_city_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['city']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('city');
    }

    /** @test */
    public function should_error_when_province_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['province']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('province');
    }

    /** @test */
    public function should_error_when_hp_not_provided()
    {
        $bodyPost = $this->bodyPost();
        unset($bodyPost['hp']);
        $response = $this->post('/api/employee/add', $bodyPost);
        $response->assertSessionHasErrors('hp');
    }

    /** @test */
    public function should_return_data_employee_with_childrens()
    {
        $this->withoutExceptionHandling();

        $responsePost = $this->post('/api/employee/add', $this->bodyPost());

        $employee = Employee::first();
        $responseAddChild1 = $this->post('/api/employee/add_children', [
            'employee_id' => $employee->id,
            'name' => 'Antonius',
            'old' => '2 Years'
        ]);
        $responseAddChild2 = $this->post('/api/employee/add_children', [
            'employee_id' => $employee->id,
            'name' => 'Elf',
            'old' => '1 Year'
        ]);

        $employees = Employee::all();
        $childrens = Children::where('employee_id', $employee->id)->get();

        $responseGet =  $this->get('/api/employee');

        $expectedResponse = [
            'data' => $employees->map(function ($employee) use ($childrens) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->full_name,
                    'email' => $employee->email,
                    'address' => $employee->address,
                    'city' => $employee->city,
                    'province' => $employee->province,
                    'hp' => $employee->hp,
                    'childrens' => $childrens->map(function ($children) {
                        return [
                            'name' => $children->name,
                            'old' => $children->old
                        ];
                    })
                ];
            }),
        ];
        $responsePost->assertOk();
        $responseAddChild1->assertOk();
        $responseAddChild2->assertOk();
        $this->assertEquals(2, count($childrens));
        $this->assertInstanceOf(Collection::class, $employee->childrens);
        $this->assertEquals(json_encode($expectedResponse), $responseGet->getContent());
    }

    private function bodyPost()
    {
        return [
            'id' => '020170',
            'full_name' => 'Ali Agus Hutapea',
            'first_name' => 'Ali Agus',
            'last_name' => 'Hutapea',
            'email' => 'aliagushutapea@gmail.com',
            'address' => 'Jl.Mahkota Hidup Km.13',
            'city' => 'Medan',
            'province' => 'Sumatera Utara',
            'hp' => '081260875288'
        ];
    }
}
