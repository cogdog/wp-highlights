<?php
/* Functions and stuff for the WP-Highlights theme

   Based on HTML5up html5up.net

   mods by and blame go to http://cog.dog
*/


/* --- setup -------------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'highlights_setup' );
function highlights_setup() {
   add_theme_support( 'title-tag' );

   // give us thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1024, 768, true );

	// give us custom headers (used for background of intro section)
	$defaults = array(
		'default-image'          => get_template_directory_uri() . '/images/header.jpg',
		'width'                  => 1024,
		'height'                 => 768,
		'uploads'                => true,
		'random-default'         => false,
		'header-text'            => false,
	);

	add_theme_support( 'custom-header', $defaults );

}

function highlights_modify_read_more_link() {
    return '<div class="morebutton"><a class="button special icon fa-share-square-o " href="' . get_permalink() . '#more">MORE...</a></div>';

}

add_filter( 'the_content_more_link', 'highlights_modify_read_more_link' );

/* --- menus -------------------------------------------------------------------------- */
add_action( 'init', 'highlights_register_my_menu' );

function highlights_register_my_menu() {
	register_nav_menu( 'highlights-social', __( 'Social Media' ) );
}

// --------- rebrand posts ---------------------------------------------------------------

// change the name of admin menu items from "Posts" to be "Sections"
// -- h/t https://wordpress.stackexchange.com/a/9224/14945

// change the prompts and stuff for posts to be relevant to Sections

add_action( 'init', 'highlights_change_post_object' );

function highlights_change_post_object() {

    $thing_name = 'Section';

    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name =  $thing_name . 's';
    $labels->singular_name =  $thing_name;
    $labels->add_new = 'Add ' . $thing_name;
    $labels->add_new_item = 'Add ' . $thing_name;
    $labels->edit_item = 'Edit ' . $thing_name;
    $labels->new_item =  $thing_name;
    $labels->view_item = 'View ' . $thing_name;
    $labels->search_items = 'Search ' . $thing_name;
    $labels->not_found = 'No ' . $thing_name . ' found';
    $labels->not_found_in_trash = 'No ' .  $thing_name . ' found in Trash';
    $labels->all_items = 'All ' . $thing_name . 's';
    $labels->menu_name =  $thing_name . 's';
    $labels->name_admin_bar =  $thing_name;
    $labels->attributes = $thing_name . ' Properties';
}

// edit the post editing admin messages to reflect use of Sections
// h/t http://www.joanmiquelviade.com/how-to-change-the-wordpress-post-updated-messages-of-the-edit-screen/


add_filter( 'post_updated_messages', 'highlights_post_updated_messages', 10, 1 );

function highlights_post_updated_messages ( $msg ) {
    $msg[ 'post' ] = array (
     0 => '', // Unused. Messages start at index 1.
	 1 => "Section updated.",
	 2 => 'Custom field updated.',  // Probably better do not touch
	 3 => 'Custom field deleted.',  // Probably better do not touch

	 4 => "Section updated.",
	 5 => "Section restored to revision",
	 6 => "Section published.",

	 7 => "Section saved.",
	 8 => "Section submitted.",
	 9 => "Section scheduled.",
	10 => "Section draft updated.",
    );
    return $msg;
}


/* --- post order  --------------------------------------------------------------------- */


// add menu order to posts
function highlights_posts_order() {
    add_post_type_support( 'post', 'page-attributes' );
}

add_action( 'admin_init', 'highlights_posts_order' );


// add post order to posts
function highlights_columns_show_columns($name) {
    global $post;

    switch ($name) {
        case 'order':
            $views = $post->menu_order;
            echo $views;
            break;
    }
}

add_action('manage_posts_custom_column',  'highlights_columns_show_columns');

/* Sort posts in posts view by menu_order in ascending or descending order. */

// h/t http://wordpress.stackexchange.com/questions/66455/how-to-change-order-of-posts-in-admin
function custom_post_order($query){
    /*
        Set post types.
        _builtin => true returns WordPress default post types.
        _builtin => false returns custom registered post types.
    */
    $post_types = get_post_types(array('_builtin' => true), 'names');
    /* The current post type. */
    $post_type = $query->get('post_type');
    /* Check post types. */
    if(in_array($post_type, $post_types)){
        /* Post Column: e.g. title */
        if($query->get('orderby') == ''){
            $query->set('orderby', 'menu_order');
        }
        /* Post Order: ASC / DESC */
        if($query->get('order') == ''){
            $query->set('order', 'ASC');
        }
    }
}

if (is_admin()){
    add_action('pre_get_posts', 'custom_post_order');
}

// organize the admin view; removed date / category, insert slide order columns
// h/t http://stackoverflow.com/questions/27602116/how-to-add-order-column-in-page-admin-wordpress


add_filter('manage_posts_columns', 'highlights_columns');

function highlights_columns($columns) {

	$highlights_columns = array();

	foreach( $columns as $key => $value) {

		if ( $key != 'date' and $key != 'categories' ) $highlights_columns[$key] = $value;
		if ( $key== 'title' ) {
			$highlights_columns['order'] = ' Section Order';
		}
	}

    return $highlights_columns;
}


/* --- enqueues ------------------------------------------------------------------------ */
// enqueue the scripts'n styles... do it right!

