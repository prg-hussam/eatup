<?php

namespace Modules\Dashboard\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\User\Entities\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return Inertia::render('Admin/Dashboard/Index', [
            'totalUsers' => $this->hasAccess('admin.users.index') ? User::withoutGlobalScope('active')->count() : 0,
        ]);
    }

    /**
     * Determin if user has access or not
     *
     * @param string $permission
     * @return bool
     */
    private function hasAccess(string $permission): bool
    {
        return auth()->user()->can($permission) ? true : false;
    }
}
