<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">

					<div class="row text-center">
						<div class="col-md-4 box">
							<span class="copyright quick-links">&copy; Indo-Kenya Expo<script>document.write(new Date().getFullYear())</script>
							</span>
						</div>
						<div class="col-md-4 box">
							<ul class="list-inline social-buttons">
							<li class="list-inline-item">
								<a href="#">
								<i class="fab fa-twitter"></i>
							</a>
							</li>
							<li class="list-inline-item">
								<a href="#">
								<i class="fab fa-facebook-f"></i>
							</a>
							</li>
							<li class="list-inline-item">
								<a href="#">
								<i class="fab fa-linkedin-in"></i>
							</a>
							</li>
							</ul>
						</div>
						<div class="col-md-4 box">
							<ul class="list-inline quick-links">
							<li class="list-inline-item">
								<a href="#">Privacy Policy</a>
							</li>
							<li class="list-inline-item">
								<a href="#">Terms of Use</a>
							</li>
							</ul>
						</div>
						</div>

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

