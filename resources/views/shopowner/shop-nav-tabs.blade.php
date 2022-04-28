<ul class="nav nav-tabs card-header-tabs">
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop' || Route::currentRouteName() == 'shopowner.shop.edit') ? 'active' : '' }}" href="{{ route('shopowner.shop') }}">
      {{ __('Shop Details') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop.images' || Route::currentRouteName() == 'shopowner.shop.images.upload') ? 'active' : '' }}" href="{{ route('shopowner.shop.images') }}">
      {{ __('Shop Images') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop.services' || Route::currentRouteName() == 'shopowner.shop.services.add' || Route::currentRouteName() == 'shopowner.shop.services.edit') ? 'active' : '' }}" href="{{ route('shopowner.shop.services') }}">
      {{ __('Shop Services') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop.queue') ? 'active' : '' }}" href="{{ route('shopowner.shop.queue') }}">
      {{ __('Shop Queue') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop.employees' || Route::currentRouteName() == 'shopowner.shop.employees.add' || Route::currentRouteName() == 'shopowner.shop.employees.edit') ? 'active' : '' }}" href="{{ route('shopowner.shop.employees') }}">
      {{ __('Shop Employees') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop.reviews') ? 'active' : '' }}" href="{{ route('shopowner.shop.reviews') }}">
      {{ __('Shop Reviews') }}
    </a>
  </li>
</ul>
