<?php

namespace Modules\Meal\Http\Controllers\Admin;

use Modules\Meal\Entities\Menu;
use Illuminate\Routing\Controller;
use Modules\Support\Traits\HasCrudActions;
use Modules\Meal\Http\Requests\Admin\SaveMenuRequest;
use Modules\Meal\Transformers\Admin\MenuResource;

class MenuController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.menus.menu';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Menu';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveMenuRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = MenuResource::class;

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
        ]
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

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
        "attributes" => ["name", "is_active", 'is_default'],
    ];
}
