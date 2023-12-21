<?php

namespace Modules\Setting\Http\Controllers\Admin;

use Arr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;
use Modules\Dashboard\Ui\Facades\BoxManager;
use Modules\Setting\Http\Requests\UpdateSettingRequest;
use Modules\Support\DateFormats;
use Modules\Support\Enums\MailEncryptionProtocols;
use Modules\Support\Locale;
use Modules\Support\TimeZone;
use Modules\Media\Transformers\FileResource;

class SettingController extends Controller
{
    /** Boxes fields */
    private $fields = [
        'general' => [
            'supported_locales',
            'default_locale',
            'default_timezone',
            'default_currency',
            'default_dateformat',
            'enable_activity_log',
            'week_starts_at',
            'week_ends_at',
        ],
        'logo' => [
            'dashboard_sidebar_logo',
            'dashboard_sidebar_icon',
            'dashboard_fav_icon',
            'dashboard_auth_cover',
            'dashboard_auth_logo',
            'mail_logo'
        ],
        'mail' => [
            'mail_from_address',
            'mail_from_name',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
        ],
        'application' => [
            'translatable.app_name',
            'translatable.app_address',
            'translatable.copyright_text',
            'app_phone_number',
            'app_email'
        ],
        'maintenance' => [
            'maintenance_mode',
        ],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return Inertia::render('Admin/Setting/Index', ['boxes' => BoxManager::get('settings')->render()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = [
            'title' => "admin.settings.boxes.{$request->name}.name",
            'name' => $request->name,
            'settings' => setting()->all(),
        ];
        switch ($request->name) {
            case 'general':
                $data['locales'] = Locale::all();
                $data['timeZones'] = TimeZone::all();
                $data['dateFormats'] = DateFormats::all();
                $data['weekDays'] = __('days');
                break;
            case 'logo':
                $data['dashboardSidebarLogo'] = $this->getMedia(Arr::get($data['settings'], 'dashboard_sidebar_logo'));
                $data['dashboardSidebarIcon'] = $this->getMedia(Arr::get($data['settings'], 'dashboard_sidebar_icon'));
                $data['dashboardFavIcon'] = $this->getMedia(Arr::get($data['settings'], 'dashboard_fav_icon'));
                $data['dashboardAuthCover'] = $this->getMedia(Arr::get($data['settings'], 'dashboard_auth_cover'));
                $data['dashboardAuthLogo'] = $this->getMedia(Arr::get($data['settings'], 'dashboard_auth_logo'));
                $data['mailLogo'] = $this->getMedia(Arr::get($data['settings'], 'mail_logo'));
            case 'mail':
                $data['encryptionProtocols'] = MailEncryptionProtocols::toArray();
                break;
            case 'application':

                break;
        }

        return Inertia::render('Admin/Setting/Boxes/' . implode('', array_map('ucfirst', explode('_', $request->name))), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request)
    {
        if ($request->name == 'maintenance') {
            $this->handleMaintenanceMode($request);
        }

        setting($request->only($this->fields[$request->name] ?? []));

        return redirect()->route('admin.settings.index');
    }

    private function handleMaintenanceMode($request)
    {
        if ($request->maintenance_mode) {
            Artisan::call('down');
        } elseif (app()->isDownForMaintenance()) {
            Artisan::call('up');
        }
    }

    private function getMedia($fileId)
    {
        $file = getMedia($fileId);
        return $file->exists ? new FileResource($file) : ["data" => null];
    }
}
