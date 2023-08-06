<div>
    <div class="row">
        <div class="col-md-12 form-group">
            @if ($uploadMode)
            <button type="button" wire:click="$set('uploadMode', false)"
                class="btn btn-outline-primary btn-sm">
                {{ trans('media.choose') }}
            </button>
            @else
                @can('media_add')
                    <button type="button" wire:click="$set('uploadMode', true)"
                        class="btn btn-outline-primary btn-sm">
                        {{ trans('media.upload_files') }}
                    </button>
                @endcan
            @endif
        </div>
    </div>

    @if ($totalItemsCount && $uploadMode == false)
    <div class="row form-group">
        <div class="col-md-6 form-group">
            <div class="">
                <a href="javascript:;" wire:click="$set('typeFilter', null)"
                    class="mr-1 {{ $typeFilter == null ? '' : 'text-muted' }}">
                    {{ trans('table-messages.all') }}({{ $totalItemsCount }})</a>

                @if ($imageItemsCount && in_array('image', $allowedType))
                | <a href="javascript:;" wire:click="$set('typeFilter', 'image')"
                    class="mr-1 {{ $typeFilter == 'image' ? '' : 'text-muted' }}">
                    {{ trans('media.image') }}({{ $imageItemsCount }})</a>
                @endif

                @if ($videoItemsCount && in_array('video', $allowedType))
                | <a href="javascript:;" wire:click="$set('typeFilter', 'video')"
                    class="mr-1 {{ $typeFilter == 'video' ? '' : 'text-muted' }}">
                    {{ trans('media.video') }}({{ $videoItemsCount }})</a>
                @endif

                @if ($textItemsCount && in_array('text', $allowedType))
                | <a href="javascript:;" wire:click="$set('typeFilter', 'text')"
                    class="mr-1 {{ $typeFilter == 'text' ? '' : 'text-muted' }}">
                    {{ trans('media.text') }}({{ $textItemsCount }})</a>
                @endif
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <div class="mt-0" style="width: 150px;">
                <input type="text" name="search" id="search" wire:model.debouce.400ms="search" class="form-control-sm form-control float-right"
                    placeholder="{{ trans('table-messages.search') }}">
            </div>
        </div>
    </div>
    @endif

    @if ($uploadMode)
    <div class="row">
        <div class="col-12">
            @livewire('admin.media.create')
        </div>
    </div>
    @else
    <div class="row">
        @foreach($allMedia as $media)
        @php
            $isSelected = $multiple ?
                in_array($media->id, $selectedFile) : $selectedFile == $media->id;
        @endphp
        <div class="col-2 form-group media-item {{ $isSelected ? 'selected' : '' }}"
            wire:click="selectFile({{ $media->id }})">
            <x-admin.media.media-icon-preview :media="$media" />
        </div>
        @endforeach

        @if (!count($allMedia))
            <x-admin.table.no-record-found />
        @endif
    </div>
    <div class="row">
        <div class="col-6">
            {{ $allMedia->links() }}
        </div>
        <div class="col-6 text-right">
            <button type="button" wire:click="setInputValue()"
            class="btn btn-primary">{{ trans('media.select') }}</button>
        </div>
    </div>
    @endif

</div>

