<?php

namespace Modules\Dashboard\Http\Controllers\Admin;

use Inertia\Inertia;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Customer;
use Modules\Core\Enums\PaymentStatus;
use Illuminate\Contracts\Support\Renderable;
use Modules\Subscription\Entities\Subscription;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $user = auth()->user();
        return Inertia::render('Admin/Dashboard/Index', [
            "totals" => $this->getTotals($user),
        ]);
    }


    /**
     * Get totals
     *
     * @param \Modules\User\Entities\User
     * @return array
     */
    public function getTotals(User $user): array
    {
        return [
            'customers' => $user->can('admin.customers.index') ? Customer::withoutGlobalScope('active')->count() : 0,
            'activeSubscriptions' => $user->can('admin.subscriptions.index') ? Subscription::where('ends_at', '>=', now())->where('payment_status', PaymentStatus::Paid)->count() : 0,
            'expiredSubscriptions' => $user->can('admin.subscriptions.index') ? Subscription::where('ends_at', '<=', now())->where('payment_status', PaymentStatus::Paid)->count() : 0,
            'unpaidSubscriptions' => $user->can('admin.subscriptions.index') ? Subscription::where('payment_status', PaymentStatus::Unpaid)->count() : 0,

        ];
    }
}