$(document).ready(function(){
  $('#requestModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract info from data-* attributes
    var modal_information = {};

    modal_information['approve_form_action'] = button.data('approve-form-action');
    modal_information['reject_form_action'] = button.data('reject-form-action');
    modal_information['id'] = button.data('id');
    modal_information['user_id'] = button.data('user-id');
    modal_information['reported_user_id'] = button.data('reported-user-id');
    modal_information['reported_user_name'] = button.data('reported-user-name');
    modal_information['reported_user_email'] = button.data('reported-user-email');
    modal_information['reported_user_type'] = button.data('reported-user-type');
    modal_information['name'] = button.data('name');
    modal_information['email'] = button.data('email');
    modal_information['email_verified_at'] = button.data('email-verified-at');
    modal_information['img_id'] = button.data('img-id');
    modal_information['img_shop_doc'] = button.data('img-shop-doc');
    modal_information['mobile'] = button.data('mobile');
    modal_information['user_type'] = button.data('user-type');
    modal_information['review_id'] = button.data('review-id');
    modal_information['review_text'] = button.data('review-text');
    modal_information['report_reason'] = button.data('report-reason');
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
      modal.find('.modal-body #name').append('<li class="list-group-item"><b>ID Photo: </b><a href="#" data-toggle="modal" data-target="#deleteModal" data-id="{{ ' + modal_information.id + ' }}" data-src="' + asset_url + '/' + modal_information.user_id + '/' + modal_information.img_id + '"><img src="' + asset_url + '/' + modal_information.user_id + '/' + modal_information.img_id + '" class="col-md-6 img-thumbnail"></a></li> <li class="list-group-item"><b>User ID:</b> ' + modal_information.user_id + '</li> <li class="list-group-item"><b>User Name:</b> '+ modal_information.name + '</li> <li class="list-group-item"><b>Email:</b> ' + modal_information.email + '</li> <li class="list-group-item"><b>Email Verified:</b> ' + modal_information.email_verified_at + '</li> <li class="list-group-item"><b>Mobile:</b> ' + modal_information.mobile + '</li>');
    }
    if (modal_information.request_type == 'add-new-shop') {
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to approve the following shop:');
      modal.find('.modal-body #name').empty();
      modal.find('.modal-body #name').append('<li class="list-group-item"><b>User ID Photo: </b><a href="#" data-toggle="modal" data-target="#deleteModal" data-id="{{ ' + modal_information.id + ' }}" data-src="' + asset_url + '/' + modal_information.user_id + '/' + modal_information.img_id + '"><img src="' + asset_url + '/' + modal_information.user_id + '/' + modal_information.img_id + '" class="col-md-6 img-thumbnail"></a></li> <li class="list-group-item"><b>Shop Document Photo: </b><a href="#" data-toggle="modal" data-target="#deleteModal" data-id="{{ ' + modal_information.id + ' }}" data-src="' + asset_url + '/' + modal_information.user_id + '/' + modal_information.img_shop_doc + '"><img src="' + asset_url + '/' + modal_information.user_id + '/' + modal_information.img_shop_doc + '" class="col-md-6 img-thumbnail"></a></li>  <li class="list-group-item"><b>User ID:</b> ' + modal_information.user_id + '</li> <li class="list-group-item"><b>User Name:</b> '+ modal_information.name + '</li> <li class="list-group-item"><b>Email:</b> ' + modal_information.email + '</li> <li class="list-group-item"><b>Email Verified:</b> ' + modal_information.email_verified_at + '</li> <li class="list-group-item"><b>Mobile:</b> ' + modal_information.mobile + '</li> <li class="list-group-item"><b>User Type:</b> ' + modal_information.user_type + '</li> <li class="list-group-item"><b>Shop ID:</b> ' + modal_information.shop_id + '</li> <li class="list-group-item"><b>Shop Name:</b> <a href="'+ modal_information['shop_url'] +'" target="_blank">' + modal_information.shop_name + '</a></li>');
    }

    if (modal_information.request_type == 'report-review') {
      modal.find('.modal-body #modalMessage').text('Please confirm that you want to delete the following review:');
      modal.find('.modal-body #name').empty();
      modal.find('.modal-body #name').append('<li class="list-group-item"><b>User ID:</b> ' + modal_information.reported_user_id + '</li> <li class="list-group-item"><b>User Name:</b> '+ modal_information.reported_user_name + '</li> <li class="list-group-item"><b>Email:</b> ' + modal_information.reported_user_email + '</li> <li class="list-group-item"><b>User Type:</b> ' + modal_information.reported_user_type + '</li> <li class="list-group-item"><b>Shop ID:</b> ' + modal_information.shop_id + '</li> <li class="list-group-item"><b>Shop Name:</b> <a href="'+ modal_information['shop_url'] +'" target="_blank">' + modal_information.shop_name + '</a></li> <li class="list-group-item"><b>Review Text:</b> '
        + '<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseReview" aria-expanded="false" aria-controls="collapseReview">'
        +   'Click to View/Hide'
        +  '</button>'
        +  '<div class="collapse" id="collapseReview">'
        +   '<div class="card card-body">'
        +     modal_information.review_text + '</li>'
        +   '</div>'
        +  '</div>');
    }
  });
});
