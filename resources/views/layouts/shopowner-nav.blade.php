@if (Auth::user())
  @if (Auth::user()->type == 'shopowner' || Auth::user()->pending_request->where('request_type', 'change-user-type')->first())
    @if(Auth::user()->shop)
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shopowner.shop', ['id' => Auth::user()->shop->id]) }}">{{ __('Manage Shop') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shopowner.shop.images') }}">{{ __('Images') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shopowner.shop.services') }}">{{ __('Services') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shopowner.shop.queue') }}">{{ __('Queue') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shopowner.shop.employees') }}">{{ __('Employees') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shopowner.shop.reviews') }}">{{ __('Reviews') }}</a>
    </li>
    @else
      @if(Auth::user()->email_verified_at != '')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('shopowner.shop.add') }}">{{ __('Create Shop') }}</a>
        </li>
      @endif
    @endif
  @endif
@endif
