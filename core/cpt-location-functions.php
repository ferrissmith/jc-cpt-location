<?php
/**
 * Provides helper functions.
 *
 * @since      0.1.0
 *
 * @package    CPT_Location
 * @subpackage CPT_Location/core
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Returns the main plugin object
 *
 * @since 0.1.0
 *
 * @return CPT_Location
 */
function CPT_LOCATION() {
	return CPT_Location::getInstance();
}