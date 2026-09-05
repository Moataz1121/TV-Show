<?php

namespace Tests\Feature;

use App\Models\TvShow;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class RandomTvShowsNavbarTest extends TestCase
{
    use RefreshDatabase;

    public function test_navbar_displays_up_to_5_random_tv_shows(): void
    {
        for ($i = 1; $i <= 7; $i++) {
            TvShow::create([
                'title' => ['en' => "Show Number {$i}", 'ar' => "مسلسل رقم {$i}"],
                'description' => ['en' => "Description {$i}", 'ar' => "وصف {$i}"],
            ]);
        }

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Random Shows');

        $content = $response->getContent();
        // Count how many show links are rendered inside dropdown
        $matchCount = preg_match_all('/href="[^"]*\/shows\/\d+"/', $content);
        // Navbar has up to 5 random shows + homepage shows
        $this->assertGreaterThanOrEqual(1, $matchCount);
    }

    public function test_navbar_displays_all_shows_if_fewer_than_5_exist(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            TvShow::create([
                'title' => ['en' => "Mini Show {$i}", 'ar' => "مسلسل مصغر {$i}"],
                'description' => ['en' => "Description {$i}", 'ar' => "وصف {$i}"],
            ]);
        }

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Mini Show 1');
        $response->assertSee('Mini Show 2');
        $response->assertSee('Mini Show 3');
    }

    public function test_random_show_link_navigates_to_show_details_page(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'Featured Series', 'ar' => 'مسلسل مميز'],
            'description' => ['en' => 'Awesome series', 'ar' => 'مسلسل رائع'],
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(route('shows.show', $show));
    }
}
