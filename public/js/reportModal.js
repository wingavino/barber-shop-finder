$(document).ready(function(){
  $('#reportModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract info from data-* attributes
    var modal_information = {};

    modal_information['report_form_action'] = button.data('report-form-action');
    modal_information['id'] = button.data('id');
    modal_information['shop_id'] = button.data('shop-id');
    modal_information['shop_name'] = button.data('shop-name');
    modal_information['rating'] = button.data('rating');
    modal_information['review_text'] = button.data('review-text');
    modal_information['reported_user_id'] = button.data('reported-user-id');
    modal_information['reported_user_name'] = button.data('reported-user-name');
    modal_information['request_type'] = button.data('request-type');
    modal_information['user_id'] = button.data('user-id');

    for (var key in modal_information){
      if (modal_information[key] == null) {
        modal_information[key] = 'n/a';
      }
    }

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-body #reportForm').attr('action', modal_information.report_form_action);
    if (modal_information.request_type == 'report-review') {
      modal.find('.modal-body #modalMessage').empty();
      modal.find('.modal-body #modalMessage').append('<b>Once submitted, this review will be checked by admins and will be removed if deemed inappropriate.</b><br>');
      modal.find('.modal-body #modalMessage').append('Please confirm that you want to report the following review of <b>' + modal_information.shop_name + '</b>:');
      modal.find('.modal-body #name').empty();
      modal.find('.modal-body #name').append('<li class="list-group-item"><b>User Name:</b> ' + modal_information.reported_user_name + '</li> <li class="list-group-item"><b>Rating:</b> '+ modal_information.rating + '</li> <li class="list-group-item"><b>Text:</b> ' + modal_information.review_text + '</li>');
    }
  });
});
