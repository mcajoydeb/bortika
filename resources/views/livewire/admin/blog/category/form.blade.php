<div>
    @if ($term)
    {!! Form::model($term, ['url' => route('admin.blog.categories.update', $term->id), 'method' => 'PUT', 'files' => true, 'autocomplete' => 'off']) !!}
    @else
    {!! Form::open(['url' => route('admin.blog.categories.store'), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']) !!}
    @endif<div class="row">
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
                            {!! Form::label('slug', trans('form.slug')) !!}
                            {{ Form::text('slug', null, ['class' => ($errors->has('slug') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'slug']) }}
                            @error('slug')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 form-group" wire:ignore>
                            {!! Form::label('parent_id', trans('form.parent')) !!}
                            {{ Form::select('parent_id',
                                \App\Models\Term::postCategories()->whereNotIn('id', [$term->id ?? 0])->orderBy('name')->pluck('name', 'id')->toArray(), null, [
                                'placeholder' => 'Select...', 'class' => ($errors->has('parent_id') ? 'is-invalid' : '') . ' select2 form-control', 'wire:model' => 'parent_id']) }}
                            @error('parent_id')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-edit"></i> {{ trans('form.description') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group" wire:ignore>
                        {!! Form::label('_description', trans('form.description')) !!}
                        {{ Form::textarea('_description', null, ['class' => ($errors->has('_description') ? 'is-invalid' : '') . ' texteditor form-control', 'wire:model' => '_description']) }}
                        <div class="text-right text-muted">
                            {{ trans('form-actions.char_count') }}:
                            <span class="description-count">
                                {{ $term ? Str::length($_description) : 0 }}
                            </span>
                        </div>
                        @error('_description')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-globe"></i> {{ trans('form.seo_settings') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group">
                        {!! Form::label('_meta_key', trans('form.meta_key')) !!}
                        {{ Form::text('_meta_key', null, ['class' => ($errors->has('_meta_key') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_meta_key']) }}
                        @error('_meta_key')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 form-group">
                        {!! Form::label('_meta_description', trans('form.meta_description')) !!}
                        {{ Form::text('_meta_description', null, ['class' => ($errors->has('_meta_description') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_meta_description']) }}
                        @error('_meta_description')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-image"></i> {{ trans('form.media') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group">
                        {!! Form::label('_thumbnail', trans('form.thumbnail')) !!}
                        <div>
                            @livewire('admin.utilities.choose-media', [
                                'inputName' => '_thumbnail',
                                'inputValue' => $_thumbnail,
                            ])
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
<x-admin.form.summernote show-count-class-name="description-count" input-name="_description" />
@endpush
