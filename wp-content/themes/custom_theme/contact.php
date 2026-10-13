
<?php /* Template Name: Contact Page */
  get_header(); ?>
   <?php
global $wpdb;
$info = $wpdb->get_row(
    "SELECT * FROM {$wpdb->prefix}restaurant_info WHERE status = 1 LIMIT 1"
);
 // Debugging line to check the retrieved data
// Fallback to default theme image if no image set
$bg_image = 
     wp_get_attachment_image_url( $info->image_id, 'full' );

?>

?>
    <!--Info Back Drop-->
    <div class="info-back-drop"></div>
        

    <!-- Inner Banner Section -->
    <section class="inner-banner">
<div class="image-layer"
     style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/background/banner-image-4.jpg');">
</div>        <div class="auto-container">
            <div class="inner">
                <h1>Contact Us</h1>
                <div class="sub_text"> <p> A taste of perfection in every dish - <span class="primary-color"> fine dining with a modern twist.</span></p> </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->

    <!--Contact Info Section-->
    <section class="contact-page section-kt">
    
        <!--Location form Section-->
        <div class="auto-container">
            <div class="c-page-form-box">
                <div class="row clearfix">

                <!--form image Section-->
                <div class="loc-block info-block col-lg-5 col-md-12 col-sm-12">
                    <div class="contact-image">
<img src="<?php echo esc_url( $bg_image ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    </div>
                    <?php if ( $info ) : ?>

<h5>Visit Us</h5>

<div class="text">

    <?php if ( ! empty( $info->address_line ) || ! empty( $info->address_city ) ) : ?>
        <?php echo esc_html( $info->address_line ); ?> ,
        <?php if ( ! empty( $info->address_city ) ) : ?>
           
            <?php echo esc_html( $info->address_city ); ?>
        <?php endif; ?>
        <br><br>
    <?php endif; ?>

    <?php if ( ! empty( $info->lunch_start ) || ! empty( $info->lunch_end ) ) : ?>
        <span class="c-info-ttl">Lunch Time</span> -
        <?php echo esc_html( $info->lunch_start ); ?> – <?php echo esc_html( $info->lunch_end ); ?>
        <br>
    <?php endif; ?>

    <?php if ( ! empty( $info->dinner_start ) || ! empty( $info->dinner_end ) ) : ?>
        <span class="c-info-ttl">Dinner Time</span> -
        <?php echo esc_html( $info->dinner_start ); ?> – <?php echo esc_html( $info->dinner_end ); ?>
        <br><br>
    <?php endif; ?>

    <?php if ( ! empty( $info->booking_phone ) ) : ?>
        <span class="more-link">
            Booking :
            <a href="tel:<?php echo esc_attr( $info->booking_phone ); ?>">
                <?php echo esc_html( $info->booking_phone ); ?>
            </a>
        </span>
        <br>
    <?php endif; ?>

    <?php if ( ! empty( $info->email ) ) : ?>
        <span class="more-link">
            Email:
            <a href="mailto:<?php echo esc_attr( $info->email ); ?>">
                <?php echo esc_html( $info->email ); ?>
            </a>
        </span>
    <?php endif; ?>

</div>

<?php endif; ?>
                </div>

                <!--Vertical line -->
                <div class="col-12 col-md-1 d-flex justify-content-center middle-line-wrapper">
                  <div class="middle-line-container">
                    <div class="dot top-dot"></div>
                    <div class="v-line"></div>
                    <div class="dot bottom-dot"></div>
                  </div>
                </div>

                <!--form Section-->
                <div class="loc-block col-lg-6 col-md-12 col-sm-12">
                    <div class="form-side">
                        <div class="title-box centered">
                            <div class="subtitle"><span>Write to us</span></div>
                            <h2>Message us</h2>
                            <div class="text desc">Contact us - we aim to reply within 24 hours and are happy to help!</div>
                        </div>
                        <div class="default-form reservation-form">
                            <form method="post" action="https://kalanidhithemes.com/live-preview/landing-page/restoria/all-demo/Restoria-1-Minimal-Hero/index.html">
                                <div class="clearfix">
                                    <div class="form-group">
                                        <div class="field-inner">
                                            <input type="text" name="fieldname" value="" placeholder="Your Name" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="field-inner">
                                            <input type="text" name="fieldname" value="" placeholder="Your Email" required="">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="field-inner">
                                            <input type="text" name="fieldname" value="" placeholder="Phone Number" required="">
                                        </div>
                                    </div>
                                
                                    <div class="form-group ">
                                        <div class="field-inner">
                                            <textarea name="fieldname" placeholder="Special Request" required=""></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="theme-btn btn-style-one clearfix">
                                            <span class="btn-wrap">
                                                <span class="text-one">send your message</span>
                                                <span class="text-two">send your message</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </section>

    <!--Map Section-->
    <section class="contact-map">
                <div class="row clearfix">

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d81392.11276571127!2d-74.03116502768826!3d40.70144849986174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1667928043843!5m2!1sen!2sin" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
    </section>

  <?php get_footer(); ?>