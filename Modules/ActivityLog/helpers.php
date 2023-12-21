<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('_activity')) {
    /**
     * Custom activity log
     *
     * @param string $action
     * @param \Modules\Support\Eloquent\Model $performedOn
     * @param string $description
     * @param \Modules\Support\Eloquent\Model|int|string|null $causedBy
     * @param array $properties
     * @param array $transParams
     * @return void
     */
    function _activity(
        string $event,
        Model  $performedOn,
        string $description,
        Model | int | string | null $causedBy,
        array $properties = [],
        array $transParams = []
    ) {
        $group = is_object($performedOn) ? $performedOn->getTable() : (new $performedOn)->getTable();
        $request = request();

        activity("{$group}.{$event}")
            ->event($event)
            ->performedOn($performedOn)
            ->causedBy($causedBy)
            ->withProperties([
                "info" => [
                    "ip" => $request->ip(),
                    'http_method' => $request->method(),
                    "user_agent" => $request->header('User-Agent'),
                ],
                "trans_params" => $transParams,
                ...$properties
            ])
            ->log($description);
    }
}


if (!function_exists('getModelAttributesForActivity')) {
    /**
     * Get model attributes for activity log
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array|null $fillable
     * @return array
     */
    function getModelAttributesForActivity(Model $model, ?array $fillable = null): array
    {
        $onlyAttributes = !is_null($fillable) && isset($fillable['attributes']) ? $fillable['attributes'] : null;
        $onlyRelations = !is_null($fillable) && isset($fillable['relations']) ? $fillable['relations'] : [];

        if (empty($onlyRelations) && empty($onlyAttributes)) {
            $onlyAttributes = $fillable;
        }

        $attributes = [...$model->only($onlyAttributes)];

        foreach ($onlyRelations as $relation) {
            $relation = explode(":", $relation, 2);
            $name  = $relation[0];
            $keys =  isset($relation[1]) ? explode(",", $relation[1]) : [];
            $relation = $model->{$name};
            $data = [];
            if ($relation instanceof Collection) {
                foreach ($relation as $value) {
                    $data[] = getRelationValues($value, $keys);
                }
            } else {
                $data = !is_null($relation) ? getRelationValues($relation, $keys) : null;
            }
            $attributes = [...$attributes, $name => $data];
        }

        return $attributes;
    }
}

if (!function_exists('getRelationValues')) {
    /**
     * Get relationships values
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    function getRelationValues(Model $model, $keys): array
    {
        if (count($keys) > 0) {
            $data = [];
            foreach ($keys as $key) {
                $data[$key] = $model->getRawOriginal($key);
            }
            return $data;
        }
        return $model->getAttributes();
    }
}
