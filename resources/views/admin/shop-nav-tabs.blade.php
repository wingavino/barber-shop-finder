<ul class="nav nav-tabs card-header-tabs">
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'admin.shop' || Route::currentRouteName() == 'admin.shop.edit') ? 'active' : '' }}" href="{{ route('admin.shop', ['id' => $shop->id]) }}">
      {{ __('Details') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'admin.shop.images' || Route::currentRouteName() == 'admin.shop.images.upload') ? 'active' : '' }}" href="{{ route('admin.shop.images', ['id' => $shop->id]) }}">
      {{ __('Images') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'admin.shop.services' || Route::currentRouteName() == 'admin.shop.services.add' || Route::currentRouteName() == 'admin.shop.services.edit') ? 'active' : '' }}" href="{{ route('admin.shop.services', ['id' => $shop->id]) }}">
      {{ __('Services') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'admin.shop.reviews') ? 'active' : '' }}" href="{{ route('admin.shop.reviews') }}">
      {{ __('Reviews') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'admin.shop.settings') ? 'active' : '' }}" href="{{ route('admin.shop.settings') }}">
      {{ __('Settings') }}
    </a>
  </li>
</ul>
