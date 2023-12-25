<?php

namespace Modules\Localization\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Support\Traits\HasCrudActions;
use Modules\Localization\Entities\Province;
use Modules\Localization\Transformers\Admin\ProvinceResource;
use Modules\Localization\Http\Requests\Admin\SaveProvinceRequest;

class ProvinceController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Province::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.provinces.province';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Province';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveProvinceRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = ProvinceResource::class;

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