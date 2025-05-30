<ul class="nav nav-tabs card-header-tabs">
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop' || Route::currentRouteName() == 'admin.shop' || Route::currentRouteName() == 'admin.shop.edit') ? 'active' : '' }}" href="{{ route('admin.shop', ['id' => $shop->id]) }}">
      {{ __('Details') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.images' || Route::currentRouteName() == 'admin.shop.images' || Route::currentRouteName() == 'admin.shop.images.upload') ? 'active' : '' }}" href="{{ route('admin.shop.images', ['id' => $shop->id]) }}">
      {{ __('Images') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.services' || Route::currentRouteName() == 'admin.shop.services' || Route::currentRouteName() == 'admin.shop.services.add' || Route::currentRouteName() == 'admin.shop.services.edit') ? 'active' : '' }}" href="{{ route('admin.shop.services', ['id' => $shop->id]) }}">
      {{ __('Services') }}
    </a>
  </li>
  <!-- <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'shop.queue' || Route::currentRouteName() == 'admin.shop.queue') ? 'active' : '' }}" href="{{ route('admin.shop.queue', ['id' => $shop->id]) }}">
          {{ __('Queue') }}
        </a>
      </li> -->
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.reviews' || Route::currentRouteName() == 'admin.shop.reviews') ? 'active' : '' }}" href="{{ route('admin.shop.reviews', ['id' => $shop->id]) }}">
      {{ __('Reviews') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'admin.img.shop.doc') ? 'active' : '' }}" href="{{ route('admin.img.shop.doc', ['id' => $shop->id]) }}">
      {{ __('Documents') }}
    </a>
  </li>
  <!-- <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'shop.settings' || Route::currentRouteName() == 'admin.shop.settings') ? 'active' : '' }}" href="{{ route('admin.shop.settings', ['id' => $shop->id]) }}">
      {{ __('Settings') }}
    </a>
  </li> -->
</ul>
