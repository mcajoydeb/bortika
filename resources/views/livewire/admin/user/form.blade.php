<div>
    @if ($user)
    {!! Form::model($user, ['url' => route('admin.user.update', $user->id), 'method' => 'PUT', 'files' => true, 'autocomplete' => 'off']) !!}
    @else
    {!! Form::open(['url' => route('admin.user.store'), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']) !!}
    @endif
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa fa-edit"></i> {{ trans('user.basic_details') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 form-group">
                                {!! Form::label('name', trans('user.name')) !!}
                                {{ Form::text('name', null, ['class' => ($errors->has('name') ? 'is-invalid' : '') . ' form-control',
                                    'wire:model' => 'name',
                                    'placeholder' => trans('user.name_placeholder')
                                ]) }}
                                @error('name')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12 form-group">
                                {!! Form::label('email', trans('user.email')) !!}
                                {{ Form::text('email', null, ['class' => ($errors->has('email') ? 'is-invalid' : '') . ' form-control',
                                    'wire:model' => 'email',
                                    'placeholder' => trans('user.email_placeholder')
                                ]) }}
                                @error('email')
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
                            <i class="fa fa-user-secret"></i> {{ trans('user.auth') }}
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($showPassword)
                        <div class="row">
                            <div class="col-12 form-group">
                                {!! Form::label('password', trans('user.password')) !!}
                                {{ Form::password('password', ['class' => ($errors->has('password') ? 'is-invalid' : '') . ' form-control',
                                    'wire:model' => 'password',
                                    'placeholder' => trans('user.password_placeholder')
                                ]) }}
                                @error('password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12 form-group">
                                {!! Form::label('password_confirmation', trans('user.password_confirmation')) !!}
                                {{ Form::password('password_confirmation', ['class' => ($errors->has('password_confirmation') ? 'is-invalid' : '') . ' form-control',
                                    'wire:model' => 'password_confirmation',
                                    'placeholder' => trans('user.password_confirmation_placeholder')
                                ]) }}
                                @error('password_confirmation')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if ($user)
                            <div class="col-md-12">
                                <button type="button" class="btn btn-outline-danger" wire:click="$set('showPassword', false)">
                                    {{ trans('user.cancel') }}
                                </button>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-outline-info" wire:click="$set('showPassword', true)">
                                    {{ trans('user.new_password') }}
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card card-default">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa fa-user-tie"></i> {{ trans('user.roles') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 form-group" wire:ignore>
                                {!! Form::label('roles', trans('user.roles')) !!}
                                {{ Form::select('roles[]',
                                    $allRoles, null, [
                                    'placeholder' => 'Select...', 'class' => ($errors->has('roles') ? 'is-invalid' : '') . ' select2 form-control',
                                    'wire:model' => 'roles',
                                    'multiple' => true,
                                ]) }}
                                @error('roles')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <x-admin.form.submit-button :entity="$user ?? false" />
            </div>
        </div>
    {!! Form::close() !!}
</div>

@push('page-scripts')
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Select Option'
        });

        $('.select2').change(function (e) {
            @this.set('roles', $(this).val());
        });
    });
</script>
@endpush
