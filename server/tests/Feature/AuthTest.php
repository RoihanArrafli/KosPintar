<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_pemilik(): void
    {
        $response = $this->postJson('/api/register', [
            'type' => 'pemilik',
            'name' => 'Pemilik Test',
            'email' => 'pemilik@test.com',
            'password' => 'password123',
            'no_telp' => '08123456789',
        ]);

        $response->assertStatus(200)
        ->assertJson([
            'message' => 'Registrasi pemilik berhasil',
        ]);
    }

    public function test_register_penyewa()
{
    $response = $this->postJson('/api/register', [
        'type' => 'penyewa',
        'name' => 'Penyewa Test',
        'email' => 'penyewa@test.com',
        'password' => 'password123',
        'no_telp' => '08123456789',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Registrasi penyewa berhasil',
        ]);
}
}
