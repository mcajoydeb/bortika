<div>
    <div class="card card-default">
        <div class="card-header">
            <div class="card-title">
                <i class="fa fa-th-large"></i>
                {{ trans('menu.categories') }}
            </div>
            <div class="card-tools">
                <div class="row">
                    <div class="col-md-12 text-right">
                        @if (!$editMode)
                            <button type="button" class="btn btn-outline-primary btn-sm" wire:click="$set('editMode', true)">
                                <i class="fa fa-plus"></i> {{ trans('form-actions.add') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($editMode)
                <div class="input-group mt-2">
                    {{ Form::text('categoryName', $categoryName,
                        ['class' => ($errors->has('categoryName') ? 'is-invalid' : '') . ' form-control',
                        'placeholder' => trans('form.name'),
                        'wire:model' => 'categoryName'
                    ]) }}
                    <div class="input-group-append">
                        <button type="button" wire:click="add()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                @error('categoryName')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="text-right">
                    <button type="button" class="btn btn-outline-danger btn-sm mt-2" wire:click="$set('editMode', false)">
                        <i class="fa fa-times"></i> {{ trans('form-actions.cancel') }}
                    </button>
                </div>
            @else
                <div class="responsive category-card-content">
                    @if (count($treewiseCategories))
                        <ul class="list-style-none pl-3">
                            @foreach ($treewiseCategories as $data)
                                <x-admin.category.treewise-category :type="$type" :input-name="$inputName" :category-details="$data" :selected-categories="$selectedCategories" />
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
