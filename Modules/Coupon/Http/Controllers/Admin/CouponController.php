<?php

namespace Modules\Coupon\Http\Controllers\Admin;

use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Http\Requests\Admin\SaveCouponRequest;
use Modules\Coupon\Transformers\Admin\CouponResource;
use Modules\Support\Traits\HasCrudActions;

class CouponController
{
    use HasCrudActions;



    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.coupons.coupon';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Coupon';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveCouponRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = CouponResource::class;

    /**
     * Pipeline through
     *
     * @var array
     */
    protected array $pipelineThrough = [
        "index" => [
            \Modules\Support\Filters\NameTranslationLikeSearchFilter::class,
        ]
    ];

    /**
     * Get edit form data
     *
     * @return array
     */
    // public function editFormData($coupon): array
    // {
    //     $data = [
    //         "coupon" => [
    //             'id' => $coupon->id,
    //             'name' => $coupon->name,
    //             'code' => $coupon->code,
    //             'is_percent' => $coupon->is_percent,
    //             'value' => $coupon->is_percent ? $coupon->value : $coupon->value->amount(),
    //             'start_date' => $coupon->start_date,
    //             'end_date' => $coupon->end_date,
    //             'is_active' => $coupon->is_active,
    //             'usage_limit_per_coupon' => $coupon->usage_limit_per_coupon,
    //             'usage_limit_per_customer' => $coupon->usage_limit_per_customer,
    //         ]
    //     ];

    //     return $data;
    // }
}