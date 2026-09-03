<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Episode extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    /**
     * The attributes that are translatable using Spatie Translatable.
     *
     * @var array<int, string>
     */
    public array $translatable = [
        'title',
        'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tv_show_id',
        'title',
        'description',
        'duration',
        'airing_time',
        'thumbnail',
        'video',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'airing_time' => 'datetime',
            'duration' => 'integer',
        ];
    }

    /**
     * The TV show that owns the episode.
     */
    public function tvShow(): BelongsTo
    {
        return $this->belongsTo(TvShow::class);
    }

    /**
     * The reactions for the episode.
     */
    public function episodeReactions(): HasMany
    {
        return $this->hasMany(EpisodeReaction::class);
    }
}
