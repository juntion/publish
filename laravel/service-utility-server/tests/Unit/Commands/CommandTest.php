<?php

namespace Tests\Unit\Commands;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommandTest extends TestCase
{
    /**
     * @test
     */
    public function cleanAccessTokens()
    {
        $this->artisan('system:clean-access-tokens')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cleanUpTmpFilesCommand()
    {
        $this->artisan('tmp:clear')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function generateToken()
    {
        $this->artisan('permission:generate-token')
            ->expectsQuestion('请输入用户id:', 1)
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function createSuperAdmin()
    {
        $password = $this->faker()->password;
        $this->artisan('permission:create-super-admin')
            ->expectsQuestion('What is super admin name?', $this->faker()->name)
            ->expectsQuestion('What is super admin email?', $this->faker()->email)
            ->expectsQuestion('What is super admin password?', $password)
            ->expectsQuestion('Confirm super admin password?', $password)
            ->assertExitCode(0);
    }
}
