<?php
/**
 * Template Name: Conference Page
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
	<section class="expo-speakers gallery-block cards-gallery">
	    <div class="container">
			<div class="heading">
				<h1>Speakers</h1>
			</div>
	        <div class="row">
				<div class="col-md-4 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Ajay-K-Gupta.jpg" alt="Mr Ajay K Gupta" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Ajay K Gupta</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Managing Director,</span> Kamtech Associates</p>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-4 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Esther-Muchemi.jpg" alt="Esther Muchemi" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Esther Muchemi</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Lead-Investor,</span> Alternatives AgroHub; <span>CEO</span> Samchi Group</p>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-4 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Bimal-Kantaria.jpg" alt="Bimal Kantaria" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Bimal Kantaria</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Chairman,</span> Agricultural Sector Network</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Waithera-Gaitho.jpg" alt="Waithera Gaitho" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Waithera Gaitho</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Executive Director,</span> Alternatives Africa</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Siddharth-Chatterjee.jpg" alt="Siddharth Chatterjee" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Siddharth Chatterjee</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>UN Resident Coordinator,</span> Kenya</p>
	                    </div>
	                </div>
				</div>
	            <div class="col-md-4 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Dr-Wale-Akinyemi.jpg" alt="Dr. Wale Akinyemi" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Dr. Wale Akinyemi</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>A Passionate African and Founder,</span> Street University</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Hon-FT-Nyamu.jpg" alt="Hon. F.T Nyamu" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Hon. F.T Nyamu</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Intergenerational Partner,</span> KEPSA - Youth Enterprise Forum(YEFO)</p>
	                    </div>
	                </div>
				</div>
				
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-HC-Dr-Viranda-Paul.jpg" alt="High Commissioner Dr. Viranda Paul" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">HC Dr. Viranda Paul</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>High Commissioner,</span> High Commission of India</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Sunil-K-Marwah.jpg" alt="Sunil Marwah" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Sunil K Marwah</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>CEO,</span> FICSI</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-NK-Jain.jpg" alt="N. K. Jain" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">N. K. Jain</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>President,</span> The Employer Association of Rajasthan</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Elizabeth-Wafula.jpg" alt="Elizabeth Wafula" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Elizabeth Wafula</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>PhD Researcher,</span> Food Science and Nutrition</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Vivek-Lodha.jpg" alt="Vivek Lodha" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Vivek Lodha</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>JVS Foods,</span> Jaipur (India)</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Olivia-Awuor.jpg" alt="Olivia Awuor" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Olivia Awuor</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>CEO,</span> Pine Kazi</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Martin-Ruga.jpg" alt="Martin Ruga" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Martin Ruga</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Desserts Anyone Limited</span></p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Gerphas-Odipo.jpg" alt="Gerphas Odipo" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Gerphas Odipo</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Director,</span> Judera Group</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Arif-Neky.jpg" alt="Arif Neky" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Arif Neky</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Senior Advisor,</span> UN-SDG Platform</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Kirigo-Ngarua.jpg" alt="Kirigo Ngarua" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Kirigo Ngarua</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Moderator</span></p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Roy-Sasaka-Telewa.jpg" alt="Roy Sasaka Telewa" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Roy Sasaka Telewa</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>CEO,</span> National Youth Council</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Lucy-Muchoki.jpg" alt="Lucy Muchoki" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Lucy Muchoki</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>CEO,</span> Kenya Agribusiness and Agroindustry Alliance</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Prof-Manoj-Kumar-Shukla.jpg" alt="Prof Dr. Manoj K Shukla" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Dr. Manoj K Shukla</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Pro VC,</span> Harcourt Butler Technological Institute, Kanpur (India)</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-VK-Sharma.jpg" alt="Mr. V.K.Sharma" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Mr. V.K.Sharma</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Director,</span> MSME DI</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-SK-Blue.jpg" alt="Samuel Kuria" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Samuel Kuria</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Managing Director,</span> Gold Avenue Africa (Off Grid Affordable Energy)</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Anup-Kumar.jpg" alt="Anup Kumar" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Anup Kumar</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>CEO,</span> Kirana King</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Jane-Ngige.jpg" alt="Jane Ngige" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Jane Ngige</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Chairperson,</span> Warehouse Receipt System</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Sean-Branagan.jpg" alt="Sean Branagan" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Prof. Sean Branagan</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Director,</span> Center for Digital Media Entrepreneurship, Syracuse University</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Dr-Jeet-Singh-Sandhu.jpg" alt="Prof J S Sandhu" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Prof J S Sandhu</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>VC,</span> Sri Karan Narendra Agriculture University Jobner, India</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Fred-Kiio.jpg" alt="Fred Kiio" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Fred Kiio</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>General Manager,</span> Safaricom-DigiFarm</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Girish-Dangaych.jpg" alt="Girish Dangaych" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Girish Dangaych</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Technology Expert</span></p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Mayur-Gupta.jpg" alt="Mayur Gupta" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Mayur Gupta</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>SS AGRI Business,</span> India</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Benson-Muthendi.jpg" alt="Benson Muthendi" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Benson Muthendi</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Ag. CEO,</span> Youth Enterprise Development Fund</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Oscar-Kimani.jpg" alt="Oscar Kimani" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Oscar Kimani</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Corporate Affairs and County Banking,</span> Access Bank</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Joanne-Mwangi-Yelbert.jpg" alt="Joanne Mwangi-Yelbert" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Joanne Mwangi-Yelbert</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>CEO,</span> PMS Group</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Clemence-Bruguier.jpg" alt="Clemence Bruguier" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Clemence Bruguier</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Founder & CEO,</span> Humans to Humans, New York</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Saksham-Gupta.jpg" alt="Saksham Gupta" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Saksham Gupta</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>CTO,</span> Kamtech Associates</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Stanley-Ndono.jpg" alt="Stanley Ndono" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Stanley Ndono</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Chairperson,</span> Agricultural Sector Network Youth Forum</p>
	                    </div>
	                </div>
				</div>
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Ramesh-Mittal.jpg" alt="Dr. Ramesh Mittal" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Dr. Ramesh Mittal</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Director,</span> NIAM, India</p>
	                    </div>
	                </div>
				</div>
				
				<div class="col-md-3 col-lg-2 col-6">
	                <div class="card border-0 transform-on-hover">
						<img src="<?php echo get_template_directory_uri(); ?>/img/speakers/expo-speaker-Nidhi-Taparia.jpg" alt="Nidhi Taparia" class="card-img-top">
	                    <div class="card-body">
	                        <h6><a href="#">Nidhi Taparia</a></h6>
						</div>
						<div class="card-footer">
	                        <p class="card-text"><span>Kamtech Associates</span></p>
	                    </div>
	                </div>
	            </div>

	        </div>
	    </div>
    </section>
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
	
	<div class="expo-conference">
		<div class="container">
			<div class="ag-event-tabs">
				<div class="row d-flex">
					<div class="col-sm-12 expo-event-tabs">
						<div id="expo-tabWidget" class="tabs t-tabs">
        					<ul class="nav nav-tabs expo-tabs" role="tablist">
								<li class="tab expo-tab active">
									<div class="arrow-down"><div class="arrow-down-inner"></div></div>	
										<a id="tab0" href="#tabBody0" role="tab" aria-controls="tabBody0" aria-selected="true" data-toggle="tab" tabindex="0">27</a>
									<div class="whiteBlock"></div>
								</li>
								
								<li class="tab expo-tab">
									<div class="arrow-down"><div class="arrow-down-inner"></div></div>
										<a id="tab1" href="#tabBody1" role="tab" aria-controls="tabBody1" aria-selected="true" data-toggle="tab" tabindex="0">28</a>
									<div class="whiteBlock"></div>
								</li>
								

							</ul>
							<div id="myTabContent" class="tab-content expo-tabContent" aria-live="polite">
								<div class="tab-pane  fade active in" id="tabBody0" role="tabpanel" aria-labelledby="tab0" aria-hidden="false" tabindex="0">
									<div>
										<div class="row">
											
											<div class="col-md-12">
												<h2>This is the content of tab one.</h2>
												<p>This field is a rich HTML field with a content editor like others used in Sitefinity. It accepts images, video, tables, text, etc. Street art polaroid microdosing la croix taxidermy. Jean shorts kinfolk distillery lumbersexual pinterest XOXO semiotics. Tilde meggings asymmetrical literally pork belly, heirloom food truck YOLO. Meh echo park lyft typewriter. </p>
											</div>
											
										</div>
									</div>
								</div>
								<div class="tab-pane  fade" id="tabBody1" role="tabpanel" aria-labelledby="tab1" aria-hidden="true" tabindex="0">
									<div class="row">
											
											<div class="col-md-12">
												<h2>This is the content of tab two.</h2>
												<p>This field is a rich HTML field with a content editor like others used in Sitefinity. It accepts images, video, tables, text, etc. Street art polaroid microdosing la croix taxidermy. Jean shorts kinfolk distillery lumbersexual pinterest XOXO semiotics. Tilde meggings asymmetrical literally pork belly, heirloom food truck YOLO. Meh echo park lyft typewriter. </p>
											
											</div>
										</div>
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
