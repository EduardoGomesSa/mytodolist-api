<?php

uses(Tests\TestCase::class);

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
