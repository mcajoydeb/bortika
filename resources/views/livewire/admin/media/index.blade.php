<div>
    @include('livewire.admin.partials.livewire-request-loader')

    @if ($totalItemsCount)
    <div class="row form-group">
        <div class="col-md-6 form-group">
            <div class="">
                <a href="javascript:;" wire:click="setTypeFilter(null)"
                    class="mr-1 {{ $typeFilter == null ? '' : 'text-muted' }}">
                    {{ trans('table-messages.all') }}({{ $totalItemsCount }})</a>

                @if ($imageItemsCount)
                    |  <a href="javascript:;" wire:click="setTypeFilter('image')"
                        class="mr-1 {{ $typeFilter == 'image' ? '' : 'text-muted' }}">
                        {{ trans('media.image') }}({{ $imageItemsCount }})</a>
                @endif

                @if ($videoItemsCount)
                    |  <a href="javascript:;" wire:click="setTypeFilter('video')"
                        class="mr-1 {{ $typeFilter == 'video' ? '' : 'text-muted' }}">
                        {{ trans('media.video') }}({{ $videoItemsCount }})</a>
                @endif

                @if ($textItemsCount)
                    |  <a href="javascript:;" wire:click="setTypeFilter('text')"
                        class="mr-1 {{ $typeFilter == 'text' ? '' : 'text-muted' }}">
                        {{ trans('media.text') }}({{ $textItemsCount }})</a>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('menu.all') . ' ' . trans('menu.media') }}</h3>
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
                                <th>{{ trans('media.file') }}</th>
                                <th>{{ trans('media.type') }}</th>
                                <th>{{ trans('media.added_by') }}</th>
                                <th>{{ trans('form-actions.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($media as $index => $item)
                                <tr>
                                    <td>{{ $media->firstItem() + $index }}</td>
                                    <td class="d-flex align-items-center">
                                        <x-admin.media.media-icon-preview :media="$item" />
                                    </td>
                                    <td title="{{ $item->type }}">{{ Str::limit($item->type, 20, '...') }}</td>
                                    <td>{{ optional($item->owner)->name }}</td>
                                    <td>
                                        @can('media_edit')
                                            @if ($item->isImage())
                                                <a class="btn btn-xs btn-warning mr-2" href="{{ route('admin.media.edit', $item->id) }}"><i class="fa fa-edit"></i> {{ trans('form-actions.edit') }}</a>
                                            @endif
                                        @endcan

                                        @can('media_delete')
                                        {!! Form::open(['url' => route('admin.media.destroy', $item->id), 'method' => 'delete', 'class' => 'd-inline']) !!}
                                            <a class="btn btn-xs btn-danger delete-table-item"
                                                href="#"><i class="fa fa-trash"></i> {{ trans('form-actions.delete_permanently') }}</a>
                                        {!! Form::close() !!}
                                        @endcan
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
                        {{ $media->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
