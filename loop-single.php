<?php
/**
 * The loop that displays a single post.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.2
 */
?>
<div class="content">
    <div class="post-wrapper">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		
                
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<header>
                            <div class="title-wrapper clearfix"><h1 class="alignleft"><?php the_title(); ?></h1></div>

				
			</header>
                    <div class="article-wrapper clearfix">
			<?php the_content(); ?>
					
			<?php wp_link_pages( array( 'before' => '<nav>' . __( 'Pages:', 'starkers' ), 'after' => '</nav>' ) ); ?>
		
			<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'starkers_author_bio_avatar_size', 60 ) ); ?>
				<h2><?php printf( esc_attr__( 'About %s', 'starkers' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						<?php printf( __( 'View all posts by %s &rarr;', 'starkers' ), get_the_author() ); ?>
					</a>
			<?php endif; ?>
                    </div>
                    
		</article>
        </div><!--end post-wrapper-->
        
        
			<footer class="post-footer clearfix">
                           
                                <?php starkers_posted_on(); ?>
                           
                            <div class="category-wrap">
				<?php starkers_posted_in(); ?>
                            </div>
				<div class="edit-wrap"><?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?></div>
                                <!-- AddThis Button BEGIN -->
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
 <a class="addthis_button_compact"></a><span style="color:#dedede;font-size: 13px">Share</span>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5035f60e64e72991"></script>
<!-- AddThis Button END -->
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5035f5a26111d9fd"></script>
<!-- AddThis Button END -->
                       </footer>
                    
        
        <div class="page-nav">
		<nav>
			<div class="single-old-post alignleft"><?php previous_post_link( '%link', '' . _x( '', 'Previous post link', 'starkers' ) . ' %title' ); ?></div>
			<div class="single-new-post alignright"><?php next_post_link( '%link', '%title ' . _x( '', 'Next post link', 'starkers' ) . '' ); ?></div>
		</nav>
        </div>
        <?php if ( function_exists('related_posts') ) { ?>
       <div id="yarpp-wrap"><?php related_posts(); ?></div> <?php } ?>
		<?php comments_template() ?>

<?php endwhile; // end of the loop. ?>
</div><!--end content-->