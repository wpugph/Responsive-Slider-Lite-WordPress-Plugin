<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://carlalberto.ml/
 * @since      1.0.0
 *
 * @package    Responsive_Slider_Lite
 * @subpackage Responsive_Slider_Lite/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Responsive_Slider_Lite
 * @subpackage Responsive_Slider_Lite/includes
 * @author     Carl Alberto <cgalbert01@gmail.com>
 */
class Responsive_Slider_Lite_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

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
			add_filter( 'manage_edit-homeslider_columns', 'set_custom_edit_homeslider_columns' );
			add_action( 'manage_homeslider_posts_custom_column' , 'custom_homeslider_columns', 10, 2 );
			function set_custom_edit_homeslider_columns( $columns ) {
			    $columns['title'] = __( 'Image Title' );
			    //$columns['thumbnail'] = __( 'thumbnail' );
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
		add_action('manage_posts_custom_column', 'homeslider_columns_content', 10, 2);

	}

}
