
<ul class="nav nav-tabs card-header-tabs">
  @guest
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
  @else
    @if(Auth::user()->type == 'admin')
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
    @elseif(Auth::user()->type == 'shopowner')
      <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'shop' || Route::currentRouteName() == 'shopowner.shop' || Route::currentRouteName() == 'shopowner.shop.edit') ? 'active' : '' }}" href="{{ route('shopowner.shop') }}">
          {{ __('Details') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'shop.images' || Route::currentRouteName() == 'shopowner.shop.images' || Route::currentRouteName() == 'shopowner.shop.images.upload') ? 'active' : '' }}" href="{{ route('shopowner.shop.images') }}">
          {{ __('Images') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'shop.services' || Route::currentRouteName() == 'shopowner.shop.services' || Route::currentRouteName() == 'shopowner.shop.services.add' || Route::currentRouteName() == 'shopowner.shop.services.edit') ? 'active' : '' }}" href="{{ route('shopowner.shop.services') }}">
          {{ __('Services') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'shop.queue' || Route::currentRouteName() == 'shopowner.shop.queue') ? 'active' : '' }}" href="{{ route('shopowner.shop.queue') }}">
          {{ __('Queue') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'shop.employees' || Route::currentRouteName() == 'shopowner.shop.employees' || Route::currentRouteName() == 'shopowner.shop.employees.add' || Route::currentRouteName() == 'shopowner.shop.employees.edit') ? 'active' : '' }}" href="{{ route('shopowner.shop.employees') }}">
          {{ __('Employees') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'shop.reviews' || Route::currentRouteName() == 'shopowner.shop.reviews') ? 'active' : '' }}" href="{{ route('shopowner.shop.reviews') }}">
          {{ __('Reviews') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'shop.settings' || Route::currentRouteName() == 'shopowner.shop.settings') ? 'active' : '' }}" href="{{ route('shopowner.shop.settings') }}">
          {{ __('Settings') }}
        </a>
      </li>
    @else
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
    @endif
  @endguest
</ul>
