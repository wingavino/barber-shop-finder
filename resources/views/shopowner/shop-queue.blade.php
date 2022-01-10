@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
                        <div class="card-header bg-success">
                          Current Ticket
                        </div>

                        <div class="card-body text-center">
                          <h3>
                            @isset($shop->queue->current_ticket)
                              <h3>{{ $shop->queue->current_ticket }}</h3>
                            @else
                              <button class="btn btn-danger disabled" type="button" name="button">None</button>
                            @endisset
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
                          Next Ticket
                        </div>

                        <div class="card-body text-center">
                          <div class="card-group">
                            <!-- On Hold -->
                              <div class="card">
                                <div class="card-header bg-light">
                                  On Hold
                                </div>

                                <div class="card-body text-center">
                                  <div class="row">
                                    @empty($shop->queue->ticket->where('on_hold', true)->first())
                                    <div class="col">
                                      <button class="btn btn-danger disabled" type="button" name="button">None</button>
                                    </div>
                                    @else
                                    @foreach($shop->queue->ticket->where('on_hold', true) as $on_hold_ticket)
                                    <div class="col">
                                      <form method="POST" action="{{ route('shopowner.shop.queue.next', ['id' => $on_hold_ticket->id]) }}">
                                        @csrf
                                        <button class="btn btn-primary" type="submit" name="button">{{ $on_hold_ticket->ticket_number }}</button>
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
                                          <button class="btn btn-danger disabled" type="button" name="button">None</button>
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
