<div>
    <x-frontend.partials.loader />

    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h4 class="fw-title">{{ trans('menu.categories') }}</h4>
                        @livewire('utilities.category-tree', [
                            'type' => config('term-types.product_category'),
                            'parentId' => 0,
                            'selectedItems' => $selectedCategories
                        ], key(time()))

                        {!! Form::hidden('selectedCategories[]', null, [
                            'wire:model' => 'selectedCategories'
                        ]) !!}

                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">{{ trans('menu.brands') }}</h4>
                        <div class="fw-brand-check">
                        @foreach ($brands as $item)
                            <div class="bc-item">
                                <label for="brand-{{ $item->id }}">
                                    {{ $item->name }}
                                    <input type="checkbox" id="brand-{{ $item->id }}" value="{{ $item->id }}" wire:model="selectedTerms">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">{{ trans('product.price') }}</h4>
                        <div class="filter-range-wrap">
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="33" data-max="98">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>
                        </div>
                        {{-- <a href="#" class="filter-btn">Filter</a> --}}
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">{{ trans('menu.colors') }}</h4>
                        <div class="tag-checkbox color-tags">
                            @foreach ($colors as $item)
                            <div wire:click="toggleTerms('{{ $item->id }}')" class="cs-item {{ in_array($item->id, $selectedTerms) ? 'active' : '' }}">
                                <input type="checkbox" id="cs-{{ $item->id }}" value="{{ $item->id }}">
                                <span class="color-box" style="background: {{ $item->getExtraValueByKey('_color_code') }}"></span>
                                <label for="cs-{{ $item->id }}">{{ $item->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">{{ trans('menu.sizes') }}</h4>
                        <div class="tag-checkbox">
                            @foreach ($sizes as $item)
                            <div wire:click="toggleTerms('{{ $item->id }}')" class="cs-item {{ in_array($item->id, $selectedTerms) ? 'active' : '' }}">
                                <input type="checkbox" id="cs-{{ $item->id }}" value="{{ $item->id }}">
                                <label for="cs-{{ $item->id }}">{{ $item->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">{{ trans('menu.tags') }}</h4>
                        <div class="tag-checkbox">
                            @foreach ($tags as $item)
                            <div wire:click="toggleTerms('{{ $item->id }}')" class="cs-item {{ in_array($item->id, $selectedTerms) ? 'active' : '' }}">
                                <input type="checkbox" id="cs-{{ $item->id }}" value="{{ $item->id }}">
                                <label for="cs-{{ $item->id }}">{{ $item->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                {{ Form::select('sorting', \App\Services\SelectInputArrayHelperService::getFormattedArrayForSelectInput(config('product-sorting-options')),
                                    null,
                                    [
                                        'class' => 'form-control',
                                        'wire:model' => 'sorting',
                                        'style' => 'width:250px'
                                    ]
                                ) }}

                                <div class="select-option">
                                    {{-- <select class="p-show">
                                        <option value="">Show:</option>
                                    </select> --}}
                                </div>
                            </div>
                            {{-- <div class="col-lg-5 col-md-5 text-right">
                                <p>Show 01- 09 Of 36 Product</p>
                            </div> --}}
                        </div>
                    </div>
                    <div class="product-list">
                        <div class="row">
                            @forelse ($products as $product)
                            <div class="col-lg-4 col-sm-6">
                                @livewire('frontend.single-product-item', compact('product'), key(time() . $product->id))
                            </div>
                            @empty
                            <div class="col-md-12 text-center">
                                {{ trans('table-messages.no-records-found') }}
                            </div>
                            @endforelse
                            <div class="col-lg-12">
                                <div class="d-flex flex-row-reverse">
                                    {{ $products->appends(request()->input())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="loading-more">
                        <i class="icon_loading"></i>
                        <a href="#">
                            {{ trans('public-basic.load_more') }}
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
</div>

@push('page-scripts')
<script>
    /* $(function () {
        $('.tag-checkbox input').change(function (e) {
            e.preventDefault();
            console.log($(this).val());

        });
    }); */
</script>
@endpush
