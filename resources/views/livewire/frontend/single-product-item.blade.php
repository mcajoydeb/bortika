<div>
    <div class="product-item">
        <div class="pi-pic">
            <img src="{{ $product->thumbnail_url }}" alt="image">
            @if ($product->isOnSale())
            <div class="sale">{{ trans('public-basic.sale') }}</div>
            @endif
            <div class="icon">
                <i class="icon_heart_alt"></i>
            </div>
            <ul>
                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                <li class="quick-view"><a href="#">+ Quick View</a></li>
                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
            </ul>
        </div>
        <div class="pi-text">
            <a href="{{ route('product.show', $product->slug) }}">
                <h5>{{ $product->title }}</h5>
            </a>
            <div class="product-price">
                {{ $product->formatted_price }}
                @if ($product->isOnSale())
                <span>{{ $product->formatted_regular_price }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
