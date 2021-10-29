jQuery( document ).ready( function(){
    var page = 2;
    jQuery( function($) {
      jQuery( 'body' ).on( 'click', '.loadmore', function() {
            var data = {
                'action': 'load_posts_by_ajax',
                'page': page,
            };
            jQuery.post( wp_ajax.ajaxurl, data, function( response ) {
                if( $.trim(response) != '' ) {
                    jQuery( '.posts_blocks' ).append( response );
                    page++;
                    console.log(page++); 
                } else {
                    jQuery( '.loadmore' ).hide();
                    jQuery( ".no-more-post" ).html( "No More Posts Available" );
                }
            });
        });
    });
});