function highlights_scripts() {

	// Big Picture CSS
	wp_register_style( 'highlights-style', get_template_directory_uri() . '/assets/css/main.css' );
	wp_enqueue_style( 'highlights-style' );

	// big pictuer wordpress  CSS
	wp_register_style( 'highlights-style-wp', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'highlights-style-wp' );


	// scrolly jquery down in the footer you go
	wp_register_script( 'highlights-scrollex' , get_template_directory_uri() . '/assets/js/jquery.scrollex.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'highlights-scrollex' );

	// scrolly jquery down in the footer you go
	wp_register_script( 'highlights-scrolly' , get_template_directory_uri() . '/assets/js/jquery.scrolly.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'highlights-scrolly' );

	// custom jquery down in the footer you go
	wp_register_script( 'highlights-skel' , get_template_directory_uri() . '/assets/js/skel.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'highlights-skel' );

	wp_register_script( 'highlights-util' , get_template_directory_uri() . '/assets/js/util.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'highlights-util' );


	wp_register_script( 'highlights-main' , get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'highlights-main' );

}

add_action( 'wp_enqueue_scripts', 'highlights_scripts' );


/* --- customizer ----------------------------------------------------------------------- */

// register custom customizer stuff
add_action( 'customize_register', 'highlights_register_theme_customizer' );

function highlights_register_theme_customizer( $wp_customize ) {
	// Create custom panel.


	// Add section for header
	$wp_customize->add_section( 'intro_stuff' , array(
		'title'    => __('WP Highlights Mods','highlights'),
		'priority' => 25
	) );


	// Add setting for header
	$wp_customize->add_setting( 'section_max', array(
		 'default'           => __( '10', 'highlights' ),
	) );

	// Add control for quote
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'section_max',
		    array(
		        'label'    => __( 'Maximum Number Sections', 'highlights' ),
		        'description' => __( 'Set the total number of allowed items on front page', 'highlights'  ),
		        'section'  => 'intro_stuff',
		        'settings' => 'section_max',
		        'type'     => 'number',
		        'input_attrs' => array(
    '				min' => 1,
   				   'max' => 20,
                   'step' => 1,
  				),

		    )
	    )
	);

	// Add setting for header
	$wp_customize->add_setting( 'intro_header_text', array(
		 'default'           => __( 'My Highlights', 'highlights' ),
		 'sanitize_callback' => 'sanitize_text',

	) );
	// Add control for quote
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'intro_header_text',
		    array(
		        'label'    => __( 'Header Text', 'highlights' ),
		        'section'  => 'intro_stuff',
		        'settings' => 'intro_header_text',
		        'type'     => 'text'
		    )
	    )
	);

	// Add setting for front text
	$wp_customize->add_setting( 'intro_blurb_content', array(
		 'default'           => __( 'This is the exciting tag line you <strong>might</strong> customize!', 'highlights' ),
		 'sanitize_callback' => 'highlights_sanitize_html'
	) );
	// Add control for front text
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'intro_blurb_text',
		    array(
		        'label'    => __( 'Intro Blurb (allowable HTML tags are: a, em, strong, br)', 'highlights' ),
		        'section'  => 'intro_stuff',
		        'settings' => 'intro_blurb_content',
		        'type'     => 'textarea'
		    )
	    )
	);

	// Add setting for footer
	$wp_customize->add_setting( 'footer_text_block', array(
		 'default'           => __( '', 'highlights' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control for footer
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_text',
		    array(
		        'label'    => __( 'Footer Text', 'highlights' ),
		        'section'  => 'intro_stuff',
		        'settings' => 'footer_text_block',
		        'type'     => 'text'
		    )
	    )
	);





 	// Sanitize text
	function sanitize_text( $text ) {
	    return sanitize_text_field( $text );
	}

	// convert string to a slug-worthy one
	function slug_text ( $text ) {
		 return sanitize_title( $text );
	}

 	// Allow just some html
	function highlights_sanitize_html( $value ) {

		$allowed_html = [
			'a'      => [
				'href'  => [],
				'title' => [],
			],
			'br'     => [],
			'em'     => [],
			'strong' => [],
		];

		return  wp_kses( $value, $allowed_html );
	}

}


function get_highlights_section_max() {

	 if ( get_theme_mod( 'section_max') ) {
	 	return get_theme_mod( 'section_max' );
	 }	else {
	 	return 10;
	 }
}

function highlights_intro_header() {
	 if ( get_theme_mod( 'intro_header_text') != "" ) {
	 	echo get_theme_mod( 'intro_header_text');
	 }	else {
	 	echo 'Hey!';
	 }
}


function highlights_intro_blurb() {
	 if ( get_theme_mod( 'intro_blurb_content') != "" ) {
	 	echo '<p>' . get_theme_mod( 'intro_blurb_content') . '</p>';
	 }	else {
	 	echo '<p>This is the exciting tag line you <strong>might</strong> customize!</p>';
	 }
}


function highlights_footer_text() {
	 if ( get_theme_mod( 'footer_text_block') != "" ) {
	 	echo get_theme_mod( 'footer_text_block');
	 }	else {
	 	echo 'Customize this with your own tagline!';
	 }
}


// Load plugin requirements file to display admin notices.
require get_template_directory() . '/includes/splot-plugins.php';


?>
