<?php

it('test if admin user can access the rh colaborators page', function () {
    // create admin user
    addAdminUser();

    // login
    auth()->loginUsingId(1);

    // visit the page
    expect($this->get('/colaborators/rh')->status())->toBe(200);
});

it('test if a user not logged in can not access the home page', function () {
    // visit the page
    expect($this->get('/home')->status())->not()->toBe(200);
});

it('test if a user logged in can not access the login page', function () {
    // create admin user
    addAdminUser();

    // login
    auth()->loginUsingId(1);

    // visit the page
    expect($this->get('/login')->status())->not()->toBe(200);
});

it('test if a user logged in can not access the recover password page', function () {
    // create admin user
    addAdminUser();

    // login
    auth()->loginUsingId(1);

    // visit the page
    expect($this->get('/forgot-password')->status())->not()->toBe(200);
});
