
   <?php /* Template Name: blog list Page */  get_header(); ?>
    <!--End Hidden Bar -->

    <!-- Inner Banner Section -->
    <section class="inner-banner">
        <div class="image-layer" style="background-image: url(images/background/banner-image-7.jpg);"></div>
        <div class="auto-container">
            <div class="inner">
                <h1>Blog List</h1>
                <div class="sub_text"> <p> A taste of perfection in every dish - <span class="primary-color"> fine dining with a modern twist.</span></p> </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->

    <!-- Main Blog List Section Start-->
    <section class="blog_list_section section-kt">
      <div class="auto-container">
        <div class="row">
            <!-- Blog Left Side -->            
          <div class="col-lg-8">
            <div class="blog_left_side">

                
           <?php

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args = array(
    'post_type'      => 'restaurant_blog',
    'posts_per_page' => 6, // blogs per page
    'paged'          => $paged
);

$query = new WP_Query($args);


if($query->have_posts()) :
    while($query->have_posts()) :
        $query->the_post();
?>
    
<div class="blog_panel" data-aos="fade-up" data-aos-duration="1500">

    <div class="main_img">
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('large'); ?>
        </a>
    </div>

    <div class="blog_info">
        <ul>
            <li><?php echo get_the_date('d F, Y'); ?></li>
            <li>By: <?php the_author(); ?></li>
            <li><?php echo get_the_term_list(
    get_the_ID(),
    'blog_category',
    '',
    ', '
); ?></li>
        </ul>

        <h4>
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h4>

        <p>
            <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
        </p>

        <div class="link-box">
            <a href="<?php the_permalink(); ?>" class="theme-btn btn-style-two clearfix">
                <span class="btn-wrap">
                    <span class="text-one">read more</span>
                    <span class="text-two">read more</span>
                </span>
            </a>
        </div>
    </div>

</div>

<?php
    endwhile;
    wp_reset_postdata();
endif;
?>


<div class="pagination_block" data-aos="fade-up" data-aos-duration="1500">
    <div class="row">
        <div class="col-lg-8">

            <?php
            echo paginate_links(array(
                'base'      => str_replace(
                    999999999,
                    '%#%',
                    esc_url(get_pagenum_link(999999999))
                ),
                'format'    => '?paged=%#%',
                'current'   => max(1, get_query_var('paged')),
                'total'     => $query->max_num_pages,
                'prev_text' => '<i class="fa-light fa-arrow-left"></i>',
                'next_text' => '<i class="fa-light fa-arrow-right"></i>',
                'type'      => 'list'
            ));
            ?>

        </div>
    </div>
</div>



                <!-- Blog post -->
                <div class="blog_panel" data-aos="fade-up" data-aos-duration="1500">
                    <div class="main_img">
                        <a href="blog-single-post.html"><img src="images/resource/blog-list-2.jpg" alt="image"></a>
                    </div>
                    <div class="blog_info">
                        <ul>
                            <li> 05 July, 2025 </li>
                            <li> By: Admin </li>
                            <li> <a href="#"> Recipes </a> </li>
                        </ul>
                        <h4><a href="blog-single-post.html">Experience Gourmet Art and Ambience</a></h4>
                        <p>Lorem Ipsum has been the indu has been the industrys standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting.</p>
                        <div class="link-box">
                            <a href="blog-single-post.html" class="theme-btn btn-style-two clearfix">
                                <span class="btn-wrap">
                                    <span class="text-one">read more</span>
                                    <span class="text-two">read more</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                


                
            </div>
          </div>

          <!-- blog Right Side -->
          <div class="col-lg-4">
            <div class="blog_right_side">
              <!-- Search Blog -->
              <div class="blog_search_block bg_box" data-aos="fade-up" data-aos-duration="1500">
                <form action="https://kalanidhithemes.com/live-preview/landing-page/restoria/all-demo/Restoria-1-Minimal-Hero/submit">
                  <div class="form-group">
                    <div class="form_inner">
                      <input type="text" class="form-control">
                      <button><i class="fa-light fa-magnifying-glass"></i></button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- Recent Post -->
<div class="recent_post_block bg_box" data-aos="fade-up" data-aos-duration="1500">

    <h6>Recent Post</h6>

    <ul class="recent_blog_list">

        <?php
        $recent_posts = new WP_Query(array(
            'post_type'      => 'restaurant_blog',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC'
        ));

        if ($recent_posts->have_posts()) :
            while ($recent_posts->have_posts()) : $recent_posts->the_post();
                ?>

                <li>
                    <a href="<?php the_permalink(); ?>">

                        <div class="img">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail'); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="image">
                            <?php endif; ?>
                        </div>

                        <div class="text">
                            <p><?php echo wp_trim_words(get_the_title(), 12, '...'); ?></p>
                            <span><?php echo get_the_date('F d, Y'); ?></span>
                        </div>

                    </a>
                </li>

            <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <li>No recent posts found</li>
        <?php endif; ?>

    </ul>

</div>

             <!-- Categories List -->
<div class="categories_block bg_box" data-aos="fade-up" data-aos-duration="1500">

    <h6>Categories</h6>

    <ul>
        <?php
        $categories = get_terms(array(
            'taxonomy'   => 'blog_category',
            'hide_empty' => true, // only categories with posts
        ));

        if (!empty($categories) && !is_wp_error($categories)) :
            foreach ($categories as $cat) :

                // Get post count
                $count = $cat->count;

                // Category link
                $link = get_term_link($cat);
                ?>
                
                <li>
                    <a href="<?php echo esc_url($link); ?>" class="cat">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                    <span>(<?php echo intval($count); ?>)</span>
                </li>

            <?php
            endforeach;
        else :
            ?>
            <li>No categories found</li>
        <?php endif; ?>
    </ul>

</div>
              <!-- Tags Block -->
              <div class="tags_block bg_box" data-aos="fade-up" data-aos-duration="1500">

    <h6>Tags</h6>

    <ul>
        <?php
        $tags = get_terms(array(
            'taxonomy'   => 'post_tag',
            'hide_empty' => true, // only tags used in posts
        ));

        if (!empty($tags) && !is_wp_error($tags)) :
            foreach ($tags as $tag) :

                $link = get_term_link($tag);
                ?>

                <li>
                    <a href="<?php echo esc_url($link); ?>">
                        <?php echo esc_html($tag->name); ?>
                    </a>
                </li>

            <?php
            endforeach;
        else :
            ?>
            <li>No tags found</li>
        <?php endif; ?>
    </ul>

</div>
            </div>
          </div>
        </div>

        <!-- Pagination Block Start -->
        <div class="pagination_block" data-aos="fade-up" data-aos-duration="1500">
          <div class="row">
            <div class="col-lg-8">
              <ul>
                <li><a href="#" class="prev"><i class="fa-light fa-arrow-left"></i></a></li>
                <li><a href="#" class="active">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#" class="next"><i class="fa-light fa-arrow-right"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Pagination Block End -->
      </div>
    </section>
    <!-- Main Blog List Section End-->

    <?php get_footer(); ?>