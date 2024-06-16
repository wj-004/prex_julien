<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Passport::loadKeysFrom(__DIR__.'/../storage');



        Passport::actingAs(
            \App\Models\User::factory()->create(),
            ['*']
        );
    }
}
