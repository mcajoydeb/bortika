<div>
    @if ($post)
    {!! Form::model($post, ['url' => route('admin.blog.posts.update', $post->id), 'method' => 'PUT', 'files' => true, 'autocomplete' => 'off']) !!}
    @else
    {!! Form::open(['url' => route('admin.blog.posts.store'), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']) !!}
    @endif
    <div class="row">
        <div class="col-md-9 form-group">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        {{ trans('post.title') }}
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::text('post_title', null,
                        ['class' => ($errors->has('post_title') ? 'is-invalid' : '') . ' form-control', 'wire:model.debounce.500ms' => 'post_title',
                        'placeholder' => trans('post.title_placeholder')]) }}

                    @error('post_title')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        {{ trans('post.slug') }}
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::text('post_slug', null,
                        ['class' => ($errors->has('post_slug') ? 'is-invalid' : '') . ' form-control', 'wire:model.debounce.500ms' => 'post_slug',
                        'placeholder' => trans('post.slug_placeholder')]) }}

                    @error('post_slug')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="card card-default" wire:ignore>
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        {{ trans('post.content') }}
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::textarea('post_content', null,
                        ['class' => ($errors->has('post_content') ? 'is-invalid' : '') . ' texteditor form-control', 'wire:model' => 'post_content']) }}
                    <div class="text-right text-muted">
                        {{ trans('form-actions.char_count') }}:
                        <span class="description-count">
                            {{ $post ? Str::length($post_content) : 0 }}
                        </span>
                    </div>
                    @error('post_content')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-image"></i>
                        {{ trans('post.featured_image') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @livewire('admin.utilities.choose-media', [
                                'inputName' => '_featured_image',
                                'inputValue' => $_featured_image,
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-eye"></i>
                        {{ trans('post.google_preview') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="seo-preview-content">
                        <h3>{!! $_seo_page_title ? $_seo_page_title : trans('post.title_example') !!}</h3>
                        <p class="link">
                            {{ url('/') . '/blog/' . ($_seo_page_slug ? $_seo_page_slug : 'page-title') }}
                        </p>
                        <p class="description">{!! $_seo_meta_description ? $_seo_meta_description : trans('post.description_example') !!}</p>
                    </div>
                    <div class="seo-content">
                        <div class="form-group">
                            {{ Form::text('_seo_page_title', null,
                                ['class' => ($errors->has('_seo_page_title') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_seo_page_title',
                                'placeholder' => trans('post.title_example')]) }}

                            @error('_seo_page_title')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::text('_seo_page_slug', null,
                                ['class' => ($errors->has('_seo_page_slug') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_seo_page_slug',
                                'placeholder' => trans('post.url_example')]) }}

                            @error('_seo_page_slug')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::textarea('_seo_meta_description', null,
                                ['class' => ($errors->has('_seo_meta_description') ? 'is-invalid' : '') . ' form-control', 'wire:model.debounce.500ms' => '_seo_meta_description', 'rows' => 3,
                                'placeholder' => trans('post.description_example')]) }}

                            @error('_seo_meta_description')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::textarea('_seo_meta_keywords', null,
                                ['class' => ($errors->has('_seo_meta_keywords') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_seo_meta_keywords', 'rows' => 3,
                                'placeholder' => trans('post.keywords_example')]) }}

                            @error('_seo_meta_keywords')
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
                        <i class="fa fa-edit"></i>
                        {{ trans('post.allowed_max_char') }}
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::number('_allowed_max_characters', null,
                        ['class' => ($errors->has('_allowed_max_characters') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_allowed_max_characters']) }}
                    <div class="text-help">
                        {{ trans('post.max_char_help_text') }}
                    </div>

                    @error('_allowed_max_characters')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-check"></i>
                        {{ trans('post.allow_comments') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-control custom-checkbox mt-2">
                        {!! Form::checkbox('_allow_comments', 1, null, ['id' => '_allow_comments', 'class' => 'custom-control-input', 'wire:model' => '_allow_comments']) !!}
                        {!! Form::label('_allow_comments', trans('post.allow_comments_label'), ['class' => 'custom-control-label']) !!}
                    </div>

                    @error('_allow_comments')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-3 form-group">

            <div class="card card-default">
                <div class="card-body">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa fa-th"></i> {{ trans('menu.categories') }}
                        </div>
                    </div>
                    <div class="card-body">
                        @livewire('utilities.category-tree', [
                            'type' => config('term-types.post_category'),
                            'parentId' => 0,
                            'selectedItems' => $_categories
                        ])
                        @foreach ($_categories as $item)
                            {!! Form::hidden('_categories[]', $item,) !!}
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card card-default">
                @can('post_publish')
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        {!! Form::label('post_status', trans('post.status'), ['class' => 'mr-3']) !!}
                        {{ Form::select('post_status', \App\Services\SelectInputArrayHelperService::getPostStatusArray(), null, ['class' => ($errors->has('post_status') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'post_status']) }}
                    </div>
                    @error('post_status')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    @if ($post_status == config('post-status.private.value'))
                        <div class="mt-3">
                            {{ Form::text('_post_password', null,
                                ['class' => ($errors->has('_post_password') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_post_password',
                                'placeholder' => trans('post.password')]) }}

                            @error('_post_password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    @endif

                    @if ($post_status == config('post-status.scheduled_publish.value'))
                    <div class="">
                        <div class="mt-3">
                            {{ Form::date('_post_scheduled_start_time', null,
                                ['class' => ($errors->has('_post_scheduled_start_time') ? 'is-invalid' : '') . ' form-control',
                                'wire:model' => '_post_scheduled_start_time',
                                'id' => '_post_scheduled_start_time',
                                'placeholder' => trans('post.scheduled_start')]) }}

                            @error('_post_scheduled_start_time')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div class="mt-2">
                            {{ Form::date('_post_scheduled_end_time', null,
                                ['class' => ($errors->has('_post_scheduled_end_time') ? 'is-invalid' : '') . ' form-control',
                                'wire:model' => '_post_scheduled_end_time',
                                'id' => '_post_scheduled_end_time',
                                'placeholder' => trans('post.scheduled_end')]) }}

                            @error('_post_scheduled_end_time')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>
                    @endif
                </div>
                @endcan
                @cannot('post_publish')
                    {!! Form::hidden('post_status', config('post-status.draft.value')) !!}
                @endcannot
                <div class="card-footer text-right">
                    <x-admin.form.submit-button :entity="$post ?? false" />
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@push('page-scripts')
<script>
    $(function () {
        $('.texteditor').summernote({
            callbacks: {
                onChange: function(contents) {
                    $('.description-count').html(contents.length);
                    @this.set('post_content', contents);
                }
            }
        });
    });
</script>
@endpush
