<?php
/*Plugin Name: Slider LF
Description: Use the form [home-slider]
Version: 1.0
License: GPLv2
Author: Dionisio Chavez
*/

// ENQUEUE FOR ADMIN

$cpt = array("slide");

include_once('mui/multi-image-upload.php');
include_once('pto/post-types-order.php');
include_once('inc/settings.php');

// ENQUEUE FOR ADMIN

function load_custom_wp_admin_style(){
    wp_enqueue_style( 'custom_wp_admin_css',  plugin_dir_url( __FILE__ ) . '/css/admin.css' );
    wp_enqueue_style( 'custom_wp_admin_css' );
}

add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');



function plugin_scripts() {
	if(is_home()){
		wp_enqueue_style( 'cycle2-styles',  plugin_dir_url( __FILE__ ) .'css/cycle.css' );
		wp_enqueue_style( 'demo-cycle2-styles',  plugin_dir_url( __FILE__ ) .'css/demo-slideshow.css' );
	}

	wp_enqueue_script( 'jquery' );
	
	if(is_home()){
		wp_enqueue_script( 'cycle2-js', plugin_dir_url( __FILE__ ) . 'js/jquery.cycle2.js', array(), '3.0.3', true );
		wp_enqueue_script( 'cycle2-carousel-js', plugin_dir_url( __FILE__ ) . 'js/jquery.cycle2.carousel.js', array(), '3.0.3', true );
		//wp_enqueue_script( 'videoLightning-js', plugin_dir_url( __FILE__ ) . 'js/videoLightning.min.js', array(), '3.0.3', true );
		wp_enqueue_script( 'hoverIntent-js', plugin_dir_url( __FILE__ ) . 'js/jquery.hoverIntent.js', array(), '3.0.3', true );
		
		wp_enqueue_script( 'script-js', plugin_dir_url( __FILE__ ) . 'js/scripts.js', array(), '1.0', true );
	}
}

add_action( 'wp_enqueue_scripts', 'plugin_scripts' );


// THUMBNAILS

function admin_thumbnails_creation() {
  //add_image_size( 'category-thumb', 300 ); // 300 pixels wide (and unlimited height)
  add_image_size( 'admin-thumb', 242, 140, true ); // (cropped)
}

add_action( 'after_setup_theme', 'admin_thumbnails_creation' );


// ADD CUSTOM POST TYPE

function wpmudev_create_post_type() {
$labels = array(
	'name' => 'Slides',
	'singular_name' => 'Slide',
	'add_new' => 'Add New',
	'add_new_item' => 'Add New',
	'edit_item' => 'Edit',
	'new_item' => 'New',
	'all_items' => 'All Items',
	'view_item' => 'View',
	'search_items' => 'Search',
	'not_found' => 'No Items Found',
	'not_found_in_trash' => 'No Items found in Trash',
	'parent_item_colon' => '',
	'menu_name' => 'Slides',
	);

	//register post type
	register_post_type( 'slide', array(
		'labels' => $labels,
		'has_archive' => true,
		'menu_position'	=>	5,
		'public'		=>	true,
		'hierarchical' => flase,
		//'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
		'supports' => array('title'),
		// 'taxonomies' => array( 'post_tag', 'category' ),
		'menu_icon'           => 'dashicons-editor-code',
		'exclude_from_search' => false,
		'_builtin' => false, // It's a custom post type, not built in!
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'slide' ),
		
		)
	);
}
add_action( 'init', 'wpmudev_create_post_type' );

// GET FEATURED IMAGE
function ST4_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'homepage-thumb');
        return the_post_thumbnail('homepage-thumb');
    }
}

// ONLY MOVIE CUSTOM TYPE POSTS
add_filter('manage_slide_posts_columns', 'ST4_columns_head_only_slide', 10);
add_action('manage_slide_posts_custom_column', 'ST4_columns_content_only_slide', 10, 2);
 
// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
function ST4_columns_head_only_slide($defaults) {
	
    $defaults['slide_image'] = 'Slide image';
    return $defaults;
}
function ST4_columns_content_only_slide($column_name, $post_ID) {

	$image = miu_get_images($post_ID);
    if ($column_name == 'slide_image') {
        
        if ($image[0]){
            echo '<img width="100" src="' . $image[0] . '" />';
        }
    }
}







/**
* Add a link to the WordPress menu
*/
function add_option_page() {

    add_submenu_page('edit.php?post_type=slide', 'Slides', __('Settings', $this->hook), $this->accesslvl, 'slide', array(&$this, 'display_admin_page'));

}




