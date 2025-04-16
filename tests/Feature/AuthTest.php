<?php

use App\Models\User;
use App\Models\Department;

it('display the login page when not logged in', function () {

    // verify redirect to login page
    $response = $this->get('/')->assertRedirect('/login');

    expect($response->status())->toBe(302);

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

    // login attempt
    $response = $this->post('/login', [
        'email' => 'admin@rhmangnt.com',
        'password' => 'Aa123456',
    ]);

    // verify if login was successful
    expect($response->status())->toBe(302);
    expect($response->assertRedirect('/home'));

});