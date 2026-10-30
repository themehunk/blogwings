<?php
/**
 * Comments.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="bwt-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="bwt-comments__title">
			<?php
			/* translators: %s count */
			printf( esc_html( _n( '%s comment', '%s comments', get_comments_number(), 'blogwings' ) ), esc_html( number_format_i18n( get_comments_number() ) ) );
			?>
		</h2>
		<ol class="bwt-comments__list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 44 ) ); ?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>
	<?php comment_form( array( 'class_submit' => 'bw-btn bw-btn--primary' ) ); ?>
</section>
