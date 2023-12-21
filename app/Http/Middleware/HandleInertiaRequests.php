<?php

namespace App\Http\Middleware;

use App\Platform;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Modules\Dashboard\Ui\Sidebar\AdminSidebarRenderer;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $data = array_merge(parent::share($request), [
            'app_name' => config('app.name'),
            'copyright_text' => getCopyrightText(),
            'settings' => Platform::installed()
                ? [
                    'default_locale' => setting('default_locale'),
                    'app_name' => setting('app_name'),
                ]
                : [],
            'locale' => locale(),
            'current_locale_name' => LaravelLocalization::getCurrentLocaleName(),
            'supported_locales' => collect(supported_locales())
                ->map(function ($language, $locale) {
                    $language['localized_url'] = localized_url($locale);
                    $language['is_rtl'] = isRtl($locale);

                    return $language;
                })
                ->toArray(),
            'auth' => [
                'check' => auth()->check(),
                'user' => fn () => $request->user()
                    ? $request->user()->toAuthResource()
                    : null,
            ],
        ]);
        if (Platform::inAdminPanel()) {
            $data['dashboard_auth_cover'] = getMedia(setting('dashboard_auth_cover'))->url;
            $data['dashboard_auth_logo'] = getMedia(setting('dashboard_auth_logo'))->url;
        }

        if (Platform::inAdminPanel() && auth()->check()) {
            $data['dashboard_sidebar_logo'] = getMedia(setting('dashboard_sidebar_logo'))->url;
            $data['admin_sidebar'] = app(AdminSidebarRenderer::class)->render();
            $data['dashboard_sidebar_icon'] = getMedia(setting('dashboard_sidebar_icon'))->url;

            if ($request->routeIs('admin.media.*', 'admin.file_manager.*')) {
                $data["maxFileSize"] = (int) ini_get('upload_max_filesize');
                $data["csrfToken"] = csrf_token();
                $data["acceptedFiles"] = null;
                if ($request->mime) {
                    $data["acceptedFiles"] = implode(",", array_map(function ($mime) {
                        return "{$mime}/*";
                    }, explode(",", $request->mime)));
                }
            }
        }

        return $data;
    }
}
