<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
?>

</div> <!-- end content-wrapper --> 
</div> <!-- end main-wrapper -->
<div class="clear"></div>
    <div class="footer-wraper">
        <footer>
            <div class="clear"></div>
          <p class="copy-right"> &copy; Copyright 2011, All rights reserved, Security Aegis | Designed By <a id="rt" href="http://www.rtcamp.com" target="_blank">rtCamp</a></p>
          <a href="http//:www.facebook.com" title="facebook" class="facebook" target="_blank">Facebook</a>
                        <a href="http//:www.twitter.com" title="Twitter" class="twitter" target="_blank">Twitter</a>
                        <a href="http//:www.youtube.com" title="Youtube" class="youtube" target="_blank">Youtube</a>
                        <a href="#" title="RSS FEED" class="rss" target="_blank">RSS FEED</a>
        <?php get_sidebar( 'footer' ); ?>
            <div class="clear"></div>            
            
            <a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <?php bloginfo( 'name' ); ?>
            </a>
        		

            <?php do_action( 'starkers_credits' ); ?>
                           
        </footer>    
    

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
        </div> <!-- end footer-wrapper -->
        
</body>
</html>