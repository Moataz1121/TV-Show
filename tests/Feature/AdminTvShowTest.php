<?php

namespace Tests\Feature;

use App\Models\TvShow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTvShowTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $normalUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->normalUser = User::factory()->create(['role' => 'user']);
    }

    public function test_admin_can_list_tv_shows_with_pagination(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            TvShow::create([
                'title' => ['en' => "Show {$i}", 'ar' => "مسلسل {$i}"],
                'description' => ['en' => "Desc {$i}", 'ar' => "وصف {$i}"],
            ]);
        }

        $response = $this->actingAs($this->admin)->get(route('admin.tv-shows.index'));

        $response->assertStatus(200);
        $response->assertSee('TV Shows Management');

        $showsInView = $response->viewData('shows');
        $this->assertEquals(10, $showsInView->perPage());
        $this->assertEquals(15, $showsInView->total());
    }

    public function test_admin_can_render_create_page_and_create_tv_show(): void
    {
        $responseCreate = $this->actingAs($this->admin)->get(route('admin.tv-shows.create'));
        $responseCreate->assertStatus(200);

        $responseStore = $this->actingAs($this->admin)->post(route('admin.tv-shows.store'), [
            'title' => [
                'en' => 'Better Call Saul',
                'ar' => 'من الأفضل الاتصال بسول',
            ],
            'description' => [
                'en' => 'Lawyer Jimmy McGill transforms into Saul Goodman',
                'ar' => 'تحول المحامي جيمي ماكجيل إلى سول جودمان',
            ],
            'airing_time' => '2026-10-15T20:00',
        ]);

        $show = TvShow::where('title->en', 'Better Call Saul')->first();
        $this->assertNotNull($show);
        $this->assertEquals('من الأفضل الاتصال بسول', $show->getTranslation('title', 'ar'));
        $responseStore->assertRedirect(route('admin.tv-shows.show', $show));
    }

    public function test_admin_can_view_tv_show_details(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'The Sopranos', 'ar' => 'عائلة سوبرانو'],
            'description' => ['en' => 'Mafia boss Tony Soprano', 'ar' => 'زعيم المافيا توني سوبرانو'],
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.tv-shows.show', $show));

        $response->assertStatus(200);
        $response->assertSee('The Sopranos');
        $response->assertSee('عائلة سوبرانو');
    }

    public function test_admin_can_render_edit_page_and_update_tv_show(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'Old Title', 'ar' => 'عنوان قديم'],
            'description' => ['en' => 'Old Description', 'ar' => 'وصف قديم'],
        ]);

        $responseEdit = $this->actingAs($this->admin)->get(route('admin.tv-shows.edit', $show));
        $responseEdit->assertStatus(200);
        $responseEdit->assertSee('Old Title');

        $responseUpdate = $this->actingAs($this->admin)->put(route('admin.tv-shows.update', $show), [
            'title' => [
                'en' => 'Updated Title',
                'ar' => 'عنوان محدث',
            ],
            'description' => [
                'en' => 'Updated Description',
                'ar' => 'وصف محدث',
            ],
        ]);

        $show->refresh();
        $this->assertEquals('Updated Title', $show->getTranslation('title', 'en'));
        $this->assertEquals('عنوان محدث', $show->getTranslation('title', 'ar'));
        $responseUpdate->assertRedirect(route('admin.tv-shows.show', $show));
    }

    public function test_validation_fails_for_missing_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.tv-shows.store'), [
            'title' => ['en' => ''],
            'description' => ['en' => ''],
        ]);

        $response->assertSessionHasErrors(['title.en', 'description.en']);
    }

    public function test_non_admin_user_receives_403_forbidden_on_admin_tv_shows_routes(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'Test Show', 'ar' => 'مسلسل تجريبي'],
            'description' => ['en' => 'Test Desc', 'ar' => 'وصف تجريبي'],
        ]);

        $this->actingAs($this->normalUser)->get(route('admin.tv-shows.index'))->assertStatus(403);
        $this->actingAs($this->normalUser)->get(route('admin.tv-shows.create'))->assertStatus(403);
        $this->actingAs($this->normalUser)->post(route('admin.tv-shows.store'), [])->assertStatus(403);
        $this->actingAs($this->normalUser)->get(route('admin.tv-shows.show', $show))->assertStatus(403);
        $this->actingAs($this->normalUser)->get(route('admin.tv-shows.edit', $show))->assertStatus(403);
        $this->actingAs($this->normalUser)->put(route('admin.tv-shows.update', $show), [])->assertStatus(403);
    }

    public function test_guest_user_is_redirected_to_login_on_admin_tv_shows_routes(): void
    {
        $response = $this->get(route('admin.tv-shows.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_existing_user_facing_tv_show_pages_continue_to_work(): void
    {
        $show = TvShow::create([
            'title' => ['en' => 'Public Show', 'ar' => 'مسلسل عام'],
            'description' => ['en' => 'Public Desc', 'ar' => 'وصف عام'],
        ]);

        $response = $this->get(route('shows.show', $show));
        $response->assertStatus(200);
        $response->assertSee('Public Show');
    }
}
