<?php

namespace App\Http\Controllers\Admin;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('media_management')) {
            abort(403);
        }

        return view('admin.media.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('media_add')) {
            abort(403);
        }

        return view('admin.media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('media_add')) {
            abort(403);
        }

        $media = new Media();

        $data = Validator::validate($request->all(), $media->rules());

        foreach ($data['files'] as $file) {
            try {
                $mediaData = [];
                $mediaData['title'] = $media->createTitle($file->getClientOriginalName());
                $mediaData['file_name'] = $file->getClientOriginalName();
                $mediaData['path'] = $file->store($media->getFolderToUpload());
                $mediaData['thumbnail_path'] = $media->createThumbnailAndGetPath($file, 'file');
                $mediaData['type'] = $file->getClientMimeType();
                $mediaData['added_by'] = Auth::user()->id;

                Media::create($mediaData);

                $response = [
                    'status' => 'success'
                ];
            } catch (\Exception $e) {
                $response = [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('media_view')) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('media_edit')) {
            abort(403);
        }

        $media = Media::findOrFail($id);

        if (!$media->isImage()) {
            return redirect()->back()->with('alert-error', trans('alert-messages.invalid-entity'));
        }

        JavaScriptFacade::put([
            'editRoute' => route('admin.media.update', $media->id),
            'successUrl' => route('admin.media.index'),
            'successMessage' => trans('alert-messages.successfully-updated', ['entity' => 'Media']),
            'errorMessage' => trans('alert-messages.error-message'),
        ]);

        return view('admin.media.edit', compact('media'));
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
        if (!auth()->user()->can('media_edit')) {
            abort(403);
        }

        $media = Media::findOrFail($id);

        $file = $request->image;

        if ($media->asset_url) {
            $prevMediaPath = $media->path;
        }

        if ($media->asset_thumbnail_url) {
            $prevThumbnailPath = $media->thumbnail_path;
        }

        try {
            $mediaData = [];
            $mediaData['path'] = $media->uploadBase64Image($file);
            $mediaData['thumbnail_path'] = $media->createThumbnailAndGetPath($file, 'base64');
            $mediaData['type'] = $media->getMimeTypeFromBase64($file);

            $result = $media->update($mediaData);

            if ($result) {
                if (isset($prevMediaPath)) {
                    Storage::delete($prevMediaPath);
                }

                if (isset($prevThumbnailPath)) {
                    Storage::delete($prevThumbnailPath);
                }

                $response = [
                    'status' => 'success'
                ];
            } else {
                $response = [
                    'status' => 'error'
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('media_delete')) {
            abort(403);
        }

        $media = Media::findOrFail($id);

        if ($media->asset_url) {
            Storage::delete($media->path);
        }

        if ($media->asset_thumbnail_url) {
            Storage::delete($media->thumbnail_path);
        }

        $media->delete();

        return redirect()->back()->with('alert-success', trans('alert-messages.successfully-deleted', ['entity' => 'Media']));
    }
}
