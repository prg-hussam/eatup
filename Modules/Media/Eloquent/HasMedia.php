<?php

namespace Modules\Media\Eloquent;

use Modules\Media\Entities\File;

trait HasMedia
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootHasMedia()
    {
        static::saved(function ($entity) {
            $entity->syncFiles(request('files', []));
        });
    }

    /**
     * Get all of the files for the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'entity', 'entity_files')
            ->withPivot(['id', 'zone'])
            ->withTimestamps();
    }

    /**
     * Filter files by zone.
     *
     * @param string $zone
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterFiles($zone)
    {
        return $this->files()->wherePivot('zone', $zone);
    }

    /**
     * Sync files for the entity.
     *
     * @param array $files
     */
    public function syncFiles($files = [])
    {
        $entityType = get_class($this);

        foreach ($files as $zone => $fileIds) {
            $syncList = [];

            foreach (\Arr::wrap($fileIds) as $fileId) {
                if (!empty($fileId)) {
                    $syncList[$fileId]['zone'] = $zone;
                    $syncList[$fileId]['entity_type'] = $entityType;
                }
            }

            $this->filterFiles($zone)->detach();
            $this->filterFiles($zone)->attach($syncList);
        }
    }

    /**
     * Get file resource
     *
     * @param \Modules\Media\Entities\File|null
     * @return array|null
     */
    protected function fileResource(?File $file = null)
    {
        if ($file) {
            return [
                "id" => $file->id,
                "filename" => $file->filename,
                "download_url" => $file->download_url,
                "url" => $file->url,
                "preview_image_url" => $file->preview_image_url,
            ];
        }
    }
}
