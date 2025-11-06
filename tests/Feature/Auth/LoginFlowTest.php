<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable CSRF middleware for login tests
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    public function testCompleteUserLoginFlow(): void
    {
        // Create user
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole('user');

        // Visit login page
        $response = $this->get(route('login'));
        $response->assertStatus(200);

        // Submit login form
        $response = $this->post(route('login'), [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        // Assert redirected to home
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        // Visit home page
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function testCompleteAdminLoginFlow(): void
    {
        // Create admin
        $admin = $this->createAdmin();

        // Visit login page
        $response = $this->get(route('login'));
        $response->assertStatus(200);

        // Submit login form
        $response = $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        // Assert redirected to dashboard
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        // Visit dashboard
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function testLogoutFlow(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        // Login
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // Logout
        $response = $this->post(route('logout'));
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function testGuestCannotAccessProtectedRoutes(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function testLoginPageStyleInclusions(): void
    {
        $response = $this->get(route('login'));

        // Check for Beauty High Tech design elements
        $response->assertSee('Lunaray Beauty Factory');
        $response->assertSee('Science Meets Beauty');

        // Check for correct styling classes (partial match)
        $content = $response->getContent();
        $this->assertStringContainsString('bg-[#000d1a]', $content); // Deep navy
        $this->assertStringContainsString('cyan-400', $content); // Cyan accents
    }
}

