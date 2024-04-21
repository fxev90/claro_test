<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    use  RefreshDatabase;

    protected string $endpoint = '/api/students';
    protected string $tableName = 'students';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateStudent(): void
    {
        $payload = Student::factory()->make([
            'nombre' => 'John Doe',
            'apellido' => 'Doe',
            'edad' => 25,
            'cedula' => '12345678901',
            'email' => 'john.doe@example.com',
        ])->toArray();

        $this->json('POST', $this->endpoint, $payload)
            ->assertStatus(201)
            ->assertJson([
                'status' => 201,
                'message' => 'Student created successfully',
                'data' => [
                    'nombre' => $payload['nombre'],
                    'apellido' => $payload['apellido'],
                    'edad' => $payload['edad'],
                    'cedula' => $payload['cedula'],
                    'email' => $payload['email'],
                ],
            ]);

        $this->assertDatabaseHas($this->tableName, [
            'nombre' => $payload['nombre'],
            'apellido' => $payload['apellido'],
            'edad' => $payload['edad'],
            'cedula' => $payload['cedula'],
            'email' => $payload['email'],
        ]);
    }

    public function testViewAllStudentsSuccessfully(): void
    {

        //$this->actingAs(User::factory()->create());

        $estudiantes = Student::factory(5)->create();

        $response = $this->json('GET', $this->endpoint)
        ->assertStatus(200)
        ->assertJsonCount(5, 'data')
        ->assertJsonFragment([
            'nombre' => $estudiantes->random()->nombre,
            'apellido' => $estudiantes->random()->apellido,
            'edad' => $estudiantes->random()->edad,
            'cedula' => $estudiantes->random()->cedula,
            'email' => $estudiantes->random()->email,
        ]);
    }


    public function testsCreateStudentValidation(): void
    {

        //$this->actingAs(User::factory()->create());

        $data = [];

        $response = $this->json('post', $this->endpoint, $data)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'status' => 422,
                        'title' => 'Validation Error',
                        'detail' => 'The nombre field is required.',
                        'source' => [
                            'pointer' => '/nombre',
                        ],
                    ],
                    [
                        'status' => 422,
                        'title' => 'Validation Error',
                        'detail' => 'The edad field is required.',
                        'source' => [
                            'pointer' => '/edad',
                        ],
                    ],
                    [
                        'status' => 422,
                        'title' => 'Validation Error',
                        'detail' => 'The cedula field is required.',
                        'source' => [
                            'pointer' => '/cedula',
                        ],
                    ],
                    [
                        'status' => 422,
                        'title' => 'Validation Error',
                        'detail' => 'The email field is required.',
                        'source' => [
                            'pointer' => '/email',
                        ],
                    ],
                ],
            ]);
    }

    public function testViewStudentData(): void
    {

        //$this->actingAs(User::factory()->create());

        $estudiante = Student::factory()->create();

        $response = $this->json('GET', $this->endpoint . '/' . $estudiante->id)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'nombre' => $estudiante->nombre,
                'apellido' => $estudiante->apellido,
                'edad' => $estudiante->edad,
                'cedula' => $estudiante->cedula,
                'email' => $estudiante->email,
            ],
        ]);
    }

    public function testUpdateStudent(): void
    {
        $this->actingAs(User::factory()->create());
        $estudiante = Student::factory()->create();
    
        $payload = [
            'nombre' => 'Name Updated',
            'apellido' => 'Updated',
            'edad' => 30,
            'cedula' => '98765432109',
            'email' => 'random@example.com',
        ];
    
        $response = $this->json('PUT', $this->endpoint . '/' . $estudiante->id, $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nombre',
                    'apellido',
                    'edad',
                    'cedula',
                    'email',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                ],
            ]);
    
        $this->assertDatabaseHas($this->tableName, [
            'id' => $estudiante->id,
            'nombre' => $payload['nombre'],
            'apellido' => $payload['apellido'],
            'edad' => $payload['edad'],
            'cedula' => $payload['cedula'],
            'email' => $payload['email'],
        ]);
    
        $response->assertJson([
            'data' => [
                'nombre' => $payload['nombre'],
                'apellido' => $payload['apellido'],
                'edad' => $payload['edad'],
                'cedula' => $payload['cedula'],
                'email' => $payload['email'],
            ],
        ]);
    }

    public function testDeleteStudent(): void
    {
        $this->actingAs(User::factory()->create());
        $estudiante = Student::factory()->create();

        $this->json('DELETE', $this->endpoint . '/' . $estudiante->id)
            ->assertStatus(204);

        $this->assertSoftDeleted($this->tableName, [
                'id' => $estudiante->id,
            ]);

        $this->assertEquals(0, Student::count());
    }
    public function testRestoreStudent(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        Student::factory()->create();

        $this->json('DELETE', $this->endpoint.'/1')
            ->assertStatus(204);

        $this->json('GET', $this->endpoint.'/1/restore')
            ->assertStatus(200);

        $this->assertDatabaseHas($this->tableName, [
            'id'         => 1,
            'deleted_at' => null,
        ]);
    }

    public function testPermanentStudent(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        Student::factory()->create();

        $this->json('DELETE', $this->endpoint.'/1')
            ->assertStatus(204);

        $this->json('DELETE', $this->endpoint.'/1/permanent-delete')
            ->assertStatus(204);

        $this->assertDatabaseMissing($this->tableName, ['id' => 1]);
    }
}
