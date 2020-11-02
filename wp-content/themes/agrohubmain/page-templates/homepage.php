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
			<div class="row d-flex justify-content-center">
				<div class="col-sm-12">
					<div class="ag-header-logo">
						<img src="wp-content/themes/agrohubmain/img/expo-logo-white.svg" class="img-fluid" alt="Agrohub Expo">
					</div>
					<?php get_template_part( 'global-templates/hero' ); ?>
					<div class="ag-square-intro">
						<h1>A Virtual Event for Agro-Processors</h1>
						<a class="btn btn-primary btn-lg" href="#" role="button">Register Now</a>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
	<div class="ag-geometric-long">
		<img src="wp-content/themes/agrohubmain/img/ag-geometric-long.svg" class="img-fluid" alt="Agrohub Expo">
	</div>
	<div class="expo-sectors">
		<div class="container-fluid">
			<div class="ag-home-squares">
				<div class="row row-cols-3 row-cols-sm-3 row-cols-md-5">
					<div class="col ag-home-square expo-yellow-bg">
						<div class="ag-square-content">
							<div class="ag-square-icon-block">
								<div class="ag-icon-title">
									<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Fruits & Vegetables</p>
							</div>
						</div>
					</div>
					<div class="col ag-home-square expo-lightblue-bg">
						<div class="ag-square-content">
							<div class="ag-square-icon-block">
								<div class="ag-icon-title">
									<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Milk & Dairy Processing</p>
							</div>
						</div>
					</div>
					<!-- <div class="col-sm-4 ag-home-square ag-clear-box">
						<div class="ag-square-content">
						</div>
					</div> -->
					<div class="col ag-home-square expo-green-bg">
						<div class="ag-square-content">
							<div class="ag-square-icon-block">
								<div class="ag-icon-title">
									<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Dry Foods Processing</p>
							</div>
						</div>
					</div>
					<div class="col ag-home-square">
						<div class="ag-square-content">
							<div class="ag-square-icon-block">
								<div class="ag-icon-title">
									<img src="wp-content/themes/agrohubmain/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Beverage Processing</p>
							</div>
						</div>
					</div>
					<div class="col ag-home-square expo-dark-bg">
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
	
	<div class="expo-brief">
		<div class="container">
			<div class="row">
				<div class="col-md-12 ag-flags">
					<div class="ag-flag">
						<img src="wp-content/themes/agrohubmain/img/flag-Kenya.svg" class="img-fluid" alt="Kenya Flag">
					</div>
					<div class="ag-flag">
						<img src="wp-content/themes/agrohubmain/img/flag-India.svg" class="img-fluid" alt="India Flag">
					</div>
				</div>
				<div class="col-sm-12 ag-motto">
					<h3>Two countries, a shared history, a timeless bond, have come together at the dawn of a new era, to present for the time ever, the<br/><span class="text-bold expo-blue">Indo Kenya</span> <span class="text-bold expo-green">Agro &</span> <span class="text-bold expo-yellow"> Food</span> <span class="text-bold expo-lightblue"> Processing Virtual Expo.</span></h3>
				</div>
				<div class="col-md-4">
					<div class="ag-hosts">
						<div class="ag-host">
							<img src="wp-content/themes/agrohubmain/img/logo-agrohub.svg" class="img-fluid" alt="Agrohub Logo">
						</div>
						<div class="ag-host">
							<img src="wp-content/themes/agrohubmain/img/logo-kamtech.jpg" class="img-fluid" alt="Kamtech Logo">
						</div>
					</div>
				</div>
				<div class="col-md-8 ag-timer">
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
			</div>
		</div>
	</div>
	
	<div class="expo-attend">
		<div class="container">
			<h1 class="section-heading text-white">Why Attend?</h1>
			<div class="row">
				<div class="col-sm-12 ag-why-squares">
					<div class="row no-gutters">
						<div class="col-md-4 col-sm-6 ag-why-square bg-white">
							<div class="ag-square-content expo-green">
								<h2>SHOWCASE OF<br><span class="text-bold">“BEST IN CLASS” INNOVATIONS</span></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ag-geometric-long">
		<img src="wp-content/themes/agrohubmain/img/ag-geometric-long.svg" class="img-fluid" alt="Agrohub Expo">
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
