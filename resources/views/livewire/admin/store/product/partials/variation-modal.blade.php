<div class="modal fade" id="variation-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('product.variations') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @livewire('admin.store.product.variation.form', [
                    'variations' => $variations
                ])
            </div>
        </div>
    </div>
</div>
