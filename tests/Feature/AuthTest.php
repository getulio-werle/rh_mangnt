<?php

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