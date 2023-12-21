<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class LockScreenController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->setting('screen_locked', false)) {
            return redirect()->route('admin.dashboard.index');
        }

        return Inertia::render('Admin/LockScreen/Index');
    }

    public function lock(Request $request)
    {
        session()->put('lock_screen_previous_url', url()->previous());
        $request->user()->setting()->screen_locked = true;
    }

    public function unlock(Request $request)
    {
        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => __('auth.password'),
            ]);
        }

        $request->user()->setting()->screen_locked = false;
        $previousUrl = session('lock_screen_previous_url');

        if ($previousUrl) {
            session()->remove('lock_screen_previous_url');

            return redirect()->to($previousUrl);
        }

        return redirect()->route('admin.dashbaord.index');
    }
}
