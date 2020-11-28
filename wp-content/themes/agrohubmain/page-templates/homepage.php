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
	
	<div class="expo-hero d-flex justify-content-center align-items-center">
		<div class="container">
			<div class="row d-flex justify-content-center align-items-center">
				<div class="col-sm-7">
					<?php get_template_part( 'global-templates/hero' ); ?>
					<div class="ag-square-intro">
						<h1>Indo-Kenya Agro & Food Processing Virtual Expo</h1>
						<h3>More Harvest. More Value. More Money. More Jobs. Embrace your fortunes.</h3>
					</div>
				</div>
				<div class="col-sm-5 expo-cta-hero">
					<div class="ag-cta-intro-date">
						<h2 class="ag-cta-date">Now open till Sunday, 29 November</h2>
					</div>
					<div class="ag-cta-intro-header">
						<h2 class="ag-cta-intro-heading">Free Virtual Pass</h2>
					</div>
					<div class="row no-gutters">
						<div class="col-12 ag-cta-hero">
							<a class="btn btn-primary btn-lg hero-cta" href="http://virtual.agrohubexpo.com">Enter Virtual Expo</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	
<?php endif; ?>


<div class="wrapper" id="full-width-page-wrapper">
	<div class="expo-brief">
		<div class="container">
			<div class="row">
				<!-- <div class="col-md-12 ag-flags">
					<div class="ag-flag">
						<img src="<?php echo get_template_directory_uri(); ?>/img/flag-Kenya.svg" class="img-fluid" alt="Kenya Flag">
					</div>
					<div class="ag-flag">
						<img src="<?php echo get_template_directory_uri(); ?>/img/flag-India.svg" class="img-fluid" alt="India Flag">
					</div>
				</div> -->
				
				<div class="col-sm-12 ag-motto">
					<h3>Two countries, a shared history, a timeless bond, have come together at the dawn of a new era, to present for the first time ever, the<br/><span class="text-bold expo-blue">Indo Kenya</span> <span class="text-bold expo-green">Agro &</span> <span class="text-bold expo-yellow"> Food</span> <span class="text-bold expo-lightblue"> Processing Virtual Expo.</span></h3>
				</div>
				<div class="col-md-12">
					<div class="row ag-hosts">
						<div class="col-sm-4 col-6 ag-host">
							<a href="http://alternatives.co.ke/" target="_blank">
								<img src="<?php echo get_template_directory_uri(); ?>/img/logo-agrohub.svg" class="img-fluid" alt="Agrohub Logo">
							</a>
						</div>
						<div class="col-sm-4 col-6 ag-host">
							<a href="https://www.kamtech.in/" target="_blank">
								<img src="<?php echo get_template_directory_uri(); ?>/img/logo-kamtech.jpg" class="img-fluid" alt="Kamtech Logo">
							</a>
						</div>
						<div class="col-sm-4 col-12 ag-host">
							<a href="https://twitter.com/asnetkenya" target="_blank">
								<img src="<?php echo get_template_directory_uri(); ?>/img/ASNET-Logo-Full.png" class="img-fluid" alt="ASNET Kenya Logo">
							</a>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="expo-sectors">
		<div class="container-fluid">
			<div class="ag-home-squares">
				<div class="row row-cols-2 row-cols-sm-3 row-cols-md-5">
					<div class="col ag-home-square expo-yellow-bg">
						<div class="ag-square-content">
							<div class="ag-square-icon-block">
								<div class="ag-icon">
									<img src="<?php echo get_template_directory_uri(); ?>/img/icons/iconChain-Fruits.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Fruits & Veg<br>Processing</p>
							</div>
							
						</div>
						<div class="ag-square-image-block">
							<div class="ag-icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/home-veg-processing.jpg" class="ag-square-icon" alt="Agrohub Fruits Vegetable Processing">
							</div>
						</div>
					</div>
					<div class="col ag-home-square expo-lightblue-bg">
						<div class="ag-square-content">
							<div class="ag-square-icon-block">
								<div class="ag-icon">
									<img src="<?php echo get_template_directory_uri(); ?>/img/icons/iconChain-Dairy.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Milk & Dairy<br>Processing</p>
							</div>
						</div>
						<div class="ag-square-image-block">
							<div class="ag-icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/home-dairy-processing.jpg" class="ag-square-icon" alt="Agrohub Dairy Processing">
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
								<div class="ag-icon">
									<img src="<?php echo get_template_directory_uri(); ?>/img/icons/iconChain-DryFoods.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Dry Foods<br>Processing</p>
							</div>
						</div>
						<div class="ag-square-image-block">
							<div class="ag-icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/home-dry-foods-processing.jpg" class="ag-square-icon" alt="Agrohub Dry Foods Processing">
							</div>
						</div>
					</div>
					<div class="col ag-home-square">
						<div class="ag-square-content">
							<div class="ag-square-icon-block">
								<div class="ag-icon">
									<img src="<?php echo get_template_directory_uri(); ?>/img/icons/iconChain-Beverage.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Beverage<br>Processing</p>
							</div>
						</div>
						<div class="ag-square-image-block">
							<div class="ag-icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/home-beverage-processing.jpg" class="ag-square-icon" alt="Agrohub Beverage Processing">
							</div>
						</div>
					</div>
					<div class="col col-12 ag-home-square expo-dark-bg">
						<div class="ag-square-content">
							<div class="ag-square-icon-block">
								<div class="ag-icon">
									<img src="<?php echo get_template_directory_uri(); ?>/img/icons/iconChain-Storage.svg" class="ag-square-icon" alt="Agrohub Expo">
								</div>
								<p class="ag-icon-title">Storage<br>Facilities</p>
							</div>
						</div>
						<div class="ag-square-image-block">
							<div class="ag-icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/home-storage-facilities.jpg" class="ag-square-icon" alt="Agrohub Storage Facilities">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ag-geometric-long">
	</div>
	
	
	

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
	<?php echo do_shortcode('[metaslider id="73"]'); ?>

	<div class="expo-attend">
		<div class="container">
			
			<div class="row">
				<div class="col-sm-12 ag-why-squares">
				<h1 class="section-heading">Why Attend?</h1>
					<div class="row no-gutters">
						<div class="col-md-4 col-sm-6 col-12 ag-why-square bg-white">
							<div class="ag-square-content expo-green">
								<h2>Showcase of<br><span class="text-bold">“BEST IN CLASS” INNOVATIONS</span></h2>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-12 ag-why-square expo-green-bg">
							<div class="ag-square-content expo-blue">
								<h2>Access to<br><span class="text-bold">AFFORDABLE DURABLE MACHINERY</span></h2>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-12 ag-why-square expo-blue-bg">
							<div class="ag-square-content expo-yellow">
								<h2>Access to<br><span class="text-bold">ASSET FINANCE & INSURANCE</span></h2>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-12 ag-why-square expo-yellow-bg">
							<div class="ag-square-content expo-blue">
								<h2>Assistance in<br><span class="text-bold">PURCHASE & LOGISTICAL SUPPORT</span></h2>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-12 ag-why-square expo-lightblue-bg">
							<div class="ag-square-content expo-blue">
								<h2>Access to<br><span class="text-bold">LOCAL & INTERNATIONAL INVESTORS</span></h2>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-12 ag-why-square bg-white">
							<div class="ag-square-content expo-green">
								<h2>Value Addition<br><span class="text-bold">TRAINING & SKILLS DEVELOPMENT</span></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ag-geometric-long">
	</div>

