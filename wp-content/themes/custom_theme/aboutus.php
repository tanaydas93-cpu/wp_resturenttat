<?php /* Template Name: About Us Page */
get_header(); ?>
   
 
    <!--End Hidden Bar -->

    <!-- Inner Banner Section -->
    <section class="inner-banner">
        <div class="image-layer" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/background/banner-image-1.jpg);"></div>
        <div class="auto-container">
            <div class="inner">
                <h1>About Us</h1>
                <div class="sub_text"> <p> A taste of perfection in every dish - <span class="primary-color"> fine dining with a modern twist.</span></p> </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->

    <!--Story Section-->
    <section class="story-section section-kt">
        <div class="auto-container">
            <div class="title-box centered">
                <div class="subtitle"><span>Jai Guru</span></div>

                <h2>Where Exquisite Flavors Meet <span class="theme_color">Elegant Ambiance</span> for an <span class="theme_color">Unforgettable Fine Dining </span> Experience!</h2>
            </div>
            <div class="row clearfix">
                <!--Col-->
                <div class="text-col col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="inner wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">

                        <div class="text"> Lorem Ipsum is simply dummy text of the printingand typesetting industry lorem Ipsum has been the industrys standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen book It has survived not only five centuries, but also the leap into.</div>

                        <div class="feature-info">

                            <div class="feature-info-box">
                                <div class="feature-title">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/hygienic.png" alt="image">
                                    <h6>Hygienic <br> Food </h6>
                                </div>
                                <div class="infotext"> Lorem Ipsum is simply dummy text of the printing and type setting dummy text.</div>
                            </div>

                            <div class="feature-info-box">
                                <div class="feature-title">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/ambiance.png" alt="image">
                                    <h6>fresh <br> Ambience </h6>
                                </div>
                                <div class="infotext"> Lorem Ipsum is simply dummy text of the printing and type setting dummy text.</div>
                            </div>

                        </div>

                        <div class="booking-info">
                            <div class="bk-title">Booking Request : <br>
                            <a class="bk-no" href="tel:+80-400-123456">+80 (400) 123 4567</a></div>
                            
                            <div class="link-box">
                                <a href="http://localhost/resturent/book_table/" class="theme-btn btn-style-two clearfix">
                                    <span class="btn-wrap">
                                        <span class="text-one">book a table</span>
                                        <span class="text-two">book a table</span>
                                    </span>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!--Col-->
                <div class="image-col col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="inner wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="images parallax-scene-1">
                            <div class="image" data-depth="0.15"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/image-1.jpg" alt="image"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!--Intro Section-->
    <section class="intro-section ">
        <div class="intro-anim-image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/abt_dish.png" alt="image"></div>
        <div class="image-layer" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/background/video_bg.jpg);"></div>
        <?php
global $wpdb;
$video = $wpdb->get_row(
    "SELECT * FROM {$wpdb->prefix}video_section WHERE status = 1 LIMIT 1"
);

$video_url = ( $video && $video->video_id )
    ? wp_get_attachment_url( $video->video_id )
    : '';
?>
<?php if ( $video_url ) : ?>
    <div class="auto-container">
        <div class="content-box">
            <div class="play-btn">
                <a href="<?php echo esc_url( $video_url ); ?>"
                   class="lightbox-image theme-btn">
                    <span class="icon fa-sharp-duotone fa-solid fa-play">
                        <i class="ripple"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
    </section>

    <!--Why Us Section-->
    <section class="why-us-two section-kt">
        <div class="auto-container">
            <div class="title-box centered">
                <div class="subtitle"><span>why choose us</span></div>
                <h2>Why Dine With Us</h2>
            </div>
            <div class="row clearfix">

    <?php
    $why_query = new WP_Query( array(
        'post_type'      => 'why_choose',
        'posts_per_page' => 4,          // Always show exactly 4 blocks
        'post_status'    => 'publish',
        'orderby'        => 'rand',     // 🔀 Random on every page reload
    ) );

    // WOW animation delays for each block
    $delays = array( '0ms', '300ms', '600ms', '900ms' );
    $index  = 0;

    if ( $why_query->have_posts() ) :
        while ( $why_query->have_posts() ) : $why_query->the_post();

            $image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            $title = get_the_title();
            $delay = isset( $delays[ $index ] ) ? $delays[ $index ] : '0ms';
        ?>

        <!--Block-->
        <div class="why-block-two col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="inner-box wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="<?php echo esc_attr( $delay ); ?>">
                <div class="image-box">
                    <?php if ( $image ) : ?>
                        <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>">
                    <?php endif; ?>
                </div>
                <div class="over-box">
                    <h6><?php echo esc_html( $title ); ?></h6>
                </div>
            </div>
        </div>

        <?php
            $index++;
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No items found. Please add some Why Choose Us items.</p>';
    endif;
    ?>

