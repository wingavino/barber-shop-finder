$(document).ready(function(){
  $('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var formAction = button.data('form-action');
    var id = button.data('id'); // Extract info from data-* attributes
    var service_id = button.data('service-id');
    var name = button.data('name');
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-body form').attr('action', formAction);
    modal.find('.modal-body #name').text('ID: ' + id + ' Name: '+ name);
  });
});
