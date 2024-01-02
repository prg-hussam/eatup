<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Support\Eloquent\Model;
use Modules\Support\Eloquent\Translatable;

class Slider extends Model
{
    use Translatable;

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($slider) {
            $slider->saveSlides(request('slides', []));
            $slider->clearCache();
        });
    }

    /**
     * Clear the cache
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::tags("sliders.{$this->id}")->flush();
    }

    /**
     * Find with slides
     *
     * @param int|null $id
     * @return \Modules\Slider\Entities\Slider|null
     */
    public static function findWithSlides(?int $id = null): ?Slider
    {
        return is_null($id)
            ? null
            : Cache::tags("sliders.{$id}")
            ->rememberForever(md5("sliders.{$id}:" . locale()), function () use ($id) {
                return static::with('slides')->find($id);
            });
    }

    /**
     * Get a list of all slider.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function list(): Collection
    {
        return Cache::tags("sliders")->rememberForever(
            md5("sliders.list:" . locale()),
            fn () => static::select('id', 'name')->pluck('name', 'id')
        );
    }

    /**
     * Get slides
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function slides(): HasMany
    {
        return $this->hasMany(SliderSlide::class)->orderBy('position');
    }

    /**
     * Save slides for the slider.
     *
     * @param array $slides
     * @return void
     */
    public function saveSlides(array $slides): void
    {
        $ids = $this->getDeleteCandidates($slides);

        if ($ids->isNotEmpty()) {
            $this->slides()->whereIn('id', $ids)->delete();
        }

        foreach ($slides as $index => $slide) {
            $slide = $this->slides()->updateOrCreate(
                ['id' => $slide['id']],
                $slide + ['position' => $index]
            );
            $slide->syncFiles(request("slides.{$index}.files", []));
        }
    }

    /**
     * Get Delete slides for the slider.
     *
     * @param array $slides
     * @return array
     */
    private function getDeleteCandidates(array $slides = []): Collection
    {
        return $this->slides()
            ->pluck('id')
            ->diff(Arr::pluck($slides, 'id'));
    }
}