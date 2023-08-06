<!-- Header Section Begin -->
<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="ht-left">
                <div class="mail-service">
                    <i class=" fa fa-envelope"></i>
                    {{ config('public-basic.home_email') }}
                </div>
                <div class="phone-service">
                    <i class=" fa fa-phone"></i>
                    {{ config('public-basic.home_phone') }}
                </div>
            </div>
            <div class="ht-right">
                @guest
                <a href="{{ route('public.login') }}" class="login-panel"><i class="fa fa-user"></i>{{ trans('public-basic.login') }}</a>
                @else
                <a href="#" class="login-panel"><i class="fa fa-user"></i>{{ trans('public-basic.account') }}</a>
                @endguest

                <div class="lan-selector">
                    <select class="language_drop" name="set-locale" id="set-locale" style="width:300px;">
                        <option value='en' {{ Cookie::get('locale') == 'en' ? 'selected' : '' }}
                            data-href="{{ route('locale.set', 'en') }}"  data-title="English">English</option>
                        <option value='bn' {{ Cookie::get('locale') == 'bn' ? 'selected' : '' }}
                            data-href="{{ route('locale.set', 'bn') }}" data-title="Bangla">বাংলা</option>
                    </select>
                </div>
                <div class="top-social">
                    <a href="#"><i class="ti-facebook"></i></a>
                    <a href="#"><i class="ti-twitter-alt"></i></a>
                    <a href="#"><i class="ti-linkedin"></i></a>
                    <a href="#"><i class="ti-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="inner-header">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('public-assets/img/logo-placeholder.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="advanced-search">
                        <button type="button" class="category-btn">{{ trans('menu.all') . ' ' . trans('menu.categories') }}</button>
                        <div class="input-group">
                            <input type="text" placeholder="What do you need?">
                            <button type="button"><i class="ti-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 text-right col-md-3">
                    <ul class="nav-right">
                        <li class="heart-icon">
                            <a href="#">
                                <i class="icon_heart_alt"></i>
                                {{-- <span>1</span> --}}
                            </a>
                        </li>
                        <li class="cart-icon">
                            <a href="#">
                                <i class="icon_bag_alt"></i>
                                {{-- <span>3</span> --}}
                            </a>
                                {{-- <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="si-pic"><img src="{{ asset('public-assets/img/select-product-1.jpg') }}" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>$60.00 x 1</p>
                                                            <h6>Kabino Bedside Table</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i class="ti-close"></i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="si-pic"><img src="{{ asset('public-assets/img/select-product-2.jpg') }}" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>$60.00 x 1</p>
                                                            <h6>Kabino Bedside Table</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i class="ti-close"></i>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>total:</span>
                                        <h5>$120.00</h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="#" class="primary-btn view-card">VIEW CARD</a>
                                        <a href="#" class="primary-btn checkout-btn">CHECK OUT</a>
                                    </div>
                                </div> --}}
                        </li>
                        {{-- <li class="cart-price">$150.00</li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-item">
        <div class="container">
            {{-- <div class="nav-depart">
                <div class="depart-btn">
                    <i class="ti-menu"></i>
                    <span>{{ trans('menu.categories') }}</span>
                    <ul class="depart-hover">
                        @foreach ($publicSharedData['productParentCategories'] as $item)
                        <li class=""><a href="{{ route('shop.index') }}?category={{ $item->slug }}">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div> --}}
            <nav class="nav-menu mobile-menu">
                <ul>
                    <li class="{{ \App\Services\NavigationService::activeRouteName('home') ? 'active' : '' }}"><a href="{{ route('home') }}">{{ trans('public-basic.home') }}</a></li>
                    {{-- <li><a href="./shop.html">Shop</a></li>
                    <li><a href="#">Collection</a>
                        <ul class="dropdown">
                            <li><a href="#">Men's</a></li>
                            <li><a href="#">Women's</a></li>
                            <li><a href="#">Kid's</a></li>
                        </ul>
                    </li> --}}
                    <li class="{{ \App\Services\NavigationService::activeRoutePattern('*shop*') ? 'active' : '' }}"><a href="{{ route('shop.index') }}">{{ trans('public-basic.shop') }}</a></li>
                    <li class="{{ \App\Services\NavigationService::activeRoutePattern('*blog*') ? 'active' : '' }}"><a href="{{ route('blog.index') }}">{{ trans('public-basic.blog') }}</a></li>
                    <li><a href="#">{{ trans('public-basic.contact') }}</a></li>
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
        </div>
    </div>
</header>
<!-- Header End -->

@push('page-scripts')
    <script>
        $(function () {
            $('[name="set-locale"]').change(function(e) {
                e.preventDefault();
                var langCode = $(this).val();
                var href = $(this).find('option[value=' + langCode + ']').data('href');
                window.location.replace(href);
            });
        });
    </script>
@endpush
