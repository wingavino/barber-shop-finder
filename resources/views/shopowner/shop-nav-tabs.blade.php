<ul class="nav nav-tabs card-header-tabs">
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop') ? 'active' : '' }}" href="{{ route('shopowner.shop') }}">
      {{ __('Shop Details') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop.images' || Route::currentRouteName() == 'shopowner.shop.images.upload') ? 'active' : '' }}" href="{{ route('shopowner.shop.images') }}">
      {{ __('Shop Images') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop.services' || Route::currentRouteName() == 'shopowner.shop.services.add') ? 'active' : '' }}" href="{{ route('shopowner.shop.services') }}">
      {{ __('Shop Services') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shopowner.shop.queue') ? 'active' : '' }}" href="{{ route('shopowner.shop.queue') }}">
      {{ __('Shop Queue') }}
    </a>
  </li>
</ul>
