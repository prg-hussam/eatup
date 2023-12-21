<?php

namespace Modules\Media\Entities;

use Modules\Support\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Media\MediaHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;

class File extends Model
{
    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = ['id', 'entity_id', 'entity_type', 'folder_id', 'is_folder', 'filename', 'disk', 'extension', 'mime', 'size', 'path'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url', 'preview_image_url', 'human_size', 'download_url'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($file) {
            if (!$file->is_folder) {
                Storage::disk($file->disk)->delete($file->getRawOriginal('path'));
            }
        });
    }

    /**
     * Get files inside folder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class, "folder_id");
    }

    /**
     * Get the user that uploaded the file.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function uploader()
    {
        return $this->morphTo("entity");
    }

    /**
     * Determine if the file type is image.
     *
     * @return bool
     */
    public function isImage()
    {
        return !$this->is_folder && strtok($this->mime, '/') === 'image';
    }

    /**
     * Check if the file has linked entities.
     *
     * @return bool
     */
    public function hasLinked()
    {
        return !$this->is_folder && \DB::table("entity_files")->where("file_id", $this->id)->count() > 0;
    }

    /**
     * Get download for the file.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download()
    {
        return $this->is_folder ? null : Storage::disk($this->disk)->download($this->path, $this->filename);
    }

    /**
     * Get the file's url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->exists && !$this->is_folder ?  Storage::disk($this->disk)->url($this->path) : null
        );
    }

    /**
     * Get the file's preview image.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function previewImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->isImage() ? $this->url : MediaHelper::resolvePreviewImage($this->extension ?: "folder")
        );
    }

    /**
     * Get the file's human size.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function humanSize(): Attribute
    {
        return Attribute::make(
            get: fn () => humanFileSize($this->size ?? 0)
        );
    }

    /**
     * Get the file's download url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function downloadUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_folder ? null : route('media.download', $this->id)
        );
    }
}
