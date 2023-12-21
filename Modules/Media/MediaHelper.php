<?php

namespace Modules\Media;

class MediaHelper
{
    /**
     * The supported mime types.
     *
     * @var array
     */
    public static $supportedMime = [
        "txt", "png", "jpg", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "zip", "rar", "csv"
    ];

    /**
     * The max file size
     *
     * @var int
     */
    public static $maxFileSize = 30720;

    /**
     * Resolve preview image for the given extension.
     *
     * @param string $extension
     * @return string
     */
    public static function resolvePreviewImage($extension): string
    {
        return asset("images/media/{$extension}.png");
    }
}
