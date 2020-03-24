<?php
/**
 * Hornby functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hornby
 */

if ( ! function_exists( 'hornby_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function hornby_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Hornby, use a find and replace
		 * to change 'hornby' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'hornby', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Register navigation menus uses wp_nav_menu
		 */
		function hornby_nav_menus() {
			register_nav_menus(
				array(
					'header-menu' => __('Header Menu', 'hornby')
				)
			);
		}
		add_action('init', 'hornby_nav_menus');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'hornby_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( array( 'css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'hornby_setup' );

/**
 * Change the default separator '-' to a custom one.
 */
function hornby_document_title_separator($sep) {
	$sep = '|';
	return $sep;
}
add_filter('document_title_separator', 'hornby_document_title_separator');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hornby_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'hornby_content_width', 640 );
}
add_action( 'after_setup_theme', 'hornby_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hornby_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'hornby' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'hornby' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'hornby_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hornby_scripts() {

	// Enqueue normalize.min.css
	wp_enqueue_style( 'normalize-style', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css', array(), '8.0.1' );

	// Enqueue bootstrap.min.css
	// wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.min.css', array(), '4.3.1' );
	
	// Enqueue main.css
	wp_enqueue_style( 'hornby-style', get_template_directory_uri() . '/css/main.css', array(), '1.0' );
	
	// Enqueue google fonts
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,500,700|Noto+Sans:400,700&display=swap', array(), '1.0' );

	// Enqueue google material icons
	wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '1.0' );

	// Enqueue style.css (in the root directory of the theme)
	wp_enqueue_style( 'wp-style', get_stylesheet_uri(), array(), '1.0' );

	// Enqueue font awesome
	wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/e73c9f8b45.js', array(), '5.11.2' );
	// Add a crossorigin attribute on font awesome script tags
	function add_crossorigin_to_script($tag, $handle, $src) {
		if ($handle == 'font-awesome') {
			$tag = '<script type="text/javascript" src="' . $src . '" crossorigin="anonymous"></script>';
		}
		return $tag;
	}
	add_filter('script_loader_tag', 'add_crossorigin_to_script', 10, 3);

	// Enqueue jQuery
	wp_deregister_script( 'jquery' );  // Remove default WordPress jQuery
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/node_modules/jquery/dist/jquery.min.js', array(), '3.4.1', true );

	// Enqueue Popper.js for Bootstrap
	wp_enqueue_script( 'bootstrap-popper', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', array(), '4.3.1', true );

	// Enqueue bootstrap.min.js
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.min.js', array('jquery', 'bootstrap-popper'), '4.3.1', true );

	// Enqueue script.js
	wp_enqueue_script( 'hornby-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true );

	// Enqueue the comment-reply script if certain conditions exist
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hornby_scripts' );