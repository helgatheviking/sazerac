<?php
/**
 * @package sazerac
 */
?>
<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemType="http://schema.org/BlogPosting">
	<?php tha_entry_top(); ?>
	<header class="entry-header">
		<div class="entry-category">
			<?php /* translators: used between list items, there is a space after the comma */
			the_category( __( ', ', 'some-like-it-neat' ) );
			?>
		</div><!-- .entry-category -->

		<h1 class="entry-title" itemprop="name" ><?php the_title(); ?></h1>

		<?php if( function_exists( 'the_subtitle' ) ) the_subtitle( '<h2 class="subtitle">', '</h2>'); ?>
		
		<div class="entry-meta">

			<?php sazerac_posted_on(); ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link" itemprop="comment" ><?php comments_popup_link( __( 'Leave a comment', 'some-like-it-neat' ), __( '1 Comment', 'some-like-it-neat' ), __( '% Comments', 'some-like-it-neat' ) ); ?></span>
			<?php endif; ?>

		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content" itemprop="articleBody" >

	<?php the_content(); ?>

	</div><!-- .entry-content -->

	<footer class="entry-meta" itemprop="keywords" >

	<?php
	
	echo get_the_tag_list( '<div class="entry-tags">', '', '</div>' );

	printf( _e( 'Bookmark the <a href="%2$s" rel="bookmark">permalink</a>.', 'some-like-it-neat' ), get_permalink() );
	
	?>

	<?php edit_post_link( __( 'Edit', 'some-like-it-neat' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
	<?php tha_entry_bottom(); ?>
</article><!-- #post-## -->
<?php tha_entry_after(); ?>
