<div>
    @include('livewire.admin.partials.livewire-request-loader')

    @if ($totalItemsCount)
    <div class="row form-group">
        <div class="col-md-6 form-group">
            <div class="">
                <a href="javascript:;" wire:click="$set('trashFilter', false)"
                    class="mr-1 {{ $trashFilter ? 'text-muted' : '' }}">
                    {{ trans('table-messages.all') }}({{ $totalItemsCount }})</a>

                @if ($trashedItemsCount)
                    |  <a href="javascript:;" wire:click="$set('trashFilter', true)"
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
                    <h3 class="card-title">{{ trans('menu.all') . ' ' . trans('menu.users') }}</h3>
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
                                <th>{{ trans('user.name') }}</th>
                                <th>{{ trans('user.email') }}</th>
                                <th>{{ trans('user.roles') }}</th>
                                <th>{{ trans('form-actions.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td title="{{ implode(', ', $user->getRoleNames()->toArray()) }}">{{ Str::limit(implode(', ', $user->getRoleNames()->toArray()), 20, '...') }}</td>
                                    <td>
                                        @if ($user->trashed())
                                            @can('user_delete', Model::class)
                                            {!! Form::open(['url' => route('admin.user.update', $user->id), 'method' => 'PUT', 'class' => 'd-inline']) !!}
                                                {!! Form::hidden('restore', 1) !!}
                                                <button class="btn btn-xs btn-info mr-2" type="submit"><i class="fa fa-trash-restore"></i> {{ trans('form-actions.restore') }}</button>
                                            {!! Form::close() !!}

                                            {!! Form::open(['url' => route('admin.user.destroy', $user->id), 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                {!! Form::hidden('force_delete', true) !!}
                                                <a class="btn btn-xs btn-danger delete-table-item"
                                                    href="#"><i class="fa fa-trash"></i> {{ trans('form-actions.delete_permanently') }}</a>
                                            {!! Form::close() !!}
                                            @endcan
                                        @else
                                            @can('user_edit')
                                            <a class="btn btn-xs btn-warning mr-2" href="{{ route('admin.user.edit', $user->id) }}"><i class="fa fa-edit"></i> {{ trans('form-actions.edit') }}</a>
                                            @endcan

                                            @can('user_delete')
                                            {!! Form::open(['url' => route('admin.user.destroy', $user->id), 'method' => 'delete', 'class' => 'd-inline']) !!}
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
                        {{ $users->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
