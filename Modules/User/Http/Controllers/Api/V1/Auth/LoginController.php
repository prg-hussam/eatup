<?php



namespace Modules\User\Http\Controllers\Api\V1\Auth;


use Illuminate\Http\Response;
use Modules\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\Controller;
use Modules\User\Entities\Customer;
use Modules\User\Http\Requests\Api\V1\Auth\LoginRequest;
use Modules\Verification\Entities\Verification;
use Modules\Verification\Enums\VerificationCases;
use Modules\Verification\Enums\VerificationChannelsCases;

class LoginController extends Controller
{
    /**
     * Customer Register
     *
     * @param \Modules\User\Http\Requests\Api\V1\Auth\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function __invoke(LoginRequest $request): JsonResponse
    {

        $phone = phone($request->phone, setting('default_country'));
        $customer = Customer::where('phone', $phone)->first();

        if (!is_null($customer)) {
            if (!$customer->is_active) {
                return ApiResponse::errors(["username" => __('api.messages.account_inactive')], null, Response::HTTP_FORBIDDEN);
            }

            $verification = Verification::addOrUpdate(
                username: $request->phone,
                channel: VerificationChannelsCases::Phone,
                meta: [
                    "case" => VerificationCases::Login->value,
                    "data" => [
                        "phone" => $request->phone,
                    ]
                ]
            );

            return ApiResponse::success([
                "token" => $verification->token
            ]);
        }

        return ApiResponse::errors(["username" => __('auth.failed')], null, 401);
    }
}