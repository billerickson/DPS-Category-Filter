<?php
/**
 * Plugin Name: Category Filter for Display Posts Shortcode
 * Plugin URI: https://github.com/billerickson/dps-category-filter/
 * Description: Filter results of [display-posts] using [dps_category_filter]
 * Version: 1.0.0
 * Author: Bill Erickson
 * Author URI: https://www.billerickson.net
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

/**
 * DPS Category Filter
 *
 */
function be_dps_category_filter_shortcode( $atts = array() ) {

	$atts = shortcode_atts( array(
		'categories' => '',
	), $atts, 'dps_category_filter' );

	if( empty( $atts[ 'categories' ] ) )
		return;

	$categories = array_map( 'sanitize_html_class', ( explode( ',', $atts['categories'] ) ) );
	$current = !empty( $_GET['dps_category_filter'] ) ? array_map( 'sanitize_html_class', $_GET['dps_category_filter'] ) : array();

	$output = '<form class="dps-category-filter" method="GET" action="' . get_permalink() . '">';

	foreach( $categories as $category ) {

		$parent = get_term_by( 'slug', $category, 'category' );
		if( empty( $parent ) || is_wp_error( $parent ) )
			continue;

		$terms = get_terms( array(
			'taxonomy' => 'category',
			'parent'   => $parent->term_id,
		));

		if( !empty( $terms ) && ! is_wp_error( $terms ) ) {
			$output .= '<select name="dps_category_filter[]">';
			$output .= '<option value="">Select a ' . $parent->name . '</option>';
			foreach( $terms as $term )
				$output .= '<option value="' . $term->slug . '"' . selected( in_array( $term->slug, $current ), true, false ) . '>' . $term->name . '</option>';
			$output .= '</select>';
		}
	}

	$output .= '<button class="button" type="submit">Filter Results</button>';
	$output .= '</form>';

	return $output;
}
add_shortcode( 'dps_category_filter', 'be_dps_category_filter_shortcode' );


/**
 * DPS Category Filter Args
 *
 */
function be_dps_category_filter_args( $args ) {

	if( empty( $_GET['dps_category_filter'] ) )
		return $args;

	$extra_categories = array_map( 'sanitize_html_class', $_GET['dps_category_filter'] );
	if( empty( $extra_categories ) )
		return $args;

	// Check for existing category_name
	if( !empty( $args[ 'category_name'] ) ) {
		$current_categories = explode( ',', $args[ 'category_name' ] );
		foreach( $current_categories as $current_category )
			$extra_categories[] = $current_category;
	}
	$extra_categories = array_filter( $extra_categories );

	// Check for existing tax_query
	if( !empty( $args[ 'tax_query' ] ) ) {
		foreach( $args[ 'tax_query' ] as $i => $tax_query ) {
			if( 'category' == $tax_query[ 'taxonomy' ] ) {
				$extra_categories = array_merge( $extra_categories, $tax_query[ 'terms' ] );
				unset( $args[ 'tax_query' ][ $i ] );
			}
		}
	}

	$tax_query = array(
		'taxonomy' => 'category',
		'field'    => 'slug',
		'terms'    => $extra_categories,
		'operator' => 'AND',
		'include_children' => false,
	);

	if( !empty( $args[ 'tax_query' ] ) )
		$args[ 'tax_query' ][] = $tax_query;
	else
		$args[ 'tax_query' ] = array( $tax_query );

	return $args;
}
add_filter( 'display_posts_shortcode_args', 'be_dps_category_filter_args' );
