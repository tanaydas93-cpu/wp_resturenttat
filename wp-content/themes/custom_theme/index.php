<?php
get_header(); ?>


    <section class="banner-section">

        <!-- social link -->
        <div class="banner-social-list">
          <span class="line"></span>

          <ul class="custom-ul">
            <li> <a href="#"> FB </a> </li>
            <li><a href="#"> IN </a> </li>
            <li><a href="#"> YT </a> </li>
          </ul>

          <span class="line"></span>
        </div>

        <!-- social link -->
        <div class="banner-call">
          <span class="line"></span>

          <ul class="call-ul">
            <li><a href="tel:+88-123-123456">Booking : +88-123-123456</a></li>
          </ul>

          <span class="line"></span>
        </div>

          <!-- Banner Inner Container -->
          <div class="banner-container">
            <div class="auto-container">

                <!--  Text content moved above Swiper -->
                <div class="content-box banner-text-top">
                <div class="content">
                  <div class="clearfix">
                    <div class="inner">
                      <h1>Delightful Experience</h1>
                      <div class="text">A taste of perfection in every dish -  <span class="theme_color">fine dining with a modern twist.</span></div>
                    </div>
                  </div>
                </div>
                </div>
                  
                <!--  Slider image inside container -->
                <div class="banner-slider slider-contained">
                <div class="swiper-wrapper">

    <?php
    $slider_query = new WP_Query( array(
        'post_type'      => 'slider',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',   // Controlled by "Order" field in admin
        'order'          => 'ASC',
    ) );

    if ( $slider_query->have_posts() ) :
        while ( $slider_query->have_posts() ) : $slider_query->the_post();

            // Get the featured image URL (full size for background)
            $slide_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );

            // Skip slide if no image is set
            if ( ! $slide_image ) continue;
        ?>

        <!--Slide Item-->
        <div class="swiper-slide slide-item">
            <div class="image-layer" style="background-image: url(<?php echo esc_url( $slide_image ); ?>);"></div>
        </div>

        <?php
        endwhile;
        wp_reset_postdata();
    else :
        // Fallback: show nothing or a default slide
    endif;
    ?>

</div>

                <div class="swiper-button-prev"><span class="fal fa-angle-left"></span></div>
                <div class="swiper-button-next"><span class="fal fa-angle-right"></span></div>
                </div>

                <!--  location and time info -->
                <div class="hero-info">
                    <?php
global $wpdb;

$restaurant_info = $wpdb->get_row(
    "SELECT * FROM {$wpdb->prefix}restaurant_info WHERE status = 1 LIMIT 1"
);

if ($restaurant_info) :
    $address = $restaurant_info->address_line . ', ' . $restaurant_info->address_city;

    // Example: Lunch 12:00 PM - 3:00 PM | Dinner 7:00 PM - 11:00 PM
    $opening_hours = sprintf(
        'Lunch: %s - %s | Dinner: %s - %s',
        $restaurant_info->lunch_start,
        $restaurant_info->lunch_end,
        $restaurant_info->dinner_start,
        $restaurant_info->dinner_end
    );
?>
<div class="top-bar-content">
    <div class="info-item">
        <span class="label">VISIT US :</span>
        <?php echo esc_html($address); ?>
    </div>

    <div class="separator">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/star-element.svg'); ?>" alt="separator">
    </div>

    <div class="info-item">
        <span class="label">WE ARE OPEN :</span>
        <?php echo esc_html($opening_hours); ?>
    </div>
