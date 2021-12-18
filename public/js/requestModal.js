$(document).ready(function(){
  $('#requestModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract info from data-* attributes
    var modal_information = {};

    modal_information['formAction'] = button.data('form-action');
    modal_information['id'] = button.data('id');
    modal_information['user_id'] = button.data('user-id');
    modal_information['name'] = button.data('name');
    modal_information['shop_id'] = button.data('shop-id');
    modal_information['shop_name'] = button.data('shop-name');
    modal_information['request_type'] = button.data('request-type');
    modal_information['change_to_user_type'] = button.data('change-to-user-type');

    for (var key in modal_information){
      if (modal_information[key] == null) {
        modal_information[key] = 'n/a';
      }
    }

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-body form').attr('action', modal_information.formAction);
    if (modal_information.request_type == 'change-user-type') {
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to change the following account\'s type to ' + modal_information.change_to_user_type + '.');
    }
    if (modal_information.request_type == 'add-new-shop') {
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to approve the following shop:');
    }
    modal.find('.modal-body #name').text('User ID: ' + modal_information.user_id + ', User Name: '+ modal_information.name + ', Shop ID: ' + modal_information.shop_id + ', Shop Name: ' + modal_information.shop_name);
  });
});
