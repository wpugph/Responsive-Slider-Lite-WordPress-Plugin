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
						'name'                  => _x( 'Slider Lite', 'Post Type General Name', 'responsive_slider_lite' ),
						'singular_name'         => _x( 'Slider Lite', 'Post Type Singular Name', 'responsive_slider_lite' ),
						'menu_name'             => __( 'Slider Lite', 'responsive_slider_lite' ),
						'name_admin_bar'        => __( 'Slider Lite', 'responsive_slider_lite' ),
						'archives'              => __( 'Slider Archives', 'responsive_slider_lite' ),
						'parent_item_colon'     => __( 'Parent Item:', 'responsive_slider_lite' ),
						'all_items'             => __( 'All Sliders', 'responsive_slider_lite' ),
						'add_new_item'          => __( 'Add New Image', 'responsive_slider_lite' ),
						'add_new'               => __( 'Add New Image', 'responsive_slider_lite' ),
						'new_item'              => __( 'New Slider', 'responsive_slider_lite' ),
						'edit_item'             => __( 'Edit Slider', 'responsive_slider_lite' ),
						'update_item'           => __( 'Update Slider', 'responsive_slider_lite' ),
						'view_item'             => __( 'View Slider', 'responsive_slider_lite' ),
						'search_items'          => __( 'Search Slider', 'responsive_slider_lite' ),
						'not_found'             => __( 'Not found', 'responsive_slider_lite' ),
						'not_found_in_trash'    => __( 'Not found in Trash', 'responsive_slider_lite' ),
						'featured_image'        => __( 'Featured Image', 'responsive_slider_lite' ),
						'set_featured_image'    => __( 'Set featured image', 'businessportfolio' ),
						'remove_featured_image' => __( 'Remove featured image', 'responsive_slider_lite' ),
						'use_featured_image'    => __( 'Use as featured image', 'responsive_slider_lite' ),
						'insert_into_item'      => __( 'Insert into item', 'responsive_slider_lite' ),
						'uploaded_to_this_item' => __( 'Uploaded to this item', 'responsive_slider_lite' ),
						'items_list'            => __( 'Items list', 'responsive_slider_lite' ),
						'items_list_navigation' => __( 'Items list navigation', 'responsive_slider_lite' ),
						'filter_items_list'     => __( 'Filter items list', 'responsive_slider_lite' ),
					);
					$args = array(
						'label'                 => __( 'Slider Lite', 'responsive_slider_lite' ),
						'description'           => __( 'Slider Images', 'responsive_slider_lite' ),
						'labels'                => $labels,
						'supports'              => array( 'editor', 'title',  'thumbnail', 'page-attributes' ),
						'taxonomies'            => array( 'slider_cat' ),
						'hierarchical'          => true,
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
					register_post_type( 'responsive_slider_l', $args );
				}
				add_action( 'init', 'homeslider_post_type', 0 );
			}

			// Register Custom Taxonomy
			function responsive_slider_l_taxonomy() {

				$labels = array(
					'name'                       => _x( 'Slider Categories', 'Taxonomy General Name', 'responsive_slider_l' ),
					'singular_name'              => _x( 'Slider Category', 'Taxonomy Singular Name', 'responsive_slider_l' ),
					'menu_name'                  => __( 'Slider Category', 'responsive_slider_l' ),
					'all_items'                  => __( 'All Slider Category', 'responsive_slider_l' ),
					'parent_item'                => __( 'Parent Slider Category', 'responsive_slider_l' ),
					'parent_item_colon'          => __( 'Parent Slider Category:', 'responsive_slider_l' ),
					'new_item_name'              => __( 'New Slider Category', 'responsive_slider_l' ),
					'add_new_item'               => __( 'Add New Slider Category', 'responsive_slider_l' ),
					'edit_item'                  => __( 'Edit Slider Category', 'responsive_slider_l' ),
					'update_item'                => __( 'Update Slider Category', 'responsive_slider_l' ),
					'view_item'                  => __( 'View Slider Category', 'responsive_slider_l' ),
					'separate_items_with_commas' => __( 'Separate Slider Category with commas', 'responsive_slider_l' ),
					'add_or_remove_items'        => __( 'Add or remove Slider Category', 'responsive_slider_l' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'responsive_slider_l' ),
					'popular_items'              => __( 'Popular Slider Category', 'responsive_slider_l' ),
					'search_items'               => __( 'Search Slider Category', 'responsive_slider_l' ),
					'not_found'                  => __( 'Not Found', 'responsive_slider_l' ),
					'no_terms'                   => __( 'No Slider Category', 'responsive_slider_l' ),
					'items_list'                 => __( 'Items Slider Category', 'responsive_slider_l' ),
					'items_list_navigation'      => __( 'Items list navigation', 'responsive_slider_l' ),
				);
				$args = array(
					'labels'                     => $labels,
					'hierarchical'               => true,
					'public'                     => true,
					'show_ui'                    => true,
					'show_admin_column'          => true,
					'show_in_nav_menus'          => true,
					'show_tagcloud'              => true,
				);
				register_taxonomy( 'responsive_slider_cat', array( 'responsive_slider_l' ), $args );

			}
			add_action( 'init', 'responsive_slider_l_taxonomy', 0 );

	}

	public function homeslider_style_admin() {

		function homeslider_get_featured_image($post_ID) {
		    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
		    if ($post_thumbnail_id) {
		        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured');
		        return $post_thumbnail_img[0];
		    }
		}
		// ADD NEW COLUMN
		function homeslider_columns_head($defaults) {
		    $defaults['featured_image'] = __('Featured Image', 'responsive_slider_l');
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

		add_filter('manage_responsive_slider_l_posts_columns', 'homeslider_columns_head');
		add_action('manage_responsive_slider_l_posts_custom_column', 'homeslider_columns_content', 10, 2);

	}

	//resgister shortcode
	public function activate_slider_responsive_sc() {
		function responsive_slider_lite_func( $options ) {
		    $att = shortcode_atts( array(
		        'cat' => '',
		    ), $options );
				$cat = "{$att['cat']}";
				$args = array(
						'post_type' => 'responsive_slider_l',
						'taxonomy' => 'responsive_slider_cat',
						'term' => $cat,
				);
				$loop = new WP_Query( $args );
				render_slider_front($loop);
				//var_dump($cat);
		    return;
		}

		function render_slider_front($loop) {
			?>
			<div class="container-fluid">
				 <br>
				 <div id="myCarousel" class="carousel slide" data-ride="carousel">
					 <div class="carousel-inner" role="listbox">
						 <?php
						 $c = 0;
						 $class = '';
						 while ( $loop->have_posts() ) : $loop->the_post(); ?>
							 <?php
								 $c++;
								 if ( $c == 1 ) {
									 $class = ' active';
								 } else {
									 $class = '';
								 };
								?>
							 <div class="item<?php echo $class ?>">
								<?php
									//$feat_image_size = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ));
									$feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
									echo '<img src="' . $feat_image . '" alt="" width="" height="">' ;
									//echo '<div class="carousel-caption">';
									//echo '<h3></h3>';
									//echo '<p></p>';
									//echo '</div>';
								?>
							</div>
						<?php endwhile; ?>
					</div>
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
			<?php
		}
		add_shortcode( 'rsliderl', 'responsive_slider_lite_func' );
	}

}
