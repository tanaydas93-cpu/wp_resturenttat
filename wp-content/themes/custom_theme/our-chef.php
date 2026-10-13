
<?php /* Template Name: Our Chef Page */
get_header(); ?>
    
   


    <!-- Inner Banner Section -->
    <section class="inner-banner">
        <div class="image-layer" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/background/banner-image-5.jpg);"></div>
        <div class="auto-container">
            <div class="inner">
                <h1>Our Chef</h1>
                <div class="sub_text"> <p> A taste of perfection in every dish - <span class="primary-color"> fine dining with a modern twist.</span></p> </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->

    <!--Chef Section-->
    <section class="chef-section section-kt">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="title-box centered">
                    <div class="subtitle"><span>meet the chef</span></div>
                    <h2>Master Chef Creations Designed to Elevate Your Dining Experience with Flawless Favor and Artistry.</h2>
                </div>
                <!--Col-->
                <div class="content-col col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="inner clearfix wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="content-box">
                            <div class="title-box">
                                <h5>Mater Chef <br> <span class="theme_color"> Lorenzo Oliver </span></h5>
                                <div class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has been the industrys standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap.</div>
                            </div>
                            <div class="link-box">
                            <a href="about.html" class="theme-btn btn-style-two clearfix">
                                <span class="btn-wrap">
                                    <span class="text-one">meet our team</span>
                                    <span class="text-two">meet our team</span>
                                </span>
                            </a>
                            </div>

                            <div class="side-image parallax-scene-2 wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">
                                <div class="image" data-depth="0.15"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/mainchef-side.jpg" alt="image"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <!--Col-->
                <div class="image-col col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="inner parallax-scene-1 wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="image" data-depth="0.15"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/mainchef.jpg" alt="image"></div>
                    </div>
                    <div class="round-stamp-2">
                        <img data-depth="0.50" class="stamp_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/chefcap.png" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Team Section-->
    <section class="team-section section-kt">
        <div class="auto-container">
            <div class="title-box centered">
                <div class="subtitle"><span>our team</span></div>
                <h2>Meet Our Team</h2>
            </div>
            <div class="row justify-content-center clearfix">
                <!--Block-->
               <?php
           global $wpdb;
$chefs = $wpdb->get_results(
    "SELECT * FROM {$wpdb->prefix}chefs WHERE status = 1 ORDER BY sort_order ASC"
);
?>

<?php if ( ! empty( $chefs ) ) : ?>
    <?php foreach ( $chefs as $chef ) : ?>

        <div class="team-block col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="inner-box wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="0ms">
                <div class="image">

                    <!-- Profile Image -->
                    <?php if ( $chef->profile_image_id ) : ?>
                        <img src="<?php echo esc_url( wp_get_attachment_image_url( $chef->profile_image_id, 'full' ) ); ?>"
                             alt="<?php echo esc_attr( $chef->name ); ?>">
                    <?php endif; ?>

                    <div class="overlay-box">
                        <div class="overlay-inner">

                            <!-- Social Box -->
                            <ul class="social-box">

                                <?php if ( ! empty( $chef->facebook_url ) ) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( $chef->facebook_url ); ?>"
                                           class="fab fa-facebook-f"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( ! empty( $chef->twitter_url ) ) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( $chef->twitter_url ); ?>"
                                           class="fab fa-twitter"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( ! empty( $chef->dribbble_url ) ) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( $chef->dribbble_url ); ?>"
                                           class="fab fa-dribbble"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( ! empty( $chef->linkedin_url ) ) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( $chef->linkedin_url ); ?>"
                                           class="fab fa-linkedin"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                        </a>
                                    </li>
                                <?php endif; ?>

                            </ul>

                        </div>
                    </div>
                </div>

                <!-- Name -->
                <h5>
                    <a href="#"><?php echo esc_html( $chef->name ); ?></a>
                </h5>

                <!-- Designation -->
                <div class="designation">
                    <?php echo esc_html( $chef->designation ); ?>
                </div>

                <!-- Bio -->
                <div class="text desc">
                    <?php echo esc_html( $chef->bio ); ?>
                </div>

            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>
<!--             
               
                
    </section>

<?php get_footer(); ?>