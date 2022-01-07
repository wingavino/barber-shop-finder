$(document).ready(function(){
  $('#requestModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract info from data-* attributes
    var modal_information = {};

    modal_information['approve_form_action'] = button.data('approve-form-action');
    modal_information['reject_form_action'] = button.data('reject-form-action');
    modal_information['id'] = button.data('id');
    modal_information['user_id'] = button.data('user-id');
    modal_information['name'] = button.data('name');
    modal_information['email'] = button.data('email');
    modal_information['user_type'] = button.data('user-type');
    modal_information['shop_id'] = button.data('shop-id');
    modal_information['shop_name'] = button.data('shop-name');
    modal_information['shop_url'] = button.data('shop-url');
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
    modal.find('.modal-body #rejectForm').attr('action', modal_information.reject_form_action);
    modal.find('.modal-body #approveForm').attr('action', modal_information.approve_form_action);
    if (modal_information.request_type == 'change-user-type') {
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to change the following account\'s type to ' + modal_information.change_to_user_type + '.');
      modal.find('.modal-body #name').empty();
      modal.find('.modal-body #name').append('<li class="list-group-item"><b>User ID:</b> ' + modal_information.user_id + '</li> <li class="list-group-item"><b>User Name:</b> '+ modal_information.name + '</li> <li class="list-group-item"><b>Email:</b> ' + modal_information.email + '</li>');
    }
    if (modal_information.request_type == 'add-new-shop') {
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to approve the following shop:');
      modal.find('.modal-body #name').empty();
      modal.find('.modal-body #name').append('<li class="list-group-item"><b>User ID:</b> ' + modal_information.user_id + '</li> <li class="list-group-item"><b>User Name:</b> '+ modal_information.name + '</li> <li class="list-group-item"><b>Email:</b> ' + modal_information.email + '</li> <li class="list-group-item"><b>User Type:</b> ' + modal_information.user_type + '</li> <li class="list-group-item"><b>Shop ID:</b> ' + modal_information.shop_id + '</li> <li class="list-group-item"><b>Shop Name:</b> <a href="'+ modal_information['shop_url'] +'" target="_blank">' + modal_information.shop_name + '</a></li>');
    }
  });
});
