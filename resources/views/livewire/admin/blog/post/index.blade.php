<div>
    @include('livewire.admin.partials.livewire-request-loader')

    @if ($totalItemsCount || $trashedItemsCount)
    <div class="row form-group">
        <div class="col-md-6 form-group">
            <div class="">
                @if ($totalItemsCount)
                    <a href="javascript:;" wire:click="setFilter('status', null)"
                        class="mr-1 {{ $statusFilter == null && !$trashFilter  ? '' : 'text-muted' }}">
                        {{ trans('table-messages.all') }}({{ $totalItemsCount }})</a>
                @endif

                @if ($publishItemsCount)
                    |  <a href="javascript:;" wire:click="setFilter('status', '{{ config('post-status.publish.value') }}')"
                        class="mr-1 {{ $statusFilter == 'publish' ? '' : 'text-muted' }}">
                        {{ config('post-status.publish.label') }}({{ $publishItemsCount }})</a>
                @endif

                @if ($privateItemsCount)
                    |  <a href="javascript:;" wire:click="setFilter('status', '{{ config('post-status.private.value') }}')"
                        class="mr-1 {{ $statusFilter == 'private' ? '' : 'text-muted' }}">
                        {{ config('post-status.private.label') }}({{ $privateItemsCount }})</a>
                @endif

                @if ($draftItemsCount)
                    |  <a href="javascript:;" wire:click="setFilter('status', '{{ config('post-status.draft.value') }}')"
                        class="mr-1 {{ $statusFilter == 'draft' ? '' : 'text-muted' }}">
                        {{ config('post-status.draft.label') }}({{ $draftItemsCount }})</a>
                @endif

                @if ($scheduledPublishItemsCount)
                    |  <a href="javascript:;" wire:click="setFilter('status', '{{ config('post-status.scheduled_publish.value') }}')"
                        class="mr-1 {{ $statusFilter == 'scheduled_publish' ? '' : 'text-muted' }}">
                        {{ config('post-status.scheduled_publish.label') }}({{ $scheduledPublishItemsCount }})</a>
                @endif

                @if ($trashedItemsCount)
                    |  <a href="javascript:;" wire:click="setFilter('trash', 1)"
                        class="{{ $trashFilter ? '' : 'text-muted' }}">
                        {{ trans('table-messages.trashed') }}({{ $trashedItemsCount }})</a>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('menu.all') . ' ' . trans('menu.posts') }}</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm mt-0" style="width: 150px;">
                            <input type="text" name="search" id="search" wire:model.debouce.400ms="search" class="form-control float-right"
                                placeholder="{{ trans('table-messages.search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('post.featured_image') }}</th>
                                <th>{{ trans('post.title') }}</th>
                                <th>{{ trans('post.slug') }}</th>
                                <th>{{ trans('menu.categories') }}</th>
                                <th>{{ trans('post.status') }}</th>
                                <th>{{ trans('form-actions.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $index => $post)
                                <tr>
                                    <td>{{ $posts->firstItem() + $index }}</td>
                                    <td>
                                        @if ($post->featured_image_model)
                                            <x-admin.media.media-icon-preview :media="$post->featured_image_model" :show-title="false" />
                                        @endif
                                    </td>
                                    <td title="{{ $post->post_title }}">{{ Str::limit($post->post_title, 20, '...') }}</td>
                                    <td title="{{ $post->post_slug }}">{{ Str::limit($post->post_slug, 20, '...') }}</td>
                                    <td title="{{ $post->category_names }}">{{ Str::limit($post->category_names, 20, '...') }}</td>
                                    <td>{!! $post->statusLabel() !!}</td>
                                    <td>
                                        @if ($post->trashed())
                                            @can('post_delete')
                                            {!! Form::open(['url' => route('admin.blog.posts.update', $post->id), 'method' => 'PUT', 'class' => 'd-inline']) !!}
                                                {!! Form::hidden('restore', 1) !!}
                                                <button class="btn btn-xs btn-info mr-2" type="submit"><i class="fa fa-trash-restore"></i> {{ trans('form-actions.restore') }}</button>
                                            {!! Form::close() !!}

                                            {!! Form::open(['url' => route('admin.blog.posts.destroy', $post->id), 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                {!! Form::hidden('force_delete', true) !!}
                                                <a class="btn btn-xs btn-danger delete-table-item"
                                                    href="#"><i class="fa fa-trash"></i> {{ trans('form-actions.delete_permanently') }}</a>
                                            {!! Form::close() !!}
                                            @endcan
                                        @else
                                            @can('post_edit')
                                            <a class="btn btn-xs btn-warning mr-2" href="{{ route('admin.blog.posts.edit', $post->id) }}"><i class="fa fa-edit"></i> {{ trans('form-actions.edit') }}</a>
                                            @endcan

                                            @can('post_delete')
                                            {!! Form::open(['url' => route('admin.blog.posts.destroy', $post->id), 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                <a class="btn btn-xs btn-danger delete-table-item"
                                                    href="#"><i class="fa fa-trash"></i> {{ trans('form-actions.delete') }}</a>
                                            {!! Form::close() !!}
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <x-admin.table.no-record-found />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer table-responsive">
                    <div class="d-flex flex-row-reverse">
                        {{ $posts->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>
