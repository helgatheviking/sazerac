<?php
/**
 * @package sazerac
 */
?>

<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemType="http://schema.org/BlogPosting" >
	<?php tha_entry_top(); ?>
	<header class="entry-header">

		<?php if( ! is_category() && 'post' == get_post_type() ) : ?>

			<div class="entry-category">

			<?php /* translators: used between list items, there is a space after the comma */
			the_category( __( ', ', 'some-like-it-neat' ) );
			?>

			</div><!-- .entry-category -->

		<?php endif; ?>

		<h1 class="entry-title" itemprop="name" ><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if( function_exists( 'the_subtitle' ) ) the_subtitle( '<h2 class="subtitle">', '</h2>'); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
			<span class="genericon genericon-time"></span> <?php sazerac_posted_on(); ?>
			<span itemprop="dateModified" style="display:none;"><?php printf( __( 'Last modified:', 'some-like-it-neat' ) ); ?> <?php the_modified_date(); ?></span>
		<?php endif; ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link" itemprop="comment" ><?php comments_popup_link( __( 'Leave a comment', 'some-like-it-neat' ), __( '1 Comment', 'some-like-it-neat' ), __( '% Comments', 'some-like-it-neat' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'some-like-it-neat' ), '<span class="edit-link">', '</span>' ); ?>
	
	</header><!-- .entry-header -->

	<?php if ( is_search() || 'yes' === get_theme_mod( 'criticalink_show_excerpts_in_archive', 'yes' ) ) : // Only display Excerpts for Search ?>
		<div class="entry-summary" itemprop="description">
		<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php endif; ?>

	<footer class="entry-meta" itemprop="keywords">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
		<?php the_tags( '<div class="entry-tags">', '', '</div>' ); ?>
		<?php endif; // End if 'post' == get_post_type() ?>
	</footer><!-- .entry-meta -->
	<?php tha_entry_bottom(); ?>
</article><!-- #post-## -->
<?php tha_entry_after(); ?>