</div><!-- #full-width-page-wrapper -->

<script type ="text/javascript">
	window.onload =  (function($) {
		// Specify the deadline date
		const deadlineDate = new Date('November 27, 2020 09:00:00 GMT+03:00').getTime();

		// Cache all countdown boxes into consts
		const countdownDays = document.querySelector('.ag-countdown-days .number');
		const countdownHours = document.querySelector('.ag-countdown-hours .number');
		const countdownMinutes = document.querySelector('.ag-countdown-minutes .number');
		const countdownSeconds = document.querySelector('.ag-countdown-seconds .number');

		// Update the count down every 1 second (1000 milliseconds)
		setInterval(() => {
			// Get current date and time
			const currentDate = new Date().getTime();

			// Calculate the distance between current date and time and the deadline date and time
			const distance = deadlineDate - currentDate;

			// Calculations the data for remaining days, hours, minutes and seconds
			const days = Math.floor(distance / (1000 * 60 * 60 * 24));
			const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Insert the result data into individual countdown boxes
			countdownDays.innerHTML = days;
			countdownHours.innerHTML = hours;
			countdownMinutes.innerHTML = minutes;
			countdownSeconds.innerHTML = seconds;
		}, 1000);
	})(jQuery);
</script>

<?php get_footer(); ?>
