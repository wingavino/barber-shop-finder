$(document).ready(function(){
  $('#requestModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var formAction = button.data('form-action');
    var id = button.data('id'); // Extract info from data-* attributes
    var user_id = button.data('user-id');
    var name = button.data('name');
    var shop_id = button.data('shop-id');
    var shop_name = button.data('shop-name');
    var request_type = button.data('request-type');
    var change_to_user_type = button.data('change-to-user-type');
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-body form').attr('action', formAction);
    if (request_type == 'change-user-type') {
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to change the following account\'s type to ' + change_to_user_type + '.');
    }
    if (request_type == 'add-new-shop') {
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to approve the following shop:');
    }
    modal.find('.modal-body #name').text('User ID: ' + user_id + ', Owner Name: '+ name + ', Shop ID: ' + shop_id + ', Shop Name: ' + shop_name);
  });
});
