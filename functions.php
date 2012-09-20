<?php
/**
 * Starkers functions and definitions
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

/** Tell WordPress to run starkers_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'starkers_setup' );

if ( ! function_exists( 'starkers_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_setup() {

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'starkers', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'starkers' ),
	) );
}
endif;

if ( ! function_exists( 'starkers_menu' ) ):
/**
 * Set our wp_nav_menu() fallback, starkers_menu().
 *
 * @since Starkers HTML5 3.0
 */    
function starkers_menu() {
	echo '<nav><ul><li><a href="'.get_bloginfo('url').'">Home</a></li>';
            wp_list_pages('title_li=');
	echo '</ul></nav>';
}
endif;

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * @since Starkers HTML5 3.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * @since Starkers HTML5 3.0
 * @deprecated in Starkers HTML5 3.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function starkers_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'starkers_remove_gallery_css' );

if ( ! function_exists( 'starkers_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>

	<article <?php comment_class(); ?>>
            <div class="rtp-comment-container">
			<div class="comment-avatar"><?php echo get_avatar( $comment, 70 ); ?>
                            <div class="comment-reply"> <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
                        </div>
                        
			<?php printf( __( '%s ', 'starkers' ), sprintf( '<div class="author-name">%s</div>', get_comment_author_link() ) ); ?>
            <?php
				/* translators: 1: date, 2: time */
				printf( __( ' <div class="comment-date">On %1$s</div> ', 'starkers' ), get_comment_date() ); ?><?php edit_comment_link( __( '(Edit)', 'starkers' ), ' ' );
			?>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<?php _e( 'Your comment is awaiting moderation.', 'starkers' ); ?>
			<br />
		<?php endif; ?>

		
			

		<div class="comment-text"><?php comment_text(); ?>
                    <?php if ( $comment->comment_approved == '0' ) : ?>
			<?php _e( 'Your comment is awaiting moderation.', 'starkers' ); ?>
			<br />
		<?php endif; ?>
                </div>
            </div>


	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<p><?php _e( 'Pingback:', 'starkers' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'starkers'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Closes comments and pingbacks with </article> instead of </li>.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_comment_close() {
	echo '</article>';
}

/**
 * Adjusts the comment_form() input types for HTML5.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_fields($fields) {
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$fields =  array(
	'author' => '<p><label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span style="color:#0197d7">*</span>' : '' ) .
	'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
	'email'  => '<p><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span style="color:#0197d7">*</span>' : '' ) .
	'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
	'url'    => '<p><label for="url">' . __( 'Website' ) . '</label>' .
	'<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
);
return $fields;
}
add_filter('comment_form_default_fields','starkers_fields');

/**
 * Register widgetized areas.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_widgets_init() {
	// Area 1, located at the top of the sidebar.
	 register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'starkers' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'starkers' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s test">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'starkers' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'starkers' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'starkers' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'starkers' ),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'starkers' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'starkers' ),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'starkers' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'starkers' ),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'starkers' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'starkers' ),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running starkers_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'starkers_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * @updated Starkers HTML5 3.2
 */
function starkers_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'starkers_remove_recent_comments_style' );

if ( ! function_exists( 'starkers_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_posted_on() {
	printf( __( '%2$s  %3$s', 'starkers' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" class="post-date" title="%2$s" rel="bookmark"><span>%4$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date('Y-m-d'),
			get_the_date()
		),
                
		sprintf( '<a href="%1$s" class="post-author" title="%2$s">%3$s</a>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'starkers' ), get_the_author() ),
			get_the_author()
		),
                  sprintf('<a herf="%5$s" class="category-wrap" title="%7$s">%5$s</a>'
                    ,get_the_category_list( ', ' )   ) 
	);
}
endif;

if ( ! function_exists( 'starkers_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Starkers HTML5 3.0
 */
function starkers_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( ' in %1$s', 'starkers' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( ' in %1$s ', 'starkers' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'starkers' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;


function rtp_new_search_form( $form ) {
    $form = '<form role="search" method="get" class="searchform" action="' . esc_url( home_url( '/' ) ) . '" >
        <div>
            <input type="text" value="' . get_search_query() . '" name="s" class="s" placeholder="Search" />
            <input type="submit" class="searchsubmit" value="'. esc_attr__('Search') .'" />
        </div>
        </form>';
    return $form;
}
add_filter( 'get_search_form', 'rtp_new_search_form' );


function cust_comment_form( $args = array(), $post_id = null ) {
	global $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( '', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Comment' ),
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div id="respond">
				<h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						<?php echo $args['comment_notes_after']; ?>
						<p class="form-submit">
							<input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
							<?php comment_id_fields( $post_id ); ?>
						</p>
						<?php do_action( 'comment_form', $post_id ); ?>
					</form>
				<?php endif; ?>
			</div><!-- #respond -->
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
        }
        
        function remove_category_list_rel($output)
{
  $output = str_replace(' rel="category tag"', '', $output);
  return $output;
}
add_filter('wp_list_categories', 'remove_category_list_rel');
add_filter('the_category', 'remove_category_list_rel');


/* how many posts to fetch, autostart the slide or not, and the effects
/* Call Slider */
function load_scripts() {
    
    wp_enqueue_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.js',array('jquery')  );
    wp_enqueue_script( 'rtp_custom_js', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery') );
}
add_action('wp_enqueue_scripts', 'load_scripts');

/*custom-slider */ 

class slider_widget extends WP_Widget {

    function slider_widget() {
        $widget_ops = array( 'classname' => 'slider_widget', 'description' => __( 'Shows featured image and contebt with slider ', 'starkers' ) );
        $this->WP_Widget( 'test-widget', __( 'slider_widget', 'starkers' ), $widget_ops );
    }

    function widget( $args, $instance ) {
       
        extract($args, EXTR_SKIP);
        
        $title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
        $post_count = empty( $instance['post_count'] ) ? '' : $instance['post_count'];
        $drop_down = empty( $instance['drop_down'] ) ? '' : $instance['drop_down'];
        echo $before_widget;

        if ( $title ) {
            echo $before_title . $title . $after_title; //
    
        }
        
?>
		
<?php

		
                        
        $args = array('post_type' => 'slider','posts_per_page' => $post_count );
        $query = new WP_Query( $args);
             echo '<div class="widget-slider">';
            if ( $query->have_posts() ) {
                
                echo '<ul>';
                while ( $query->have_posts() ) { $query->the_post();
                echo "<li>";
                 echo  the_title();
                
               
            if ( has_post_thumbnail() ) {
                echo the_post_thumbnail(get_the_ID(), 'thumbnail', array());
            }
        $excerpt = get_the_content();
        echo wp_html_excerpt($excerpt, 100);?>
            <a href="<?php echo get_permalink() ?>"> Read more</a>
            <input  role="textbox" id="hidden" name="hidden" type="hidden" value="<?php echo esc_attr( $drop_down ); ?>" />
<?php     
                    echo '</li>';
                    
                }
                echo '</ul>';
                echo '<div id="rtp-cycle-nav"></div>';
                echo '<a id ="stop">stop</a>';
                echo '<a id ="pause">pause</a>';
                echo '<a id ="resume">resume</a>';
                
            }
            
                echo '</div>';
   
             
                ;      
            // Reset Post Data
            wp_reset_postdata();
           

        echo $after_widget;
  
    }

    function update( $new_instance, $old_instance ) {        
        $instance = $old_instance;        
        $instance['title'] = strip_tags ( $new_instance['title'] );
        $instance['post_count'] = strip_tags ( $new_instance['post_count'] );
        $instance['hidden'] = strip_tags ( $new_instance['hidden'] );
        $instance['drop_down'] = strip_tags ( $new_instance['drop_down'] );
        return $instance;
    }

    function form($instance) {
        $post_count = isset ( $instance['post_count'] ) ? esc_attr( $instance['post_count'] ) : '';
        $hidden = isset ( $instance['hidden'] ) ? esc_attr( $instance['hidden'] ) : '';
        $drop_down = isset ( $instance['drop_down'] ) ? esc_attr( $instance['drop_down'] ) : '';
        $title = isset ( $instance[''] ) ? esc_attr( $instance['hidden'] ) : ''; ?>
        
        <p style="overflow: hidden;">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>" style="display: block; float: left; padding: 0 0 3px;"><?php _e( 'Title', 'Starkers' ); ?>: </label>
           <input  role="textbox" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
           <label for="<?php echo $this->get_field_id( 'post_count' ); ?>" style="display: block; float: left; padding: 0 0 3px;"><?php _e( 'number of posts', 'starkers' ); ?>: </label>
           <input  role="textbox" id="<?php echo $this->get_field_id('post_count'); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="text" value="<?php echo esc_attr( $post_count ); ?>" />
           
           <select id="scroll-effect" name="<?php echo $this->get_field_name( 'drop_down' ); ?>" >
               <option value="scrollRight" <?php selected('scrollRight',$drop_down) ?>><?php echo esc_attr(__('Scroll Right')); ?></option> 
                <option value="scrollLeft"<?php selected('scrollLeft',$drop_down) ?>><?php echo esc_attr(__('Scroll Left')); ?></option>
                <option value="blindX"<?php selected('blindX',$drop_down) ?>><?php echo esc_attr(__('blindX')); ?></option>
                <option value="blindY"<?php selected('blindY',$drop_down) ?>><?php echo esc_attr(__('blindY')); ?></option>
                <option value="blindZ"<?php selected('blindZ',$drop_down) ?>><?php echo esc_attr(__('blindZ')); ?></option>
                <option value="cover"<?php selected('cover',$drop_down) ?>><?php echo esc_attr(__('cover')); ?></option>
                <option value="curtainX"<?php selected('curtainX',$drop_down) ?>><?php echo esc_attr(__('curtainX')); ?></option>
                <option value="curtainY"<?php selected('curtainY',$drop_down) ?>><?php echo esc_attr(__('curtainY')); ?></option>
        </select>
           
        
                   
        </p>
    <?php
    }
}

function test_register_widgets() {
    register_widget( 'slider_widget' );
}
add_action( 'widgets_init', 'test_register_widgets' );?>

<?php 

/**
 * Custom post type 
 *  
 *
 */
function create_event() {  
    $labels = array( 
        'name' => _x('My Slider', 'post type general name'),
        'singular_name' => _x('Slider', 'post type singular name'),
        'add_new' => _x('Add New', 'Post'), 
        'add_new_item' => __('Add New Post'),
        'edit_item' => __('Edit Post'), 
        'new_item' => __('New Post'),
        'view_item' => __('View Post'),
        'search_items' => __('Search Post'), 
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => '' );   
        $args = array( 
            'labels' => $labels,
            'public' => true, 
            'publicly_queryable' => true, 
            'show_ui' => true, 
            'query_var' => true, 
           // 'menu_icon' => get_stylesheet_directory_uri() . '/article16.png', 'rewrite' => true,
            'capability_type' => 'post', 'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'custom-fields', 'revisions', 'excerpt' , 'thumbnail') ); 
        register_post_type( 'slider' , $args ); 
        

 
        
}
add_action('init', 'create_event');
/**
 * meta for slider
 */
function admin_credit_meta(){  
    add_meta_box("slider_meta", "Custom parmlink", "credit_meta", "slider", "side", "low");
    
 } 

 
 function credit_meta() { 
     global $post; 
     $custom = get_post_custom(
             $post->ID); 
             $change_permalink = $custom["change_permalink"][0]; 
            
             ?>
             <p>
                 <label>Permlink Url:</label><br />
                 <textarea cols="25" rows="2" name="change_permalink"><?php echo $change_permalink; ?></textarea>
             </p> 
              
          <?php } 
  
add_action("admin_init", "admin_credit_meta");

/*
 * save the values slider
 */

function save_slider(){
    global $post;   
    update_post_meta($post->ID, "change_permalink",$_POST["change_permalink"]);  
}

add_action('save_post', 'save_slider');

?>

