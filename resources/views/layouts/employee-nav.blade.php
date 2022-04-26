@if (Auth::user())
  @if (App\Models\Employee::where('user_id', Auth::user()->id)->first())
    @if(App\Models\Employee::where('user_id', Auth::user()->id)->first()->shop)
    <li class="nav-item">
      <a class="nav-link" href="{{ route('employee.shop', ['id' => App\Models\Employee::where('user_id', Auth::user()->id)->first()->shop->id]) }}">{{ __('Manage Shop') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('employee.shop.images') }}">{{ __('Images') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('employee.shop.services') }}">{{ __('Services') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('employee.shop.queue') }}">{{ __('Queue') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('employee.shop.employees') }}">{{ __('Employees') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('employee.shop.reviews') }}">{{ __('Reviews') }}</a>
    </li>
    @endif
  @endif
@endif
