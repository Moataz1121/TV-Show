<?php

namespace Tests\Feature;

use App\Models\Episode;
use App\Models\TvShow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected TvShow $show;
    protected Episode $episode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'High school chemistry teacher turned empire builder', 'ar' => 'معلم كيمياء ثانوية يدير إمبراطورية'],
            'airing_time' => now(),
        ]);

        $this->episode = $this->show->episodes()->create([
            'title' => ['en' => 'Fly Episode', 'ar' => 'حلقة الذبابة'],
            'description' => ['en' => 'Contamination in the lab causing delays', 'ar' => 'تلوث في المختبر يسبب تأخيرات'],
            'duration' => 45,
            'airing_time' => now(),
        ]);
    }

    public function test_searching_by_tv_show_title_returns_correct_show(): void
    {
        $response = $this->actingAs($this->user)->get(route('search', ['q' => 'Breaking']));

        $response->assertStatus(200);
        $response->assertSee('TV Shows (1)');
        $response->assertSee('Breaking Bad');
        $response->assertSee(route('shows.show', $this->show));
    }

    public function test_searching_by_episode_title_returns_correct_episode(): void
    {
        $response = $this->actingAs($this->user)->get(route('search', ['q' => 'Fly Episode']));

        $response->assertStatus(200);
        $response->assertSee('Episodes (1)');
        $response->assertSee('Fly Episode');
        $response->assertSee(route('episodes.show', $this->episode));
    }

    public function test_searching_by_description_returns_matching_records(): void
    {
        $response = $this->actingAs($this->user)->get(route('search', ['q' => 'Contamination']));

        $response->assertStatus(200);
        $response->assertSee('Fly Episode');
    }

    public function test_searching_translated_arabic_content_works(): void
    {
        $response = $this->actingAs($this->user)->get(route('search', ['q' => 'بريكينج']));

        $response->assertStatus(200);
        $response->assertSee('Breaking Bad');
    }

    public function test_empty_search_query_is_handled_properly(): void
    {
        $response = $this->actingAs($this->user)->get(route('search', ['q' => '']));

        $response->assertStatus(200);
        $response->assertSee('Please enter a search keyword');
    }

    public function test_no_results_found_state_is_handled_properly(): void
    {
        $response = $this->actingAs($this->user)->get(route('search', ['q' => 'NonExistentTerm123']));

        $response->assertStatus(200);
        $response->assertSee('No TV shows or episodes found matching');
    }

    public function test_guest_user_is_redirected_to_login_when_accessing_search(): void
    {
        $response = $this->get(route('search', ['q' => 'Breaking']));

        $response->assertRedirect(route('login'));
    }
}
