<?php

namespace Modules\Payment\Platform;

use Modules\Dashboard\Ui\Boxes\Box;
use Modules\Dashboard\Ui\Boxes\Boxes;
use Modules\Support\SvgIcons;

class PaymentBoxes extends Boxes
{
    public function make()
    {

        $this->group('payment_gateway_companies', __('modules.payments.settings.boxes.group.payment_gateway_companies'))
            ->add($this->clickpay());
        // ->add($this->hyperpay());

        $this->group('system_payment', __('modules.payments.settings.boxes.group.system'))
            ->add($this->wallet())
            ->add($this->teamWallet())
            ->add($this->postpaid());



        $this->group('clickpay_payment', __('modules.payments.settings.boxes.group.clickpay'))
            ->add($this->mada())
            ->add($this->creditCard())
            ->add($this->stcPay());

        // $this->group('hyperpay_payment', __('modules.payments.settings.boxes.group.hyperpay'))
        //     ->add($this->visa())
        //     ->add($this->mastercard());
    }

    private function clickpay(): Box
    {
        return tap(new Box('clickpay', __('modules.payments.settings.boxes.clickpay.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.clickpay.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon("bx bx-wallet", 'font');
            $box->url(route('platform.payments.settings.edit', ['name' => 'clickpay']));
        });
    }

    private function hyperpay(): Box
    {
        return tap(new Box('hyperpay', __('modules.payments.settings.boxes.hyperpay.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.hyperpay.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon("bx bx-wallet", 'font');
            $box->url(route('platform.payments.settings.edit', ['name' => 'hyperpay']));
        });
    }

    private function wallet(): Box
    {
        return tap(new Box('wallet', __('modules.payments.settings.boxes.wallet.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.wallet.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon("bx bx-wallet", 'font');
            $box->url(route('platform.payments.settings.edit', ['name' => 'wallet']));
        });
    }

    private function teamWallet(): Box
    {
        return tap(new Box('team_wallet', __('modules.payments.settings.boxes.team_wallet.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.team_wallet.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon("bx bx-wallet-alt", 'font');
            $box->url(route('platform.payments.settings.edit', ['name' => 'team_wallet']));
        });
    }

    private function visa(): Box
    {
        return tap(new Box('visa', __('modules.payments.settings.boxes.visa.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.visa.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon(SvgIcons::VISA, 'svg');
            $box->url(route('platform.payments.settings.edit', ['name' => 'visa']));
        });
    }

    private function mada(): Box
    {
        return tap(new Box('mada', __('modules.payments.settings.boxes.mada.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.mada.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon(SvgIcons::MADA, 'svg');
            $box->url(route('platform.payments.settings.edit', ['name' => 'mada']));
        });
    }

    private function creditCard(): Box
    {
        return tap(new Box('creditcard', __('modules.payments.settings.boxes.creditcard.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.creditcard.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon("bx bx-credit-card-alt", 'font');
            $box->url(route('platform.payments.settings.edit', ['name' => 'creditcard']));
        });
    }
    private function stcPay(): Box
    {
        return tap(new Box('stcpay', __('modules.payments.settings.boxes.stcpay.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.stcpay.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon(SvgIcons::VISA, 'svg');
            $box->url(route('platform.payments.settings.edit', ['name' => 'stcpay']));
        });
    }


    private function mastercard(): Box
    {
        return tap(new Box('mastercard', __('modules.payments.settings.boxes.mastercard.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.mastercard.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon(SvgIcons::MASTERCARD, 'svg');
            $box->url(route('platform.payments.settings.edit', ['name' => 'mastercard']));
        });
    }

    private function postpaid(): Box
    {
        return tap(new Box('postpaid', __('modules.payments.settings.boxes.postpaid.name')), function (Box $box) {
            $box->description(__('modules.payments.settings.boxes.postpaid.description'));
            $box->authorize($this->auth->can('platform.payments.settings'));
            $box->icon(SvgIcons::POSTPAID, 'svg');
            $box->url(route('platform.payments.settings.edit', ['name' => 'postpaid']));
        });
    }
}