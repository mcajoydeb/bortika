<div>

    {!! Form::hidden('variation_id', $variationId, ['wire:model' => 'variationId']) !!}

    <div class="row form-group">
        @forelse (\App\Services\ProductAttributeService::getProductAttributes() as $key => $attribute)
        <div class="col-md-4 form-group">
            {!! Form::label('_attributes', $attribute['attribute']->name) !!}
            {{ Form::select('_attributes[]',
                ['' => 'Select Option'] + $attribute['values'], null,
                ['class' => ($errors->has('_attributes') ? 'is-invalid' : '') . ' form-control',
                'wire:model' => '_attributes.' . $key, ]) }}
        </div>
        @empty
        <div class="col-md-12 text-center">
            {{ trans('table-messages.no-records-found') }}
        </div>
        @endforelse
        @error('_attributes')
        <div class="col-12">
            <div class="text-danger">
                {{ $message }}
            </div>
        </div>
        @enderror
    </div>
    <div class="row form-group">
        <div class="col-md-12 form-group">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-edit"></i> {{ trans('form.basic_details') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            {!! Form::label('variation_title', trans('form.title')) !!}
                            {{ Form::text('variation_title', null, ['class' => ($errors->has('variation_title') ? 'is-invalid' : '') . ' form-control', 'wire:model.debounce.500ms' => 'variation_title']) }}
                            @error('variation_title')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 form-group">
                            {!! Form::label('variation_slug', trans('form.slug')) !!}
                            {{ Form::text('variation_slug', null, ['class' => ($errors->has('variation_slug') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_slug']) }}
                            @error('variation_slug')
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
                        <i class="fa fa-edit"></i> {{ trans('form.content') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group" wire:ignore>
                        {!! Form::label('variation_content', trans('form.content')) !!}
                        {{ Form::textarea('variation_content', null, ['class' => ($errors->has('variation_content') ? 'is-invalid' : '') . ' texteditor form-control', 'wire:model' => 'variation_content']) }}
                        <div class="text-right text-muted">
                            {{ trans('form-actions.char_count') }}:
                            <span class="variation-content-count">
                                {{ Str::length($variation_content) }}
                            </span>
                        </div>
                        @error('variation_content')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-globe"></i> {{ trans('product._minimum_purchase_qty') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group">
                        {!! Form::label('variation_minimum_purchase_qty', trans('product._minimum_purchase_qty')) !!}
                        {{ Form::text('variation_minimum_purchase_qty', null, ['class' => ($errors->has('variation_minimum_purchase_qty') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_minimum_purchase_qty']) }}
                        @error('variation_minimum_purchase_qty')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-image"></i> {{ trans('form.thumbnail') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group">
                        {!! Form::label('thumbnail', trans('form.thumbnail')) !!}
                        <div>
                            @livewire('admin.utilities.choose-media', [
                                'inputName' => 'variation_image_id',
                                'inputValue' => $variation_image_id,
                            ], key(time()))
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-credit-card"></i> {{ trans('product.pricing') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            {!! Form::label('variation_sku', trans('product.sku')) !!}
                            {{ Form::text('variation_sku', null, ['class' => ($errors->has('variation_sku') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_sku']) }}
                            @error('variation_sku')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            {!! Form::label('variation_regular_price', trans('product.regular_price')) !!}
                            {{ Form::number('variation_regular_price', null, ['class' => ($errors->has('variation_regular_price') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_regular_price']) }}
                            @error('variation_regular_price')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            {!! Form::label('variation_sale_price', trans('product.sale_price')) !!}
                            {{ Form::number('variation_sale_price', null, ['class' => ($errors->has('variation_sale_price') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_sale_price']) }}
                            @error('variation_sale_price')
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
                        <i class="fa fa-th"></i> {{ trans('product.inventory') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {{ Form::checkbox('variation_enable_stock', 1, null, ['class' => ($errors->has('variation_enable_stock') ? 'is-invalid' : '') . ' ', 'wire:model' => 'variation_enable_stock']) }}
                            {!! Form::label('variation_enable_stock', trans('product.enable_stock')) !!}
                            @error('variation_enable_stock')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    @if ($variation_enable_stock)
                    <div class="row">
                        <div class="col-md-12 form-group">
                            {!! Form::label('variation_stock_qty', trans('product.stock_qty')) !!}
                            {{ Form::number('variation_stock_qty', null, ['class' => ($errors->has('variation_stock_qty') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_stock_qty']) }}
                            @error('variation_stock_qty')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            {!! Form::label('variation_back_to_order_status', trans('product.back_to_order_status')) !!}
                            {{ Form::select('variation_back_to_order_status', \App\Services\SelectInputArrayHelperService::getBackToOrderStatus(), null,
                                ['class' => ($errors->has('variation_back_to_order_status') ? 'is-invalid' : '') . ' form-control select2', 'wire:model' => 'variation_back_to_order_status']) }}
                            @error('variation_back_to_order_status')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12 form-group">
                            {!! Form::label('variation_stock_availability', trans('product.stock_availability')) !!}
                            {{ Form::select('variation_stock_availability', \App\Services\SelectInputArrayHelperService::getStockAvailabilityStatus(), null,
                                ['class' => ($errors->has('variation_stock_availability') ? 'is-invalid' : '') . ' form-control select2', 'wire:model' => 'variation_stock_availability']) }}
                            @error('variation_stock_availability')
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
                        <i class="fa fa-edit"></i> {{ trans('form.seo_settings') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="seo-preview-content">
                        <h3>{!! $variation_seo_title ? $variation_seo_title : trans('post.title_example') !!}</h3>
                        <p class="link">
                            {{ url('/') . '/product/' . ($variation_seo_slug ? $variation_seo_slug : 'page-title') }}
                        </p>
                        <p class="description">{!! $variation_seo_meta_description ? $variation_seo_meta_description :
                            trans('post.description_example') !!}</p>
                    </div>
                    <div class="seo-content">
                        <div class="form-group">
                            {{ Form::text('variation_seo_title', null,
                                ['class' => ($errors->has('variation_seo_title') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_seo_title',
                                'placeholder' => trans('post.title_example')]) }}

                            @error('variation_seo_title')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::text('variation_seo_slug', null,
                                ['class' => ($errors->has('variation_seo_slug') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_seo_slug',
                                'placeholder' => trans('post.url_example')]) }}

                            @error('variation_seo_slug')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::textarea('variation_seo_meta_description', null,
                                ['class' => ($errors->has('variation_seo_meta_description') ? 'is-invalid' : '') . ' form-control', 'wire:model.debounce.500ms' => 'variation_seo_meta_description', 'rows' => 3,
                                'placeholder' => trans('post.description_example')]) }}

                            @error('variation_seo_meta_description')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::textarea('variation_seo_meta_keywords', null,
                                ['class' => ($errors->has('variation_seo_meta_keywords') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_seo_meta_keywords', 'rows' => 3,
                                'placeholder' => trans('post.keywords_example')]) }}

                            @error('variation_seo_meta_keywords')
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
                        <i class="fa fa-star-half-full"></i>
                        {{ trans('product.product_reviews_settings') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {{ Form::checkbox('variation_enable_reviews', 1, null, ['class' => ($errors->has('variation_enable_reviews') ? 'is-invalid' : '') . ' ', 'wire:model' => 'variation_enable_reviews']) }}
                            {!! Form::label('variation_enable_reviews', trans('product.enable_reviews')) !!}
                            @error('variation_enable_reviews')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            {{ Form::checkbox('variation_enable_add_review_to_product_page', 1, null, ['class' => ($errors->has('variation_enable_add_review_to_product_page') ? 'is-invalid' : '') . ' ', 'wire:model' => 'variation_enable_add_review_to_product_page']) }}
                            {!! Form::label('variation_enable_add_review_to_product_page',
                            trans('product.enable_add_review_to_product_page')) !!}
                            @error('variation_enable_add_review_to_product_page')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            {{ Form::checkbox('variation_enable_add_review_to_details_page', 1, null, ['class' => ($errors->has('variation_enable_add_review_to_details_page') ? 'is-invalid' : '') . ' ', 'wire:model' => 'variation_enable_add_review_to_details_page']) }}
                            {!! Form::label('variation_enable_add_review_to_details_page',
                            trans('product.enable_add_review_to_details_page')) !!}
                            @error('variation_enable_add_review_to_details_page')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        {!! Form::label('variation_status', trans('form.status'), ['class' => 'mr-3']) !!}
                        {{ Form::select('variation_status', \App\Services\SelectInputArrayHelperService::getGeneralStatusArray(), null,
                            ['class' => ($errors->has('variation_status') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'variation_status']) }}
                    </div>
                    @error('variation_status')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-12 text-right">
            <div wire:loading.remove>
                <button type="button" class="btn btn-primary" wire:click="addVariation">
                    <i class="fa fa-save"></i> {{ trans('form-actions.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
@push('page-scripts')
<x-admin.form.summernote show-count-class-name="variation-content-count" input-name="variation_content" />
@endpush
