<?php

namespace Modules\Payment\Gateways\System;

use App\Fezlee;
use Illuminate\Http\Request;
use Modules\Payment\Contracts\ShipmentGatewayInterface;
use Modules\Payment\Gateway;
use Modules\Payment\GatewayResponse;
use Modules\Payment\Responses\NullResponse;
use Modules\Support\Eloquent\Model;
use Modules\Team\Enums\PermissionCases;

class Postpaid extends Gateway implements ShipmentGatewayInterface
{
    public function __construct()
    {
        $this->label = setting('postpaid_label', 'postpaid');
        $this->description = setting('postpaid_description', 'Pay with postpaid.');
        $this->logo = getMedia(setting('postpaid_logo'))?->url;
    }

    /** @inheritDoc */
    public function purchase(Request $request, Model $entity): GatewayResponse
    {
        return new NullResponse($entity);
    }

    /** @inheritDoc */
    public function complete(Request $request, Model $entity): GatewayResponse
    {
        return new NullResponse($entity);
    }

    /** @inheritDoc */
    public function available(): bool
    {
        if (auth('customer')->check() || auth('merchant')->check()) {
            $user = auth()->user();
            if (Fezlee::inPortalPanel()) {
                return $user->hasCurrentTeamPermission(PermissionCases::PaymentsPostpaid->value)
                    && $user->currentTeam->owner->allowUsePostpaid();
            } else {
                return $user->allowUsePostpaid();
            }
        }

        return false;
    }
}
