<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
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
     * 
     *@group updateAdmin
     * @return void
     */
    public function testUpdateAdmin()
    {
        $header = ['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODZcL2FkbWluXC9sb2dpbiIsImlhdCI6MTYwMzg2MzYyOSwiZXhwIjoxNjA2NDU1NjI5LCJuYmYiOjE2MDM4NjM2MjksImp0aSI6ImhQSzRWVFVMRzhNS1RNamEiLCJzdWIiOjEsInBydiI6ImRmODgzZGI5N2JkMDVlZjhmZjg1MDgyZDY4NmM0NWU4MzJlNTkzYTkiLCIwIjoiYWRtaW4ifQ.RRh26qLuJ2Rs0xFWm6Xkhl4tpKCiJz9VW_gtWSnBhwM'];
        $data = [
            'name' => '1234',
            'password' => '1',
            'roleId' => 1
        ];
        $response = $this->post('/admin/admin/185', $data, $header);
        $response->assertStatus(200)
            ->assertJson(['code' => 0]);
    }
}
