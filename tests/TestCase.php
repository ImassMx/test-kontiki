<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install', ['--no-interaction' => true,]);
    }

    protected function createUser()
    {
       return User::create($this->userData());
    }

    protected function userData(): array
    {
        return [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'testtest'
        ];
    }
}
