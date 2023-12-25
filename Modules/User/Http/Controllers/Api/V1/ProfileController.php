<?php



namespace Modules\User\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use Modules\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\Api\V1\UpdateProfileRequest;
use Modules\User\Transformers\Api\V1\CustomerResource;

class ProfileController extends Controller
{

    /**
     * Get user information
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success(
            new CustomerResource($request->user("customer"))
        );
    }

    /**
     * Update profile
     */

    public function update(UpdateProfileRequest $request)
    {
        $customer = $request->user("customer");
        $customer->update([
            ...$request->except('phone'),
            'is_profile_completed' => true,
        ]);

        $customer->ingredients()->sync($request->ingredients);


        return 'updated';
    }
}