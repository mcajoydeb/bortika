<div>
    @if ($message)
    <div class="row form-group">
        <div class="col-md-12 alert alert-{{ $type }}">
            {{ $message }}
        </div>
    </div>
    @endif
</div>
