<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use Modules\Support\Traits\HasCrudActions;
use Modules\User\Entities\Role;
use Modules\User\Http\Requests\SaveRoleRequest;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Transformers\Admin\RoleResource;

class RoleController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Role';

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.roles.role';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveRoleRequest::class;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['permissions'];

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = RoleResource::class;

    /**
     * Pipeline through
     *
     * @var array
     */
    protected array $pipelineThrough = [
        "index" => [
            \Modules\User\Filters\RoleSearchFilter::class,
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected array $fillableActivityLog = [
        "attributes" => ["id", "name", "guard_name", "display_name"],
        "relations" => ["permissions:id,name"]
    ];

    /**
     * Get edit form data
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return array
     */
    private function editFormData(Model $entity): array
    {
        return [
            'permissionNames' => $entity->getPermissionNames()->toArray(),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $data = $this->getRequest('update')->all();

        $entity = $this->getEntity($id);
        $oldAttributes = getModelAttributesForActivity($entity, $this->fillableActivityLog);

        if (in_array($entity->name, RoleRepository::all())) {
            unset($data['name']);
        }

        $entity->update($data);

        _activity(
            __FUNCTION__,
            $entity,
            "messages.resource_updated",
            auth()->user(),
            [
                "attributes" => getModelAttributesForActivity($entity, $this->fillableActivityLog),
                "old" => $oldAttributes
            ],
            ['resource' => $this->label]
        );


        return redirect()->route("{$this->getRoutePrefix()}.index");
    }

    /**
     * Destroy resources by given ids.
     *
     * @param  string  $ids
     * @return void
     */
    public function destroy($ids)
    {
        $this->getModel()
            ->withoutGlobalScope("active")
            ->whereIn('id', explode(',', $ids))
            ->whereNotIn('name', RoleRepository::all())
            ->each(function ($entity) {
                if ($entity->delete()) {
                    _activity(
                        __FUNCTION__,
                        $entity,
                        "messages.resource_deleted",
                        auth("web")->user(),
                        ["attributes" => $entity],
                        ['resource' => $this->label]
                    );
                }
            });
    }
}
