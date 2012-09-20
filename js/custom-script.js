jQuery( window ).on( 'load', function() {
    jQuery('.twtr-widget-profile').parent().parent().addClass( 'rtp-twitter-widget' );
    jQuery('.twtr-timeline').prepend(('<div class="twitter-top">'));
} );


/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready( function() {
    jQuery( '.widget-slider ul' ).cycle({
     pagerAnchorBuilder: pagerFactory,
        fx: jQuery('#hidden').val(),
        pager : '#rtp-cycle-nav'
        
         
        } );
    function pagerFactory( idx, slide ) {
       /* var img;
      //img = jQuery( slide ).find( 'img' ).attr( 'src' );	
        return '<span><a href="#">' + ( idx + 1 ) + '<img width="50" height="50" src="' + img + '" /></a></span>';*/ 
	        return '<span><a href="#">' + ( idx + 1 ) + '</a></span>';
	    }
    jQuery('#stop').live('click', function(){
        jQuery( '.widget-slider ul' ).cycle('stop');
    });
    jQuery('#pause').live('click', function(){
        jQuery( '.widget-slider ul' ).cycle('pause');
    });
    jQuery('#resume').live('click', function(){
        jQuery( '.widget-slider ul' ).cycle('resume');
    });    
    
});
   