<?php

namespace Modules\Subscription\Http\Controllers\Api\V1;



use Illuminate\Routing\Controller;
use Modules\Subscription\Entities\Plan;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Http\Requests\Api\V1\SubscribeRequest;

class SubscribeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(SubscribeRequest $request, SubscriptionService $subscriptionService)
    {
        $user = $request->user('customer');
        $plan = Plan::findOrFail($request->plan_id);

        $subscription = $subscriptionService->create($request, $plan);
    }
}