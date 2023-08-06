<div>
    @if ($role)
    {!! Form::model($role, ['url' => route('admin.role.update', $role->id), 'method' => 'PUT', 'files' => true, 'autocomplete' => 'off']) !!}
    @else
    {!! Form::open(['url' => route('admin.role.store'), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']) !!}
    @endif
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa fa-edit"></i> {{ trans('role.name') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 form-group">
                                {!! Form::label('name', trans('role.name')) !!}
                                {{ Form::text('name', null, ['class' => ($errors->has('name') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'name']) }}
                                @error('name')
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
                            <i class="fa fa-user-shield"></i> {{ trans('role.permissions') }}
                            @error('permissions')
                            <span class="text-danger ml-5">
                                ({{ $message }})
                            </span>
                            @enderror
                        </div>
                        <div class="card-tools">
                            <div class="custom-control custom-switch">
                                {!! Form::checkbox('select_all', 1, $selectAll, [
                                    'class' => 'custom-control-input',
                                    'id' => 'select_all',
                                    'wire:model' => 'selectAll'
                                ]) !!}

                                {!! Form::label('select_all', trans('permissions.select_all'), [
                                    'class' => 'custom-control-label'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach (config('permissions-list') as $permission)
                            <div class="col-md-3 form-group">
                                <div class="custom-control custom-switch">
                                    {!! Form::checkbox('permissions[]', $permission, ($selectAll || in_array($permission, $permissions)), [
                                        'class' => 'custom-control-input permissions',
                                        'id' => $permission,
                                        'wire:model' => 'permissions'
                                    ]) !!}

                                    {!! Form::label($permission, trans('permissions.' . $permission), [
                                        'class' => 'custom-control-label'
                                    ]) !!}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <x-admin.form.submit-button :entity="$role ?? false" />
            </div>
        </div>
    {!! Form::close() !!}
</div>

@push('page-scripts')
    <script>
        $(function () {
            $('.permissions').change(function(e) {
                var permissions = [];
                $('.permissions:checked').each(function(e) {
                    permissions.push($(this).val());
                });

                @this.set('permissions', permissions);
            });

            $('#select_all').change(function(e) {
                @this.set('selectAll', $(this).is(':checked'));
            });
        });
    </script>
@endpush
