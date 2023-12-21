<?php

namespace Modules\Core\Http\Requests;

use Arr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class Request extends FormRequest
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = '';

    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributesPrefix = 'admin';

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        $attributes = trans("{$this->availableAttributesPrefix}.{$this->availableAttributes}.attributes") ?: [];

        if (!is_array($attributes)) {
            return [];
        }

        return array_map('mb_strtolower', Arr::dot($attributes));
    }

    protected function uniqueRule(string $table, string $route)
    {
        $rule = Rule::unique($table);

        if ($this->route()->getName() === $route) {
            $id = $this->route()->parameter('id');

            return $rule->ignore($id);
        }

        return $rule;
    }

    protected function requiredInSpecificRoute($route)
    {
        $rule = $this->route()->getName() === $route
            ? 'required'
            : 'nullable';

        return $rule;
    }

    /**
     * Get translation rules
     *
     * @param  array  $columns
     * @return array
     */
    protected function getTranslationRules(array $columns): array
    {
        $rules = [];

        foreach ($columns as $column => $rule) {
            foreach (supported_locale_keys() as $locale) {
                $rules["{$column}.{$locale}"] = $rule;
            }
        }

        return $rules;
    }
}
