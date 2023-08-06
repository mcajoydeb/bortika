<div>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <img src="{{ $media->asset_url }}" alt="{{ $media->title }}" class="cropper">
        </div>
    </div>
    <div class="hover-bottom-right">
        <button class="btn btn-primary btn-lg crop-and-upload">
            <i class="fa fa-crop"></i> {{ trans('form-actions.crop_and_save') }}
        </button>
    </div>
</div>
