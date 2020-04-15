<?php

namespace Tests\Feature;

use App\Employee;
use App\Children;
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
    public function should_create_children()
    {
        $this->withoutExceptionHandling();
        $responsePostEmployee = $this->post('/api/employee/add', $this->bodyPost());

        $responsePostEmployee->assertOk();

        $employee = Employee::first();

        $responsePostChildren1 = $this->post('/api/employee/add_children', [
            'employee_id' => $employee->id,
            'name' => 'Antonius',
            'age' => '2 Years',
        ]);

        $responsePostChildren2 = $this->post('/api/employee/add_children', [
            'employee_id' => $employee->id,
            'name' => 'Elf',
            'age' => '1 Year',
        ]);

        $responsePostChildren1->assertOk();
        $responsePostChildren2->assertOk();

        $childrens = Children::all();

        $this->assertEquals(2, count($childrens));
        $this->assertEquals(1, $childrens->first()->id);
        $this->assertEquals('Antonius', $childrens->first()->name);
        $this->assertEquals('2 Years', $childrens->first()->age);
    }

    /** @test */
    public function should_have_instance_of_children()
    {
        $responsePostEmployee = $this->post('/api/employee/add', $this->bodyPost());

        $responsePostEmployee->assertOk();

        $employee = Employee::first();

        $responsePostChildren1 = $this->post('/api/employee/add_children', [
            'employee_id' => $employee->id,
            'name' => 'Antonius',
            'age' => '2 Years',
        ]);

        $responsePostChildren2 = $this->post('/api/employee/add_children', [
            'employee_id' => $employee->id,
            'name' => 'Elf',
            'age' => '1 Year',
        ]);

        $responsePostChildren1->assertOk();
        $responsePostChildren2->assertOk();

        $this->assertInstanceOf(Collection::class, $employee->childrens);
    }

    /** @test */
    public function should_return_all_data_employee_with_children()
    {
        $this->withoutExceptionHandling();
        $responsePostEmployee = $this->post('/api/employee/add', $this->bodyPost());

        $responsePostEmployee->assertOk();

        $employees = Employee::all();

        $responsePostChildren1 = $this->post('/api/employee/add_children', [
            'employee_id' => $employees->first()->id,
            'name' => 'Antonius',
            'age' => '2 Years',
        ]);

        $responsePostChildren2 = $this->post('/api/employee/add_children', [
            'employee_id' => $employees->first()->id,
            'name' => 'Elf',
            'age' => '1 Year',
        ]);

        $responsePostChildren1->assertOk();
        $responsePostChildren2->assertOk();
        $responseGet = $this->get('/api/employee');

        $expectedResponse = [
            'data' => $employees->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'full_name' => $employee->name,
                    'email' => $employee->email,
                    'address' => $employee->address,
                    'city' => $employee->city,
                    'province' => $employee->province,
                    'childrens' => $employee->childrens->map(function ($children) use ($employee) {
                        return [
                            'employee_id' => $employee->id,
                            'name' => $children->name,
                            'age' => $children->age
                        ];
                    })
                ];
            })
        ];
        $this->assertEquals(json_encode($expectedResponse), $responseGet->getContent());
    }

    private function bodyPost()
    {
        return [
            'name' => 'your name',
            'email' => 'your_mail@gmail.com',
            'address' => 'your address',
            'hp' => 'your hp',
            'city' => 'your city',
            'province' => 'your province'
        ];
    }
}
