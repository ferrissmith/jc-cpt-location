<?php
/**
 * Creates and manages the location CPT.
 *
 * @since      0.1.0
 *
 * @package    CPT_Location
 * @subpackage CPT_Location/core
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class CPT_Location_InitCPT {

	private $post_type = 'jc-location';
	private $label_singular = 'Location';
	private $label_plural = 'Locations';
	private $icon = 'location';

	function __construct() {

		$this->add_actions();
	}

	private function add_actions() {

		add_action( 'init', array( $this, '_create_cpt' ) );
		add_filter( 'post_updated_messages', array( $this, '_post_messages' ) );
		add_action( 'add_meta_boxes', array( $this, '_add_meta_boxes' ), 100 );
		add_action( 'current_screen', array( $this, '_page_actions' ) );

		add_filter( 'post_type_labels_jc-location', array( $this, '_rename_featured_image' ) );
	}

	function _page_actions( $screen ) {

		if ( $screen->id != 'jc-location' ) {
			return;
		}

		// Load Parsley
		add_filter( 'rbm_load_parsley', '__return_true' );
	}

	function _create_cpt() {

		$labels = array(
			'name'               => $this->label_plural,
			'singular_name'      => $this->label_singular,
			'menu_name'          => $this->label_plural,
			'name_admin_bar'     => $this->label_singular,
			'add_new'            => "Add New",
			'add_new_item'       => "Add New $this->label_singular",
			'new_item'           => "New $this->label_singular",
			'edit_item'          => "Edit $this->label_singular",
			'view_item'          => "View $this->label_singular",
			'all_items'          => "All $this->label_plural",
			'search_items'       => "Search $this->label_plural",
			'parent_item_colon'  => "Parent $this->label_plural:",
			'not_found'          => "No $this->label_plural found.",
			'not_found_in_trash' => "No $this->label_plural found in Trash.",
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'menu_icon'          => 'dashicons-' . $this->icon,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'thumbnail', 'editor' )
		);

		register_post_type( $this->post_type, $args );
	}

	function _post_messages( $messages ) {

		$post             = get_post();
		$post_type_object = get_post_type_object( $this->post_type );

		$messages[ $this->post_type ] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => "$this->label_singular updated.",
			2  => 'Custom field updated.',
			3  => 'Custom field deleted.',
			4  => "$this->label_singular updated.",
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? "$this->label_singular restored to revision from " . wp_post_revision_title( (int) $_GET['revision'], false ) : false,
			6  => "$this->label_singular published.",
			7  => "$this->label_singular saved.",
			8  => "$this->label_singular submitted.",
			9  => "$this->label_singular scheduled for: <strong>" . date( 'M j, Y @ G:i', strtotime( $post->post_date ) ) . '</strong>.',
			10 => "$this->label_singular draft updated.",
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), "View $this->label_singular" );
			$messages[ $this->post_type ][1] .= $view_link;
			$messages[ $this->post_type ][6] .= $view_link;
			$messages[ $this->post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link      = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), "Preview $this->label_singular" );
			$messages[ $this->post_type ][8] .= $preview_link;
			$messages[ $this->post_type ][10] .= $preview_link;
		}

		return $messages;
	}

	/**
	 * Renames the featured image text.
	 *
	 * @since 0.1.0
	 *
	 * @param object $labels Object with labels for the post type as member variables.
	 *
	 * @return object Object with labels for the post type as member variables.
	 */
	function _rename_featured_image( $labels ) {

		$labels->featured_image        = 'Location Picture';
		$labels->remove_featured_image = 'Remove location picture';
		$labels->set_featured_image    = 'Set location picture';
		$labels->use_featured_image    = 'Use as location picture';

		return $labels;
	}

	function _add_meta_boxes() {

		add_meta_box(
			'properties',
			'Location Properties',
			array( $this, '_mb_properties' ),
			'jc-location'
		);

		rbm_replace_taxonomy_mb( 'jc-location-department', 'jc-location', 'checkbox' );
	}

	function _mb_properties() {

		rbm_do_field_textarea( 'address', 'Address', false, array(
			'wrapper_class' => 'rbm-col-2',
			'validation'    => array(
				'required' => 'true',
			),
		) );

		rbm_do_field_text( 'phone', 'Phone', false, array(
			'wrapper_class' => 'rbm-col-2',
		) );

		echo '<div class="clearfix"></div>';
	}
}