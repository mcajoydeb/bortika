<div>
    @include('livewire.admin.partials.livewire-request-loader')

    <div class="row">
        <div class="col-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('menu.all') . ' ' . trans('menu.roles') }}</h3>
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
                                <th>{{ trans('role.name') }}</th>
                                <th>{{ trans('role.permissions') }}</th>
                                <th>{{ trans('form-actions.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $index => $role)
                                <tr>
                                    <td>{{ $roles->firstItem() + $index }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td title="{{ implode(', ', $role->getPermissionNames()->toArray()) }}">{{ Str::limit(implode(', ', $role->getPermissionNames()->toArray()), 20, '...') }}</td>
                                    <td>
                                        @can('role_edit')
                                        <a class="btn btn-xs btn-warning mr-2" href="{{ route('admin.role.edit', $role->id) }}"><i class="fa fa-edit"></i> {{ trans('form-actions.edit') }}</a>
                                        @endcan

                                        @can('role_delete')
                                        {!! Form::open(['url' => route('admin.role.destroy', $role->id), 'method' => 'delete', 'class' => 'd-inline']) !!}
                                            <a class="btn btn-xs btn-danger delete-table-item"
                                                href="#"><i class="fa fa-trash"></i> {{ trans('form-actions.delete') }}</a>
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
                        {{ $roles->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
