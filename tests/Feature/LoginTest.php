<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * php artisan test --group admin/login 基于group的测试
     * php artisan test --filter LoginTest 基于类名的测试
     * @group admin/login
     */
    public function testLogin()
    {
        $response = $this->post('/admin/login', ['name' => 'admin', 'password' => '123456abc']);
        $response->assertStatus(200)
            ->assertJson(['code' => 0]);
    }
}
