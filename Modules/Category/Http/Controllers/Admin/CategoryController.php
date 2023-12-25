<?php

namespace Modules\Category\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Support\Traits\HasCrudActions;
use Modules\Category\Transformers\Admin\CategoryResource;
use Modules\Category\Http\Requests\Admin\SaveCategoryRequest;

class CategoryController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.categories.category';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Category';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveCategoryRequest::class;




    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = CategoryResource::class;

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