<?php

namespace Modules\ActivityLog\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\ActivityLog\Enums\HttpMethodsCases;
use Modules\ActivityLog\Entities\ActivityLog;
use Modules\ActivityLog\Transformers\Admin\ActivityLogResource;
use Modules\Support\Traits\HasCrudActions;

class ActivityLogController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected string $model = ActivityLog::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = ActivityLogResource::class;

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'ActivityLog';

    /**
     * Pipeline through
     *
     * @var array
     */
    protected array $pipelineThrough = [
        "index" => [
            \Modules\ActivityLog\Filters\CreatedByAdminsFilter::class,
            \Modules\ActivityLog\Filters\HttpMethodsFilter::class,
            \Modules\ActivityLog\Filters\LogTypesFilter::class,
            \Modules\ActivityLog\Filters\IpFilter::class,
            \Modules\ActivityLog\Filters\CauserFilter::class,
            \Modules\Support\Filters\FromCreatedAtFilter::class,
            \Modules\Support\Filters\ToCreatedAtFilter::class,
            \Modules\ActivityLog\Filters\SearchFilter::class,
        ],
        "show" => [
            \Modules\ActivityLog\Filters\CreatedByAdminsFilter::class,
        ]
    ];

    /**
     * Get data for index page
     *
     * @return array
     */
    public function indexData(): array
    {
        return [
            'filters' => [
                "logTypes" => $this->getLogTypes(),
                'httpMethods' => HttpMethodsCases::toArray(),
            ]
        ];
    }

    /**
     * Get show page data
     *
     * @return array
     */
    public function showData($entity): array
    {
        return [
            "properties" => $entity->properties
        ];
    }

    /**
     * Get log types
     * @return array
     */
    private function getLogTypes(): array
    {
        $types = [];
        foreach (config('platform.modules.activitylog.config.modules', []) as $module => $actions) {
            $singularModule = \Str::singular($module);
            foreach ($actions as $action) {
                $types["{$module}.{$action}"] = __("admin.activity_log.actions.{$action}", ["resource" => __("admin.{$module}.$singularModule")]);
            }
        }
        return $types;
    }
}
