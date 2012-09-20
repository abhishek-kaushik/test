<?php
/**
 * The template for displaying 404 pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>
<div class="content">
    <div class="post-wrapper">
<div class="four">
	<h1><?php _e( 'Not Found', 'starkers' ); ?></h1>
		<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'starkers' ); ?></p>
</div>
		<div class="four-form"><?php get_search_form(); ?></div>

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>
    </div>
        </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>