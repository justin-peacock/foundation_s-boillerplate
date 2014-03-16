<?php
/**
 * Foundation_s functions and definitions
 *
 * @package Foundation_s
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'foundation_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function foundation_s_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Foundation_s, use a find and replace
	 * to change 'foundation-s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'foundation-s', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'featured-image', 640, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'left-menu' => __( 'Topbar Left Menu', 'foundation-s' ),
		'right-menu' => __( 'Topbar Right Menu', 'foundation-s' )
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'foundation_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );
}
endif; // foundation_s_setup
add_action( 'after_setup_theme', 'foundation_s_setup' );

/**
 * Show Kitchen Sink in WYSIWYG Editor
 */
function minimus_unhide_kitchensink( $args ) {
	$args['wordpress_adv_hidden'] = false;
	return $args;
}
add_filter( 'tiny_mce_before_init', 'minimus_unhide_kitchensink' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function foundation_s_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'foundation-s' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'foundation_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function foundation_s_scripts() {
	// Stylesheets
	wp_enqueue_style( 'foundation-s-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,300,700' );
	wp_enqueue_style( 'foundation-s-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', null, '4.0.3' );
	wp_enqueue_style( 'foundation-s-style', get_stylesheet_uri() );

	// Scripts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( !is_admin() ) {
		wp_enqueue_script( 'foundation-s-modernizr', get_template_directory_uri().'/assets/js/vendor/modernizr.min.js', null, '2.7.1');
		wp_enqueue_script( 'foundation-s-foundation', get_template_directory_uri() . '/assets/js/scripts.min.js', array( 'jquery' ), '5.2.1', true );
	}
}
add_action( 'wp_enqueue_scripts', 'foundation_s_scripts' );

/**
 * Add conditional IE scripts
 */
function foundation_s_ie_scripts() { ?>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/ie.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/rem-fallback.css">
	<![endif]-->
<?php }
add_action( 'wp_head', 'foundation_s_ie_scripts', 8 );