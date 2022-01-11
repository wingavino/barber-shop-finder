
<ul class="nav nav-tabs card-header-tabs">
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop' || Route::currentRouteName() == 'admin.shop') ? 'active' : '' }}" href="{{ route('shop', ['id' => $shop->id]) }}">
      {{ __('Details') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.images' || Route::currentRouteName() == 'admin.shop.images') ? 'active' : '' }}" href="{{ route('shop.images', ['id' => $shop->id]) }}">
      {{ __('Images') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.services' || Route::currentRouteName() == 'admin.shop.services') ? 'active' : '' }}" href="{{ route('shop.services', ['id' => $shop->id]) }}">
      {{ __('Services') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.reviews' || Route::currentRouteName() == 'shop.reviews.add' || Route::currentRouteName() == 'admin.shop.reviews') ? 'active' : '' }}" href="{{ route('shop.reviews', ['id' => $shop->id]) }}">
      {{ __('Reviews') }}
    </a>
  </li>
</ul>