</div>
<?php endif; ?>
                </div>

            </div>
          </div>

          <a href="book-table.html" class="book-btn">
            <span class="icon"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/book-icon-1.png" alt="image" title="image"> </span>
          </a>
    </section>

    <!--About Section-->
    <section class="about-section section-kt">
        <div class="container-fluid">
            <div class="title-box centered">
                <div class="subtitle"><span>our story</span></div>

                <h2>Enjoy Every Moment with Tasty <span class="theme_color"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/tag-img1.png" alt="image" title="image"> Breakfast</span>, Hearty <span class="theme_color"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/tag-img2.png" alt="image" title="image"> Mains</span> &  <span class="theme_color"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/tag-img3.png" alt="image" title="image"> Drinks </span> </h2>
            </div>

            <div class="row clearfix">
                <!--Col-->
                <div class="text-col col-xl-3 col-lg-4 col-md-8 mx-auto">
                    <div class="inner wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">

                        <div class="text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has Ipsum has been been the  industrys standard dummy text ever since the when an unknown printer took.</div>

                        <div class="lower-link-box text-center">
                            <a href="http://localhost/resturent/about-us/" class="theme-btn btn-style-two clearfix">
                                <span class="btn-wrap">
                                    <span class="text-one">About us</span>
                                    <span class="text-two">About us</span>
                                </span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <!--Col-->
            <div class="image-col col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="inner wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="0ms">
                    <div class="floating-images ">
                        <div class="abt-image1 parallax-scene-1"><img data-depth="0.50" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/about1.jpg" alt="image"></div>
                        <div class="abt-image2 parallax-scene-2"><img data-depth="0.50" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/about2.jpg" alt="image"></div>
                        <div class="abt-image3 parallax-scene-3"><img data-depth="0.90" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/about3.jpg" alt="image"></div>
                    </div>

                </div>
            </div>


        </div>
    </section>
<!-- menu section -->
    <section class="menu-card-style-section section-kt">
    <div class="auto-container">
        <div class="menu-card-main">

            <div class="top-pattern"></div>

            <div class="title-box centered">
                <div class="title-badge">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/menu-title-badge.svg" alt="image">
                </div>
                <h2>Our Menu</h2>
            </div>

            <!-- menu card corner images -->
            <img class="menu-card-corner top-left" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/menucard-corner-left-top.png" alt="image">
            <img class="menu-card-corner top-right" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/menucard-corner-right-top.png" alt="image">
            <img class="menu-card-corner bottom-left" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/menucard-corner-left-bottom.png" alt="image">
            <img class="menu-card-corner bottom-right" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/menucard-corner-right-bottom.png" alt="image">

            <?php

            $categories = get_terms([
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'orderby'    => 'menu_order',
                'order'      => 'ASC',
            ]);

            if (!empty($categories) && !is_wp_error($categories)) :

                $count = 1;
                $total = count($categories);

                foreach ($categories as $category) :

                    $thumbnail_id = get_term_meta(
                        $category->term_id,
                        'thumbnail_id',
                        true
                    );

                    $image = wp_get_attachment_url($thumbnail_id);

                    if (!$image) {
                        $image = wc_placeholder_img_src();
                    }

                    $classes = '';

                    if ($count % 2 != 0) {
                        $classes .= ' alternate';
                    }

                    if ($count == $total) {
                        $classes .= ' last';
                    }
            ?>

                <div class="menu-card-style<?php echo esc_attr($classes); ?>">
                    <div class="row clearfix">

                        <!-- Category Image -->
                        <div class="image-col col-lg-6 col-md-12 col-sm-12">
                            <div class="inner">
                                <div class="image">
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Category Products -->
                        <div class="menu-col col-lg-6 col-md-12 col-sm-12">
                            <div class="inner">

                                <div class="title-box">
                                    <h3><?php echo esc_html($category->name); ?></h3>
                                </div>

                                <?php

                                $products = new WP_Query([
                                    'post_type'      => 'product',
                                    'posts_per_page' => -1,
                                    'post_status'    => 'publish',
                                    'tax_query'      => [
                                        [
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'term_id',
                                            'terms'    => $category->term_id,
                                        ]
                                    ]
                                ]);

                                if ($products->have_posts()) :

                                    while ($products->have_posts()) :

                                        $products->the_post();

                                        global $product;
                                ?>

                                        <div class="dish-block">
                                            <div class="inner-box">

                                                <div class="title clearfix">

                                                    <div class="ttl clearfix">
                                                        <h6>
                                                            <a href="<?php the_permalink(); ?>">
                                                                <?php the_title(); ?>
                                                            </a>
                                                        </h6>
                                                    </div>

                                                    <span class="menu-list-line"></span>

                                                    <div class="price">
                                                        <span>
                                                            <?php echo $product->get_price_html(); ?>
                                                        </span>
                                                    </div>

                                                </div>

                                                <div class="text desc">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php
                                                        echo wp_trim_words(
                                                            get_the_excerpt(),
                                                            20,
                                                            '...'
                                                        );
                                                        ?>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>

                                <?php

                                    endwhile;

                                    wp_reset_postdata();

                                endif;

                                ?>

                            </div>
                        </div>

                    </div>
                </div>

            <?php

                    $count++;

                endforeach;

            endif;

            ?>

        </div>
    </div>
