<?php

namespace Modules\Subscription\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Subscription\Entities\Plan;
use Modules\Support\Traits\HasCrudActions;
use Modules\Subscription\Transformers\Admin\PlanResource;
use Modules\Subscription\Http\Requests\Admin\SavePlanRequest;

class PlanController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.plans.plan';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Plan';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SavePlanRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = PlanResource::class;

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
        "attributes" => ["name", "is_active"],
    ];
}