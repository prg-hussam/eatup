<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Media\Eloquent\HasMedia;
use Modules\Support\Eloquent\Model;

class SliderSlide extends Model
{
    use HasMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slider_id',
        'position'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ["banners"];

    /**
     * Get the product's base image.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function banners(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->files->whereIn(
                'pivot.zone',
                array_map(fn ($locale) => "banner_{$locale}", supported_locale_keys())
            )

                ->map(fn ($banner) => $this->fileResource($banner, true))
        );
    }

    /**
     * Get the slide's banner.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function banner(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->fileResource(
                $this->files->whereIn('pivot.zone', "banner_" . locale())
                    ->first()
            )
        );
    }
}