<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rules()
    {
        return [
            'files.*' => 'required|file',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function scopeType($query, $value)
    {
        if (!empty($value)) {
            return $query->where('type', 'LIKE', "{$value}%");
        }

        return $query;
    }

    public function scopeImage($query)
    {
        return $query->type('image');
    }

    public function scopeVideo($query)
    {
        return $query->type('video');
    }

    public function scopeText($query)
    {
        return $query->type('text');
    }

    public function scopeSearch($query, $value)
    {
        if (!empty($value)) {
            return $query->where('title', 'LIKE', "%{$value}%");
        }

        return $query;
    }

    public function getAssetUrlAttribute()
    {
        if (Str::contains($this->path, 'http://') || Str::contains($this->path, 'https://')) {
            return $this->path;
        }

        $storage_url = Storage::url($this->path);

        return Storage::exists($this->path) ?
            $storage_url :
            ($this->isVideo() ? $this->videoPlaceholder() : $this->imagePlaceholder());
    }

    public function getAssetThumbnailUrlAttribute()
    {
        if ($this->isImage()) {

            if (Str::contains($this->thumbnail_path, 'http://') || Str::contains($this->thumbnail_path, 'https://')) {
                return $this->thumbnail_path;
            }

            $storage_url = Storage::url($this->thumbnail_path);
            return Storage::exists($this->thumbnail_path) ? $storage_url : $this->asset_url;
        }

        return $this->asset_url;
    }

    public function createTitle($fileName)
    {
        $fileName = explode('.', $fileName);

        if (isset($fileName[0])) {
            return Str::title($fileName[0]);
        }

        return $fileName;
    }

    public function getFolderToUpload()
    {
        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $day = $now->format('d');
        return 'public/' . config('media.default_folder') . $year . '/' . $month . '/' . $day;
    }

    public function getThumbnailFolder()
    {
        return $this->getFolderToUpload() . '/thumbnail';
    }

    public function isImage()
    {
        return Str::contains($this->type, 'image');
    }

    public function isVideo()
    {
        return Str::contains($this->type, 'video');
    }

    public function isText()
    {
        return Str::contains($this->type, 'text');
    }

    public function createThumbnailAndGetPath($file, $type)
    {
        $fileExt = 'png';

        if ($type == 'file') {
            $mimeType = $file->getClientMimeType();
        } elseif ($type == 'base64') {
            $mimeType = $this->getMimeTypeFromBase64($file);
        }

        if (!Str::contains($mimeType, 'image')) {
            return null;
        }

        $resize = Image::make($file)->resize(config('media.thumbnail_width'), config('media.thumbnail_height'), function ($constraint) {
            $constraint->aspectRatio();
        })->encode($fileExt);

        $hash = md5($resize->__toString());
        $thumbnailFileName = $hash . "." . $fileExt;
        $thumbnailFilePath = $this->getThumbnailFolder() . '/' . $thumbnailFileName;

        $save = Storage::put($thumbnailFilePath, $resize->__toString());

        if ($save) {
            return $thumbnailFilePath;
        }

        return null;
    }

    public function uploadBase64Image($image)
    {
        $imageParts = explode(";base64,", $image);
        $imageTypeParts = explode("image/", $imageParts[0]);
        $imageType = $imageTypeParts[1];
        $imageBase64 = base64_decode($imageParts[1]);

        $hash = md5($imageBase64);
        $fileName = $hash . "." . $imageType;
        $fullPath = $this->getFolderToUpload() . '/' . $fileName;

        $save = Storage::put($fullPath, $imageBase64);

        if ($save) {
            return $fullPath;
        }

        return null;
    }

    public function getMimeTypeFromBase64($image)
    {
        $imageParts = explode(";base64,", $image);
        $imageTypeParts = explode(":", $imageParts[0]);
        return $imageTypeParts[1];
    }

    public function imagePlaceholder(): string
    {
        return asset('img/placeholder-image.png');
    }

    public function videoPlaceholder(): string
    {
        return asset('img/video-placeholder.png');
    }
}
