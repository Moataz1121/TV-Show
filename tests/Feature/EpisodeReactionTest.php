<?php

namespace Tests\Feature;

use App\Models\Episode;
use App\Models\TvShow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EpisodeReactionTest extends TestCase
{
    use RefreshDatabase;

    protected TvShow $show;
    protected Episode $episode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'Show description', 'ar' => 'وصف المسلسل'],
        ]);

        $this->episode = $this->show->episodes()->create([
            'title' => ['en' => 'Pilot Episode', 'ar' => 'الحلقة الأولى'],
            'description' => ['en' => 'First episode description', 'ar' => 'وصف الحلقة الأولى'],
        ]);
    }

    public function test_authenticated_user_can_like_an_episode(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('episodes.react', $this->episode), [
            'type' => 'like',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('episode_reactions', [
            'user_id' => $user->id,
            'episode_id' => $this->episode->id,
            'type' => 'like',
        ]);
    }

    public function test_authenticated_user_can_dislike_an_episode(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('episodes.react', $this->episode), [
            'type' => 'dislike',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('episode_reactions', [
            'user_id' => $user->id,
            'episode_id' => $this->episode->id,
            'type' => 'dislike',
        ]);
    }

    public function test_user_can_remove_their_reaction_by_clicking_same_type_again(): void
    {
        $user = User::factory()->create();

        // Like the episode
        $this->actingAs($user)->post(route('episodes.react', $this->episode), ['type' => 'like']);
        $this->assertDatabaseHas('episode_reactions', ['user_id' => $user->id, 'type' => 'like']);

        // Click Like again -> removes reaction
        $response = $this->actingAs($user)->post(route('episodes.react', $this->episode), ['type' => 'like']);

        $response->assertRedirect();
        $this->assertDatabaseMissing('episode_reactions', ['user_id' => $user->id]);
    }

    public function test_user_can_switch_reaction_from_like_to_dislike(): void
    {
        $user = User::factory()->create();

        // Like first
        $this->actingAs($user)->post(route('episodes.react', $this->episode), ['type' => 'like']);

        // Switch to Dislike
        $response = $this->actingAs($user)->post(route('episodes.react', $this->episode), ['type' => 'dislike']);

        $response->assertRedirect();
        $this->assertDatabaseHas('episode_reactions', [
            'user_id' => $user->id,
            'episode_id' => $this->episode->id,
            'type' => 'dislike',
        ]);
        $this->assertEquals(1, $this->episode->episodeReactions()->where('user_id', $user->id)->count());
    }

    public function test_duplicate_reactions_are_prevented(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('episodes.react', $this->episode), ['type' => 'like']);

        $this->assertEquals(1, $this->episode->episodeReactions()->where('user_id', $user->id)->count());
    }

    public function test_guest_user_cannot_react_and_is_redirected_to_login(): void
    {
        $response = $this->post(route('episodes.react', $this->episode), ['type' => 'like']);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('episode_reactions', ['episode_id' => $this->episode->id]);
    }

    public function test_correct_current_reaction_is_displayed_when_reopening_episode(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('episodes.react', $this->episode), ['type' => 'like']);

        $response = $this->actingAs($user)->get(route('episodes.show', $this->episode));

        $response->assertStatus(200);
        $response->assertSee('btn-primary'); // Active like button CSS class
    }
}
