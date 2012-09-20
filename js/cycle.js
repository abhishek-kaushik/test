/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready( function() {
    $( '.pics' ).cycle({
        pager:         '#rtp-cycle-nav',
        pagerAnchorBuilder: pagerFactory,
        fx: 'scrollRight'
        } );
    function pagerFactory( idx, slide ) {
       /* var img;
      //img = jQuery( slide ).find( 'img' ).attr( 'src' );	
        return '<span><a href="#">' + ( idx + 1 ) + '<img width="50" height="50" src="' + img + '" /></a></span>';*/ 
	        return '<span><a href="#">' + ( idx + 1 ) + '</a></span>';
	    }
    } );