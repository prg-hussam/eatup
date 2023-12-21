<?php

namespace Modules\ActivityLog\Http\Requests;

use Modules\Core\Http\Requests\Request;

class SaveSettingActivityLogRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'activity_log';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "enabled" => "required|boolean",
            "delete_records_older_than_days" => "required|numeric|min:30|max:365"
        ];
    }
}
