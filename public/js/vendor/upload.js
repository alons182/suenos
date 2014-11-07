
$(function () {
    'use strict';
    $('.file-inputs').bootstrapFileInput();
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'downloads/store'
    });

    $('table[role="presentation"]').on('click','.delete', function(e){

       $(this).parents('.template-download').addClass('fade').removeClass('in');

    });

});