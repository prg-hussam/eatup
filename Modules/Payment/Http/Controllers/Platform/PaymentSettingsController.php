<?php

namespace Modules\Payment\Http\Controllers\Platform;

use Arr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Dashboard\Ui\Facades\BoxManager;
use Modules\Media\Transformers\FileResource;
use Modules\Payment\Http\Requests\Platform\UpdatePaymentSettingRequest;

class PaymentSettingsController extends Controller
{
    /** Boxes fields */
    private $fields = [
        'wallet' => [
            'translatable.wallet_label',
            'translatable.wallet_description',
            'wallet_enabled',
            'wallet_logo',
        ],
        'team_wallet' => [
            'translatable.team_wallet_label',
            'translatable.team_wallet_description',
            'team_wallet_enabled',
            'team_wallet_logo',
        ],
        'visa' => [
            'translatable.visa_label',
            'translatable.visa_description',
            'visa_enabled',
            'visa_logo',
        ],
        'mastercard' => [
            'translatable.mastercard_label',
            'translatable.mastercard_description',
            'mastercard_enabled',
            'mastercard_logo',
        ],
        'mada' => [
            'translatable.mada_label',
            'translatable.mada_description',
            'mada_enabled',
            'mada_logo'
        ],
        'creditcard' => [
            'translatable.creditcard_label',
            'translatable.creditcard_description',
            'creditcard_enabled',
            'creditcard_logo'
        ],
        'stcpay' => [
            'translatable.stcpay_label',
            'translatable.stcpay_description',
            'stcpay_enabled',
            'stcpay_logo'
        ],
        "postpaid" => [
            "translatable.postpaid_label",
            "translatable.postpaid_description",
            "postpaid_enabled",
            "postpaid_logo"
        ],
        'clickpay' => [
            'clickpay_enabled',
            'encryptable.clickpay_profile_id',
            'encryptable.clickpay_server_key',
            'encryptable.clickpay_currency',
        ],
        "hyperpay" => [
            "hyperpay_enabled",
            "encryptable.hyperpay_access_token",
            "encryptable.hyperpay_entity_id_visa_master",
            "encryptable.hyperpay_entity_id_mada"
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Inertia
     */
    public function index(): Response
    {
        return Inertia::render('Platform/Payment/Setting/Index', ['boxes' => BoxManager::get('payment_settings')->render()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = [
            'title' => __("modules.payments.settings.boxes.{$request->name}.name"),
            'name' => $request->name,
            'settings' => setting()->all(),
        ];

        switch ($request->name) {
            case 'wallet':
                $data['walletLogo'] = $this->getMedia(Arr::get($data['settings'], 'wallet_logo'));
                break;
            case 'team_wallet':
                $data['teamWalletLogo'] = $this->getMedia(Arr::get($data['settings'], 'team_wallet_logo'));
                break;
            case 'visa':
                $data['visaLogo'] = $this->getMedia(Arr::get($data['settings'], 'visa_logo'));
                break;
            case 'creditcard':
                $data['creditCardLogo'] = $this->getMedia(Arr::get($data['settings'], 'creditcard_logo'));
                break;
            case 'stcpay':
                $data['stcPayLogo'] = $this->getMedia(Arr::get($data['settings'], 'stcpay_logo'));
                break;
            case 'mada':
                $data['madaLogo'] = $this->getMedia(Arr::get($data['settings'], 'mada_logo'));
                break;
            case 'postpaid':
                $data['postpaidLogo'] = $this->getMedia(Arr::get($data['settings'], 'postpaid_logo'));
                break;
            case 'mastercard':
                $data['mastercardLogo'] = $this->getMedia(Arr::get($data['settings'], 'mastercard_logo'));
                break;
        }

        return Inertia::render('Platform/Payment/Setting/Boxes/' . implode('', array_map('ucfirst', explode('_', $request->name))), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Payment\Http\Requests\Platform\UpdatePaymentSettingRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePaymentSettingRequest $request): RedirectResponse
    {
        setting($request->only($this->fields[$request->name] ?? []));

        return redirect()->route('platform.payments.settings.index');
    }

    private function getMedia($fileId)
    {
        $file = getMedia($fileId);
        return $file->exists ? new FileResource($file) : ["data" => null];
    }
}