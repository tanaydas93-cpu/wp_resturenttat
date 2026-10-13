 <?php wp_footer(); ?>

     <?php
global $wpdb;
$info = $wpdb->get_row(
    "SELECT * FROM {$wpdb->prefix}restaurant_info WHERE status = 1 LIMIT 1"
);

?>
 <!--Main Footer-->
    <footer class="main-footer">
        <div class="upper-section section-kt">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Footer Col-->
                    <div class="footer-col info-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="content">
                                <div class="logo"><a href="index-2.html" title="Restoria - Restaurants HTML Template"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="image" title="Restoria - Restaurants HTML Template"></a></div>
<?php if ( $info ) : ?>
<div class="info">
    <h6>visit us</h6>
    <ul>
        <li>
            <?php echo esc_html( $info->address_line ); ?>,
            <?php echo esc_html( $info->address_city ); ?>
        </li>

        <li>
            Daily - <?php echo esc_html( $info->lunch_start ); ?> to <?php echo esc_html( $info->dinner_end ); ?>
        </li>

        <li>
            <a href="mailto:<?php echo esc_attr( $info->email ); ?>">
                <?php echo esc_html( $info->email ); ?>
            </a>
        </li>

        <li>
            <a href="tel:<?php echo esc_attr( $info->booking_phone ); ?>">
                Booking Request : <?php echo esc_html( $info->booking_phone ); ?>
            </a>
        </li>
    </ul>
</div>
<?php endif; ?>
                                <div class="separator"><span> </span> </div>
                                <div class="newsletter">
                                    <h4>Our Newsletter</h4>
                                    <div class="text">Subscribe us & Get 25% Off. Get latest updates.</div>
                                    <div class="newsletter-form">
                                        <form method="post" action="" id="ns-newsletter-form">
    <div class="form-group">
        <span class="alt-icon far fa-envelope"></span>
        <input type="email" name="email" value="" placeholder="Your email" required>
        <button type="submit" class="theme-btn btn-style-one clearfix">
            <span class="btn-wrap">
                <span class="text-one">subscribe</span>
                <span class="text-two">subscribe</span>
            </span>
        </button>
    </div>

    <!-- Message will appear here -->
    <div class="ns-message" style="margin-top:10px;"></div>
</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Footer Col-->
                    <div class="footer-col footer-image-col col-lg-3 col-md-6 col-sm-12">
                        <div class="footer-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/footer-img-1.jpg" alt="image">
                        </div>
                    </div>
                    <!--Footer Col-->
                    <div class="footer-col footer-image-col last col-lg-3 col-md-6 col-sm-12">
                        <div class="footer-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/footer-img-2.jpg" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- last footer -->
        <div class="bottom_footer">
        <!-- container start -->
          <div class="auto-container">
            <!-- row start -->
            <div class="row clearfix">
              <div class="col-lg-4 col-md-4 col-sm-12">
                  <p>© 2025 All Rights Reserved</p>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                <ul class="social_media">
                  <li><a href="https://themeforest.net/user/kalanidhithemes/portfolio" aria-label="facebook page" ><i class="fa-brands fa-facebook-f"></i></a></li>
                  <li><a href="https://www.behance.net/kalanidhithemes" aria-label="twitter page"><i class="fa-brands fa-instagram"></i></a></li>
                  <li><a href="https://themeforest.net/user/kalanidhithemes/portfolio" aria-label="instagram page"><i class="fa-brands fa-pinterest-p"></i></a></li>
                  <li><a href="https://themeforest.net/user/kalanidhithemes/portfolio" aria-label="pinterest page"><i class="fa-brands fa-youtube"></i></a></li>
                </ul>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                  <p class="developer_text">Crafted by <a href="https://themeforest.net/user/kalanidhithemes/portfolio" target="blank">Kalanidhi Themes</a></p>
              </div>
            </div>
          <!-- row end -->
          </div>
          <!-- container end -->
        </div>
    </footer>

</div>
<!--End pagewrapper--> 

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="icon fa fa-angle-up"></span></div>
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]--> 

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/popper.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery-ui.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.fancybox.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/owl.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/appear.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/wow.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/parallax.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/custom-script.js"></script>
</body>

<!-- Mirrored from kalanidhithemes.com/live-preview/landing-page/restoria/all-demo/Restoria-1-Minimal-Hero/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 May 2026 06:14:25 GMT -->
</html>