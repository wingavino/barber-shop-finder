@if (Auth::user() && Auth::user()->type == 'admin')
<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.shopowners') }}">{{ __('Shop Owners') }}</a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.shops') }}">{{ __('Shops') }}</a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.admins') }}">{{ __('Admins') }}</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.pending-requests') }}">{{ __('Requests') }}</a>
</li>
@endif
