
<ul class="nav nav-tabs card-header-tabs">
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop') ? 'active' : '' }}" href="{{ route('shop', ['id' => $shop->id]) }}">
      {{ __('Shop Details') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.images') ? 'active' : '' }}" href="{{ route('shop.images', ['id' => $shop->id]) }}">
      {{ __('Shop Images') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.services') ? 'active' : '' }}" href="{{ route('shop.services', ['id' => $shop->id]) }}">
      {{ __('Shop Services') }}
    </a>
  </li>
</ul>
