<?php

namespace Modules\Coupon\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;
use Modules\Coupon\Enums\DiscountTypeCases;

class SaveCouponRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'coupons';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return [
            ...$this->getTranslationRules(['name' => 'required']),
            'code' => 'required|' .  $this->uniqueRule('coupons', 'admin.coupons.update'),
            'discount_type' => ['required', Rule::in(DiscountTypeCases::values())],
            'value' => 'required|numeric|min:1|max:99999999999999',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'required|boolean',
            // Meta limitations
            'meta.limitations.per_coupon' => 'nullable|numeric|min:0|max:5000',
            'meta.limitations.per_customer' => 'nullable|numeric|min:0|max:5000',

        ];
    }
}