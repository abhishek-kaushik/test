<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>
<div class="not-found " style="width: 620px;background: none;border: 0;float: left">

    
<?php if ( have_posts() ) : ?>
    <h1 class="title-wrapper" style="margin: 0 0 15px 0"><?php printf( __( 'Search Results for: %s', 'starkers' ), '' . get_search_query() . '' ); ?></h1>
			<?php
				get_template_part( 'loop', 'search' );
			?>
<?php else : ?><div class="post-wrapper">
                <div class="title-wrapper" style="margin: 0 0 15px 0">
		<h1 class="title-wrapper" style="padding:20px"><?php _e( 'Nothing Found', 'starkers' ); ?></h1>
			<p class="article-wrapper" style="padding:20px"><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'starkers' ); ?></p>
                </div>
                        <?php get_search_form(); ?>
<?php endif; ?>
</div>
    </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>