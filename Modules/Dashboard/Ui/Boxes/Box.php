<?php

namespace Modules\Dashboard\Ui\Boxes;

use Arr;
use Illuminate\Contracts\Support\Arrayable;

class Box implements Arrayable
{
    /**
     * Name of the box.
     *
     * @var string
     */
    private $name;

    /**
     * Label of the box.
     *
     * @var string
     */
    private $label;

    /**
     * Icon of the box.
     *
     * @var string
     */
    private $icon;

    /**
     * Icon type (url,svg,font) of the box.
     *
     * @var string
     */
    private $iconType = 'svg';

    /**
     * Description of the box.
     *
     * @var string|null
     */
    private $description = null;

    /**
     * url of the box.
     *
     * @var string
     */
    private $url;

    /**
     * ajax of the box.
     *
     * @var bool
     */
    private $ajax = true;

    /**
     * Open new tab of the box.
     *
     * @var bool
     */
    private $openNewTab = false;

    /**
     * authorize of the box.
     *
     * @var bool
     */
    private $authorize = true;

    /**
     * Create a new Box instance.
     *
     * @param  string  $name
     * @param  string  $label
     * @return void
     */
    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * Get name of the box.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get label of the box.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set description of box.
     *
     * @param  string  $description
     * @return self
     */
    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description of the box.
     *
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->description;
    }

    /**
     * Set icon of box.
     *
     * @param  string  $icon
     * @param  string  $iconType
     * @return self
     */
    public function icon(string $icon, ?string $iconType = null): self
    {
        $this->icon = $icon;
        if (! is_null($iconType) && in_array($iconType, ['svg', 'url', 'font', 'asset'])) {
            $this->iconType = $iconType;
        }

        return $this;
    }

    /**
     * Get icon & type of the box.
     *
     * @return array|string|null
     */
    public function getIcon($key = null): array|string|null
    {
        $data = [
            'type' => $this->iconType,
            'icon' => $this->iconType == 'asset' ? asset($this->icon) : ($this->iconType == 'url' ? url($this->icon) : $this->icon),
        ];

        if (is_null($key)) {
            return $data;
        }

        return Arr::get($data, $key);
    }

    /**
     * Set url of box.
     *
     * @param  string  $url
     * @return self
     */
    public function url(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url of the box.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set ajax of box.
     *
     * @param  bool  $ajax
     * @return self
     */
    public function ajax(bool $ajax): self
    {
        $this->ajax = $ajax;

        return $this;
    }

    /**
     * Check is ajax of the box.
     *
     * @return bool
     */
    public function isAjax(): bool
    {
        return $this->ajax;
    }

    /**
     * Set Open new tab of box.
     *
     * @param  bool  $openNewTab
     * @return self
     */
    public function openNewTab(bool $openNewTab): self
    {
        $this->openNewTab = $openNewTab;

        return $this;
    }

    /**
     * Check Open new tab of the box.
     *
     * @return bool
     */
    public function isOpenNewTab(): bool
    {
        return $this->openNewTab;
    }

    /**
     * authorize tab of box.
     *
     * @param  bool  $authorize
     * @return self
     */
    public function authorize(bool $authorize): self
    {
        $this->authorize = $authorize;

        return $this;
    }

    /**
     * Check authorize of the box.
     *
     * @return bool
     */
    public function isAuthorize(): bool
    {
        return $this->authorize;
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
            'icon' => $this->getIcon(),
            'url' => $this->getUrl(),
            'is_ajax' => $this->isAjax(),
            'is_open_new_tab' => $this->isOpenNewTab(),
            'is_authorize' => $this->isAuthorize(),
        ];
    }
}
