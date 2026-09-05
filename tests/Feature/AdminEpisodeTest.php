<?php

namespace Tests\Feature;

use App\Models\Episode;
use App\Models\TvShow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminEpisodeTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;
    protected TvShow $show;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->regularUser = User::factory()->create([
            'role' => 'user',
        ]);

        $this->show = TvShow::create([
            'title' => ['en' => 'Breaking Bad', 'ar' => 'بريكينج باد'],
            'description' => ['en' => 'Show description', 'ar' => 'وصف المسلسل'],
        ]);
    }

    public function test_non_admin_cannot_access_admin_episodes_routes(): void
    {
        $episode = Episode::create([
            'tv_show_id' => $this->show->id,
            'title' => ['en' => 'Pilot'],
            'description' => ['en' => 'Pilot episode description'],
            'duration' => 45,
        ]);

        // Unauthenticated user -> redirect to login
        $this->get(route('admin.episodes.index'))->assertRedirect(route('login'));

        // Non-admin user -> 403 Forbidden
        $this->actingAs($this->regularUser)->get(route('admin.episodes.index'))->assertStatus(403);
        $this->actingAs($this->regularUser)->get(route('admin.episodes.create'))->assertStatus(403);
        $this->actingAs($this->regularUser)->get(route('admin.episodes.show', $episode))->assertStatus(403);
        $this->actingAs($this->regularUser)->get(route('admin.episodes.edit', $episode))->assertStatus(403);
    }

    public function test_admin_can_list_episodes_with_pagination(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Episode::create([
                'tv_show_id' => $this->show->id,
                'title' => ['en' => "Episode {$i}"],
                'description' => ['en' => "Description {$i}"],
                'duration' => 40 + $i,
            ]);
        }

        $response = $this->actingAs($this->admin)->get(route('admin.episodes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.episodes.index');
        $response->assertSee('Episode 15');
    }

    public function test_admin_can_view_create_episode_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.episodes.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.episodes.create');
        $response->assertSee('Breaking Bad');
    }

    public function test_admin_can_create_episode_with_translations_and_tv_show_association(): void
    {
        $data = [
            'tv_show_id' => $this->show->id,
            'title' => [
                'en' => 'Ozymandias',
                'ar' => 'أوزيماندياس',
            ],
            'description' => [
                'en' => 'Everyone copes with chaos.',
                'ar' => 'الجميع يتعامل مع الفوضى.',
            ],
            'duration' => 48,
            'airing_time' => '2026-09-10 20:00:00',
            'thumbnail_url' => 'https://example.com/thumb.jpg',
            'video_url' => 'https://example.com/video.mp4',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.episodes.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('episodes', [
            'tv_show_id' => $this->show->id,
            'duration' => 48,
            'thumbnail' => 'https://example.com/thumb.jpg',
            'video' => 'https://example.com/video.mp4',
        ]);

        $createdEpisode = Episode::where('tv_show_id', $this->show->id)->first();
        $this->assertEquals('Ozymandias', $createdEpisode->getTranslation('title', 'en'));
        $this->assertEquals('أوزيماندياس', $createdEpisode->getTranslation('title', 'ar'));
    }

    public function test_admin_can_create_episode_with_file_uploads(): void
    {
        Storage::fake('public');

        $thumbnail = UploadedFile::fake()->image('thumbnail.png');
        $video = UploadedFile::fake()->create('sample.mp4', 1024, 'video/mp4');

        $data = [
            'tv_show_id' => $this->show->id,
            'title' => ['en' => 'Uploaded Episode'],
            'description' => ['en' => 'Uploaded episode description'],
            'duration' => 50,
            'thumbnail' => $thumbnail,
            'video' => $video,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.episodes.store'), $data);

        $response->assertRedirect();
        $episode = Episode::where('tv_show_id', $this->show->id)->where('duration', 50)->first();
        $this->assertNotNull($episode);
        $this->assertStringContainsString('/storage/thumbnails/', $episode->thumbnail);
        $this->assertStringContainsString('/storage/videos/', $episode->video);
    }

    public function test_validation_errors_when_creating_episode_with_invalid_data(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.episodes.store'), [
            'tv_show_id' => 99999, // Non-existent TV show
            'title' => ['en' => ''],
            'duration' => 'invalid',
        ]);

        $response->assertSessionHasErrors(['tv_show_id', 'title.en', 'description.en', 'duration']);
    }

    public function test_admin_can_view_episode_details(): void
    {
        $episode = Episode::create([
            'tv_show_id' => $this->show->id,
            'title' => ['en' => 'Face Off', 'ar' => 'مواجهة'],
            'description' => ['en' => 'Gus and Walt final show-down.', 'ar' => 'المواجهة النهائية.'],
            'duration' => 50,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.episodes.show', $episode));

        $response->assertStatus(200);
        $response->assertViewIs('admin.episodes.show');
        $response->assertSee('Face Off');
        $response->assertSee('Breaking Bad');
    }

    public function test_admin_can_view_edit_episode_page(): void
    {
        $episode = Episode::create([
            'tv_show_id' => $this->show->id,
            'title' => ['en' => 'Felina'],
            'description' => ['en' => 'Series finale.'],
            'duration' => 55,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.episodes.edit', $episode));

        $response->assertStatus(200);
        $response->assertViewIs('admin.episodes.edit');
        $response->assertSee('Felina');
    }

    public function test_admin_can_update_episode(): void
    {
        $episode = Episode::create([
            'tv_show_id' => $this->show->id,
            'title' => ['en' => 'Old Title', 'ar' => 'عنوان قديم'],
            'description' => ['en' => 'Old description', 'ar' => 'وصف قديم'],
            'duration' => 40,
        ]);

        $updateData = [
            'tv_show_id' => $this->show->id,
            'title' => ['en' => 'Updated Title', 'ar' => 'عنوان محدث'],
            'description' => ['en' => 'Updated description', 'ar' => 'وصف محدث'],
            'duration' => 60,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.episodes.update', $episode), $updateData);

        $response->assertRedirect(route('admin.episodes.show', $episode));

        $episode->refresh();
        $this->assertEquals('Updated Title', $episode->getTranslation('title', 'en'));
        $this->assertEquals('عنوان محدث', $episode->getTranslation('title', 'ar'));
        $this->assertEquals(60, $episode->duration);
    }
}