</div>

            <div class="fact-counter">
                <div class="row clearfix">
                    <div class="fact-block col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="inner clearfix">
                            <div class="fact-count"><div class="count-box"><span class="count-text" data-stop="60" data-speed="2000">0</span><i>+</i></div></div>
                            <div class="fact-title">monthly visitors</div>
                            <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry has been. </p>
                        </div>
                    </div>
                    <div class="fact-block col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="inner clearfix">
                            <div class="fact-count"><div class="count-box"><span class="count-text" data-stop="22" data-speed="1500">0</span><i>+</i></div></div>
                            <div class="fact-title">positive reviews</div>
                            <p> Simply dummy text of the printing and typesetting industry lorem Ipsum has been. </p>
                        </div>
                    </div>
                    <div class="fact-block col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="inner clearfix">
                            <div class="fact-count"><div class="count-box"><span class="count-text" data-stop="135" data-speed="1000">0</span><i>+</i></div></div>
                            <div class="fact-title">secreat recipe</div>
                            <p> Simply dummy text of the printing and typesetting lorem Ipsum has been industry. </p>
                        </div>
                    </div>
                    <div class="fact-block col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="inner clearfix">
                            <div class="fact-count"><div class="count-box"><span class="count-text" data-stop="10" data-speed="1000">0</span><i>+</i></div></div>
                            <div class="fact-title">award & honnors</div>
                            <p> Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--chef Section 1-->
    <section class="chef-section-1 section-kt">
        <div class="auto-container">

            <div class="row clearfix">
                <!--Block-->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="title-box">
                        <div class="subtitle"><span>meet the chef</span></div>
                        <h2>Mater Chef Lorenzo</h2>
                        <p> A fine dine master chef crafts exquisite cuisine with precision, passion, creativity, and elegance, delivering unforgettable culinary experiences and refined flavors.</p>
                        <div class="link-box">
                            <a href="about.html" class="theme-btn btn-style-two clearfix">
                                <span class="btn-wrap">
                                    <span class="text-one">meet our team</span>
                                    <span class="text-two">meet our team</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!--Block-->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">
                    <div class="chef-image image1 parallax-scene-2 " >
                        <img data-depth="0.15" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/mainchef1.jpg" alt="image">
                    </div>
                    <div class="round-stamp">
                        <img data-depth="0.50" class="stamp_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/chefcap.png" alt="image">
                    </div>
                </div>

                <!--Block-->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="chef-image image2 parallax-scene-3">
                        <img data-depth="0.50" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/mainchef2.jpg" alt="image">
                    </div>
                    <div class="chef-image image3 parallax-scene-4">
                        <img data-depth="0.50" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/mainchef3.jpg" alt="image">
                    </div>
                </div>


            </div>

        </div>
    </section>

    <!--Testimonials Section-->
    <section class="testimonials-section section-kt">
        <div class="image-layer" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/background/testimonial-bg1.jpg);"></div>
        <div class="auto-container">
            <div class="title-box centered">
                <div class="subtitle"><span>Reviews</span></div>
                <h2>Happy Testimonials</h2>
            </div>

            <div class="row clearfix align-items-center">

                <div class="state-col col-xl-3 col-lg-2 col-md-6 col-sm-6 col-xs-12 order-2 order-lg-1">
                    <div class="value">25k+</div>
                    <div class="label">happy <br> customers</div>
                </div>

                <div class="carousel-col col-xl-6 col-lg-8 col-md-12 col-sm-12 order-1 order-lg-2">
                    <div class="carousel-box">
                        <div class="testi-top owl-theme owl-carousel">
                            <div class="slide-item">
                                <div class="slide-content">
                                    <div class="text quote-text">An unforgettable dining experience! Every dish was a masterpiece, and the ambiance was simply perfect. From the first bite to the last, every moment was pure culinary bliss!.</div>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="slide-content">
                                    <div class="text quote-text">An extraordinary dining journey! The flavors were rich, the presentation stunning, and the atmosphere just right. Each bite felt like art on a plate. Truly a must-try experience! </div>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="slide-content">
                                    <div class="text quote-text">Every dish was bursting with flavor and creativity! The ambiance set the mood perfectly. From start to finish, it was a delightful culinary adventure. the presentation stunning!</div>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="slide-content">
                                    <div class="text quote-text">Such a memorable meal! The food was divine, beautifully plated, and the setting was cozy and elegant and delicious. A true gem for food lovers. We’ll definitely be back for more!</div>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="slide-content">
                                    <div class="text quote-text">A delightful feast for all the senses! The food was sensational, and the ambiance added charm to the evening. Each course impressed us. A dining experience worth repeating again.</div>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="slide-content">
                                    <div class="text quote-text">From the warm welcome to the last bite, everything was flawless. The dishes were exceptional, the vibe was perfect, and the service was top-notch. An absolute culinary!</div>
                                </div>
                            </div>
                        </div>

                        <div class="thumbs-carousel-box">
                            <div class="testi-thumbs owl-theme owl-carousel">
                                <div class="slide-item">
                                    <div class="image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/author-thumb-1.jpg"  alt="image"></div>
                                    <div class="auth-title">Sam Jhonson</div>
                                </div>
                                <div class="slide-item">
                                    <div class="image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/author-thumb-2.jpg"  alt="image"></div>
                                    <div class="auth-title">Ian Botham</div>
                                </div>
                                <div class="slide-item">
                                    <div class="image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/author-thumb-3.jpg"  alt="image"></div>
                                    <div class="auth-title">Dan Bitson</div>
                                </div>
                                <div class="slide-item">
                                    <div class="image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/author-thumb-1.jpg"  alt="image"></div>
                                    <div class="auth-title">Sam Jhonson</div>
                                </div>
                                <div class="slide-item">
                                    <div class="image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/author-thumb-2.jpg"  alt="image"></div>
                                    <div class="auth-title">Ian Botham</div>
                                </div>
                                <div class="slide-item">
                                    <div class="image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/author-thumb-3.jpg"  alt="image"></div>
                                    <div class="auth-title">Dan Bitson</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rating-col col-xl-3 col-lg-2 col-md-6 col-sm-6 col-xs-12 order-3 order-lg-3">
                    <div class="value">4.9/5</div>
                    <div class="label">rated on <br> google</div>
                </div>
            </div>

        </div>
    </section>

    <!--Services Section-->
    <section class="services-section section-kt">
        <div class="auto-container">
            <div class="title-box centered">
                <div class="subtitle"><span>our services</span></div>
                <h2>Perfect Spaces for <br> Every Occasion</h2>
            </div>
            <div class="row clearfix">
                <div class="s-col col-lg-4 col-md-6 col-sm-12">
                    <div class="inner wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="s-block alternate">
                            <div class="inner">
                                <div class="icon-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/s-icon-1.png" alt="image" title=""></div>
                                <h6>party & <br> celebrations</h6>
                                <div class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has been the industrys.</div>
                            </div>
                        </div>
                        <div class="s-block alternate">
                            <div class="inner">
                                <div class="icon-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/s-icon-2.png" alt="image" title=""></div>
                                <h6>luxury <br> Fine Dining</h6>
                                <div class="text">Simply dummy text of the printing and typesetting industry lorem Ipsum has been the industrys lorem Ipsum is.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="s-col last col-lg-4 col-md-6 col-sm-12">
                    <div class="inner wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="s-block ">
                            <div class="inner">
                                <div class="icon-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/s-icon-3.png" alt="image" title=""></div>
                                <h6>banquet <br> hall</h6>
                                <div class="text">Printing and typeset industry lorem Ipsum has been lorem Ipsum is simply dummy typeset industry lorem Ipsum has been.</div>
                            </div>
                        </div>
                        <div class="s-block ">
                            <div class="inner">
                                <div class="icon-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/s-icon-4.png" alt="image" title=""></div>
                                <h6>outdoor <br> catering</h6>
                                <div class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has been the industrys.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-col col-lg-4 col-md-12 col-sm-12">
                    <div class="inner wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="image-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/service-image.png" alt="image" title=""></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Gallery Section-->
    <section class="image-gallery section-kt">
        <div class="carousel-box">
            <div class="auto-container">
                <div class="title-box centered">
                    <div class="subtitle"><span>Gallery</span></div>
                    <h2>Restoria Gallery</h2>
                </div>
<div class="image-gallery-slider owl-theme owl-carousel">

    <?php
    $gallery_query = new WP_Query( array(
        'post_type'      => 'gallery_item',
        'posts_per_page' => -1,          // Show all items
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ) );

    if ( $gallery_query->have_posts() ) :
        while ( $gallery_query->have_posts() ) : $gallery_query->the_post();

            // Small image — Featured Image
            $small_img = get_the_post_thumbnail_url( get_the_ID(), 'medium' );

            // Big image — custom meta
            $big_image_id  = get_post_meta( get_the_ID(), '_gallery_big_image_id', true );
            $big_img       = $big_image_id ? wp_get_attachment_url( $big_image_id ) : $small_img;

            $alt = esc_attr( get_the_title() );
        ?>

        <!--Slide Item-->
        <div class="gallery-block">
            <div class="image">
                <a href="<?php echo esc_url( $big_img ); ?>" class="lightbox-image" data-fancybox="gallery">
                    <img src="<?php echo esc_url( $small_img ); ?>" alt="<?php echo $alt; ?>">
                </a>
            </div>
        </div>

        <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No gallery images found.</p>';
    endif;
    ?>

</div>
            </div>
        </div>
    </section>

    <?php get_footer(); ?>