<div>
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{ $activeCategory->category_image_url }}"
                        style="background-image:url('{{ $activeCategory->category_image_url }}')">
                        <h2>{{ $activeCategory->name }}</h2>
                        <a href="{{ route('shop.index') }}">{{ trans('public-basic.discover_more') }}</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="filter-control">
                        <ul>
                            @foreach ($productCategories as $item)
                            <li wire:click="setActiveCategory({{ $item->id }})" class="{{ $item->id != $activeCategory->id ?: 'active' }}">{{ $item->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel">
                        @forelse ($activeCategoryProducts as $product)
                            @livewire('frontend.single-product-item', compact('product'), key(time() . $product->id))
                        @empty
                            <div class="text-center">{{ trans('table-messages.no-products-found') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('page-scripts')
<script>
    function initProductSlider() {
        var el = $(".product-slider");
        el.owlCarousel('destroy');
        el.owlCarousel({
            loop: false,
            margin: 25,
            nav: true,
            items: 4,
            dots: true,
            navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
            smartSpeed: 1200,
            autoHeight: false,
            autoplay: true,
            responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1200: {
                    items: 3,
                }
            }
        });
    }

    document.addEventListener('reloadProductSlider', function (event) {
        initProductSlider();
    });

    document.addEventListener('livewire:load', function (event) {
        initProductSlider();
    });
</script>
@endpush
