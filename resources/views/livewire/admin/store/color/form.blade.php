@push('page-styles')
 <!-- Bootstrap Color Picker -->
 <link rel="stylesheet" href="{{ asset('theme/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
 <style>
    .colorpicker {display:block;}
 </style>
@endpush

<div>
    @if ($term)
    {!! Form::model($term, ['url' => route('admin.product-colors.update', $term->id), 'method' => 'PUT', 'files' => true, 'autocomplete' => 'off']) !!}
    @else
    {!! Form::open(['url' => route('admin.product-colors.store'), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']) !!}
    @endif
        <div class="row">
            <div class="col-md-9 form-group">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa fa-edit"></i> {{ trans('form.basic_details') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 form-group">
                                {!! Form::label('name', trans('form.name')) !!}
                                {{ Form::text('name', null, ['class' => ($errors->has('name') ? 'is-invalid' : '') . ' form-control', 'wire:model.debounce.500ms' => 'name']) }}
                                @error('name')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12 form-group">
                                {!! Form::label('_color_code', trans('form.color_code')) !!}
                                <div class="input-group colorpicker-area">
                                    {{ Form::text('_color_code', null, ['class' => ($errors->has('_color_code') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_color_code']) }}
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="color:{{ $_color_code }}"><i class="fas fa-square"></i></span>
                                    </div>
                                </div>
                                @error('_color_code')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 form-group">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            {!! Form::label('status', trans('form.status'), ['class' => 'mr-3']) !!}
                            {{ Form::select('status', \App\Services\SelectInputArrayHelperService::getGeneralStatusArray(), null,
                                ['class' => ($errors->has('status') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'status']) }}
                        </div>
                        @error('status')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="card-footer text-right">
                        <x-admin.form.submit-button :entity="$term ?? false" />
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>

@push('page-scripts')
<!-- bootstrap color picker -->
<script src="{{ asset('theme/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script>
    $('.colorpicker-area').colorpicker()
    $('.colorpicker-area').on('colorpickerChange', function(event) {
        $('.colorpicker-area .fa-square').css('color', event.color.toString());
        @this.set('_color_code', event.color.toString());
    });
</script>
@endpush
