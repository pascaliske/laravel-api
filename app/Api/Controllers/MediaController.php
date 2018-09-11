<?php

namespace App\Api\Controllers;

use Exception;
use App\Api\Models\Media;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Dingo\Api\Routing\Helpers;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read-media', ['only' => ['fetch', 'fetchAll']]);
        $this->middleware('can:create-media', ['only' => ['create']]);
        $this->middleware('can:update-media', ['only' => ['update']]);
        $this->middleware('can:delete-media', ['only' => ['delete']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        return Media::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchAll()
    {
        return Media::all();
    }

    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $file = $request->file('file');
        $path = Storage::putFile('public', $file);

        try {
            Media::create([
                'title' => $request->title,
                'description' => $request->description,
                'path' => $path,
                'type' => $file->getMimeType(),
                'author' => $request->author,
            ]);
        } catch (Exception $exception) {
            Storage::delete($path);
            throw $exception;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->updateModel(Media::findOrFail($id), [
            'title' => $request->title,
            'description' => $request->description,
            'author' => $request->author,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $media = Media::findOrFail($id);

        if ($media->path && Storage::exists($media->path)) {
            Storage::delete($media->path);
        }

        $media->delete();
    }

    /**
     * Runs image optimizations on demand.
     *
     * @return \Illuminate\Http\Response
     */
    public function optimize()
    {
        $exit = Artisan::call('media:optimize');

        if ($exit > 0) {
            return response()->json(['error' => 'Error during image optimization process.'], 500);
        }

        return response(null, 204);
    }
}
