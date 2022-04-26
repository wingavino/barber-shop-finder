<ul class="nav nav-tabs card-header-tabs">
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'employee.shop') ? 'active' : '' }}" href="{{ route('employee.shop') }}">
      {{ __('Shop Details') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'employee.shop.images' || Route::currentRouteName() == 'employee.shop.images.upload') ? 'active' : '' }}" href="{{ route('employee.shop.images') }}">
      {{ __('Shop Images') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'employee.shop.services' || Route::currentRouteName() == 'employee.shop.services.add' || Route::currentRouteName() == 'employee.shop.services.edit') ? 'active' : '' }}" href="{{ route('employee.shop.services') }}">
      {{ __('Shop Services') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'employee.shop.queue') ? 'active' : '' }}" href="{{ route('employee.shop.queue') }}">
      {{ __('Shop Queue') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'employee.shop.employees' || Route::currentRouteName() == 'employee.shop.employees.add' || Route::currentRouteName() == 'employee.shop.employees.edit') ? 'active' : '' }}" href="{{ route('employee.shop.employees') }}">
      {{ __('Shop Employees') }}
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ (Route::currentRouteName() == 'employee.shop.reviews') ? 'active' : '' }}" href="{{ route('employee.shop.reviews') }}">
      {{ __('Shop Reviews') }}
    </a>
  </li>
</ul>
