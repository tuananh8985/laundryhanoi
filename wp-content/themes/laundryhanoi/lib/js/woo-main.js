jQuery(document).ready(function(){

    /* Quantity Product
     ---------------------------------------------------------------*/
    jQuery('body').on('click', 'a.shopping-cart-icon-container', function(){
        jQuery('.shopping-cart-wrapper').toggleClass('open');
    });
    jQuery('body').on('click', 'a.menu-cart-close', function(){
        jQuery('.shopping-cart-wrapper').toggleClass('open');
    });

    if ( ! String.prototype.getDecimals ) {
        String.prototype.getDecimals = function() {
            var num = this,
                match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            if ( ! match ) {
                return 0;
            }
            return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
        }
    }
 
    function wcqi_refresh_quantity_increments(){
        jQuery( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );
    }
 
    jQuery( document ).on( 'updated_wc_div', function() {
        wcqi_refresh_quantity_increments();
    } );
 
    jQuery( document ).on( 'click', '.plus, .minus', function() {
        // Get values
        var $qty        = jQuery( this ).closest( '.quantity' ).find( '.qty'),
            currentVal  = parseFloat( $qty.val() ),
            max         = parseFloat( $qty.attr( 'max' ) ),
            min         = parseFloat( $qty.attr( 'min' ) ),
            step        = $qty.attr( 'step' );
 
        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;
 
        // Change the value
        if ( jQuery( this ).is( '.plus' ) ) {
            if ( max && ( currentVal >= max ) ) {
                $qty.val( max );
            } else {
                $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
            }
        } else {
            if ( min && ( currentVal <= min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
            }
        }
 
        // Trigger change event
        $qty.trigger( 'change' );
    });
    wcqi_refresh_quantity_increments();

});