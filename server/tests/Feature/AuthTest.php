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

    public function test_login_auto_detect_admin()
    {
        \App\Models\Admin::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'no_telp' => '083536367'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Login Berhasil!',
                'user_type' => 'admin',
            ]);
    }

    public function test_login_auto_detect_pemilik()
    {
        \App\Models\Pemilik::create([
            'name' => 'Pemilik Test',
            'email' => 'pemilik@test.com',
            'password' => bcrypt('password123'),
            'no_telp' => '08123456789',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'pemilik@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Login Berhasil!',
                'user_type' => 'pemilik',
            ]);
    }

    public function test_login_auto_detect_penyewa()
{
    \App\Models\Penyewa::create([
        'name' => 'Penyewa Test',
        'email' => 'penyewa@test.com',
        'password' => bcrypt('password123'),
        'no_telp' => '08123456789',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'penyewa@test.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Login Berhasil!',
            'user_type' => 'penyewa',
        ]);
}
}
