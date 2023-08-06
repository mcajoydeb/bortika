@extends('public.layouts.master-public-layout')

@section('page-title')
{{ trans('public-basic.blog_details') }}
@endsection

@section('content')
<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> {{ trans('public-basic.home') }}</a>
                    <a href="{{ route('blog.index') }}"> {{ trans('public-basic.blog') }}</a>
                    <span>{{ $post->post_title }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog-details-inner">
                    <div class="blog-detail-title">
                        <h2>{!! $post->post_title !!}</h2>
                        <p>{{ $post->category_names }} <span>- {{ $post->formattedCreatedAt() }}</span></p>
                    </div>
                    <div class="blog-large-pic">
                        <img src="{{ $post->featured_image_url }}" alt="image">
                    </div>
                    <div class="blog-detail-desc">
                        <p>{!! $post->post_content !!}</p>
                    </div>
                    <div class="tag-share">
                        <div class="details-tag">
                            <ul>
                                <li><i class="fa fa-tags"></i></li>
                                <li>{{ $post->category_names }}</li>
                            </ul>
                        </div>
                        <div class="blog-share">
                            <span>{{ trans('public-basic.share') }}:</span>
                            <div class="social-links">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="blog-post">
                        <div class="row">
                            <div class="col-lg-5 col-md-6">
                                <a href="#" class="prev-blog">
                                    <div class="pb-pic">
                                        <i class="ti-arrow-left"></i>
                                        <img src="{{ asset('public-assets/img/blog/prev-blog.png') }}" alt="">
                                    </div>
                                    <div class="pb-text">
                                        <span>Previous Post:</span>
                                        <h5>The Personality Trait That Makes People Happier</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-5 offset-lg-2 col-md-6">
                                <a href="#" class="next-blog">
                                    <div class="nb-pic">
                                        <img src="{{ asset('public-assets/img/blog/next-blog.png') }}" alt="">
                                        <i class="ti-arrow-right"></i>
                                    </div>
                                    <div class="nb-text">
                                        <span>Next Post:</span>
                                        <h5>The Personality Trait That Makes People Happier</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="posted-by">
                        <div class="pb-pic">
                            <img src="{{ asset('public-assets/img/blog/post-by.png') }}" alt="">
                        </div>
                        <div class="pb-text">
                            <a href="#">
                                <h5>{{ $post->author->name }}</h5>
                            </a>
                            <p>{{ 'Author bio goes here...' }}</p>
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
</section>
<!-- Blog Details Section End -->

@endsection
