<div>
    <button type="submit" class="btn btn-primary" {{ count($errors) ? 'disabled' : '' }}>
        @if ($entity)
            <i class="fa fa-save"></i> {{ trans('form-actions.update') }}
        @else
            <i class="fa fa-plus-circle"></i> {{ trans('form-actions.add') }}
        @endif
    </button>
</div>
