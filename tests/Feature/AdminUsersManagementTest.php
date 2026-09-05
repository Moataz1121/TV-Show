<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUsersManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_users_listing_with_pagination(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->count(12)->create();

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('User Management');
        $response->assertSee('Admin');

        $usersInView = $response->viewData('users');
        $this->assertEquals(10, $usersInView->perPage());
        $this->assertEquals(13, $usersInView->total()); // 12 users + 1 admin
    }

    public function test_admin_can_view_user_details_page(): void
    {
        $admin = User::factory()->admin()->create();
        $targetUser = User::factory()->create([
            'name' => 'Target John',
            'email' => 'target@example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.show', $targetUser));

        $response->assertStatus(200);
        $response->assertSee('Target John');
        $response->assertSee('target@example.com');
        $response->assertSee('User Profile Overview');
    }

    public function test_non_admin_user_receives_403_forbidden_when_accessing_users_management(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $targetUser = User::factory()->create();

        $responseIndex = $this->actingAs($user)->get(route('admin.users.index'));
        $responseIndex->assertStatus(403);

        $responseShow = $this->actingAs($user)->get(route('admin.users.show', $targetUser));
        $responseShow->assertStatus(403);
    }

    public function test_guest_user_is_redirected_to_login_when_accessing_users_management(): void
    {
        $targetUser = User::factory()->create();

        $responseIndex = $this->get(route('admin.users.index'));
        $responseIndex->assertRedirect(route('login'));

        $responseShow = $this->get(route('admin.users.show', $targetUser));
        $responseShow->assertRedirect(route('login'));
    }

    public function test_admin_user_management_is_read_only_and_has_no_create_or_delete_routes(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        // Ensure no edit or create or delete forms exist
        $response->assertDontSee('Create User');
        $response->assertDontSee('Edit User');
        $response->assertDontSee('Delete User');
    }
}
