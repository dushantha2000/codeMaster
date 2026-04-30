<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PragmaRX\Google2FALaravel\Google2FA;

class TwoFactorTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_without_2fa()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'two_factor_enabled' => 0,
            'is_verified' => 1
        ]);

        $response = $this->post('/user-login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_2fa_redirects_to_challenge()
    {
        $user = User::factory()->create([
            'email' => 'test2fa@example.com',
            'password' => Hash::make('password123'),
            'two_factor_enabled' => 1,
            'two_factor_secret' => 'DUMMYSECRET12345',
            'is_verified' => 1
        ]);

        $response = $this->post('/user-login', [
            'email' => 'test2fa@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/2fa/challenge');
        $this->assertGuest(); // Should not be fully logged in yet
        $this->assertEquals($user->id, session('2fa:user:id'));
    }

    public function test_verify_2fa_challenge_logs_user_in()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();
        $code = $google2fa->getCurrentOtp($secret);

        $user = User::factory()->create([
            'email' => 'testverify@example.com',
            'password' => Hash::make('password123'),
            'two_factor_enabled' => 1,
            'two_factor_secret' => $secret,
            'is_verified' => 1
        ]);

        // Start session as if redirected
        $response = $this->withSession(['2fa:user:id' => $user->id])
             ->post('/2fa/challenge', [
                 'code' => $code
             ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
        $this->assertNull(session('2fa:user:id'));
    }
}
