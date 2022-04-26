@isset(Auth::user()->ticket)
<div class="row justify-content-center">

    <div class="col-lg-2 justify-content-center text-center">
      <p class="">Now Serving at <b>{{ Auth::user()->ticket->queue->shop->name }}: </b></p>
      <script>
      $(document).ready(function(){
        function updateCurrentTicket(){
          $.ajax({
            url:'/queue/{{ Auth::user()->ticket->queue->id }}/current_ticket',
            type:'GET',
            dataType:'json',
            success:function(response){
              var current_ticket = '';
              var btn_status = '';

              if(response.queue.current_ticket){
                current_ticket = response.queue.current_ticket;
                
                $('#current_ticket_nav').removeClass('btn-danger').addClass('btn-primary');
              }else {
                current_ticket = 'None';

                $('#current_ticket_nav').removeClass('btn-primary').addClass('btn-danger');
              }


              $('#current_ticket_nav').empty();

              $('#current_ticket_nav').append(current_ticket);

            },error:function(err){

              $('#current_ticket_nav').empty();
            }
          }).then(function(){
            setTimeout(updateCurrentTicket, 5000);
          });
        }
        updateCurrentTicket();
      });
      </script>
      <a class="btn btn-primary" id="current_ticket_nav" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button" role="button"></a>
      <!-- @isset(Auth::user()->ticket->queue->current_ticket)
      <a class="btn btn-primary" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button" role="button">{{ Auth::user()->ticket->queue->current_ticket }}</a>
      @else
      <a class="btn btn-danger" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button">None</a>
      @endisset -->
    </div>
    <div class="col-lg-2 justify-content-center text-center">
      <p>Your ticket:</p>
      <a class="btn btn-success" href="{{ route('shop', ['id' => Auth::user()->ticket->queue->shop_id]) }}" type="button" role="button">Your ticket: {{ Auth::user()->ticket->ticket_number }}</a>
    </div>

</div>
@endisset
