<?php

namespace Modules\Media\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FileManagerController
{
    /**
     * Display a listing of the resource..
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Inertia::render("Admin/Media/FileManager", [
            "isPicker" => true,
            "isSinglePicker" => (bool) $request->get('isSinglePicker', false),
            "mime" => $request->mime
        ]);
    }
}
