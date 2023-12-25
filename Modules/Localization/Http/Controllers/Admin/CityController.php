<?php

namespace Modules\Localization\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Localization\Entities\City;
use Modules\Support\Traits\HasCrudActions;
use Modules\Localization\Transformers\Admin\CityResource;
use Modules\Localization\Http\Requests\Admin\SaveCityRequest;



class CityController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = City::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.cities.city';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'City';


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['province'];

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveCityRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = CityResource::class;

    /**
     * Pipeline through
     *
     * @var array
     */
    protected array $pipelineThrough = [
        "index" => [
            \Modules\Support\Filters\NameTranslationLikeSearchFilter::class,
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected array $fillableActivityLog = [
        "attributes" => ["name", 'province_id', "is_active"],
    ];
}