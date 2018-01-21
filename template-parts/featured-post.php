<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shared
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a class="post-thumbnail" href="<?php the_permalink(); ?>" rel="bookmark">

		<header class="entry-header"<?php
			// Output the featured image.
			if ( has_post_thumbnail() ) :
				echo( ' style="background-image:url(' . get_the_post_thumbnail_url('large') .')"');
			endif;
	?>>
			<div class="entry-header__wrapper">
				<?php the_title( '<h1 class="entry-title">','</h1>' ); ?>
			</div>
		</header><!-- .entry-header -->

	</a>
</article><!-- #post-## -->
