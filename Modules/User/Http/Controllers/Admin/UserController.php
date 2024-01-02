<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\Admin\SaveUserRequest;
use Modules\Support\Traits\HasCrudActions;
use Modules\User\Transformers\Admin\UserResource;

class UserController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = User::class;


    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.users.user';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'User';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ["roles"];

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveUserRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = UserResource::class;

    /**
     * Pipeline through
     *
     * @var array
     */
    protected array $pipelineThrough = [
        "index" => [
            \Modules\Support\Filters\FromCreatedAtFilter::class,
            \Modules\Support\Filters\ToCreatedAtFilter::class,
            \Modules\Support\Filters\ActiveStatusesFilter::class,
            \Modules\User\Filters\UserSearchFilter::class,
            \Modules\User\Filters\UserRoleFilter::class,
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected array $fillableActivityLog = [
        "attributes" => ["name", "email", "username", "is_active"],
        "relations"  => ["roles:id,name"]
    ];

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $request = $this->getRequest('store');

        $request->merge(['password' => bcrypt($request->password)]);

        $user = $this->getModel()->create($request->all());

        $user->syncRoles($request->roles);

        _activity(
            __FUNCTION__,
            $user,
            "messages.resource_created",
            auth($this->getGuard())->user(),
            ["attributes" => getModelAttributesForActivity($user, $this->fillableActivityLog)],
            ['resource' => $this->label]
        );

        return redirect()->route("{$this->getRoutePrefix()}.index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $entity = $this->getEntity($id);
        $request = $this->getRequest('update');
        $oldAttributes = getModelAttributesForActivity($entity, $this->fillableActivityLog);

        if (is_null($request->password)) {
            unset($request['password']);
        } else {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $entity->update($request->all());

        $entity->syncRoles($request->roles);

        _activity(
            __FUNCTION__,
            $entity,
            "messages.resource_updated",
            auth($this->getGuard())->user(),
            [
                "attributes" => [
                    ...getModelAttributesForActivity($entity, $this->fillableActivityLog),
                    "password" => !is_null($request->password) ? "Changed" : null,
                ],
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
        $model = $this->getModel();
        $model->withoutGlobalScope("active")
            ->whereNotIn('id', [1])
            ->whereIn($model->getKeyName(), explode(',', $ids))
            ->each(function ($entity) {
                if ($entity->delete() && $this->activityLogEnabled()) {
                    _activity(
                        "destroy",
                        $entity,
                        "messages.resource_deleted",
                        auth($this->getGuard())->user(),
                        ["attributes" => $entity],
                        ['resource' => $this->label]
                    );
                }
            });
    }

    /**
     * Get index page data
     * @return array
     */
    protected function indexData(): array
    {
        return [
            'filters' => [
                "roles" => Role::list()
            ]
        ];
    }
}