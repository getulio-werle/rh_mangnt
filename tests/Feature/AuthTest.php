<?php

use App\Models\User;
use App\Models\Department;

it('display the login page when not logged in', function () {

    // verify redirect to login page
    $result = $this->get('/')->assertRedirect('/login');

    expect($result->status())->toBe(302);

    // verify login page URL
    expect($this->get('/login')->status())->toBe(200);

    // verify login page content
    expect($this->get('/login')->content())->toContain('Forgot your password?');
});

it('display the recover password page correctly', function () {

    // verify forgot password page URL and content
    expect($this->get('/forgot-password')->status())->toBe(200);
    expect($this->get('/forgot-password')->content())->toContain('Remember my password?');
});

it('login with admin user', function () {

    addAdminUser();

    // login attempt
    $result = $this->post('/login', [
        'email' => 'admin@rhmangnt.com',
        'password' => 'Aa123456',
    ]);

    // verify if login was successful
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));
});

it('login with rh user', function () {

    addRhUser();

    // login attempt
    $result = $this->post('/login', [
        'email' => 'rh@rhmangnt.com',
        'password' => 'Aa123456',
    ]);

    // verify if login was successful
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    // verify if the user can access the colaborators page
    expect($this->get('/colaborators')->status())->toBe(200);
});

it('login with colaborator user', function () {

    addColaboratorUser();

    // login attempt
    $result = $this->post('/login', [
        'email' => 'colaborator@rhmangnt.com',
        'password' => 'Aa123456',
    ]);

    // verify if login was successful
    expect($result->status())->toBe(302);
    expect($result->assertRedirect('/home'));

    //  verify if the user can't access the colaborators page
    expect($this->get('/colaborators')->status())->not()->toBe(200);
});

function addAdminUser()
{
    // create department in test database
    Department::insert([
        'name' => 'Administração',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // create user in test database
    User::insert([
        'department_id' => 1,   // Administração
        'name' => 'Administrador',
        'email' => 'admin@rhmangnt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'admin',
        'permissions' => '["admin"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function addRhUser()
{
    // create departments in test database
    Department::insert([
        [
            'name' => 'Administração',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Recursos Humanos',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);

    // create user in test database
    User::insert([
        'department_id' => 2,
        'name' => 'Colaborador de RH',
        'email' => 'rh@rhmangnt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'rh',
        'permissions' => '["rh"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function addColaboratorUser()
{
    Department::insert([
        [
            'name' => 'Administração',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Recursos Humanos',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Armazém',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);

    // create user in test database
    User::insert([
        'department_id' => 2,
        'name' => 'Colaborador do Armazém',
        'email' => 'colaborator@rhmangnt.com',
        'email_verified_at' => now(),
        'password' => bcrypt('Aa123456'),
        'role' => 'colaborator',
        'permissions' => '["colaborator"]',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
