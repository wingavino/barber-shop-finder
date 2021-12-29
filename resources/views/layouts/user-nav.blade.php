@isset(Auth::user()->ticket)
  <li class="nav-item">
    <p class="nav-link">Now Serving at <b>{{ Auth::user()->ticket->queue->shop->name }}: </b></p>
  </li>
  <div class="col">
    @isset(Auth::user()->ticket->queue->current_ticket)
      <li class="nav-item">
        <a class="btn btn-primary" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button" role="button">{{ Auth::user()->ticket->queue->current_ticket }}</a>
      </li>
    @else
      <li class="nav-item">
        <a class="btn btn-danger" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button">None</a>
      </li>
    @endisset
  </div>
  <li class="nav-item">
    <a class="btn btn-success" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button" role="button">Your ticket: {{ Auth::user()->ticket->ticket_number }}</a>
  </li>
@endisset
