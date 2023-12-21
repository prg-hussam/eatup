<?php

namespace Modules\ActivityLog\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Routing\Controller;
use Modules\ActivityLog\Http\Requests\SaveSettingActivityLogRequest;

class ActivityLogSettingController extends Controller
{
    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'ActivityLog';

    public function index()
    {
        return Inertia::render("Admin/{$this->component}/Setting", [
            "enabled" => (bool) setting('activitylog.enabled'),
            "deleteRecordsOlderThanDays" => (int) setting(
                'activitylog.delete_records_older_than_days',
                config('activitylog.delete_records_older_than_days')
            ),
        ]);
    }

    public function update(SaveSettingActivityLogRequest $request)
    {
        setting([
            "activitylog.enabled" => $request->enabled,
            "activitylog.delete_records_older_than_days" => $request->delete_records_older_than_days,
        ]);

        return back();
    }
}
