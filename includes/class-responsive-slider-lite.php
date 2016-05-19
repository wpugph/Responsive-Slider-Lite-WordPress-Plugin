<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://carlalberto.ml/
 * @since      1.0.0
 *
 * @package    Responsive_Slider_Lite
 * @subpackage Responsive_Slider_Lite/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Responsive_Slider_Lite
 * @subpackage Responsive_Slider_Lite/includes
 * @author     Carl Alberto <cgalbert01@gmail.com>
 */
class Responsive_Slider_Lite {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Responsive_Slider_Lite_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'responsive-slider-lite';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Responsive_Slider_Lite_Loader. Orchestrates the hooks of the plugin.
	 * - Responsive_Slider_Lite_i18n. Defines internationalization functionality.
	 * - Responsive_Slider_Lite_Admin. Defines all hooks for the admin area.
	 * - Responsive_Slider_Lite_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-responsive-slider-lite-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-responsive-slider-lite-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-responsive-slider-lite-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-responsive-slider-lite-public.php';

		$this->loader = new Responsive_Slider_Lite_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Responsive_Slider_Lite_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Responsive_Slider_Lite_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Responsive_Slider_Lite_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Responsive_Slider_Lite_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Responsive_Slider_Lite_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


	public function register_homeslider() {
			if ( ! function_exists('homeslider_post_type') ) {
				// Register Slider CPT
				function homeslider_post_type() {
					$labels = array(
						'name'                  => _x( 'Home Sliders', 'Post Type General Name', 'businessportfolio' ),
						'singular_name'         => _x( 'Home Slider', 'Post Type Singular Name', 'businessportfolio' ),
						'menu_name'             => __( 'Home Slider', 'businessportfolio' ),
						'name_admin_bar'        => __( 'Home Slider', 'businessportfolio' ),
						'archives'              => __( 'Home Slider Archives', 'businessportfolio' ),
						'parent_item_colon'     => __( 'Parent Item:', 'businessportfolio' ),
						'all_items'             => __( 'All Sliders', 'businessportfolio' ),
						'add_new_item'          => __( 'Add New Slider', 'businessportfolio' ),
						'add_new'               => __( 'Add New Slider', 'businessportfolio' ),
						'new_item'              => __( 'New Slider', 'businessportfolio' ),
						'edit_item'             => __( 'Edit Slider', 'businessportfolio' ),
						'update_item'           => __( 'Update Slider', 'businessportfolio' ),
						'view_item'             => __( 'View Slider', 'businessportfolio' ),
						'search_items'          => __( 'Search Slider', 'businessportfolio' ),
						'not_found'             => __( 'Not found', 'businessportfolio' ),
						'not_found_in_trash'    => __( 'Not found in Trash', 'businessportfolio' ),
						'featured_image'        => __( 'Featured Image', 'businessportfolio' ),
						'set_featured_image'    => __( 'Set featured image', 'businessportfolio' ),
						'remove_featured_image' => __( 'Remove featured image', 'businessportfolio' ),
						'use_featured_image'    => __( 'Use as featured image', 'businessportfolio' ),
						'insert_into_item'      => __( 'Insert into item', 'businessportfolio' ),
						'uploaded_to_this_item' => __( 'Uploaded to this item', 'businessportfolio' ),
						'items_list'            => __( 'Items list', 'businessportfolio' ),
						'items_list_navigation' => __( 'Items list navigation', 'businessportfolio' ),
						'filter_items_list'     => __( 'Filter items list', 'businessportfolio' ),
					);
					$args = array(
						'label'                 => __( 'Home Slider', 'businessportfolio' ),
						'description'           => __( 'Home Page Slider Images', 'businessportfolio' ),
						'labels'                => $labels,
						'supports'              => array( 'editor', 'title',  'thumbnail', ),
						'taxonomies'            => array( '' ),
						'hierarchical'          => false,
						'public'                => true,
						'show_ui'               => true,
						'show_in_menu'          => true,
						'menu_position'         => 5,
						'menu_icon'             => 'dashicons-format-gallery',
						'show_in_admin_bar'     => true,
						'show_in_nav_menus'     => true,
						'can_export'            => true,
						'has_archive'           => true,
						'exclude_from_search'   => false,
						'publicly_queryable'    => true,
						'capability_type'       => 'page',
					);
					register_post_type( 'homeslider', $args );
				}
				add_action( 'init', 'homeslider_post_type', 0 );
			}
	}

	public function homeslider_style_admin() {

		add_filter( 'manage_edit-homeslider_columns', 'set_custom_edit_homeslider_columns' );
		add_action( 'manage_homeslider_posts_custom_column' , 'custom_homeslider_columns', 10, 2 );

		function set_custom_edit_homeslider_columns( $columns ) {
		    $columns['title'] = __( 'Image Title' );
		    $columns['featured_image'] = __( 'Image' );
		    return $columns;
		}

		function custom_homeslider_columns( $column, $post_id ) {
		    switch ( $column ) {
		        case 'title' :
		            echo get_post_meta( $post_id, '_quote_post_pairname', true );
		            break;
		        case 'thumbnail' :
		            echo get_post_meta( $post_id, 'thumbnail', true );
		            break;
		    }
		}

		function homeslider_get_featured_image($post_ID) {
		    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
		    if ($post_thumbnail_id) {
		        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
		        return $post_thumbnail_img[0];
		    }
		}
		// ADD NEW COLUMN
		function homeslider_columns_head($defaults) {
		    $defaults['featured_image'] = 'Featured Image';
		    return $defaults;
		}
		// SHOW THE FEATURED IMAGE
		function homeslider_columns_content($column_name, $post_ID) {
		    if ($column_name == 'featured_image') {
		        $post_featured_image = homeslider_get_featured_image($post_ID);
		        if ($post_featured_image) {
		            echo '<img src="' . $post_featured_image . '" height="100px"/>';
		        }
		    }
		}

		add_filter('manage_posts_columns', 'homeslider_columns_head');
		add_action('manage_posts_custom_column', 'homeslider_columns_content', 9, 2);

	}

}
