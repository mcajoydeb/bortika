<?php

use App\Services\NavigationService;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="{{ route('admin.admin.dashboard') }}" class="brand-link">
		<img src="{{ asset('theme/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
			class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">{{ config('app.name') }}</span>
	</a>

	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ asset('theme/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
					alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">{{ Auth::user()->name }}</a>
			</div>
		</div>

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ NavigationService::activeRouteName('admin.dashboard') }}">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							{{ trans('menu.dashboard') }}
						</p>
					</a>
                </li>

                @can('blog_management')
                <li class="nav-header">
                    {{ trans('menu.manage_cms') }}
                </li>

                <li class="nav-item has-treeview {{ NavigationService::activeRoutePattern('*admin/blog*') == 'active' ? 'menu-open active' : '' }}">
					<a href="#" class="nav-link {{ NavigationService::activeRoutePattern('*admin/blog*') }}">
						<i class="nav-icon fas fa-comment"></i>
						<p>
							{{ trans('menu.blogs') }}
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
                        @can('post_management')
						<li class="nav-item">
							<a href="{{ route('admin.blog.posts.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*blog/posts') }}">
								<i class="fa fa-file nav-icon"></i>
								<p>{{ trans('menu.all') . ' ' . trans('menu.posts') }}</p>
							</a>
						</li>
                        @endcan

                        @can('post_add')
						<li class="nav-item">
							<a href="{{ route('admin.blog.posts.create') }}" class="nav-link {{ NavigationService::activeRoutePattern('*blog/posts/create*') }}">
								<i class="fa fa-plus-circle nav-icon"></i>
								<p>{{ trans('menu.add') . ' ' . trans('menu.post') }}</p>
							</a>
                        </li>
                        @endcan

                        @can('post_category_management')
						<li class="nav-item">
							<a href="{{ route('admin.blog.categories.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*blog/categories') }}">
								<i class="fa fa-th-large nav-icon"></i>
								<p>{{ trans('menu.all') . ' ' . trans('menu.categories') }}</p>
							</a>
						</li>
                        @endcan

                        @can('post_category_add')
						<li class="nav-item">
							<a href="{{ route('admin.blog.categories.create') }}" class="nav-link {{ NavigationService::activeRoutePattern('*blog/categories/create') }}">
								<i class="fa fa-plus-circle nav-icon"></i>
								<p>{{ trans('menu.add') . ' ' . trans('menu.category') }}</p>
							</a>
						</li>
                        @endcan
					</ul>
                </li>
                @endcan

                @can('media_management')
                <li class="nav-header">
                    {{ trans('menu.manage_media') }}
                </li>

                <li class="nav-item has-treeview {{ NavigationService::activeRoutePattern('*admin/manage-media*') == 'active' ? 'menu-open active' : '' }}">
					<a href="#" class="nav-link {{ NavigationService::activeRoutePattern('*admin/manage-media*') }}">
						<i class="nav-icon fas fa-images"></i>
						<p>
							{{ trans('menu.media') }}
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.media.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*manage-media/media') }}">
								<i class="fa fa-images nav-icon"></i>
								<p>{{ trans('menu.all') . ' ' . trans('menu.media') }}</p>
							</a>
						</li>

                        @can('media_add')
						<li class="nav-item">
							<a href="{{ route('admin.media.create') }}" class="nav-link {{ NavigationService::activeRoutePattern('*manage-media/media/create') }}">
								<i class="fa fa-plus-circle nav-icon"></i>
								<p>{{ trans('menu.add') . ' ' . trans('menu.media') }}</p>
							</a>
                        </li>
                        @endcan
					</ul>
                </li>
                @endcan

                @can('user_section_management')
                <li class="nav-header">
                    {{ trans('menu.manage_user') }}
                </li>

                <li class="nav-item has-treeview {{ NavigationService::activeRoutePattern('*admin/manage-user*') == 'active' ? 'menu-open active' : '' }}">
					<a href="#" class="nav-link {{ NavigationService::activeRoutePattern('*admin/manage-user*') }}">
						<i class="nav-icon fas fa-users"></i>
						<p>
							{{ trans('menu.users') }}
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
                        @can('user_management')
						<li class="nav-item">
							<a href="{{ route('admin.user.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*manage-user/user') }}">
								<i class="fa fa-user nav-icon"></i>
								<p>{{ trans('menu.all') . ' ' . trans('menu.users') }}</p>
							</a>
						</li>
                        @endcan
                        @can('user_add')
						<li class="nav-item">
							<a href="{{ route('admin.user.create') }}" class="nav-link {{ NavigationService::activeRoutePattern('*manage-user/user/create') }}">
								<i class="fa fa-plus-circle nav-icon"></i>
								<p>{{ trans('menu.add') . ' ' . trans('menu.user') }}</p>
							</a>
                        </li>
                        @endcan

                        @can('role_management')
						<li class="nav-item">
							<a href="{{ route('admin.role.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*manage-user/role') }}">
								<i class="fa fa-user-tie nav-icon"></i>
								<p>{{ trans('menu.all') . ' ' . trans('menu.roles') }}</p>
							</a>
						</li>
                        @endcan

                        @can('role_add')
						<li class="nav-item">
							<a href="{{ route('admin.role.create') }}" class="nav-link {{ NavigationService::activeRoutePattern('*manage-user/role/create') }}">
								<i class="fa fa-plus-circle nav-icon"></i>
								<p>{{ trans('menu.add') . ' ' . trans('menu.role') }}</p>
							</a>
                        </li>
                        @endcan
					</ul>
                </li>
                @endcan

                @can('store_management')
                <li class="nav-header">
                    {{ trans('menu.manage_store') }}
                </li>

                <li class="nav-item has-treeview {{ NavigationService::activeRoutePattern('*admin/manage-store*') == 'active' ? 'menu-open active' : '' }}">
					<a href="#" class="nav-link {{ NavigationService::activeRoutePattern('*admin/manage-store*') }}">
						<i class="nav-icon fas fa-shopping-cart"></i>
						<p>
							{{ trans('menu.products') }}
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
                        @can('product_management')
						<li class="nav-item">
							<a href="{{ route('admin.products.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*manage-store/products') }}">
								<i class="fa fa-shopping-cart nav-icon"></i>
								<p>{{ trans('menu.all') . ' ' . trans('menu.products') }}</p>
							</a>
						</li>
                        @endcan

                        @can('product_add')
						<li class="nav-item">
							<a href="{{ route('admin.products.create') }}" class="nav-link {{ NavigationService::activeRoutePattern('*manage-store/products/create') }}">
								<i class="fa fa-plus nav-icon"></i>
								<p>{{ trans('menu.add') . ' ' . trans('menu.products') }}</p>
							</a>
						</li>
                        @endcan

						<li class="nav-item">
							<a href="{{ route('admin.product-categories.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*product-categories*') }}">
								<i class="fa fa-th nav-icon"></i>
								<p>{{ trans('menu.categories') }}</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="{{ route('admin.product-tags.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*product-tags*') }}">
								<i class="fa fa-tags nav-icon"></i>
								<p>{{ trans('menu.tags') }}</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="{{ route('admin.product-attributes.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*product-attributes*') }}">
								<i class="fa fa-th nav-icon"></i>
								<p>{{ trans('menu.attributes') }}</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="{{ route('admin.product-colors.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*product-colors*') }}">
								<i class="fa fa-brush nav-icon"></i>
								<p>{{ trans('menu.colors') }}</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="{{ route('admin.product-sizes.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*product-sizes*') }}">
								<i class="fa fa-th nav-icon"></i>
								<p>{{ trans('menu.sizes') }}</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="{{ route('admin.product-brands.index') }}" class="nav-link {{ NavigationService::activeRoutePattern('*product-brands*') }}">
								<i class="fa fa-th nav-icon"></i>
								<p>{{ trans('menu.brands') }}</p>
							</a>
						</li>

					</ul>
                </li>
                @endcan
            </ul>
		</nav>
	</div>
</aside>
