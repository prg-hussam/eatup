<?php

namespace Modules\Media\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Media\Entities\File;
use Illuminate\Support\Facades\Storage;
use Modules\Support\Traits\HasCrudActions;
use Modules\Media\Http\Requests\FolderMediaRequest;
use Modules\Media\Http\Requests\UploadMediaRequest;
use Inertia\Inertia;
use Modules\Media\Http\Requests\SaveMediaRequest;
use Modules\Media\Transformers\FileResource;

class MediaController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Media';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has("json")) {
            return response()->json([
                "files" => $this->getFiles($request)
            ]);
        }
        return Inertia::render("Admin/{$this->component}/Index");
    }

    /**
     * Store a newly created media in storage.
     *
     * @param \Modules\Media\Http\Requests\UploadMediaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadMediaRequest $request)
    {
        $file = $request->file('file');
        $path = Storage::putFile('media', $file);
        $user = auth()->user();

        return File::create([
            'entity_id' => $user->id,
            'entity_type' => get_class($user),
            'disk' => config('filesystems.default'),
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'extension' => $file->guessExtension() ?? '',
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
            'folder_id' => $request->folder_id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Modules\Media\Http\Requests\SaveMediaRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveMediaRequest $request, $id)
    {
        $user = $request->user();
        File::where("entity_id", $user->id)
            ->where("entity_type", get_class($user))
            ->where("id", $id)
            ->update(["filename" => $request->name]);

        return response()->json(["success" => true]);
    }

    /**
     * Store a newly created folder media in storage.
     *
     * @param \Modules\Media\Http\Requests\FolderMediaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeFolder(FolderMediaRequest $request)
    {
        $user = auth()->user();

        File::create([
            'entity_id' => $user->id,
            'entity_type' => get_class($user),
            'filename' => $request->folder_name,
            'folder_id' => $request->folder_id,
            "is_folder" => true
        ]);

        return response()->json(["success" => true]);
    }

    private function getFiles(Request $request)
    {
        $user = $request->user();

        $query = File::when($request->has('search'), function ($query) use ($request) {
            $query->where('filename', 'LIKE', '%' . $request->search . '%');
        })
            ->when($request->folder_id, function ($query) use ($request) {
                $query->where('folder_id', $request->folder_id);
            })
            ->when(!$request->folder_id, function ($query) use ($request) {
                $query->whereNull('folder_id');
            })
            ->when(!is_null($request->mime), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    foreach (explode(",", $request->mime) as $mime) {
                        $query->orWhere('mime', 'LIKE', "{$mime}/%")
                            ->orWhere("is_folder", true);
                    }
                });
            })
            ->where("entity_id", $user->id)
            ->where("entity_type", get_class($user))
            ->skip($request->get('skip', 0))
            ->take(30)
            ->latest()
            ->get();

        return FileResource::collection($query);
    }

    /**
     * Destroy resources by given ids.
     *
     * @param  string  $ids
     * @return void
     */
    public function destroy($ids)
    {

        File::find(explode(',', $ids))->each->delete();

        return response()->json(["success" => true]);
    }
}
