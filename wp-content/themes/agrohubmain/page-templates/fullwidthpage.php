<?php
/**
 * Template Name: Full Width Page
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
  <?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>


<div class="wrapper" id="full-width-page-wrapper">
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

</div><!-- #full-width-page-wrapper -->

<?php get_footer(); ?>
