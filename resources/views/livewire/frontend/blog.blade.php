<div>
    <x-frontend.partials.loader />

    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1">
                    <div class="blog-sidebar">
                        <div class="search-form">
                            <h4>{{ trans('public-basic.search') }}</h4>
                            <form action="#" wire:submit.prevent="searchPost">
                                <input type="text" wire:model="search"
                                    placeholder="{{ trans('public-basic.search') }} . . .  ">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="blog-catagory">
                            <h4>{{ trans('menu.categories') }}</h4>
                            @livewire('utilities.category-tree', [
                                'type' => config('term-types.post_category'),
                                'parentId' => 0,
                                'selectedItems' => $selectedItems
                            ])
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="row">
                        @forelse ($posts as $post)
                        <div class="col-lg-6 col-sm-6">
                            <div class="blog-item">
                                <div class="bi-pic">
                                    <img src="{{ $post->featured_image_thumbnail_url }}" alt="image">
                                </div>
                                <div class="bi-text">
                                    <a href="{{ route('blog.show', $post->post_slug) }}">
                                        <h4>{!! Str::limit($post->post_title, 50, '...') !!}</h4>
                                    </a>
                                    <p class="mb-3">{{ $post->category_names }} <span>-
                                        {{ $post->formattedCreatedAt() }}</span></p>
                                </div>
                                <div>{!! Str::limit($post->post_content, 100, '...') !!}</div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12 text-center">
                            {{ trans('table-messages.no-records-found') }}
                        </div>
                        @endforelse
                        <div class="col-lg-12">
                            <div class="d-flex flex-row-reverse">
                                {{ $posts->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
