<?php

namespace Modules\ActivityLog\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Support\Enums\DateTimeFormatCases;
use Str;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $logName = explode('.', $this->log_name, 2);
        $action = $logName[1];
        $module = $logName[0];

        return [
            'id' => $this->id,
            'action' => $action,
            'log_type' => __("admin.activity_log.actions.{$action}", ["resource" => __("admin.{$module}." . Str::singular($module))]),
            'causer' => $this->causer->name,
            'causer_id' => $this->causer_id,
            'causer_type' => $this->causer_type,
            'description' => __($this->description, array_map(function ($param) {
                return __($param);
            }, $this->properties["trans_params"] ?? [])),
            "ip" => $this->properties["info"]['ip'] ?? '-',
            "user_agent" => $this->properties["info"]['user_agent'] ?? '-',
            "subject_id" => $this->subject_id ?? "-",
            "subject_type" => $this->subject_type ?? '-',
            "batch_uuid" => $this->batch_uuid ?? "-",
            'agent' => $this->agent,
            "http_method" => $this->properties["info"]['http_method'] ?? "-",
            'created_at' => dateTimeFormat($this->created_at, DateTimeFormatCases::DateTime),
        ];
    }
}