</section>

    <!--Special Offer Section-->
    <section class="special-offer section-kt">
        <div class="outer-container">
            <div class="auto-container">
                <div class="title-box centered">
                    <div class="subtitle"><span>Popular</span></div>
                    <h2>Special Dishes</h2>
                </div>
                <div class="dish-gallery-slider owl-theme owl-carousel">

    <?php
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1, // all products
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'special-dishes', // category slug
            ),
        ),
    );

    $special_dishes = new WP_Query($args);

    if ($special_dishes->have_posts()) :
        $count = 0;

        while ($special_dishes->have_posts()) :
            $special_dishes->the_post();

            global $product;

            $count++;
            $rounded_class = ($count % 2 == 0) ? 'rounded' : '';

            // Get first category name
            $terms = get_the_terms(get_the_ID(), 'product_cat');
            $cat_name = !empty($terms) ? $terms[0]->name : '';

            // Short description
            $description = $product->get_short_description();
    ?>

        <div class="offer-block-two <?php echo esc_attr($rounded_class); ?>">
            <div class="inner-box">

                <div class="cat-name">
                    <?php echo esc_html($cat_name); ?>
                </div>

                <div class="image">
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('full');
                        } else {
                            echo wc_placeholder_img();
                        }
                        ?>
                    </a>
                </div>

                <h5>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h5>

                <div class="text desc">
                    <?php echo wp_trim_words($description, 15); ?>
                </div>

                <div class="price">
                    <?php echo $product->get_price_html(); ?>
                </div>

            </div>
        </div>

    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

</div>
        </div>
    </section>

    <!--Reservation Section Split Style-->
    <section class="fluid-section reserve-section splitscreen">
        <div class="outer-container">
            <div class="outer-box">
                <div class="row clearfix">
                    <div class="reserv-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="title-box centered">
                                <div class="subtitle"><span>Online reservation</span></div>
                                <h2>Book A Table</h2>
                                <div class="request-info">Booking request <a href="#">+88-123-123456</a> or fill out the order form</div>
                            </div>
                            <div class="default-form reservation-form">
                                <form method="post" id="restaurantBookingForm">
    <div class="row clearfix">
        <div class="form-group col-lg-6 col-md-6 col-sm-12">
            <div class="field-inner">
                <input type="text" name="name" id="bookingName" value="" placeholder="Your Name" required>
            </div>
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-12">
            <div class="field-inner">
                <input type="text" name="phone" id="bookingPhone" value="" placeholder="Phone Number" required>
            </div>
        </div>
        <!-- persons select -->
        <div class="form-group col-lg-4 col-md-6 col-sm-12">
            <div class="field-inner">
                <span class="alt-icon far fa-user"></span>
                <select name="persons" id="bookingPersons" class="l-icon">
                    <option>1 Person</option>
                    <option>2 Person</option>
                    <option>3 Person</option>
                    <option>4 Person</option>
                    <option>5 Person</option>
                    <option>6 Person</option>
                    <option>7 Person</option>
                </select>
                <span class="arrow-icon far fa-angle-down"></span>
            </div>
        </div>
        <!-- date -->
        <div class="form-group col-lg-4 col-md-6 col-sm-12">
            <div class="field-inner">
                <span class="alt-icon far fa-calendar"></span>
                <input class="l-icon datepicker" type="text" name="date" id="bookingDate" value="" placeholder="DD-MM-YYYY" required readonly>
                <span class="arrow-icon far fa-angle-down"></span>
            </div>
        </div>
        <!-- time -->
        <div class="form-group col-lg-4 col-md-12 col-sm-12">
            <div class="field-inner">
                <span class="alt-icon far fa-clock"></span>
                <select name="time" id="bookingTime" class="l-icon">
                    <option>08 : 00 am</option>
                    <option>09 : 00 am</option>
                    <option>10 : 00 am</option>
                    <option>11 : 00 am</option>
                    <option>12 : 00 pm</option>
                    <option>01 : 00 pm</option>
                    <option>02 : 00 pm</option>
                    <option>03 : 00 pm</option>
                    <option>04 : 00 pm</option>
                    <option>05 : 00 pm</option>
                    <option>06 : 00 pm</option>
                    <option>07 : 00 pm</option>
                    <option>08 : 00 pm</option>
                    <option>09 : 00 pm</option>
                    <option>10 : 00 pm</option>
                </select>
                <span class="arrow-icon far fa-angle-down"></span>
            </div>
        </div>
        <!-- message -->
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            <div class="field-inner">
                <textarea name="message" id="bookingMessage" placeholder="Message" required></textarea>
            </div>
        </div>
        <!-- submit -->
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            <div class="field-inner">
                <div id="bookingResponse"></div>
                <button type="submit" class="theme-btn btn-style-one clearfix">
                    <span class="btn-wrap">
                        <span class="text-one">book a table</span>
                        <span class="text-two">book a table</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>
                            </div>
                        </div>
                    </div>

                    <div class="graphic-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">

                            <div class="content-box">
                              <div class="video-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/split-sec-img.jpg" alt="image">
                                <div class="play-btn">
                                  <a href="https://www.youtube.com/watch?v=dZ9O_l1dIzs" class="lightbox-image theme-btn">
                                    <span class="icon fal fa-play"><i class="ripple"></i></span>
                                  </a>
                                </div>
                              </div>
 <?php
