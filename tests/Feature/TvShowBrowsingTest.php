<?php

namespace Tests\Feature;

use App\Models\Episode;
use App\Models\TvShow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TvShowBrowsingTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_latest_episodes(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'Chemistry teacher show', 'ar' => 'مسلسل كيمياء'],
            'airing_time' => now(),
        ]);

        $episode = $show->episodes()->create([
            'title' => ['en' => 'Pilot Episode', 'ar' => 'الحلقة الأولى'],
            'description' => ['en' => 'First episode description', 'ar' => 'وصف الحلقة الأولى'],
            'duration' => 58,
            'airing_time' => now(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Latest Episodes');
        $response->assertSee('Pilot Episode');
        $response->assertSee('Breaking Bad');
    }

    public function test_tv_shows_listing_page_displays_shows_with_translations(): void
    {
        TvShow::create([
            'title' => ['en' => 'Stranger Things', 'ar' => 'أمور أغرب'],
            'description' => ['en' => 'Sci-Fi series', 'ar' => 'مسلسل خيال علمي'],
            'airing_time' => now(),
        ]);

        $response = $this->get('/shows');

        $response->assertStatus(200);
        $response->assertSee('Explore TV Shows');
        $response->assertSee('Stranger Things');
    }

    public function test_tv_show_details_page_displays_show_info_and_its_episodes(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'Game of Thrones', 'ar' => 'صراع العروش'],
            'description' => ['en' => 'Epic fantasy series', 'ar' => 'مسلسل ملحمي'],
            'airing_time' => now(),
        ]);

        $episode = $show->episodes()->create([
            'title' => ['en' => 'Winter Is Coming', 'ar' => 'الشتاء قادم'],
            'description' => ['en' => 'Series Premiere', 'ar' => 'الحلقة الاولى'],
            'duration' => 62,
            'airing_time' => now(),
        ]);

        $response = $this->get('/shows/' . $show->id);

        $response->assertStatus(200);
        $response->assertSee('Game of Thrones');
        $response->assertSee('Winter Is Coming');
    }

    public function test_authenticated_user_can_view_episode_details_page(): void
    {
        $user = User::factory()->create();

        $show = TvShow::create([
            'title' => ['en' => 'The Office', 'ar' => 'المكتب'],
            'description' => ['en' => 'Comedy series', 'ar' => 'مسلسل كوميدي'],
        ]);

        $episode = $show->episodes()->create([
            'title' => ['en' => 'Health Care', 'ar' => 'الرعاية الصحية'],
            'description' => ['en' => 'Dwight picks health care plan', 'ar' => 'دوايت يختار الخطة'],
            'duration' => 22,
        ]);

        $response = $this->actingAs($user)->get('/episodes/' . $episode->id);

        $response->assertStatus(200);
        $response->assertSee('Health Care');
        $response->assertSee('The Office');
    }

    public function test_unauthenticated_user_is_redirected_to_login_when_viewing_episode(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'Sherlock', 'ar' => 'شيرلوك'],
            'description' => ['en' => 'Detective series', 'ar' => 'مسلسل تحري'],
        ]);

        $episode = $show->episodes()->create([
            'title' => ['en' => 'A Study in Pink', 'ar' => 'دراسة في اللون الوردي'],
            'description' => ['en' => 'First episode', 'ar' => 'الحلقة الأولى'],
        ]);

        $response = $this->get('/episodes/' . $episode->id);

        $response->assertRedirect(route('login'));
    }
}
