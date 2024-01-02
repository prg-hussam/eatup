<?php

namespace Modules\Payment\Gateways\System;

use Exception;
use Illuminate\Http\Request;
use Modules\Payment\Contracts\InvoiceGatewayInterface;
use Modules\Payment\Contracts\ShipmentGatewayInterface;
use Modules\Payment\Contracts\SubscriptionGatewayInterface;
use Modules\Payment\GatewayResponse;
use Modules\Payment\Responses\WalletResponse;
use Modules\Support\Eloquent\Model;
use Modules\Payment\Gateway;

class Wallet extends Gateway implements ShipmentGatewayInterface, SubscriptionGatewayInterface, InvoiceGatewayInterface
{
    public function __construct()
    {
        $this->label = setting('wallet_label', 'Wallet');
        $this->description = setting('wallet_description', 'Pay with your wallet.');
        $this->logo = getMedia(setting('wallet_logo'))?->url;
        $this->isWallet =  true;
    }

    /** @inheritDoc */
    public function handle(): void
    {
        $this->balance = auth()->user()->wallet->balance;
    }

    /** @inheritDoc */
    public function purchase(Request $request, Model $entity): GatewayResponse
    {
        if ($request->user()->wallet->canWithdraw($entity->total->amount())) {
            return new WalletResponse($entity);
        }

        throw new Exception(__('messages.can_not_withdraw'));
    }

    /** @inheritDoc */
    public function complete(Request $request, Model $entity): GatewayResponse
    {
        return new WalletResponse(
            $entity,
            $request->user()->wallet->paid(
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
}
