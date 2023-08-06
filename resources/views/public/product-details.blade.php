@extends('public.layouts.master-public-layout')

@section('page-title')
{{ trans('public-basic.product_details') }}
@endsection

@push('page-styles')
    <style>
        .color-tags { padding-top: 6px; }
    </style>
@endpush

@section('content')
<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> {{ trans('public-basic.home') }}</a>
                    <a href="{{ route('shop.index') }}"> {{ trans('public-basic.shop') }}</a>
                    <span>{{ $product->title }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Product Shop Section Begin -->
<section class="product-shop spad page-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-pic-zoom">
                            <img class="product-big-img" src="{{ $product->thumbnail_url }}" alt="">
                            <div class="zoom-icon">
                                <i class="fa fa-search-plus"></i>
                            </div>
                        </div>
                        @if (! empty($product->gallery_images))
                        <div class="product-thumbs">
                            <div class="product-thumbs-track ps-slider owl-carousel">
                                <div class="pt active" data-imgbigurl="{{ $product->thumbnail_url }}">
                                    <img src="{{ $product->thumbnail_url }}" alt="image">
                                </div>
                                @foreach ($product->gallery_images as $media)
                                <div class="pt" data-imgbigurl="{{ $media->asset_url }}">
                                    <img src="{{ $media->asset_url }}" alt="image">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <div class="product-details">
                            <div class="pd-title">
                                <h3>{{ $product->title }}</h3>
                                <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                            </div>
                            <div class="pd-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <span>(5)</span>
                            </div>
                            <div class="pd-desc">
                                {{-- <p>Lorem ipsum dolor sit amet, consectetur ing elit, sed do eiusmod tempor sum dolor
                                    sit amet, consectetur adipisicing elit, sed do mod tempor</p> --}}
                                <h4>
                                    {{ $product->formatted_price }}
                                    @if ($product->isOnSale())
                                        <span> {{ $product->formatted_regular_price}} </span>
                                    @endif
                                </h4>
                            </div>
                            @if ($product->hasColors())
                            <div class="pd-color d-flex align-items-center">
                                <h6>{{ trans('menu.colors') }}</h6>
                                <div class="tag-checkbox color-tags">
                                    @foreach ($product->colors() as $item)
                                    <div class="cs-item">
                                        <input type="checkbox" id="cs-{{ $item->id }}" value="{{ $item->id }}">
                                        <span class="color-box" style="background: {{ $item->getExtraValueByKey('_color_code') }}"></span>
                                        <label for="cs-{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($product->hasSizes())
                            <div class="pd-size-choose">
                                <div class="tag-checkbox">
                                    @foreach ($product->sizes() as $item)
                                    <div class="cs-item">
                                        <input type="checkbox" id="cs-{{ $item->id }}" value="{{ $item->id }}">
                                        <label for="cs-{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                                <a href="#" class="primary-btn pd-cart">Add To Cart</a>
                            </div>
                            <ul class="pd-tags">
                                <li><span>{{ trans('menu.categories') }}</span>: {{ $product->getCategoriesAsString() }}</li>
                                <li><span>{{ trans('menu.tags') }}</span>: {{ $product->getTagsAsString() }}</li>
                            </ul>
                            <div class="pd-share">
                                @if (! empty($product->sku))
                                <div class="p-code">{{ trans('product.sku') }} : {{ $product->sku }}</div>
                                @endif
                                <div class="pd-social">
                                    <a href="#"><i class="ti-facebook"></i></a>
                                    <a href="#"><i class="ti-twitter-alt"></i></a>
                                    <a href="#"><i class="ti-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-tab">
                    <div class="tab-item">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#tab-1" role="tab">{{ trans('public-basic.description') }}</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-2" role="tab">{{ trans('product.features') }}</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-3" role="tab">{{ trans('public-basic.reviews') }} (2)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-item-content">
                        <div class="tab-content">
                            <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                <div class="product-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            {!! $product->content !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                <div class="specification-table">
                                    {!! $product->getExtraByKeyName('_features') !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                <div class="customer-review-option">
                                    <h4>2 Comments</h4>
                                    <div class="comment-option">
                                        <div class="co-item">
                                            <div class="avatar-pic">
                                                <img src="{{ asset('public-assets/img/product-single/avatar-1.png') }}" alt="">
                                            </div>
                                            <div class="avatar-text">
                                                <div class="at-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <h5>Brandon Kelley <span>27 Aug 2019</span></h5>
                                                <div class="at-reply">Nice !</div>
                                            </div>
                                        </div>
                                        <div class="co-item">
                                            <div class="avatar-pic">
                                                <img src="{{ asset('public-assets/img/product-single/avatar-2.png') }}" alt="">
                                            </div>
                                            <div class="avatar-text">
                                                <div class="at-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <h5>Roy Banks <span>27 Aug 2019</span></h5>
                                                <div class="at-reply">Nice !</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="personal-rating">
                                        <h6>Your Rating</h6>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                    </div>
                                    <div class="leave-comment">
                                        <h4>Leave A Comment</h4>
                                        <form action="#" class="comment-form">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="text" placeholder="Name">
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" placeholder="Email">
                                                </div>
                                                <div class="col-lg-12">
                                                    <textarea placeholder="Messages"></textarea>
                                                    <button type="submit" class="site-btn">Send message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Shop Section End -->

{{-- <!-- Related Products Section End -->
<div class="related-products spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="{{ asset('public-assets/img/products/women-1.jpg"') }} alt="">
                        <div class="sale">Sale</div>
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
                        <div class="catagory-name">Coat</div>
                        <a href="#">
                            <h5>Pure Pineapple</h5>
                        </a>
                        <div class="product-price">
                            $14.00
                            <span>$35.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="{{ asset('public-assets/img/products/women-2.jpg"') }} alt="">
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
                        <div class="catagory-name">Shoes</div>
                        <a href="#">
                            <h5>Guangzhou sweater</h5>
                        </a>
                        <div class="product-price">
                            $13.00
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="{{ asset('public-assets/img/products/women-3.jpg"') }} alt="">
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
                        <div class="catagory-name">Towel</div>
                        <a href="#">
                            <h5>Pure Pineapple</h5>
                        </a>
                        <div class="product-price">
                            $34.00
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="{{ asset('public-assets/img/products/women-4.jpg"') }} alt="">
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
                        <div class="catagory-name">Towel</div>
                        <a href="#">
                            <h5>Converse Shoes</h5>
                        </a>
                        <div class="product-price">
                            $34.00
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Related Products Section End --> --}}

@endsection
