@extends('layouts.app')

@section('content')

<script>
$(document).ready(function(){
  function updateCurrentTicket(){
    $.ajax({
      url:'/queue/{{ Auth::user()->shop->queue->id }}/current_ticket',
      type:'GET',
      dataType:'json',
      success:function(response){
        var current_ticket = 'None';
        var next_ticket = 'None';
        var on_hold_ticket = 'None';
        var btn_status = '';

        $('#on_hold_tickets').empty();

        if(response.queue.current_ticket){
          current_ticket = response.queue.current_ticket + '<br>' + response.user.name;
          $('#current_ticket').removeClass('btn-danger').addClass('btn-primary');
        }else {
          current_ticket = 'None';
          $('#current_ticket').removeClass('btn-primary').addClass('btn-danger');
        }

        if(response.on_hold_tickets){
          $.each(response.on_hold_tickets, function(index, value){
            console.log('index: ' + index + ' ticket: ' + value);
            on_hold_ticket =
              '<div class="col">' +
                '<button class="btn btn-primary" type="submit" name="button">' +
                  value.ticket_number +
                '</button>' +
              '</div>';
              $('#on_hold_tickets').append(on_hold_ticket);
          });
        }else {
          on_hold_ticket =
            '<div class="col">' +
              '<button class="btn btn-danger disabled" type="button" name="button">None</button>' +
            '</div>';
          $('#on_hold_tickets').append(on_hold_ticket);
        }

        if(response.queue.next_ticket){
          next_ticket = response.queue.next_ticket;
          $('#next_ticket').removeClass('btn-danger').addClass('btn-primary');
        }else {
          next_ticket = 'None';
          $('#next_ticket').removeClass('btn-primary').addClass('btn-danger');
        }
        $('#current_ticket').empty();
        $('#current_ticket').append(current_ticket);
        $('#next_ticket').empty();
        $('#next_ticket').append(next_ticket);
      },error:function(err){
        $('#current_ticket').empty();
        current_ticket = 'None';
        $('#current_ticket').append(current_ticket);
        $('#next_ticket').empty();
        next_ticket = 'None';
        $('#next_ticket').append(next_ticket);
        setTimeout(updateCurrentTicket, 5000);
      }
    }).then(function(){
      setTimeout(updateCurrentTicket, 5000);
    });
  }
  updateCurrentTicket();
});
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 col-sm-4">
          @isset($logo)
          <img src="{{ asset('img/'.$logo->path) }}" class="img-fluid" alt="...">
          @endisset
        </div>
        <div class="col-8 col-sm-12 text-center">
          <h2>{{ $shop->name }}</h2>
          <h5>{{ $shop->address }}</h5>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  @include('shopowner.shop-nav-tabs')
                </div>
                <div class="card-body">
                  <div class="row">
                    <!-- Current Ticket -->
                    <div class="col-md-6">
                      <div class="card">
                        @if($shop_queue->is_closed)
                          <div class="card-header bg-light">
                            <div class="row">
                              <div class="col-3">
                                Current Ticket
                              </div>
                              <div class="col-9 text-right">
                                <form method="POST" action="{{ route('shopowner.shop.queue.open') }}">
                                  @csrf
                                  <button class="btn btn-danger" type="submit" name="button">Closed</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        @else
                          <div class="card-header bg-light">
                            <div class="row">
                              <div class="col-3">
                                Current Ticket
                              </div>
                              <div class="col-9 text-right">
                                <form method="POST" action="{{ route('shopowner.shop.queue.close') }}">
                                  @csrf
                                  <button class="btn btn-success" type="submit" name="button">Open</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        @endif

                        <div class="card-body text-center">
                          <h3>
                            <button class="btn btn-danger disabled" id="current_ticket" type="button" name="button">None</button>

                          </h3>
                        </div>

                        <div class="card-footer">
                          <div class="row text-center">
                            <div class="col">
                              <form method="POST" action="{{ route('shopowner.shop.queue.hold') }}">
                                @csrf
                                <button class="btn btn-primary" type="submit" name="button">Put on Hold</button>
                              </form>
                            </div>
                            <div class="col">
                              <form method="POST" action="{{ route('shopowner.shop.queue.next.hold') }}">
                                @csrf
                                <button class="btn btn-primary" type="submit" name="button">Next from On Hold</button>
                              </form>
                            </div>
                            <div class="col">
                              <form method="POST" action="{{ route('shopowner.shop.queue.finish') }}">
                                @csrf
                                <button class="btn btn-primary" type="submit" name="button">Finished / Next</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Current Ticket -->

                    <!-- Next Ticket -->
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header bg-light">
                          <div class="row">
                            <div class="col-3">
                              Next Ticket
                            </div>
                            <div class="col-9 text-right">
                              <form method="POST" action="{{ route('shopowner.shop.queue.next.notify') }}">
                                @csrf
                                <button class="btn btn-dark" type="submit" name="button">Notify</button>
                              </form>
                            </div>
                          </div>
                        </div>

                        <div class="card-body text-center">
                          <div class="card-group">
                            <!-- On Hold -->
                              <div class="card">
                                <div class="card-header bg-light">
                                  On Hold
                                </div>

                                <div class="card-body text-center">
                                  <div id="on_hold_tickets" class="row">
                                    @empty($shop->queue->ticket->where('on_hold', true)->first())
                                    <div class="col">
                                      <button class="btn btn-danger disabled" type="button" name="button">None</button>
                                    </div>
                                    @else
                                      @foreach($shop->queue->ticket->where('on_hold', true) as $on_hold_ticket)
                                      <div class="col">
                                        <form method="POST" action="{{ route('shopowner.shop.queue.next', ['id' => $on_hold_ticket->id]) }}">
                                          @csrf
                                          <button class="btn btn-primary" type="submit" name="button">
                                            {{ $on_hold_ticket->ticket_number }}
                                            @if(App\Models\Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $on_hold_ticket->ticket_number)->first()->user)
                                            <h3>Name: {{ App\Models\Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $on_hold_ticket->ticket_number)->first()->user->name }}</h3>
                                            @endif
                                          </button>
                                        </form>
                                      </div>
                                      @endforeach
                                    @endempty
                                  </div>
                                </div>
                              </div>
                            <!-- On Hold -->
                            <!-- Next In Queue -->
                              <div class="card">
                                <div class="card-header bg-light">
                                  Next In Queue
                                </div>

                                <div class="card-body text-center">
                                  <h3>
                                    <form method="POST" action="">
                                      @csrf
                                      <h3>
                                        @isset($shop->queue->next_ticket)
                                          {{ $shop->queue->next_ticket }}
                                        @else
                                          <button class="btn btn-danger disabled" type="button" id="next_ticket" name="button">None</button>
                                        @endisset
                                      </h3>
                                    </form>
                                  </h3>
                                </div>
                              </div>
                            <!-- In Queue -->
                          </div>
                        </div>

                      </div>
                    </div>
                    <!-- Next Ticket -->
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
