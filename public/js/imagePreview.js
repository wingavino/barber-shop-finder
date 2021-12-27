$(document).ready(function() {
  // Multiple images preview with JavaScript
  var multiImgPreview = function(input, imgPreviewPlaceholder) {

      if (input.files) {
          var filesAmount = input.files.length;

          for (i = 0; i < filesAmount; i++) {
              var reader = new FileReader();

              reader.onload = function(event) {
                $($.parseHTML('<img>')).attr('src', event.target.result).attr('class', 'col-md-6 img-thumbnail rounded float-left').appendTo(imgPreviewPlaceholder);
              }

              reader.readAsDataURL(input.files[i]);
          }
      }
  };

  $('#images').on('change', function() {
      multiImgPreview(this, 'div.imgPreview');
  });
});
