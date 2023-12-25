<?php

namespace Modules\Verification\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Controller;
use Modules\Support\ApiResponse;
use Modules\User\Entities\Customer;
use Modules\User\Events\CustomerRegistered;
use Modules\Verification\Entities\Verification;
use Modules\Verification\Http\Requests\Api\V1\VerifyRequest;
use Modules\User\Transformers\Api\V1\CustomerResource;

class VerificationController extends Controller
{
    /**
     * Verify code
     *
     * @param \Modules\Verification\Http\Requests\Api\V1\VerifyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(VerifyRequest $request): JsonResponse
    {
        $verification = Verification::findByTokenAndCode($request->token, $request->code);
        if (is_null($verification)) {
            return ApiResponse::errors(null, __('api.messages.verification_code_is_invalid'));
        }

        $response = $this->{$verification->meta["case"]}($request, $verification);

        return $response;
    }

    /**
     * Handler register
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Verification\Entities\Verification $verification
     * @return \Illuminate\Http\JsonResponse
     */
    private function resetPasswords(Request $request, Verification $verification): JsonResponse
    {
        $verification->meta = [
            ...$verification->meta,
            "verified" => true
        ];
        $verification->unsetEventDispatcher();
        $verification->saveQuietly();

        return ApiResponse::success([
            "case" => $verification->meta["case"],
            "token" => $verification->token
        ]);
    }

    /**
     * register handler 
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Verification\Entities\Verification $verification
     * @return \Illuminate\Http\JsonResponse
     */
    private function register(Request $request, Verification $verification): JsonResponse
    {

        $customer =  Customer::create([
            "is_active" => true,
            "is_profile_completed" => false,
            ...$verification->meta['data'],
        ]);

        //TODO:: check this
        // event(new CustomerRegistered($customer));

        $verification->delete();

        return ApiResponse::success([
            "token" =>  $customer->createToken("Login Token {$request->ip()}")->plainTextToken,
            'customer' => new CustomerResource($customer),
            "case" => $verification->meta["case"]
        ], __("api.messages.customer_created_successfully", [
            'app_name' => setting('app_name')
        ]));
    }
    /**
     * login register
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Verification\Entities\Verification $verification
     * @return \Illuminate\Http\JsonResponse
     */
    private function login(Request $request, Verification $verification): JsonResponse
    {
        $phone = phone($verification->username, setting('default_country'));
        $customer = Customer::where('phone', $phone)->first();


        //TODO:: check this
        // event(new CustomerRegistered($user));

        $verification->delete();

        return ApiResponse::success([
            "token" =>  $customer->createToken("Login Token {$request->ip()}")->plainTextToken,
            'customer' => new CustomerResource($customer),
            "case" => $verification->meta["case"]
        ], __("api.messages.customer_logged_in_successfully", [
            'app_name' => setting('app_name')
        ]));
    }
}