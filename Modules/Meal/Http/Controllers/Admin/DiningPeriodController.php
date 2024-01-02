<?php

namespace Modules\Meal\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Meal\Entities\DiningPeriod;
use Modules\Support\Traits\HasCrudActions;
use Modules\Meal\Http\Requests\Admin\SaveDiningPeriodRequest;
use Modules\Meal\Transformers\Admin\DiningPeriodResource;

class DiningPeriodController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = DiningPeriod::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.dining_periods.dining_period';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'DiningPeriod';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveDiningPeriodRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = DiningPeriodResource::class;

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
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'show' => ['categories:id,name'],
        'index' => ['files']
    ];

    /**
     * Determine if a edit action load relationship
     *
     * @var bool
     */
    protected bool $loadRelationsOnEdit = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected array $fillableActivityLog = [
        "attributes" => ["name", "is_active", 'categories', 'files'],
    ];
}
