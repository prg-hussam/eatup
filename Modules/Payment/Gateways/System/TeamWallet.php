<?php

namespace Modules\Payment\Gateways\System;

use App\Fezlee;
use Exception;
use Illuminate\Http\Request;
use Modules\Payment\Contracts\ShipmentGatewayInterface;
use Modules\Payment\GatewayResponse;
use Modules\Payment\Responses\WalletResponse;
use Modules\Support\Eloquent\Model;
use Modules\Payment\Gateway;
use Modules\Team\Enums\PermissionCases;

class TeamWallet extends Gateway implements ShipmentGatewayInterface
{
    public function __construct()
    {
        $this->label = setting('team_wallet_label', 'Team Wallet');
        $this->description = setting('team_wallet_description', 'Pay with your team wallet.');
        $this->logo = getMedia(setting('team_wallet_logo'))?->url;
        $this->isWallet =  true;
    }

    /** @inheritDoc */
    public function handle(): void
    {
        $this->balance = (Fezlee::inPortalPanel() ? auth('customer')->user()->currentTeam : request()->currentTeam)->wallet->balance;
    }

    /** @inheritDoc */
    public function purchase(Request $request, Model $entity): GatewayResponse
    {
        $currentTeam = Fezlee::inPortalPanel() ? auth('customer')->user()->currentTeam : request()->currentTeam;
        if ($currentTeam->wallet->canWithdraw($entity->total->amount())) {
            return new WalletResponse($entity);
        }

        throw new Exception(__('messages.can_not_withdraw'));
    }

    /** @inheritDoc */
    public function complete(Request $request, Model $entity): GatewayResponse
    {
        $currentTeam = Fezlee::inPortalPanel() ? auth('customer')->user()->currentTeam : request()->currentTeam;

        return new WalletResponse(
            $entity,
            $currentTeam->wallet->paid(
                $entity->total->amount(),
                null,
                [
                    "note" => [
                        "text" => 'portal.wallet_transactions.wallet_withdraw_note',
                        "params" => [
                            'reference_no' => $entity->getPaymentId()
                        ]
                    ],
                    "entity" => [
                        "id" => $entity->id,
                        "type" => get_class($entity)
                    ]
                ]
            )
        );
    }

    /** @inheritDoc */
    public function available(): bool
    {
        if (auth('merchant')->check()) {
            return true;
        }

        return auth('customer')->check() && auth('customer')->user()->hasCurrentTeamPermission(PermissionCases::PaymentsWallet->value);
    }
}
