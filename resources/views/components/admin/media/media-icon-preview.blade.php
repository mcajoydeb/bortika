<div>
    <div class="form-group">
        @if ($media->isImage())
            <img src="{{ $media->asset_thumbnail_url }}" alt="{{ $media->title }}" class="img-thumbnail thumbnail">
        @elseif ($media->isVideo())
            <video class="img-thumbnail thumbnail" controls>
                <source src="{{ $media->asset_url }}" type="{{ $media->type }}">
                Your browser does not support the video tag.
            </video>
        @else
            <i class="fa fa-file fa-6x img-thumbnail "></i>
        @endif

        @if ($showTitle)
            <div class="file-details ml-2">
                <div title="{{ $media->title }}" class="file-title">{{ Str::limit($media->title, 20, '...') }}</div>
                {{-- <div class="file-name">{{ $media->file_name }}</div> --}}
            </div>
        @endif
    </div>
</div>
