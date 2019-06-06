<?php

global $default_options;
$default_options =
[
    "thumbnail_size_w" => 150,
    "thumbnail_size_h" => 150,
    "thumbnail_crop" => true
];

function add_action( $when, $function ) {
    $function();
}

/**
 * Gets the available intermediate image sizes.
 *
 * @since 3.0.0
 *
 * @return array Returns a filtered array of image size strings.
 */
function get_intermediate_image_sizes() {
	$_wp_additional_image_sizes = wp_get_additional_image_sizes();
	$image_sizes                = array( 'thumbnail', 'medium', 'medium_large', 'large' ); // Standard sizes
	if ( ! empty( $_wp_additional_image_sizes ) ) {
		$image_sizes = array_merge( $image_sizes, array_keys( $_wp_additional_image_sizes ) );
	}

	/**
	 * Filters the list of intermediate image sizes.
	 *
	 * @since 2.5.0
	 *
	 * @param array $image_sizes An array of intermediate image sizes. Defaults
	 *                           are 'thumbnail', 'medium', 'medium_large', 'large'.
	 */
	return apply_filters( 'intermediate_image_sizes', $image_sizes );
}

/**
 * Retrieve additional image sizes.
 *
 * @since 4.7.0
 *
 * @global array $_wp_additional_image_sizes
 *
 * @return array Additional images size data.
 */
function wp_get_additional_image_sizes() {
	global $_wp_additional_image_sizes;
	if ( ! $_wp_additional_image_sizes ) {
		$_wp_additional_image_sizes = array();
	}
	return $_wp_additional_image_sizes;
}

function apply_filters( $tag, $value ) {
    global $wp_filter, $wp_current_filter;

    $args = array();

    // Do 'all' actions first.
    if ( isset( $wp_filter['all'] ) ) {
        $wp_current_filter[] = $tag;
        $args                = func_get_args();
        _wp_call_all_hook( $args );
    }

    if ( ! isset( $wp_filter[ $tag ] ) ) {
        if ( isset( $wp_filter['all'] ) ) {
            array_pop( $wp_current_filter );
        }
        return $value;
    }

    if ( ! isset( $wp_filter['all'] ) ) {
        $wp_current_filter[] = $tag;
    }

    if ( empty( $args ) ) {
        $args = func_get_args();
    }

    // don't pass the tag name to WP_Hook
    array_shift( $args );

    $filtered = $wp_filter[ $tag ]->apply_filters( $value, $args );

    array_pop( $wp_current_filter );

    return $filtered;
}

function add_image_size( $name, $width = 0, $height = 0, $crop = false ) {
    global $_wp_additional_image_sizes;

    $_wp_additional_image_sizes[ $name ] = array(
        'width'  => absint( $width ),
        'height' => absint( $height ),
        'crop'   => $crop,
    );
}

/**
 * Convert a value to non-negative integer.
 *
 * @since 2.5.0
 *
 * @param mixed $maybeint Data you wish to have converted to a non-negative integer.
 * @return int A non-negative integer.
 */
function absint( $maybeint ) {
	return abs( intval( $maybeint ) );
}

/**
 * Remove a new image size.
 *
 * @since 3.9.0
 *
 * @global array $_wp_additional_image_sizes
 *
 * @param string $name The image size to remove.
 * @return bool True if the image size was successfully removed, false on failure.
 */
function remove_image_size( $name ) {
	global $_wp_additional_image_sizes;

	if ( isset( $_wp_additional_image_sizes[ $name ] ) ) {
		unset( $_wp_additional_image_sizes[ $name ] );
		return true;
	}

	return false;
}

function get_option( $option ) {
    global $default_options;
    return $default_options[ $option ];
}

function update_option( $option, $value ) {
    global $default_options;
    $default_options[ $option ] = $value;
}
