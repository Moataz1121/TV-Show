<?php

namespace App\Services;

use App\Models\Episode;
use App\Repositories\Contracts\EpisodeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EpisodeService
{
    public function __construct(
        protected EpisodeRepositoryInterface $episodeRepository
    ) {}

    public function getLatestEpisodes(int $limit = 6): Collection
    {
        return $this->episodeRepository->getLatest($limit);
    }

    public function getEpisodeWithTvShow(int $id): ?Episode
    {
        return $this->episodeRepository->findByIdWithTvShow($id);
    }

    public function getPaginatedEpisodes(int $perPage = 10): LengthAwarePaginator
    {
        return $this->episodeRepository->getPaginatedEpisodes($perPage);
    }

    public function getEpisodeDetails(int $id): ?Episode
    {
        return $this->episodeRepository->getEpisodeDetails($id);
    }

    public function createEpisode(array $data, ?UploadedFile $thumbnailFile = null, ?UploadedFile $videoFile = null): Episode
    {
        $preparedData = $this->prepareEpisodeData($data, $thumbnailFile, $videoFile);

        return $this->episodeRepository->create($preparedData);
    }

    public function updateEpisode(Episode $episode, array $data, ?UploadedFile $thumbnailFile = null, ?UploadedFile $videoFile = null): Episode
    {
        $preparedData = $this->prepareEpisodeData($data, $thumbnailFile, $videoFile, $episode);

        return $this->episodeRepository->update($episode, $preparedData);
    }

    protected function prepareEpisodeData(array $data, ?UploadedFile $thumbnailFile, ?UploadedFile $videoFile, ?Episode $existing = null): array
    {
        $prepared = [
            'tv_show_id' => $data['tv_show_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'duration' => $data['duration'] ?? null,
            'airing_time' => $data['airing_time'] ?? null,
        ];

        // Handle thumbnail
        if ($thumbnailFile) {
            $path = $thumbnailFile->store('thumbnails', 'public');
            $prepared['thumbnail'] = Storage::url($path);
        } elseif (!empty($data['thumbnail_url'])) {
            $prepared['thumbnail'] = $data['thumbnail_url'];
        } elseif ($existing) {
            $prepared['thumbnail'] = $existing->thumbnail;
        } else {
            $prepared['thumbnail'] = null;
        }

        // Handle video
        if ($videoFile) {
            $path = $videoFile->store('videos', 'public');
            $prepared['video'] = Storage::url($path);
        } elseif (!empty($data['video_url'])) {
            $prepared['video'] = $data['video_url'];
        } elseif ($existing) {
            $prepared['video'] = $existing->video;
        } else {
            $prepared['video'] = null;
        }

        return $prepared;
    }
}
