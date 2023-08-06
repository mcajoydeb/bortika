<div>
    <div class="row">
    @if ($multiple)
        @foreach ($media as $item)
            <div class="col-md-3 form-group">
                <x-admin.media.media-icon-preview :media="$item" :show-title="false" />
            </div>
        @endforeach
    @elseif ($media)
        <div class="col-md-3 form-group">
            <x-admin.media.media-icon-preview :media="$media" :show-title="false" />
        </div>
    @endif
    </div>

    @if ($multiple)
        @forelse ($media as $item)
            {!! Form::hidden($inputName . '[]', $item->id, []) !!}
        @empty

        @endforelse
    @else
        {!! Form::hidden($inputName, $inputValue, []) !!}
    @endif

    <button type="button" data-target="#choose-media-modal-{{ $inputName }}"
        data-toggle="modal" class="btn btn-primary open-media-modal">{{ trans('media.choose') }}</button>

    <div class="modal fade" id="choose-media-modal-{{ $inputName }}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ trans('media.choose_file') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @livewire('admin.utilities.media-listing', [
                        'inputName' => $inputName,
                        'selectedFile' => $inputValue,
                        'allowedType' => $allowedType,
                        'multiple' => $multiple,
                    ])
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
