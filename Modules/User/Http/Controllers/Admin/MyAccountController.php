<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class MyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        return Inertia::render('Admin/MyAccount/Index');
    }

    public function storeUiOptions(Request $request)
    {
        $allowedKeys = ['sidebar_size' => ['lg', 'sm'], 'layout_mode' => ['dark', 'light']];

        if (
            in_array($request->key, array_keys($allowedKeys))
            && in_array($request->value, $allowedKeys[$request->key])
        ) {
            $request->user()->setting([$request->key => $request->value]);
        }
    }
}
