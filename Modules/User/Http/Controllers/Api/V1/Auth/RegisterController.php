<?php



namespace Modules\User\Http\Controllers\Api\V1\Auth;

use Modules\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\Controller;
use Modules\Verification\Entities\Verification;
use Modules\Verification\Enums\VerificationCases;
use Modules\Verification\Enums\VerificationChannelsCases;
use Modules\User\Http\Requests\Api\V1\Auth\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Customer Register
     *
     * @param \Modules\User\Http\Requests\Api\V1\Auth\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $verification = Verification::addOrUpdate(
            username: $request->phone,
            channel: VerificationChannelsCases::Phone,
            meta: [
                "case" => VerificationCases::Register->value,
                "data" => [
                    "phone" => $request->phone,
                ]
            ]
        );

        return ApiResponse::success([
            "token" => $verification->token
        ]);
    }
}