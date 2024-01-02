<?php

namespace Modules\Payment\Http\Requests\Platform;

use Modules\Core\Http\Requests\Request;

class UpdatePaymentSettingRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'payments.settings';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->name) {

            case "wallet":
                return [
                    'wallet_enabled' => "required|boolean",
                    'translatable.wallet_label' => 'required_if:wallet_enabled,true',
                    'translatable.wallet_description' => 'required_if:wallet_enabled,true',
                    'wallet_logo' => 'required_if:wallet_enabled,1',
                ];
            case "team_wallet":
                return [
                    'team_wallet_enabled' => "required|boolean",
                    'translatable.team_wallet_label' => 'required_if:team_wallet_enabled,true',
                    'translatable.team_wallet_description' => 'required_if:team_wallet_enabled,true',
                    'team_wallet_logo' => 'required_if:team_wallet_enabled,1',
                ];
            case "visa":
                return [
                    'visa_enabled' => "required|boolean",
                    'translatable.visa_label' => 'required_if:visa_enabled,true',
                    'translatable.visa_description' => 'required_if:visa_enabled,true',
                    'visa_logo' => 'required_if:visa_enabled,1',
                ];
            case "mastercard":
                return [
                    'mastercard_enabled' => "required|boolean",
                    'translatable.mastercard_label' => 'required_if:mastercard_enabled,true',
                    'translatable.mastercard_description' => 'required_if:mastercard_enabled,true',
                    'mastercard_logo' => 'required_if:mastercard_enabled,1',
                ];
            case "mada":
                return [
                    'mada_enabled' => "required|boolean",
                    'translatable.mada_label' => 'required_if:mada_enabled,true',
                    'translatable.mada_description' => 'required_if:mada_enabled,true',
                    'mada_logo' => 'required_if:mada_enabled,1',
                ];
            case "creditcard":
                return [
                    'creditcard_enabled' => "required|boolean",
                    'translatable.creditcard_label' => 'required_if:creditcard_enabled,true',
                    'translatable.creditcard_description' => 'required_if:creditcard_enabled,true',
                    'creditcard_logo' => 'required_if:creditcard_enabled,1',
                ];
            case "stcpay":
                return [
                    'stcpay_enabled' => "required|boolean",
                    'translatable.stcpay_label' => 'required_if:stcpay_enabled,true',
                    'translatable.stcpay_description' => 'required_if:stcpay_enabled,true',
                    'stcpay_logo' => 'required_if:stcpay_enabled,1',
                ];
            case "postpaid":
                return [
                    'postpaid_enabled' => "required|boolean",
                    'translatable.postpaid_label' => 'required_if:postpaid_enabled,true',
                    'translatable.postpaid_description' => 'required_if:postpaid_enabled,true',
                    'postpaid_logo' => 'required_if:postpaid_enabled,1',
                ];
            case "clickpay":
                return [
                    'clickpay_enabled' => "required|boolean",
                    'encryptable.clickpay_profile_id' => 'required_if:clickpay_enabled,true',
                    'encryptable.clickpay_server_key' => 'required_if:clickpay_enabled,true',
                    'encryptable.clickpay_currency' => 'required_if:clickpay_enabled,true',
                ];
            case "hyperpay":
                return [
                    'hyperpay_enabled' => "required|boolean",
                    'encryptable.hyperpay_access_token' => 'required_if:hyperpay_enabled,true',
                    'encryptable.hyperpay_entity_id_visa_master' => 'required_if:hyperpay_enabled,true',
                    'encryptable.hyperpay_entity_id_mada' => 'required_if:hyperpay_enabled,true',
                ];
            default:
                return [];
        }
    }
}