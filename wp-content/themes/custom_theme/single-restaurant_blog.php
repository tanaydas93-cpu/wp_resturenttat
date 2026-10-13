

<?php get_header(); ?>
    <!--Info Back Drop-->
    <div class="info-back-drop"></div>
    

    <!--End Hidden Bar -->

    <!-- Inner Banner Section -->
  
<section class="inner-banner">

    <?php if (has_post_thumbnail()) : ?>
        <div class="image-layer" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>);"></div>
    <?php else : ?>
        <div class="image-layer" style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/background/banner-image-7.jpg);"></div>
    <?php endif; ?>

    <div class="auto-container">
        <div class="inner">

            <h1><?php the_title(); ?></h1>

            <div class="sub_text">
                <p>
                    A taste of perfection in every dish -
                    <span class="primary-color">fine dining with a modern twist.</span>
                </p>
            </div>

        </div>
    </div>
</section>
    <!--End Banner Section -->

    <!-- Blog Details Block Start-->
    <section class="blog_detail_section section-kt" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200">
      <div class="auto-container">
        <div class="blog_inner_pannel">
            <div class="blog_info info" data-aos="fade-up" data-aos-duration="2000">
               <ul>
    <li><?php echo get_the_date('d F, Y'); ?></li>

    <li>By: <?php the_author(); ?></li>

    <li>
        <?php
        $cats = get_the_terms(get_the_ID(), 'blog_category');
        if ($cats && !is_wp_error($cats)) {
            foreach ($cats as $cat) {
                echo '<a href="' . get_term_link($cat) . '">' . esc_html($cat->name) . '</a>';
                break; // show only first category
            }
        }
        ?>
    </li>
</ul>

                <h2>Elegance in Every Artful Bite</h2>
                <p>Dummy text of the printing and types etting industry lorem Ipsum has been the indu has been the industrys standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen booksince the when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting.</p>

            </div>
           <?php if (has_post_thumbnail()) : ?>
    <div class="main_img">
        <?php the_post_thumbnail('full'); ?>
    </div>
<?php endif; ?>
            <div class="blog_content">

    <?php the_content(); ?>

</div>
    <!-- Blog Details Block End-->
     <div class="blog_authore" data-aos="fade-up" data-aos-duration="1500">
             <div class="social_media">
    <h6>Share this</h6>

    <ul>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>

        <li><a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>

        <li><a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a></li>

        <li><a href="https://www.youtube.com/" target="_blank"><i class="fa-brands fa-youtube"></i></a></li>
    </ul>
               </div>
     </div>
     <?php
$comments = get_comments(array(
    'post_id' => get_the_ID(),
    'status'  => 'approve'
));

if ($comments) :
?>
    <!-- Comment Section Start-->
    <section class="row_am comment_section">
      <div class="auto-container">
        <div class="blog_cooment_block">
          <div class="posted_cooment">
            <div class="section_title" data-aos="fade-up" data-aos-duration="1500">
<h3><?php echo count($comments); ?> Comments</h3>
            </div>
<ul>

<?php foreach ($comments as $comment) : ?>

<li>

    <div class="authore_info">

    <div class="avtar">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/author-thumb-1.jpg"
             alt="Author">
    </div>

    <div class="text">
        <span>
            <?php echo human_time_diff(
                strtotime($comment->comment_date),
                current_time('timestamp')
            ); ?> ago
        </span>
        <br>
        <?php echo esc_html($comment->comment_author); ?>
    </div>

</div>

    <div class="comment">
        <p><?php echo esc_html($comment->comment_content); ?></p>
    </div>

</li>

<?php endforeach; ?>

</ul>

<?php endif; ?>
          </div>
          <!-- Comment block Form -->
          <div class="comment_form_section">
            <div class="section_title" data-aos="fade-up" data-aos-duration="1500">
              <h3>Leave a comment</h3>
              <p>Your email address will not be published. Required fields are marked *</p>
            </div>
            <?php if (isset($_GET['comment']) && $_GET['comment'] == 'success') : ?>
    <div class="alert alert-success comment-success-msg">
        Thank you! Your comment has been submitted successfully and is awaiting admin approval.
    </div>
<?php endif; ?>
            <form id="commentForm" action="" method="post" data-aos="fade-up" data-aos-duration="1500">
                  <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">

            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" required class="form-control"name="author" placeholder="Name *">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" required class="form-control" name="email" placeholder="Email *">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" required class="form-control" name="phone" placeholder="Phone">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" name="website" placeholder="Website  ">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <textarea class="form-control" name="comment" required placeholder="Comments"></textarea>
                  </div>
                </div>
                <div class="col-md-12 coment-btn">
                    <button type="submit" name="submit_comment" class="theme-btn btn-style-one clearfix ">
                        <span class="btn-wrap">
                            <span class="text-one">post your comment</span>
                            <span class="text-two">post your comment</span>
                        </span>
                    </button>

                </div>
              </div>
            </form>
            <div id="comment-response"></div>
          </div>
        </div>
      </div>
    </section>
    <!-- Comment Section End-->
<?php get_footer(); ?>