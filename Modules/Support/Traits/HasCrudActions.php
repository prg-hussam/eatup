<?php

namespace Modules\Support\Traits;

use App\Platform;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pipeline\Pipeline;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Dashboard\Ui\Facades\TabManager;

trait HasCrudActions
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $records = app(Pipeline::class)
            ->send($this->model::query())
            ->through([
                ...(method_exists($this, "indexPipelineThrough")) ? $this->indexPipelineThrough() : [],
                ...$this->pipelineThrough["index"] ?? []
            ])
            ->thenReturn()
            ->with($this->getWith("index"))
            ->withOutGlobalScope("active")
            ->latest()
            ->paginate(Platform::paginate())
            ->withQueryString();

        return Inertia::render(
            $this->getViewPrefix() . "/{$this->component}/Index",
            [
                'records' => $this->getResource('index')::collection($records),
                ...$this->getData('index')
            ],
        );
    }

    /**
     * Show the specified resource.
     *
     * @param mixed $id
     * @return \Inertia\Response
     */
    public function show(mixed $id): Response
    {
        $entity = $this->getEntity($id, true);
        $resource = $this->getResource('show');

        return Inertia::render($this->getViewPrefix() . "/{$this->component}/Show", [
            $this->getResourceName() => (new $resource($entity))->resolve(),
            ...$this->getData("show", $entity)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render($this->getViewPrefix() . "/{$this->component}/Create", [
            'tabs' => TabManager::get($this->getModel()->getTable()),
            $this->getResourceName() => $this->getModel(),
            ...$this->getData('create')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(): RedirectResponse
    {
        // dd($this->getRequest('store')->all());
        $entity = $this->getModel()->create($this->getRequest('store')->all());

        if ($this->activityLogEnabled()) {
            _activity(
                __FUNCTION__,
                $entity,
                "messages.resource_created",
                auth($this->getGuard())->user(),
                array_filter([
                    "attributes" => getModelAttributesForActivity($entity, $this->fillableActivityLog ?? []),
                ]),
                ['resource' => $this->label]
            );
        }

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity);
        }

        return redirect()->route("{$this->getRoutePrefix()}.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = $this->getEntity($id, $this->loadRelationsOnEdit ?? false);

        return Inertia::render($this->getViewPrefix() . "/{$this->component}/Edit", [
            'tabs' => TabManager::get($this->getModel()->getTable()),
            $this->getResourceName() => $entity,
            ...$this->getData('edit', $entity)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(mixed $id): RedirectResponse
    {
        $entity = $this->getEntity($id);
        $request = $this->getRequest('update');

        $oldAttributes = getModelAttributesForActivity($entity, $this->fillableActivityLog ?? []);

        $entity->update($request->all());
        if ($this->activityLogEnabled()) {
            _activity(
                __FUNCTION__,
                $entity,
                "messages.resource_updated",
                auth($this->getGuard())->user(),
                array_filter([
                    "attributes" => getModelAttributesForActivity($entity, $this->fillableActivityLog ?? []),
                    "old" => $oldAttributes,
                ]),
                ['resource' => $this->label]
            );
        }

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity);
        }

        return redirect()->route("{$this->getRoutePrefix()}.index");
    }

    /**
     * Destroy resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function destroy(string $ids): void
    {
        $model = $this->getModel();
        $conditions = $this->getDestroyConditions();
        $model->withoutGlobalScope("active")
            ->when(count($conditions) > 0, function ($query) use ($conditions) {
                foreach ($conditions as $condition) {
                    $query->where(...$condition);
                }
            })
            ->whereIn($model->getKeyName(), explode(',', $ids))
            ->each(function ($entity) {
                if ($entity->delete() && $this->activityLogEnabled()) {
                    _activity(
                        "destroy",
                        $entity,
                        "messages.resource_deleted",
                        auth($this->getGuard())->user(),
                        array_filter([
                            "attributes" => $entity,
                        ]),
                        ['resource' => $this->label]
                    );
                }
            });
    }

    /**
     * Get an entity by the given id.
     *
     * @param int|string $id
     * @param bool $with
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getEntity(int|string $id, bool $with = false): Model
    {
        return app(Pipeline::class)
            ->send($this->model::query())
            ->through($this->pipelineThrough["show"] ?? [])
            ->thenReturn()
            ->with($with ? $this->getWith("show") : [])
            ->withoutGlobalScope("active")
            ->findOrFail($id);
    }

    /**
     * Get label of the resource.
     *
     * @return string
     */
    protected function getTransLabel(): string
    {
        return __($this->label);
    }

    /**
     * Get form data for the given action.
     *
     * @param  string  $action
     * @param  mixed  ...$args
     * @return array
     */
    protected function getData($action, ...$args): array
    {
        if ($action === 'index' && method_exists($this, 'indexData')) {
            return $this->indexData();
        }

        if ($action === 'show' && method_exists($this, 'showData')) {
            return $this->showData(...$args);
        }

        if (method_exists($this, 'formData')) {
            return $this->formData(...$args);
        }

        if ($action === 'create' && method_exists($this, 'createFormData')) {
            return $this->createFormData();
        }

        if ($action === 'edit' && method_exists($this, 'editFormData')) {
            return $this->editFormData(...$args);
        }

        return [];
    }

    /**
     * Get a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel(): Model
    {
        return new $this->model();
    }

    /**
     * Get guard.
     *
     * @return string
     */
    protected function getGuard(): string
    {
        return $this->guard ?? "web";
    }

    /**
     * Get request object
     *
     * @param string $action
     * @return \Illuminate\Http\Request
     */
    protected function getRequest(string $action): Request
    {
        if (!isset($this->validation)) {
            return request();
        } elseif (isset($this->validation[$action])) {
            return resolve($this->validation[$action]);
        } else {
            return resolve($this->validation);
        }
    }

    /**
     * Get name of the resource.
     *
     * @return string
     */
    protected function getEntityResourceName(): string
    {
        if (isset($this->resourceName)) {
            return $this->resourceName;
        }

        return lcfirst(class_basename($this->model));
    }

    /**
     * Get resource object
     *
     * @param string $action
     */
    protected function getResource(string $action)
    {
        if (isset($this->resource[$action])) {
            return $this->resource[$action];
        } else {
            return $this->resource;
        }
    }

    /**
     * Get with object
     *
     * @param string $action
     * @return array|string
     */
    protected function getWith(string $action): array|string
    {
        if (method_exists($this, "get{$action}With")) {
            return $this->{"get{$action}With"}();
        }

        if (!isset($this->with)) {
            return [];
        }

        if (isset($this->with[$action])) {
            return $this->with[$action];
        }

        return isset($this->with[0]) ? $this->with : [];
    }

    /**
     * Get view prefix
     *
     * @return string
     */
    protected function getViewPrefix(): string
    {
        return "Admin";
    }

    /**
     * Get route prefix of the resource.
     *
     * @return string
     */
    protected function getRoutePrefix()
    {
        if (isset($this->routePrefix)) {
            return $this->routePrefix;
        }

        return "admin.{$this->getModel()->getTable()}";
    }

    /**
     * Determine if a country enabled activity log
     *
     * @return boolean
     */
    private function activityLogEnabled(): bool
    {
        return isset($this->enableActivityLog) && $this->enableActivityLog === false ? false : true;
    }

    /**
     * Get name of the resource.
     *
     * @return string
     */
    protected function getResourceName()
    {
        if (isset($this->resourceName)) {
            return $this->resourceName;
        }

        return lcfirst(class_basename($this->model));
    }

    /**
     * Get destroy conditions
     *
     * @return array
     */
    protected function getDestroyConditions(): array
    {
        return $this->destroyConditions ?? [];
    }
}