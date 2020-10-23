<?php
/**
 * Sidebar - hero canvas setup.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>



<?php if ( is_active_sidebar( 'herocanvas' ) ) : ?>

	<!-- ******************* The Hero Canvas Widget Area ******************* -->

	

	<?php dynamic_sidebar( 'herocanvas' ); ?>

<?php endif; ?>

<div class="container-fluid expo-hero">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-sm-6">
				Test content
			</div>
			<div class="col-sm-6">
				Test content
			</div>
		</div>
	</div>
</div>
