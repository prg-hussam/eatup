<?php

namespace Modules\Payment\Providers;

use App\Fezlee;
use Illuminate\Support\ServiceProvider;
use Modules\Dashboard\Ui\Facades\BoxManager;
use Modules\Payment\Facades\Gateway;
use Modules\Payment\Gateways\ClickPay\CreditCard;
use Modules\Payment\Gateways\ClickPay\Mada;
use Modules\Payment\Gateways\HyperPay\Mastercard;
use Modules\Payment\Gateways\System\Postpaid;
use Modules\Payment\Gateways\ClickPay\StcPay;
use Modules\Payment\Gateways\System\TeamWallet;
use Modules\Payment\Gateways\HyperPay\Visa;
use Modules\Payment\Gateways\System\Wallet;
use Modules\Payment\Platform\PaymentBoxes;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        return;
        if (!Fezlee::installed()) {
            return;
        }

        if (Fezlee::inPlatformPanel()) {
            BoxManager::register('payment_settings', PaymentBoxes::class);
        }

        $this->setUpClickPayGateways();
        // $this->setUpHyperPayGateways();
        $this->registerSystemPaymentGateways();
    }

    private function enabled($paymentMethod)
    {
        if (Fezlee::inPlatformPanel()) {
            return true;
        }

        return setting("{$paymentMethod}_enabled");
    }

    /**
     * Setup clickpay config
     *
     * @return void
     */
    private function setUpClickPayGateways(): void
    {
        if ($this->enabled('clickpay')) {
            $this->app['config']->set('clickpay.profile_id', setting('clickpay_profile_id'));
            $this->app['config']->set('clickpay.server_key', setting('clickpay_server_key'));
            $this->app['config']->set('clickpay.currency', setting('clickpay_currency'));
            $this->registerClickPayPaymentGateways();
        }
    }

    /**
     * Setup hyperpay config
     *
     * @return void
     */
    private function setUpHyperPayGateways(): void
    {
        if ($this->enabled('hyperpay')) {
            $env = config('fezlee.modules.payment.config.env');
            $this->app['config']->set("fezlee.modules.payment.config.hyperpay.{$env}.access_token", setting('hyperpay_access_token'));
            $this->app['config']->set("fezlee.modules.payment.config.hyperpay.{$env}.entity_id_visa_master", setting('hyperpay_entity_id_visa_master'));
            $this->app['config']->set("fezlee.modules.payment.config.hyperpay.{$env}.entity_id_mada", setting('hyperpay_entity_id_mada'));
            $this->registerHyperpayPaymentGateways();
        }
    }

    /**
     * Register clickPay payment gateways
     *
     * @return void
     */
    private function registerClickPayPaymentGateways(): void
    {
        $this->registerMada();
        $this->registerStcPay();
        $this->registerCreditCard();
    }

    /**
     * Register system payment gateways
     *
     * @return void
     */
    private function registerSystemPaymentGateways(): void
    {
        $this->registerWallet();
        $this->registerTeamWallet();
        $this->registerPostpaid();
    }

    /**
     * Register hyperpay payment gateways
     *
     * @return void
     */
    private function registerHyperpayPaymentGateways(): void
    {
        $this->registerVisa();
        $this->registerMastercard();
    }

    /**
     * Register wallet gateway
     *
     * @return void
     */
    private function registerWallet(): void
    {
        if ($this->enabled('wallet')) {
            Gateway::register('wallet', new Wallet);
        }
    }

    /**
     * Register Team Wallet gateway
     *
     * @return void
     */
    private function registerTeamWallet(): void
    {
        if ($this->enabled('team_wallet')) {
            Gateway::register('team_wallet', new TeamWallet);
        }
    }

    /**
     * Register visa gateway
     *
     * @return void
     */
    private function registerVisa(): void
    {
        if ($this->enabled('visa')) {
            Gateway::register('visa', new Visa);
        }
    }

    /**
     * Register mastercard gateway
     *
     * @return void
     */
    private function registerMastercard(): void
    {
        if ($this->enabled('mastercard')) {
            Gateway::register('mastercard', new Mastercard);
        }
    }

    /**
     * Register mada gateway
     *
     * @return void
     */
    private function registerMada(): void
    {
        if ($this->enabled('mada')) {
            Gateway::register('mada', new Mada);
        }
    }

    /**
     * Register postpaid gateway
     *
     * @return void
     */
    private function registerPostpaid(): void
    {
        if ($this->enabled('postpaid')) {
            Gateway::register('postpaid', new Postpaid);
        }
    }

    /**
     * Register creditcard gateway
     *
     * @return void
     */
    private function registerCreditCard(): void
    {
        if ($this->enabled('creditcard')) {
            Gateway::register('creditcard', new CreditCard);
        }
    }

    /**
     * Register stcpay gateway
     *
     * @return void
     */
    private function registerStcPay(): void
    {
        if ($this->enabled('stcpay')) {
            Gateway::register('stcpay', new StcPay);
        }
    }
}