jQuery(document).ready(function($) {
    var modal = $('#enquiry-modal');
   

    $('#enquiry-toggle').on('click', function() {
        modal.show();

        if('.wp-block-post-title'){
            var productName = $('.wp-block-post-title').text();
        }
        
        if('.product_title.entry-title'){
            var productName = $('.product_title.entry-title').text();
        }
       
        $('[name="product-name"]').val(productName);
    });

    $('span.devw-mod-close').on('click', function() {
        modal.hide();
    });

   
    $(window).on('click', function(event) {
        if ($(event.target).is(modal)) {
            modal.hide();
        }
    });
});
