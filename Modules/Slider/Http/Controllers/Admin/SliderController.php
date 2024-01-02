<?php

namespace Modules\Slider\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Controller;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Http\Requests\Admin\SaveSliderRequest;
use Modules\Slider\Transformers\Admin\SliderResource;
use Modules\Support\Traits\HasCrudActions;

class SliderController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Slider::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.sliders.slider';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Slider';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveSliderRequest::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected array $fillableActivityLog = [
        "attributes" => [
            'name',

        ],
        "relations" => []
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        "show" => ["slides"]
    ];

    /**
     * Determine if a edit action load relationship
     *
     * @var bool
     */
    protected bool $loadRelationsOnEdit = true;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = SliderResource::class;

    /**
     * Pipeline through
     *
     * @var array
     */
    protected array $pipelineThrough = [
        "index" => [
            \Modules\Support\Filters\NameTranslationLikeSearchFilter::class,
            \Modules\Support\Filters\FromCreatedAtFilter::class,
            \Modules\Support\Filters\ToCreatedAtFilter::class,
        ]
    ];
}