<?php

namespace Modules\Dashboard\Ui\Tabs;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\ViewErrorBag;

class Tab implements Arrayable
{
    /**
     * Component of the tab.
     *
     * @var string
     */
    private string $component;

    /**
     * Name of the tab.
     *
     * @var string
     */
    private string $name;

    /**
     * Label of the tab.
     *
     * @var string
     */
    private $label;

    /**
     * Active state of the tab.
     *
     * @var bool
     */
    private bool $active = false;

    /**
     * Weight of the tab.
     *
     * @var int
     */
    private int $weight = 0;

    /**
     * Available fields on the tab.
     *
     * @var array
     */
    private array $fields = [];

    /**
     * Available translation fields on the tab.
     *
     * @var array
     */
    private array $translationFields = [];

    /**
     * Available data on the tab.
     *
     * @var array
     */
    private array $data = [];

    /**
     * Create a new Tab instance.
     *
     * @param  string  $component
     * @param  string  $name
     * @param  string  $label
     * @return void
     */
    public function __construct(string $name, string $component, string $label)
    {
        $this->component = $component;
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * Get component of the tab.
     *
     * @return string
     */
    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * Get name of the tab.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get label of the tab.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Determine if tabs has Translations.
     *
     * @return bool
     */
    public function hasTranslations(): bool
    {
        return count($this->translationFields) > 0;
    }

    /**
     * Set tab as active.
     *
     * @return self
     */
    public function active(): self
    {
        $this->active = true;

        return $this;
    }

    /**
     * Check is active of the tab.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Set weight of tab.
     *
     * @param  int  $weight
     * @return self
     */
    public function weight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight of the tab.
     *
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * Set fields of the tab.
     *
     * @param  array|string  $fields
     * @return self
     */
    public function fields(array|string $fields): self
    {
        $this->fields = is_array($fields) ? $fields : func_get_args();

        return $this;
    }

    /**
     * Get fields of the tab.
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Set translation fields of the tab.
     *
     * @param  array|string  $fields
     * @return self
     */
    public function translationFields(array|string $fields): self
    {
        foreach (supported_locale_keys() as $locale) {
            $this->translationFields[$locale] = [];
            foreach ((is_array($fields) ? $fields : func_get_args()) as $field) {
                $this->translationFields[$locale][] = "{$field}.{$locale}";
            }
        }

        return $this;
    }

    /**
     * Get all fields of the tab.
     *
     * @return array
     */
    public function getAllFields(): array
    {
        return array_merge($this->fields, $this->translationFields);
    }

    /**
     * Get translation fields of the tab.
     *
     * @return array
     */
    public function getTranslationFields(): array
    {
        return $this->translationFields;
    }

    /**
     * Set data of the tab.
     *
     * @param  array  $data
     * @return self
     */
    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data of the tab.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Determine if tabs fields has any error.
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->getErrors()->hasAny($this->getAllFields());
    }

    /**
     * Determine if tabs translation fields has any error.
     *
     * @return bool
     */
    public function getLocalesHasError(): array
    {
        $errors = [];

        foreach (supported_locale_keys() as $locale) {
            if ($this->getErrors()->hasAny($this->translationFields[$locale] ?? [])) {
                $errors[] = $locale;
            }
        }

        return $errors;
    }

    /**
     * Get error message bag.
     *
     * @return \Illuminate\Support\ViewErrorBag
     */
    protected function getErrors(): ViewErrorBag
    {
        return request()->session()->get('errors') ?: new ViewErrorBag;
    }

    /** {@inheritDoc} */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'label' => $this->label,
            'component' => $this->getComponent(),
            'data' => $this->getData(),
            'isActive' => $this->isActive(),
            'hasError' => $this->hasError(),
            'hasTranslations' => $this->hasTranslations(),
            'localesHasErrors' => $this->getLocalesHasError(),
        ];
    }
}
