<?php

namespace Modules\Payment\Services;

use Exception;
use Http;
use Modules\Payment\BlackBins;
use Modules\Support\Money;

class HyperPay
{
    /**
     * Hyperpay config
     *
     * @var array
     */
    protected array $config;

    /**
     * Payment gateways environment
     *
     * @var string
     */
    protected string $env;

    /**
     * Payment type
     *
     * @var string
     */
    protected string $paymentType = "DB";

    /**
     * Currency
     *
     * @var string
     */
    protected string $currency = "SAR";

    public function __construct()
    {
        $this->env =  config('fezlee.modules.payment.config.env');
        $this->config = config("fezlee.modules.payment.config.hyperpay.{$this->env}");
    }

    /**
     * Checkouts
     *
     * @param string $merchantTransactionId
     * @param string $paymentMethod
     * @param \Modules\Support\Money $total
     * @param string $customerEmail
     * @param string $customerGivenName
     * @param string $customerSurname
     * @param string $billingStreet
     * @param string $billingCity
     * @param string $billingState
     * @param string $billingPostCode
     * @param string $billingCountry
     * @return string
     */
    public function checkouts(
        string $merchantTransactionId,
        string $paymentMethod,
        Money $total,
        string $customerEmail,
        string $customerGivenName,
        string $customerSurname,
        string $customerPhone,
        string $billingStreet,
        string $billingCity,
        string $billingState,
        string $billingPostCode,
        string $billingCountry,


    ): array {
        $response = Http::withHeaders(
            ['Authorization' => "Bearer {$this->config['access_token']}"]
        )
            ->asForm()
            ->post("{$this->config['url']}/v1/checkouts", [
                'paymentType' => $this->paymentType,
                'merchantTransactionId' => $merchantTransactionId,
                'entityId' => $this->getEntityId($paymentMethod),
                'amount' =>  number_format($total->amount(), 2, '.', ''),
                'currency' => $this->currency,
                'customer.email' => $customerEmail,
                'customer.givenName' => $customerGivenName,
                'customer.surname' => $customerSurname,
                'customer.phone' => $customerPhone,
                'billing.street1' => $billingStreet,
                'billing.city' => $billingCity,
                'billing.state' => $billingState,
                'billing.postcode' => $billingPostCode,
                'billing.country' => $billingCountry,
            ]);

        if ($response->successful() && $response->json("result.code") === "000.200.100") {
            return [
                "ndc" => $response->json('ndc'),
                "url" => $this->config['url']
            ];
        }

        throw new Exception(__("messages.payment_fail"));
    }

    /**
     * Resource Path
     *
     * @param string $paymentMethod
     * @param string $resourcePath
     * @return array
     */
    public function resourcePath(string $paymentMethod, string $resourcePath): array
    {
        $response = Http::withHeaders(['Authorization' => "Bearer {$this->config['access_token']}"])
            ->asForm()
            ->get("{$this->config['url']}{$resourcePath}", [
                'entityId' => $this->getEntityId($paymentMethod),
            ]);

        $successCodePattern = '/^(000\.000\.|000\.100\.1|000\.[36])/';
        $successManualReviewCodePattern = '/^(000\.400\.0|000\.400\.100)/';

        if (
            $response->successful() &&
            preg_match($successCodePattern, $response->json("result.code")) ||
            preg_match($successManualReviewCodePattern, $response->json("result.code"))
        ) {
            return [
                "id" => $response->json('id'),
                "card" => [
                    "holder" => $response->json('card.holder'),
                    "last_4_digits" => $response->json('card.last4Digits')
                ]
            ];
        } elseif (!is_null($response->json('card.bin')) && in_array($response->json('card.bin'), BlackBins::all())) {
            throw new Exception(__("messages.mada_payment_fail"));
        } else {
            throw new Exception(__("messages.payment_fail"));
        }
    }

    /**
     * Get entity id
     *
     * @param string $paymentMethod
     * @return string
     */
    private function getEntityId(string $paymentMethod): string
    {
        if (in_array($paymentMethod, ["visa", "mastercard"])) {
            return $this->config["entity_id_visa_master"];
        } elseif ($paymentMethod == "mada") {
            return $this->config["entity_id_mada"];
        }
    }
}
