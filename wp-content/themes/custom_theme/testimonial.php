
    <?php /* Template Name: Testimonial Page */ 
    get_header(); ?>
    <!-- Inner Banner Section -->
    <section class="inner-banner">
        <div class="image-layer" style="background-image: url(<?php echo get_template_directory_uri(); ?>assets/images/background/banner-image-6.jpg);"></div>
        <div class="auto-container">
            <div class="inner">
                <h1>Testimonials</h1>
                <div class="sub_text"> <p> A taste of perfection in every dish - <span class="primary-color"> fine dining with a modern twist.</span></p> </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->

    <!--Testimonials Section-->
    <section class="testimonials-masonry section-kt">
        <div class="auto-container">
            
            <div class="google_rating">
                <div class="star">
                  <span><i class="fa-solid fa-star"></i></span>
                  <span><i class="fa-solid fa-star"></i></span>
                  <span><i class="fa-solid fa-star"></i></span>
                  <span><i class="fa-solid fa-star"></i></span>
                  <span><i class="fa-solid fa-star"></i></span>
                </div>
                <p>4.9 / 5.0  Rated on <a href="#" class="rate_link"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/google.svg" alt="image"> <i class="fa-light fa-arrow-right"></i> </a></p>
            </div>
             <div class="testimonial-boxlist">

<?php
global $wpdb;

$table_name = $wpdb->prefix . 'testimonials';

$testimonials = $wpdb->get_results(
    "SELECT * FROM {$table_name}
     WHERE status = 1
     ORDER BY sort_order ASC, id DESC"
);

if (!empty($testimonials)) :
    foreach ($testimonials as $testimonial) :

        $image_url = !empty($testimonial->image_id)
            ? wp_get_attachment_image_url($testimonial->image_id, 'thumbnail')
            : get_template_directory_uri() . '/images/resource/default-author.jpg';
?>

    <div class="testi-block">
        <div class="inner-box">

            <div class="rating">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <span class="fa <?php echo ($i <= $testimonial->rating) ? 'fa-star' : 'fa-star-o'; ?>"></span>
                <?php endfor; ?>
            </div>

            <div class="text">
                <?php echo esc_html($testimonial->description); ?>
            </div>

            <div class="auth-info">
                <div class="image">
                    <img src="<?php echo esc_url($image_url); ?>"
                         alt="<?php echo esc_attr($testimonial->author_name); ?>">
                </div>

                <div class="auth-title">
                    <?php echo esc_html($testimonial->author_name); ?>

                    <?php if (!empty($testimonial->location)) : ?>
                        - <span class="location">
                            <?php echo esc_html($testimonial->location); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php
    endforeach;
endif;
?>

</div>
            
        </div>
    </section>
    <?php get_footer(); ?>