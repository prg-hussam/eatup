<?php

namespace Modules\Meal\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Meal\Entities\Ingredient;
use Modules\Meal\Http\Requests\Admin\SaveIngredientRequest;
use Modules\Meal\Transformers\Admin\IngredientResource;
use Modules\Support\Traits\HasCrudActions;

class IngredientController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.ingredients.ingredient';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Ingredient';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveIngredientRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = IngredientResource::class;

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