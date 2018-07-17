<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package shared
 */

if ( ! function_exists( 'shared_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function shared_posted_on() {
	if (is_bob_diary()) {
		$posted = 'Date: ';
		$published_time = get_the_date() . ' ' . get_the_time() . 'h';
	} else {
		$posted = 'Posted on';
		$published_time = get_the_date();
	}

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( $published_time ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( $posted . ' %s', 'post date', 'shared' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'shared_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function shared_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'shared' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			if (is_bob_diary()) {
				$categories = 'Sources: ';
			} else {
				$categories = 'Posted in';
			}
			printf( '<div class="cat-links">' . esc_html__( $categories . ' %1$s', 'shared' ) . '</div>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'shared' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<div class="tags-links">' . esc_html__( 'Tagged %1$s', 'shared' ) . '</div>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'shared' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'shared' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<div class="edit-link">',
		'</div>'
	);
}
endif;
