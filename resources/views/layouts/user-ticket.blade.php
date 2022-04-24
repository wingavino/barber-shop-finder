@isset(Auth::user()->ticket)
<div class="row justify-content-center">

    <div class="col-lg-2 justify-content-center text-center">
      <p class="">Now Serving at <b>{{ Auth::user()->ticket->queue->shop->name }}: </b></p>
      @isset(Auth::user()->ticket->queue->current_ticket)
      <a class="btn btn-primary" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button" role="button">{{ Auth::user()->ticket->queue->current_ticket }}</a>
      @else
      <a class="btn btn-danger" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button">None</a>
      @endisset
    </div>
    <div class="col-lg-2 justify-content-center text-center">
      <p>Your ticket:</p>
      <a class="btn btn-success" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button" role="button">Your ticket: {{ Auth::user()->ticket->ticket_number }}</a>
    </div>

</div>
@endisset
