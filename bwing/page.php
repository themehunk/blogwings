<?php
/**
 * BWing routed pages (single theme / plugin / premium / author) inside BlogWings.
 *
 * @package BlogWings
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="bwt-container bwt-main">
	<?php blogwings_breadcrumbs(); ?>
	<?php echo BWing_Router::render(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
</main>
<?php
get_footer();
