<div>
    @if ($product)
    {!! Form::model($product, ['url' => route('admin.products.update', $product), 'method' => 'PUT', 'files' => true,
    'autocomplete' => 'off']) !!}
    @else
    {!! Form::open(['url' => route('admin.products.store'), 'method' => 'post', 'files' => true, 'autocomplete' =>
    'off']) !!}
    @endif

    {!! Form::hidden('active_tab', $active_tab) !!}

    <div class="row">
        <div class="col-md-9 form-group">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-edit"></i> {{ trans('form.basic_details') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            {!! Form::label('title', trans('form.title')) !!}
                            {{ Form::text('title', $title, ['class' => ($errors->has('title') ? 'is-invalid' : '') . ' form-control', 'wire:model.debounce.500ms' => 'title']) }}
                            @error('title')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 form-group">
                            {!! Form::label('slug', trans('form.slug')) !!}
                            {{ Form::text('slug', $slug, ['class' => ($errors->has('slug') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'slug']) }}
                            @error('slug')
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
                        {!! Form::label('content', trans('form.content')) !!}
                        {{ Form::textarea('content', $content, ['class' => ($errors->has('content') ? 'is-invalid' : '') . ' texteditor form-control', 'wire:model' => 'content']) }}
                        <div class="text-right text-muted">
                            {{ trans('form-actions.char_count') }}:
                            <span class="content-count">
                                {{ $product ? Str::length($content) : 0 }}
                            </span>
                        </div>
                        @error('content')
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
                        <i class="fa fa-edit"></i> {{ trans('product._minimum_purchase_qty') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group">
                        {!! Form::label('_minimum_purchase_qty', trans('product._minimum_purchase_qty')) !!}
                        {{ Form::number('_minimum_purchase_qty', $_minimum_purchase_qty, ['class' => ($errors->has('_minimum_purchase_qty') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_minimum_purchase_qty']) }}
                        @error('_minimum_purchase_qty')
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
                        <i class="fa fa-image"></i> {{ trans('form.media') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group">
                        {!! Form::label('thumbnail', trans('form.thumbnail')) !!}
                        @livewire('admin.utilities.choose-media', [
                            'inputName' => 'image_id',
                            'inputValue' => $image_id,
                        ])
                    </div>
                    <div class="col-12 form-group">
                        <hr>
                    </div>
                    <div class="col-12 form-group">
                        {!! Form::label('media', trans('product.gallery_image')) !!}
                        @livewire('admin.utilities.choose-media', [
                            'inputName' => '_gallery_image_ids',
                            'inputValue' => $_gallery_image_ids,
                            'multiple' => true,
                        ])
                    </div>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-edit"></i> {{ trans('product.type') }}
                    </div>
                    <div class="card-tools">
                        <div class="d-flex align-items-center">
                            {{ Form::select('type', \App\Services\SelectInputArrayHelperService::getProductTypeArray(), null,
                                ['class' => ($errors->has('type') ? 'is-invalid' : '') . ' form-control ', 'wire:model' => 'type']) }}
                        </div>
                        @error('type')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        @if (\App\Services\ProductTabVisibilityService::showGeneral($type))
                        <li class="nav-item general">
                            <a class="nav-link {{ $active_tab == 'general' || is_null($active_tab) ? 'active' : '' }}" wire:click="$set('active_tab', 'general')" href="#tab_general" data-toggle="tab">
                            {!! trans('product.general') !!}
                            </a>
                        </li>
                        @endif
                        @if (\App\Services\ProductTabVisibilityService::showInventory($type))
                        <li class="nav-item inventory">
                            <a class="nav-link {{ $active_tab == 'inventory' ? 'active' : '' }}" wire:click="$set('active_tab', 'inventory')" href="#tab_stock" data-toggle="tab">
                            {!! trans('product.inventory') !!}
                            </a>
                        </li>
                        @endif
                        @if (\App\Services\ProductTabVisibilityService::showFeature($type))
                        <li class="nav-item features">
                            <a class="nav-link {{ $active_tab == 'features' ? 'active' : '' }}" wire:click="$set('active_tab', 'features')" href="#tab_features" data-toggle="tab">
                            {!! trans('product.features') !!}
                            </a>
                        </li>
                        @endif
                        @if (\App\Services\ProductTabVisibilityService::showAdvance($type))
                        <li class="nav-item advanced">
                            <a class="nav-link {{ $active_tab == 'advanced' ? 'active' : '' }}" wire:click="$set('active_tab', 'advanced')" href="#tab_advanced" data-toggle="tab">
                            {!! trans('product.advanced') !!}
                            </a>
                        </li>
                        @endif
                        @if (\App\Services\ProductTabVisibilityService::showVariations($type))
                        <li class="nav-item variations">
                            <a class="nav-link {{ $active_tab == 'variations' ? 'active' : '' }}" wire:click="$set('active_tab', 'variations')" href="#tab_variations" data-toggle="tab">
                                {!! trans('product.variations') !!}
                            </a>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-general tab-pane fade {{ $active_tab == 'general' || is_null($active_tab) ? 'show active' : '' }}" id="tab_general">
                            <div class="row">
                                <div class="col-12 form-group">
                                    {!! Form::label('sku', trans('product.sku')) !!}
                                    {{ Form::text('sku', $sku, ['class' => ($errors->has('sku') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'sku']) }}
                                    @error('sku')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 form-group">
                                    {!! Form::label('regular_price', trans('product.regular_price')) !!}
                                    {{ Form::number('regular_price', $regular_price, ['class' => ($errors->has('regular_price') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'regular_price']) }}
                                    @error('regular_price')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 form-group">
                                    {!! Form::label('sale_price', trans('product.sale_price')) !!}
                                    {{ Form::number('sale_price', $sale_price, ['class' => ($errors->has('sale_price') ? 'is-invalid' : '') . ' form-control',
                                        'wire:model' => 'sale_price', 'placeholder' => trans('product.sale_price_placeholder')]) }}
                                    @error('sale_price')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    {{ Form::checkbox('_allow_scheduled_price', 1, null, ['class' => ($errors->has('_allow_scheduled_price') ? 'is-invalid' : '') . ' ', 'wire:model' => '_allow_scheduled_price']) }}
                                    {!! Form::label('_allow_scheduled_price', trans('product.allow_scheduled_price')) !!}
                                    @error('_allow_scheduled_price')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            @if ($_allow_scheduled_price)
                            <div class="row">
                                <div class="col-12 form-group">
                                    {!! Form::label('_sale_start_datetime', trans('product.sale_start_datetime')) !!}
                                    {{ Form::date('_sale_start_datetime', $_sale_start_datetime,
                                        ['class' => ($errors->has('_sale_start_datetime') ? 'is-invalid' : '') . ' form-control',
                                        'wire:model' => '_sale_start_datetime',
                                        'id' => '_sale_start_datetime']) }}
                                    @error('_sale_start_datetime')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 form-group">
                                    {!! Form::label('_sale_end_datetime', trans('product.sale_end_datetime')) !!}
                                    {{ Form::date('_sale_end_datetime', $_sale_end_datetime,
                                        ['class' => ($errors->has('_sale_end_datetime') ? 'is-invalid' : '') . ' form-control',
                                        'wire:model' => '_sale_end_datetime',
                                        'id' => '_sale_end_datetime']) }}
                                    @error('_sale_end_datetime')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="tab-stock tab-pane fade {{ $active_tab == 'inventory' ? 'show active' : '' }}" id="tab_stock">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    {{ Form::checkbox('_enable_stock', 1, null, ['class' => ($errors->has('_enable_stock') ? 'is-invalid' : '') . ' ', 'wire:model' => '_enable_stock']) }}
                                    {!! Form::label('_enable_stock', trans('product.enable_stock')) !!}
                                    @error('_enable_stock')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div style="display: {{ $_enable_stock ? '' : 'none' }}">
                                <div class="row" wire:ignore>
                                    <div class="col-md-12 form-group">
                                        {!! Form::label('stock_qty', trans('product.stock_qty')) !!}
                                        {{ Form::number('stock_qty', $stock_qty, ['class' => ($errors->has('stock_qty') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'stock_qty']) }}
                                        @error('stock_qty')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row" wire:ignore>
                                    <div class="col-md-12 form-group">
                                        {!! Form::label('_back_to_order_status', trans('product.back_to_order_status')) !!}
                                        {{ Form::select('_back_to_order_status', \App\Services\SelectInputArrayHelperService::getBackToOrderStatus(), null,
                                            ['class' => ($errors->has('_back_to_order_status') ? 'is-invalid' : '') . ' form-control select2', 'wire:model' => '_back_to_order_status']) }}
                                        @error('_back_to_order_status')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row" wire:ignore>
                                <div class="col-md-12 form-group">
                                    {!! Form::label('stock_availability', trans('product.stock_availability')) !!}
                                    {{ Form::select('stock_availability', \App\Services\SelectInputArrayHelperService::getStockAvailabilityStatus(), null,
                                        ['class' => ($errors->has('stock_availability') ? 'is-invalid' : '') . ' form-control select2', 'wire:model' => 'stock_availability']) }}
                                    @error('stock_availability')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="tab-features tab-pane fade {{ $active_tab == 'features' ? 'show active' : '' }}" id="tab_features">
                            <div class="row">
                                <div class="col-12 form-group" wire:ignore>
                                    {!! Form::label('_features', trans('product.features')) !!}
                                    {{ Form::textarea('_features', $_features, ['class' => ($errors->has('_features') ? 'is-invalid' : '') . ' texteditor form-control', 'wire:model' => '_features']) }}
                                    <div class="text-right text-muted">
                                        {{ trans('form-actions.char_count') }}:
                                        <span class="_features-count">
                                            {{ $product ? Str::length($_features) : 0 }}
                                        </span>
                                    </div>
                                    @error('_features')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="tab-advanced tab-pane fade {{ $active_tab == 'advanced' ? 'show active' : '' }}" id="tab_advanced">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    {{ Form::checkbox('_recommended_product', 1, null, ['class' => ($errors->has('_recommended_product') ? 'is-invalid' : '') . ' ', 'wire:model' => '_recommended_product']) }}
                                    {!! Form::label('_recommended_product', trans('product.recommended_product')) !!}
                                    @error('_recommended_product')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    {{ Form::checkbox('_featured_product', 1, null, ['class' => ($errors->has('_featured_product') ? 'is-invalid' : '') . ' ', 'wire:model' => '_featured_product']) }}
                                    {!! Form::label('_featured_product', trans('product.featured_product')) !!}
                                    @error('_featured_product')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    {{ Form::checkbox('_latest_product', 1, null, ['class' => ($errors->has('_latest_product') ? 'is-invalid' : '') . ' ', 'wire:model' => '_latest_product']) }}
                                    {!! Form::label('_latest_product', trans('product.latest_product')) !!}
                                    @error('_latest_product')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    {{ Form::checkbox('_related_product', 1, null, ['class' => ($errors->has('_related_product') ? 'is-invalid' : '') . ' ', 'wire:model' => '_related_product']) }}
                                    {!! Form::label('_related_product', trans('product.related_product')) !!}
                                    @error('_related_product')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    {{ Form::checkbox('_home_page_product', 1, null, ['class' => ($errors->has('_home_page_product') ? 'is-invalid' : '') . ' ', 'wire:model' => '_home_page_product']) }}
                                    {!! Form::label('_home_page_product', trans('product.home_page_product')) !!}
                                    @error('_home_page_product')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="tab-variations tab-pane fade {{ $active_tab == 'variations' ? 'show active' : '' }}" id="tab_variations">
                            <div class="row">
                                <div class="col-md-12 form-group text-right">
                                    <a href="javascript:;" wire:click="openVariationModal" class="btn btn-primary">
                                        {{ trans('menu.add') . ' ' . trans('product.variations') }}
                                    </a>
                                </div>
                            </div>

                            @include('livewire.admin.store.product.partials.variation-modal')

                            @include('livewire.admin.store.product.partials.variation-table', compact('variations'))

                            @foreach ($variations as $variation)
                                {!! Form::hidden('_variations[]', serialize($variation), []) !!}
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-globe"></i> {{ trans('form.seo_settings') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="seo-preview-content">
                        <h3>{!! $_seo_title ? $_seo_title : trans('post.title_example') !!}</h3>
                        <p class="link">
                            {{ url('/') . '/product/' . ($_seo_slug ? $_seo_slug : 'page-title') }}
                        </p>
                        <p class="description">{!! $_seo_meta_description ? $_seo_meta_description : trans('post.description_example') !!}</p>
                    </div>
                    <div class="seo-content">
                        <div class="form-group">
                            {{ Form::text('_seo_title', $_seo_title,
                                ['class' => ($errors->has('_seo_title') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_seo_title',
                                'placeholder' => trans('post.title_example')]) }}

                            @error('_seo_title')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::text('_seo_slug', $_seo_slug,
                                ['class' => ($errors->has('_seo_slug') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_seo_slug',
                                'placeholder' => trans('post.url_example')]) }}

                            @error('_seo_slug')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::textarea('_seo_meta_description', $_seo_meta_description,
                                ['class' => ($errors->has('_seo_meta_description') ? 'is-invalid' : '') . ' form-control', 'wire:model.debounce.500ms' => '_seo_meta_description', 'rows' => 3,
                                'placeholder' => trans('post.description_example')]) }}

                            @error('_seo_meta_description')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            {{ Form::textarea('_seo_meta_keywords', $_seo_meta_keywords,
                                ['class' => ($errors->has('_seo_meta_keywords') ? 'is-invalid' : '') . ' form-control', 'wire:model' => '_seo_meta_keywords', 'rows' => 3,
                                'placeholder' => trans('post.keywords_example')]) }}

                            @error('_seo_meta_keywords')
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
                        <i class="fa fa-comments"></i> {{ trans('product.product_reviews_settings') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {{ Form::checkbox('_enable_reviews', 1, null, ['class' => ($errors->has('_enable_reviews') ? 'is-invalid' : '') . ' ', 'wire:model' => '_enable_reviews']) }}
                            {!! Form::label('_enable_reviews', trans('product.enable_reviews')) !!}
                            @error('_enable_reviews')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            {{ Form::checkbox('_enable_add_review_to_product_page', 1, null, ['class' => ($errors->has('_enable_add_review_to_product_page') ? 'is-invalid' : '') . ' ', 'wire:model' => '_enable_add_review_to_product_page']) }}
                            {!! Form::label('_enable_add_review_to_product_page', trans('product.enable_add_review_to_product_page')) !!}
                            @error('_enable_add_review_to_product_page')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            {{ Form::checkbox('_enable_add_review_to_details_page', 1, null, ['class' => ($errors->has('_enable_add_review_to_details_page') ? 'is-invalid' : '') . ' ', 'wire:model' => '_enable_add_review_to_details_page']) }}
                            {!! Form::label('_enable_add_review_to_details_page', trans('product.enable_add_review_to_details_page')) !!}
                            @error('_enable_add_review_to_details_page')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-3 form-group">
            <div class="card card-default">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        {!! Form::label('status', trans('form.status'), ['class' => 'mr-3']) !!}
                        {{ Form::select('status', \App\Services\SelectInputArrayHelperService::getGeneralStatusArray(), $this->status,
                            ['class' => ($errors->has('status') ? 'is-invalid' : '') . ' form-control', 'wire:model' => 'status']) }}
                    </div>
                    @error('status')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="card-footer text-right">
                    <x-admin.form.submit-button :entity="$product ?? false" />
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-th"></i> {{ trans('menu.brands') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" wire:ignore>
                        <div class="col-md-12 form-group">
                            {{ Form::select('_brand_id', \App\Services\SelectInputArrayHelperService::getBrandsList(), $_brand_id,
                                ['class' => ($errors->has('_brand_id') ? 'is-invalid' : '') . ' form-control select2', 'wire:model' => '_brand_id']) }}
                            @error('_brand_id')
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
                        <i class="fa fa-th"></i> {{ trans('menu.categories') }}
                    </div>
                </div>
                <div class="card-body">
                    @livewire('utilities.category-tree', [
                        'type' => config('term-types.product_category'),
                        'parentId' => 0,
                        'selectedItems' => $_categories
                    ])
                    @foreach ($_categories as $item)
                        {!! Form::hidden('_categories[]', $item,) !!}
                    @endforeach
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-tags"></i> {{ trans('menu.tags') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" wire:ignore>
                        <div class="col-md-12 form-group">
                            {{ Form::select('_tag_ids[]', \App\Services\SelectInputArrayHelperService::getTagsList(), $_tag_ids,
                                ['class' => ($errors->has('_tag_ids') ? 'is-invalid' : '') . ' form-control select2',
                                'wire:model' => '_tag_ids', 'multiple' => true]) }}
                            @error('_tag_ids')
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
                        <i class="fa fa-brush"></i> {{ trans('menu.colors') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" wire:ignore>
                        <div class="col-md-12 form-group">
                            {{ Form::select('_color_ids[]', \App\Services\SelectInputArrayHelperService::getColorsList(), $_color_ids,
                                ['class' => ($errors->has('_color_ids') ? 'is-invalid' : '') . ' form-control select2',
                                'wire:model' => '_color_ids', 'multiple' => true]) }}
                            @error('_color_ids')
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
                        <i class="fa fa-th"></i> {{ trans('menu.sizes') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" wire:ignore>
                        <div class="col-md-12 form-group">
                            {{ Form::select('_size_ids[]', \App\Services\SelectInputArrayHelperService::getSizesList(), $_size_ids,
                                ['class' => ($errors->has('_size_ids') ? 'is-invalid' : '') . ' form-control select2',
                                'wire:model' => '_size_ids', 'multiple' => true]) }}
                            @error('_size_ids')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {!! Form::close() !!}
</div>

@push('page-scripts')
<x-admin.form.summernote show-count-class-name="content-count" input-name="content" />
<x-admin.form.summernote show-count-class-name="_features-count" input-name="_features" />
@endpush