global $wpdb;
$info = $wpdb->get_row(
    "SELECT * FROM {$wpdb->prefix}restaurant_info WHERE status = 1 LIMIT 1"
);
 

?>
                                <div class="desc">
                                  <h5> visit us </h5>
                                  <div class="text">

    <?php if ( ! empty( $info->address_line ) || ! empty( $info->address_city ) ) : ?>
        <?php echo esc_html( $info->address_line ); ?>
        <?php if ( ! empty( $info->address_city ) ) : ?>
            , <?php echo esc_html( $info->address_city ); ?>
        <?php endif; ?>
        <br><br>
    <?php endif; ?>

    <?php if ( ! empty( $info->lunch_start ) || ! empty( $info->lunch_end ) ) : ?>
        <span class="info-ttl">Lunch Time</span> -
        <?php echo esc_html( $info->lunch_start ); ?> – <?php echo esc_html( $info->lunch_end ); ?>
        <br>
    <?php endif; ?>

    <?php if ( ! empty( $info->dinner_start ) || ! empty( $info->dinner_end ) ) : ?>
        <span class="info-ttl dinner">Dinner Time</span> -
        <?php echo esc_html( $info->dinner_start ); ?> – <?php echo esc_html( $info->dinner_end ); ?>
    <?php endif; ?>

</div>
                                </div>
                            </div>

                            <div class="graphic-layer" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/background/reservation-bg.jpg);"></div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!--chef Section 1-->

    <?php
global $wpdb;

$chef = $wpdb->get_row(
    "SELECT * 
     FROM {$wpdb->prefix}chefs
     WHERE status = 1
     ORDER BY RAND()
     LIMIT 1"
);

if ($chef) {

    $profile_image = $chef->profile_image_id
        ? wp_get_attachment_image_url($chef->profile_image_id, 'full')
        : get_template_directory_uri() . '/assets/images/resource/mainchef1.jpg';

    $hover_image = $chef->hover_image_id
        ? wp_get_attachment_image_url($chef->hover_image_id, 'full')
        : $profile_image;
}
?>
    <section class="chef-section-1 section-kt">
        <div class="auto-container">

            <div class="row clearfix">
                <!--Block-->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="title-box">
                        <div class="subtitle"><span>meet the chef</span></div>
                        <h2><?php echo esc_html($chef->name); ?></h2>

