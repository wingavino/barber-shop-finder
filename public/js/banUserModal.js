$(document).ready(function(){
  $('#banUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var formAction = button.data('form-action');
    var ban = button.data('ban');
    var id = button.data('id'); // Extract info from data-* attributes
    var name = button.data('name');
    var email = button.data('email');

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    if(ban == true){
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to ban the following account:');
    }else{
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to unban the following account:');
    }
    modal.find('.modal-body form').attr('action', formAction);
    modal.find('.modal-body #id').text('ID: ' + id);
    modal.find('.modal-body #name').text('Name: '+ name);
    modal.find('.modal-body #email').text('Email: ' + email);
  });
});
