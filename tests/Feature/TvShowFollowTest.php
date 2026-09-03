<?php

namespace Tests\Feature;

use App\Models\TvShow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TvShowFollowTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_follow_a_tv_show(): void
    {
        $user = User::factory()->create();
        $show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'Chemistry teacher show', 'ar' => 'مسلسل كيمياء'],
        ]);

        $response = $this->actingAs($user)->post(route('shows.follow', $show));

        $response->assertRedirect();
        $this->assertDatabaseHas('show_user', [
            'user_id' => $user->id,
            'tv_show_id' => $show->id,
        ]);
        $this->assertTrue($user->tvShows()->where('tv_show_id', $show->id)->exists());
    }

    public function test_follow_button_changes_to_unfollow_when_show_is_followed(): void
    {
        $user = User::factory()->create();
        $show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'Chemistry teacher show', 'ar' => 'مسلسل كيمياء'],
        ]);

        $user->tvShows()->attach($show->id);

        $response = $this->actingAs($user)->get(route('shows.show', $show));

        $response->assertStatus(200);
        $response->assertSee('Unfollow Show');
    }

    public function test_authenticated_user_can_unfollow_a_tv_show(): void
    {
        $user = User::factory()->create();
        $show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'Chemistry teacher show', 'ar' => 'مسلسل كيمياء'],
        ]);

        $user->tvShows()->attach($show->id);

        $response = $this->actingAs($user)->delete(route('shows.unfollow', $show));

        $response->assertRedirect();
        $this->assertDatabaseMissing('show_user', [
            'user_id' => $user->id,
            'tv_show_id' => $show->id,
        ]);
    }

    public function test_duplicate_follow_attempts_are_handled_gracefully(): void
    {
        $user = User::factory()->create();
        $show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'Chemistry teacher show', 'ar' => 'مسلسل كيمياء'],
        ]);

        // Follow twice
        $this->actingAs($user)->post(route('shows.follow', $show));
        $response = $this->actingAs($user)->post(route('shows.follow', $show));

        $response->assertRedirect();
        $this->assertEquals(1, $user->tvShows()->where('tv_show_id', $show->id)->count());
    }

    public function test_guest_user_cannot_follow_a_tv_show_and_is_redirected_to_login(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'Chemistry teacher show', 'ar' => 'مسلسل كيمياء'],
        ]);

        $response = $this->post(route('shows.follow', $show));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('show_user', [
            'tv_show_id' => $show->id,
        ]);
    }
}
