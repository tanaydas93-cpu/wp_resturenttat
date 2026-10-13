<?php /* Template Name: Book Table Page */
 get_header(); ?>

    <!--Info Back Drop-->
    <div class="info-back-drop"></div>
    
    <!-- Hidden Bar -->
    <section class="info-bar">
        <div class="inner-box">
            <div class="cross-icon"><span class="far fa-close"></span></div>
            <div class="image-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/sidebar-image.jpg" alt="image" title=""></div>
            <div class="logo-box"><a href="index-2.html" title="Restoria - Restaurants HTML Template"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/sidebar-logo.png" alt="image" title="Restoria - Restaurants HTML Template"></a></div>

            <h5>Visit Us</h5>
            <ul class="info">
                <li>Restoria, Arrondissement, <br> Paris 9578</li>
                <li> <span class="ib-ttl"> Lunch Time </span>- 10.00 am – 3:30 pm </li>
                <li><span class="ib-ttl"> Dinner Time</span> - 08.00 pm – 10:30 pm</li>
                <li><a href="mailto:booking@domainame.com">booking@domainame.com</a></li>
            </ul>
            <div class="booking-info">
                <div class="bk-no"><a href="tel:+88-123-123456">Booking: +88-123-123456</a></div>
            </div>
        </div>
    </section>
    <!--End Hidden Bar -->

    <!--Reservation Section-->
    <section class="reserve-section style-two reserve-page section-kt">
        <div class="image-layer" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/background/image-10.jpg);"></div>
        <div class="auto-container">
            <div class="outer-box">
                <div class="row clearfix">

                    <div class="reserv-col col-lg-8 col-md-12 col-sm-12 mx-auto">
                        <div class="inner">
                            <div class="title-box centered">
                                <div class="subtitle"><span>Online reservation</span></div>
                                <h2>Book A Table</h2>
                                <div class="request-info">Booking request <a href="#">+88-123-123456</a> or fill out the order form</div>
                            </div>
                            <div class="default-form reservation-form">
                                <form method="post" action="https://kalanidhithemes.com/live-preview/landing-page/restoria/all-demo/Restoria-1-Minimal-Hero/index.html">
                                    <div class="row clearfix">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <div class="field-inner">
                                                <input type="text" name="fieldname" value="" placeholder="Your Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <div class="field-inner">
                                                <input type="text" name="fieldname" value="" placeholder="Phone Number" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="field-inner">
                                                <span class="alt-icon far fa-user"></span>
                                                <select class="l-icon">
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
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="field-inner">
                                                <span class="alt-icon far fa-calendar"></span>
                                                <input class="l-icon datepicker" type="text" name="fieldname" value="" placeholder="DD-MM-YYYY" required readonly>
                                                <span class="arrow-icon far fa-angle-down"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                            <div class="field-inner">
                                                <span class="alt-icon far fa-clock"></span>
                                                <select class="l-icon">
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
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="field-inner">
                                                <textarea name="fieldname" placeholder="Message" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="field-inner">
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
                </div>

            </div>
        </div>
    </section>

<?php get_footer(); ?>