<p>
    <?php
    echo wp_trim_words(
        wp_strip_all_tags($chef->bio),
        25,
        '...'
    );
    ?>
</p>

<span class="designation">
    <?php echo esc_html($chef->designation); ?>
</span>
                        <div class="link-box">
                            <a href="http://localhost/resturent/our-shef" class="theme-btn btn-style-two clearfix">
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
                    <div class="chef-image image1 parallax-scene-1 " >
<img data-depth="0.15"
     src="<?php echo esc_url($profile_image); ?>"
     alt="<?php echo esc_attr($chef->name); ?>">                    </div>
                    <div class="round-stamp">
                        <img data-depth="0.50" class="stamp_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/chefcap.png" alt="image">
                    </div>
                </div>

                <!--Block-->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="chef-image image2 parallax-scene-2">
                        <img data-depth="0.50" src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/mainchef2.jpg" alt="image">
                    </div>
                    <div class="chef-image image3 parallax-scene-3">
<img data-depth="0.50"
     src="<?php echo esc_url($hover_image); ?>"
     alt="<?php echo esc_attr($chef->name); ?>">                    </div>
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

    <!--Recnt Updates Section-->
    <section class="news-section section-kt">
        <div class="auto-container">
            <div class="title-box centered">
                <div class="subtitle"><span>recent updates</span></div>
                <h2>Latest Blog Post</h2>
            </div>
            <div class="row justify-content-center clearfix">
                <!--Block-->
                <div class="news-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <div class="image-box">
                            <div class="image rounded"><a href="blog-single-post.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/news-2.jpg" alt="image"></a></div>
                            <div class="over-content">
                                <div class="date">30 <span>May | 2025</span></div>
                                <div class="cat">Food, flavour</div>
                                <h4><a href="blog-single-post.html">So yummy, tasty, you'll eat with your eyes.</a></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Block-->
                <div class="news-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="300ms">
                        <div class="image-box">
                            
                            <div class="image"><a href="blog-single-post.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/news-1.jpg" alt="image"></a></div>
                            <div class="over-content">
                                <div class="date">25 <span>May | 2025</span></div>
                                <div class="cat">healthy food</div>
                                <h4><a href="blog-single-post.html">Chef’s signature for refined tastes ever.</a></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Block-->
                <div class="news-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="600ms">
                        <div class="image-box">
                            <div class="image rounded"><a href="blog-single-post.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/news-3.jpg" alt="image"></a></div>
                            <div class="over-content">
                                <div class="date">18 <span>May | 2025</span></div>
                                <div class="cat">recipie</div>
                                <h4><a href="blog-single-post.html">Experience gourmet art and ambience.</a></h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="lower-link-box text-center">
                <a href="blog-list.html" class="theme-btn btn-style-two clearfix">
                    <span class="btn-wrap">
                        <span class="text-one">Read more blog</span>
                        <span class="text-two">Read more blog</span>
                    </span>
                </a>
            </div>
            
        </div>
    </section>

    <!--Instagram post-->
    <section class="ig-post-section section-kt">
        <div class="auto-container">
            <div class="title-box centered">
                <div class="subtitle"><span>follow us</span></div>
                <h2>Instagram</h2>
            </div>
            <div class="row justify-content-center clearfix">
                <!--Block-->
                <div class="ig-post-block col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="ig-post-image wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/insta1.jpg" alt="image"></a>
                    </div>
                </div>
                <!--Block-->
                <div class="ig-post-block col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="ig-post-image wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/insta2.jpg" alt="image"></a>
                    </div>
                </div>
                <!--Block-->
                <div class="ig-post-block col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="ig-post-image wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/insta3.jpg" alt="image"></a>
                    </div>
                </div>
                <!--Block-->
                <div class="ig-post-block col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="ig-post-image wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="0ms">
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/insta4.jpg" alt="image"></a>
                    </div>
                </div>

            </div>
            
            
            
        </div>
    </section>
<?php
   get_footer(); ?>