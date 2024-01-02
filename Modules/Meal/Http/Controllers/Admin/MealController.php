<?php

namespace Modules\Meal\Http\Controllers\Admin;

use Modules\Meal\Entities\Meal;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Meal\Entities\DiningPeriod;
use Modules\Meal\Enums\MealType;
use Modules\Support\Traits\HasCrudActions;
use Modules\Meal\Transformers\Admin\MealResource;
use Modules\Meal\Http\Requests\Admin\SaveMealRequest;
use Modules\Meal\Transformers\Admin\ShowMealResource;

class MealController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Meal::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.meals.meal';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Meal';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveMealRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = [
        'index' => MealResource::class,
        'show' => ShowMealResource::class,
    ];

    /**
     * Pipeline through
     *
     * @var array
     */
    protected array $pipelineThrough = [
        "index" => [
            \Modules\Support\Filters\FromCreatedAtFilter::class,
            \Modules\Support\Filters\ToCreatedAtFilter::class,
            \Modules\Support\Filters\NameTranslationLikeSearchFilter::class,
            \Modules\Support\Filters\ActiveStatusesFilter::class,
            \Modules\Meal\Filters\TypesFilter::class,
            \Modules\Meal\Filters\CategoriesFilter::class,
            \Modules\Meal\Filters\DiningPeriodsFilter::class,
        ]
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'show' => ['ingredients:id,name', 'diningPeriods:id,name', 'menus:id,name'],
        'index' => ['category', 'files']
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
        "attributes" => ["name", "is_active"],
    ];


    /**
     * Get index page data
     * @return array
     */
    protected function indexData(): array
    {
        return [
            'filters' => [
                'types' => MealType::toArrayWithTranslations(),
                'categories' => Category::list(),
                'diningPeriods' => DiningPeriod::list()
            ]
        ];
    }
}
