<?php

namespace Modules\Slider\Http\Requests\Admin;

use Modules\Core\Http\Requests\Request;

class SaveSliderRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'sliders';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $bannerRules = [];
        foreach (supported_locale_keys() as $locale) {
            $bannerRules["slides.*.files.banner_{$locale}"] = "required";
        }

        return [
            "slides" => "required|array",
            ...$this->getTranslationRules([
                'name' => 'required',
            ]),
            ...$bannerRules,

        ];
    }
}