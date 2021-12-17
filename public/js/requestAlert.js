var alertPlaceholder = document.getElementById('liveAlertPlaceholder')
var alertDismiss = document.getElementById('alertDismiss')

function alert(message, type) {
  var wrapper = document.createElement('div')
  wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'

  alertPlaceholder.append(wrapper)
}

if (alertDismiss) {
  alertDismiss.addEventListener('click', function () {
    
  })
}
