<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Entities\File;

class MediaController
{
    public function download($id)
    {
        return (File::where('id', $id)
            ->where('is_folder', false)
            ->firstOrFail())->download();
    }
}
