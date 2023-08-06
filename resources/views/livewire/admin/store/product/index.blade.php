<div>
    @include('livewire.admin.partials.livewire-request-loader')

    @if ($totalItemsCount || $trashedItemsCount)
    <div class="row form-group">
        <div class="col-md-6 form-group">
            <div class="">
                <a href="javascript:;" wire:click="setFilter('status', null)"
                    class="mr-1 {{ $statusFilter == null && !$trashFilter  ? '' : 'text-muted' }}">
                    {{ trans('table-messages.all') }}({{ $totalItemsCount }})</a>

                @if ($activeItemsCount)
                    |  <a href="javascript:;" wire:click="setFilter('status', '{{ config('general-status-options.active.value') }}')"
                        class="mr-1 {{ $statusFilter == config('general-status-options.active.value') ? '' : 'text-muted' }}">
                        {{ trans('table-messages.active') }}({{ $activeItemsCount }})</a>
                @endif

                @if ($disabledItemsCount)
                    |  <a href="javascript:;" wire:click="setFilter('status', '{{ config('general-status-options.disabled.value') }}')"
                        class="mr-1 {{ $statusFilter == config('general-status-options.disabled.value') ? '' : 'text-muted' }}">
                        {{ trans('table-messages.disabled') }}({{ $disabledItemsCount }})</a>
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
                    <h3 class="card-title">{{ trans('menu.all') . ' ' . trans('menu.products') }}</h3>
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
                                <th>{{ trans('form.featured_image') }}</th>
                                <th>{{ trans('form.title') }}</th>
                                <th>{{ trans('product.sku') }}</th>
                                <th>{{ trans('product.type') }}</th>
                                <th>{{ trans('product.price') }}</th>
                                <th>{{ trans('form.status') }}</th>
                                <th>{{ trans('form-actions.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $index }}</td>
                                    <td>
                                        @if ($product->image()->exists())
                                            <x-admin.media.media-icon-preview :media="$product->image" :show-title="false" />
                                        @endif
                                    </td>
                                    <td title="{{ $product->title }}">{{ Str::limit($product->title, 20, '...') }}</td>
                                    <td title="{{ $product->sku }}">{{ $product->sku }}</td>
                                    <td title="{{ $product->type_label }}">{{ $product->type_label }}</td>
                                    <td title="{{ $product->formatted_price }}">{{ $product->formatted_price }}</td>
                                    <td>{!! $product->statusLabel() !!}</td>
                                    <td>
                                        @if ($product->trashed())
                                            @can('product_delete')
                                            {!! Form::open(['url' => route('admin.products.update', $product->id), 'method' => 'PUT', 'class' => 'd-inline']) !!}
                                                {!! Form::hidden('restore', 1) !!}
                                                <button class="btn btn-xs btn-info mr-2" type="submit"><i class="fa fa-trash-restore"></i> {{ trans('form-actions.restore') }}</button>
                                            {!! Form::close() !!}

                                            {!! Form::open(['url' => route('admin.products.destroy', $product->id), 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                {!! Form::hidden('force_delete', true) !!}
                                                <a class="btn btn-xs btn-danger delete-table-item"
                                                    href="#"><i class="fa fa-trash"></i> {{ trans('form-actions.delete_permanently') }}</a>
                                            {!! Form::close() !!}
                                            @endcan
                                        @else
                                            @can('product_edit')
                                            <a class="btn btn-xs btn-warning mr-2" href="{{ route('admin.products.edit', $product->id) }}"><i class="fa fa-edit"></i> {{ trans('form-actions.edit') }}</a>
                                            @endcan

                                            @can('product_delete')
                                            {!! Form::open(['url' => route('admin.products.destroy', $product->id), 'method' => 'delete', 'class' => 'd-inline']) !!}
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
                        {{ $products->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>
