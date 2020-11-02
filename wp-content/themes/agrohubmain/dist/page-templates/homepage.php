<?php
/**
 * Template Name: Home Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() ) : ?>
	<div class="expo-hero">
		<div class="container">
			<div class="row d-flex justify-content-center no-gutters">
				<div class="col-sm-6">
					<div class="ag-header-logo">
						<img src="wp-content/themes/agrohubmain/img/expo-logo.svg" class="img-fluid" alt="Agrohub Expo">
					</div>
					<?php get_template_part( 'global-templates/hero' ); ?>
					<!-- countdown -->
					<div class="ag-countdown">
						<div class="ag-countdown-days">
							<div class="number"></div>
							<span class>Days</span>
						</div>

						<div class="ag-countdown-hours">
							<div class="number"></div>
							<span class>Hours</span>
						</div>

						<div class="ag-countdown-minutes">
							<div class="number"></div>
							<span class>Minutes</span>
						</div>

						<div class="ag-countdown-seconds">
							<div class="number"></div>
							<span class>Seconds</span>
						</div>
					</div>
					<!-- countdown -->
				</div>
				<div class="col-sm-6 ag-home-squares">
					<div class="row no-gutters">
						<div class="col-md-4 col-sm-6 ag-home-square">
							<div class="d-flex justify-content-center align-content-center ag-square-content">
								<h5>Access to <span class="text-bold">resources & equipment</span> for</h5>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 ag-home-square expo-yellow">
							<div class="ag-square-content">
								<div class="ag-square-icon-block">
									<div class="ag-icon-title">
										<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
									</div>
									<p class="ag-icon-title">Fruits & Vegetables</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 ag-home-square ag-clear-box">
							<div class="ag-square-content">
								
							</div>
						</div>
						<div class="col-md-4 col-sm-6 ag-home-square expo-lightblue">
							<div class="ag-square-content">
								<div class="ag-square-icon-block">
									<div class="ag-icon-title">
										<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
									</div>
									<p class="ag-icon-title">Milk & Dairy Processing</p>
								</div>
							</div>
						</div>
						<div class="col-sm-4 ag-home-square ag-clear-box">
							<div class="ag-square-content">
							</div>
						</div>
						<div class="col-sm-4 ag-home-square expo-green">
							<div class="ag-square-content">
								<div class="ag-square-icon-block">
									<div class="ag-icon-title">
										<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
									</div>
									<p class="ag-icon-title">Dry Foods Processing</p>
								</div>
							</div>
						</div>
						<div class="col-sm-4 ag-home-square ag-clear-box">
							<div class="ag-square-content">
							</div>
						</div>
						<div class="col-sm-4 ag-home-square">
							<div class="ag-square-content">
								<div class="ag-square-icon-block">
									<div class="ag-icon-title">
										<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
									</div>
									<p class="ag-icon-title">Beverage Processing</p>
								</div>
							</div>
						</div>
						<div class="col-sm-4 ag-home-square expo-dark">
							<div class="ag-square-content">
								<div class="ag-square-icon-block">
									<div class="ag-icon-title">
										<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
									</div>
									<p class="ag-icon-title">Storage Facilities</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>


<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php get_footer(); ?>
