<?php

namespace Modules\Payment\Contracts;

use Illuminate\Http\Request;
use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;

interface GatewayInterface
{
    /**
     * Shipment purchase
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Support\Eloquent\Model $entity
     * @return \Modules\Payment\GatewayResponse
     */
    public function purchase(Request $request, Model $entity): GatewayResponse;

    /**
     * Shipment purchase complete
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Support\Eloquent\Model $entity
     * @return \Modules\Payment\GatewayResponse
     */
    public function complete(Request $request, Model $entity): GatewayResponse;
}