//*******************************************************//
// CREATE CUSTOM FIELDS FOR THE CUSTOM POST TYPE "SLIDE"
//*******************************************************//

function add_slide_meta_boxes() {
	add_meta_box("slide_contact_meta", "Información Adicional", "add_contact_details_slide_meta_box", "slide", "normal", "low");
}
function add_contact_details_slide_meta_box()
{
	global $post;
	$custom = get_post_custom( $post->ID );
 
	?>
	<style>.width99 {width:99%;}</style>
	<p>
		<label>Sub-Titulo:</label><br />
		<input type="text" name="subtitulo" value="<?= @$custom["subtitulo"][0] ?>" class="width99" />
	</p>
	<p>
		<label>Enlace (URL):</label><br />
		<input type="text" name="enlace" value='<?= @$custom["enlace"][0] ?>' class="width99" />
	</p>
	<!-- <p>
		<label>Phone:</label><br />
		<input type="text" name="phone" value="<?= @$custom["phone"][0] ?>" class="width99" />
	</p> -->
	<?php
}
/**
 * Save custom field data when creating/updating posts
 */
function save_slide_custom_fields(){
  global $post;
 
  if ( $post )
  {
    update_post_meta($post->ID, "subtitulo", @$_POST["subtitulo"]);
    update_post_meta($post->ID, "enlace", @$_POST["enlace"]);
    //update_post_meta($post->ID, "phone", @$_POST["phone"]);
  }
}
add_action( 'admin_init', 'add_slide_meta_boxes' );
add_action( 'save_post', 'save_slide_custom_fields' );



// SHORTCODE

function hacer_shortcode() {

	$timeout = esc_attr( get_option('timeout'));
	$autoslide = esc_attr( get_option('autoslide') );
	$pausehover = esc_attr( get_option('pausehover') );

	echo '<div class="cycle-slideshow"';
	echo 'data-cycle-fx="fade"';
	if($autoslide) 
		if(esc_attr( get_option('timeout') ))
			echo 'data-cycle-timeout="'.$timeout.'"';

	if($pausehover)
		echo 'data-cycle-pause-on-hover="true"';
		
	echo 'data-cycle-prev="#prev"
		data-cycle-next="#next"
		data-cycle-slides=">div"
		data-cycle-center-horz=true
		data-cycle-center-vert=true>
		    <span class="master-wrapper">
		    	<div class="slide-title-container">
			    	<div class="table">
			    		<div class="table-cell">
			    			<h1></h1>
			    			<h4></h4>
			    			<a target="" class="gotonews" href="">IR A LA NOTICIA →</a>
			 			</div>
			    	</div>
		    	</div>
		    </span>
		    <span class="hover-img"></span>
  
';

// args
$args = array(
	'numberposts'	=> -1,
	'post_type'		=> 'slide',
 	'post__not_in'     => $do_not_duplicate
	

);


// query

$query = new WP_Query($args);
while ($query->have_posts()) : $query->the_post();
?>

	<?php 

	$image = miu_get_images($post->ID);

	// VERIFINADO EL DOMINIO 

	$domain = "http://" . $_SERVER['HTTP_HOST'];
	
	$string = get_post_meta(get_the_ID(), "enlace", true);

	if (strpos($string, $domain) !== false) {
	    $target = '_self'; 
	}else{
		$target = '_blank';
	}


	 ?>
	<!-- <input class="news-link" type="hidden" value="<?php echo get_post_meta($post->ID, "enlace"); ?>"> -->
    <div class="slide-img-container" 
     	data-url="<?php echo get_post_meta(get_the_ID(), "enlace", true); ?>" 
     	data-target="<?= $target; ?>" data-title="<?php echo strip_tags(get_the_title()); ?>" 
     	data-subtitle="<?php echo get_post_meta(get_the_ID(), "subtitulo", true); ?>" 
     	style="background-image: url(<?= $image[0]; ?>)">
    </div>
    
<?php endwhile; wp_reset_query(); ?>
	
    <?php echo '</div>

<div class="nav-center">
	
    	<a href=# id="prev"><span class="text"><div class="table"><div class="table-cell"></div></div></span> <span class="arrow"></span></a> 
    	<a href=# id="next"><span class="text"><div class="table"><div class="table-cell"></div></div></span> <span class="arrow"></span></a>
 
</div>';
}
add_shortcode('home-slider', 'hacer_shortcode' );