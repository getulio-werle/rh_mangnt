<?php

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

it('test if an admin user can create a new rh user', function () {

    // create a admin user
    addAdminUser();

    // create departments
    addDepartment('Administração');
    addDepartment('Recurso Humanos');

    // login the admin user
    $result = $this->post('/login', [
        'email' => 'admin@rhmangnt.com',
        'password' => 'Aa123456'
    ]);
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    // create a rh user
    $result = $this->post('/colaborators/rh/create-colaborator', [
        'name' => 'RH Colaborator',
        'email' => 'rh@rhmangnt.com',
        'department' => Crypt::encrypt(2),
        'address' => 'RH Colaborator address',
        'zip_code' => '12345678',
        'city' => 'RH Colaborator city',
        'phone' => '123456789',
        'salary' => '1000.00',
        'admission_date' => '2023-10-01',
    ]);

    // check if the user was created
    $this->assertDatabaseHas('users', [
        'name' => 'RH Colaborator',
        'email' => 'rh@rhmangnt.com',
        'role' => 'rh',
        'permissions' => '["rh"]',
    ]);
});

it('test if an rh user can create a new colaborator user', function () {

    // create a admin user
    addRhUser();

    // create departments
    addDepartment('Administração');
    addDepartment('Recurso Humanos');
    addDepartment('Armazém');

    // login the admin user
    $result = $this->post('/login', [
        'email' => 'rh@rhmangnt.com',
        'password' => 'Aa123456'
    ]);
    expect(auth()->user()->role)->toBe('rh');

    // create a rh user
    $result = $this->post('/colaborators/create-colaborator', [
        'name' => 'Colaborator',
        'email' => 'colaborator@rhmangnt.com',
        'department' => Crypt::encrypt(3),
        'address' => 'Colaborator address',
        'zip_code' => '12345678',
        'city' => 'Colaborator city',
        'phone' => '123456789',
        'salary' => '900.00',
        'admission_date' => '2023-10-01',
    ]);

    // check if the user was created
    expect(User::where('email', 'colaborator@rhmangnt.com')->exists())->toBeTrue();
});

function addDepartment($name)
{
    $department = new Department();
    $department->name = $name;
    $department->save();
}
