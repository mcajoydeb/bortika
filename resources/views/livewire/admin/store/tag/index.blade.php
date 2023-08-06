<div>
    @include('livewire.admin.partials.livewire-request-loader')

    @if ($totalItemsCount)
    <div class="row form-group">
        <div class="col-md-6 form-group">
            <div class="">
                <a href="javascript:;" wire:click="setFilter(null)"
                    class="mr-1 {{ $statusFilter == null ? '' : 'text-muted' }}">
                    {{ trans('table-messages.all') }}({{ $totalItemsCount }})</a>

                @if ($activeItemsCount)
                | <a href="javascript:;" wire:click="setFilter('{{ config('general-status-options.active.value') }}')"
                    class="mr-1 {{ $statusFilter == config('general-status-options.active.value') ? '' : 'text-muted' }}">
                    {{ trans('table-messages.active') }}({{ $activeItemsCount }})</a>
                @endif

                @if ($disabledItemsCount)
                | <a href="javascript:;" wire:click="setFilter('{{ config('general-status-options.disabled.value') }}')"
                    class="mr-1 {{ $statusFilter == config('general-status-options.disabled.value') ? '' : 'text-muted' }}">
                    {{ trans('table-messages.disabled') }}({{ $disabledItemsCount }})</a>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('menu.all') . ' ' . trans('menu.tags') }}</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm mt-0" style="width: 150px;">
                            <input type="text" name="search" id="search" wire:model.debouce.400ms="search"
                                class="form-control float-right" placeholder="{{ trans('table-messages.search') }}">
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
                                <th>{{ trans('form.name') }}</th>
                                <th>{{ trans('form.slug') }}</th>
                                <th>{{ trans('form.status') }}</th>
                                <th>{{ trans('form-actions.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($terms as $index => $term)
                            <tr>
                                <td>{{ $terms->firstItem() + $index }}</td>
                                <td>{{ $term->name }}</td>
                                <td>{{ $term->slug }}</td>
                                <td>{!! $term->statusLabel() !!}</td>
                                <td>
                                    <a class="btn btn-xs btn-warning mr-2"
                                        href="{{ route('admin.product-tags.edit', $term->id) }}"><i class="fa fa-edit"></i>
                                        {{ trans('form-actions.edit') }}</a>

                                    {!! Form::open(['url' => route('admin.product-tags.destroy', $term->id), 'method' =>
                                    'delete', 'class' => 'd-inline']) !!}
                                    <a class="btn btn-xs btn-danger delete-table-item" href="#"><i
                                            class="fa fa-trash"></i> {{ trans('form-actions.delete') }}</a>
                                    {!! Form::close() !!}
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
                        {{ $terms->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
