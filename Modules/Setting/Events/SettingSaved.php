<?php

namespace Modules\Setting\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Setting\Entities\Setting;

class SettingSaved
{
    use SerializesModels;

    /**
     * The setting model.
     *
     * @var \Modules\Setting\Entities\Setting
     */
    public $setting;

    /**
     * Create a new event instance.
     *
     * @param  \Modules\Setting\Entities\Setting  $order
     * @return void
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
}
