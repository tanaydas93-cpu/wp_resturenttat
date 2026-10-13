<?php
add_theme_support('post-thumbnails');
// Enqueue script & localize AJAX URL
function restaurant_booking_scripts() {
    wp_enqueue_script(
        'booking-ajax',
        get_template_directory_uri() . '/assets/js/booking.js',
        array('jquery'),
        null,
        true
    );
    wp_localize_script('booking-ajax', 'booking_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('booking_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'restaurant_booking_scripts');


// AJAX Handler (logged in + guests)
add_action('wp_ajax_submit_booking',        'handle_restaurant_booking');
add_action('wp_ajax_nopriv_submit_booking', 'handle_restaurant_booking');

function handle_restaurant_booking() {

    // Verify nonce
    if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'booking_nonce') ) {
        wp_send_json_error(array('message' => 'Security check failed.'));
    }

    global $wpdb;
    $table = $wpdb->prefix . 'restaurant_bookings';

    $name    = sanitize_text_field($_POST['name']);
    $phone   = sanitize_text_field($_POST['phone']);
    $persons = sanitize_text_field($_POST['persons']);
    $date    = sanitize_text_field($_POST['date']);
    $time    = sanitize_text_field($_POST['time']);
    $message = sanitize_textarea_field($_POST['message']);

    // Validate required fields
    if ( empty($name) || empty($phone) || empty($date) ) {
        wp_send_json_error(array('message' => 'Please fill all required fields.'));
    }

    $inserted = $wpdb->insert($table, array(
        'name'    => $name,
        'phone'   => $phone,
        'persons' => $persons,
        'date'    => $date,
        'time'    => $time,
        'message' => $message,
    ));

    if ( $inserted ) {
        wp_send_json_success(array('message' => 'Table booked successfully!'));
    } else {
        wp_send_json_error(array('message' => 'Booking failed. Please try again.'));
    }
}

add_action( 'wp_enqueue_scripts', 'ns_enqueue_scripts' );

function ns_enqueue_scripts() {

    wp_enqueue_script(
        'newsletter-subscribe-js',
         get_template_directory_uri() . '/assets/js/newsletter.js',
        [ 'jquery' ],
        '1.0.0',
        true
    );

    // Pass AJAX URL + nonce to JS
    wp_localize_script(
        'newsletter-subscribe-js',
        'ns_ajax_obj',
        [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'ns_subscribe_action' ),
        ]
    );
}
add_action( 'wp_ajax_ns_subscribe', 'ns_subscribe_handler' );
add_action( 'wp_ajax_nopriv_ns_subscribe', 'ns_subscribe_handler' );


function ns_insert_subscriber( $email ) {
    global $wpdb;

    // Check if email already exists
    $exists = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}newsletter_subscribers WHERE email = %s",
            $email
        )
    );

    if ( $exists ) {
        return 'exists';
    }

    $result = $wpdb->insert(
        "{$wpdb->prefix}newsletter_subscribers",
        [
            'email'      => $email,
            'status'     => 1,
            'created_at' => current_time( 'mysql' ),
        ],
        [ '%s', '%d', '%s' ]
    );

    return $result ? 'success' : 'error';
}
function ns_subscribe_handler() {

    // Verify nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'ns_subscribe_action' ) ) {
        wp_send_json_error( [ 'message' => 'Security check failed. Please refresh and try again.' ] );
    }

    // Validate email
    $email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
    }

    // Insert into DB
    $result = ns_insert_subscriber( $email );

    if ( $result === 'success' ) {
        wp_send_json_success( [ 'message' => 'Thank you for subscribing!' ] );

    } elseif ( $result === 'exists' ) {
        wp_send_json_error( [ 'message' => 'This email is already subscribed.' ] );

    } else {
        wp_send_json_error( [ 'message' => 'Something went wrong. Please try again.' ] );
    }
}




// Register Gallery Custom Post Type
function register_gallery_cpt() {
    $args = array(
        'label'         => 'Gallery',
        'labels'        => array(
            'name'          => 'Gallery',
            'singular_name' => 'Gallery Item',
            'add_new_item'  => 'Add New Gallery Image',
            'edit_item'     => 'Edit Gallery Image',
        ),
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-format-gallery',
        'supports'      => array( 'title', 'thumbnail' ), // Featured image = small image
        'has_archive'   => false,
        'rewrite'       => array( 'slug' => 'gallery' ),
    );
    register_post_type( 'gallery_item', $args );
}
add_action( 'init', 'register_gallery_cpt' );


// Add Meta Box for the Big (Lightbox) Image
function gallery_meta_box() {
    add_meta_box(
        'gallery_big_image',
        'Lightbox / Full Size Image',
        'gallery_big_image_callback',
        'gallery_item',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'gallery_meta_box' );

function gallery_big_image_callback( $post ) {
    wp_nonce_field( 'gallery_big_image_nonce', 'gallery_nonce' );
    $big_image_id = get_post_meta( $post->ID, '_gallery_big_image_id', true );
    $big_image_url = $big_image_id ? wp_get_attachment_url( $big_image_id ) : '';
    ?>
    <p>
        <strong>Upload the full-size image shown in the lightbox popup.</strong><br>
        <small>The thumbnail (slider image) is set via the Featured Image box.</small>
    </p>
    <div>
        <input type="hidden" name="gallery_big_image_id" id="gallery_big_image_id" value="<?php echo esc_attr( $big_image_id ); ?>">

        <?php if ( $big_image_url ) : ?>
            <img id="gallery_big_image_preview" src="<?php echo esc_url( $big_image_url ); ?>" style="max-width:300px; display:block; margin-bottom:10px;">
        <?php else : ?>
            <img id="gallery_big_image_preview" src="" style="max-width:300px; display:none; margin-bottom:10px;">
        <?php endif; ?>

        <button type="button" class="button" id="gallery_upload_btn">Select / Upload Big Image</button>
        <button type="button" class="button" id="gallery_remove_btn" style="<?php echo $big_image_url ? '' : 'display:none;'; ?>">Remove</button>
    </div>

    <script>
        jQuery(document).ready(function($) {
            var frame;
            $('#gallery_upload_btn').on('click', function(e) {
                e.preventDefault();
                if (frame) { frame.open(); return; }
                frame = wp.media({ title: 'Select Big Image', button: { text: 'Use this image' }, multiple: false });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#gallery_big_image_id').val(attachment.id);
                    $('#gallery_big_image_preview').attr('src', attachment.url).show();
                    $('#gallery_remove_btn').show();
                });
                frame.open();
            });
            $('#gallery_remove_btn').on('click', function() {
                $('#gallery_big_image_id').val('');
                $('#gallery_big_image_preview').attr('src', '').hide();
                $(this).hide();
            });
        });
    </script>
    <?php
}

// Save the Big Image Meta
function save_gallery_meta( $post_id ) {
    if ( ! isset( $_POST['gallery_nonce'] ) || ! wp_verify_nonce( $_POST['gallery_nonce'], 'gallery_big_image_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['gallery_big_image_id'] ) ) {
        update_post_meta( $post_id, '_gallery_big_image_id', sanitize_text_field( $_POST['gallery_big_image_id'] ) );
    }
}
add_action( 'save_post_gallery_item', 'save_gallery_meta' );

// slider

// Register Slider Custom Post Type
function register_slider_cpt() {
    $args = array(
        'label'         => 'Slider',
        'labels'        => array(
            'name'               => 'Sliders',
            'singular_name'      => 'Slider',
            'add_new_item'       => 'Add New Slide',
            'edit_item'          => 'Edit Slide',
            'new_item'           => 'New Slide',
            'view_item'          => 'View Slide',
            'not_found'          => 'No slides found',
            'not_found_in_trash' => 'No slides found in Trash',
        ),
        'public'        => false,           // Not publicly accessible via URL
        'show_ui'       => true,            // Show in admin
        'show_in_menu'  => true,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-images-alt2',
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ), // page-attributes = Order field
        'has_archive'   => false,
        'rewrite'       => false,
    );
    register_post_type( 'slider', $args );
}
add_action( 'init', 'register_slider_cpt' );


// dynamic on evrey page reload

// Register "Why Choose Us" Custom Post Type
function register_why_choose_cpt() {
    $args = array(
        'label'        => 'Why Choose Us',
        'labels'       => array(
            'name'               => 'Why Choose Us',
            'singular_name'      => 'Why Item',
            'add_new_item'       => 'Add New Why Item',
            'edit_item'          => 'Edit Why Item',
            'not_found'          => 'No items found',
            'not_found_in_trash' => 'No items found in Trash',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-star-filled',
        'supports'     => array( 'title', 'thumbnail' ), // title = label, thumbnail = image
        'has_archive'  => false,
        'rewrite'      => false,
    );
    register_post_type( 'why_choose', $args );
}
add_action( 'init', 'register_why_choose_cpt' );


function register_blog_cpt() {

    register_post_type('restaurant_blog', array(
        'labels' => array(
            'name' => 'Blogs',
            'singular_name' => 'Blog'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'blog'
        ),
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt'
        ),
        'taxonomies' => array('post_tag'),
        'menu_icon' => 'dashicons-edit'
    ));
    register_taxonomy(
    'blog_category',
    'restaurant_blog',
    array(
        'label' => 'Blog Categories',
        'hierarchical' => true,
        'public' => true
    )
);

}
add_action('init', 'register_blog_cpt');


function seed_dummy_blogs() {

    $blogs = [
        [
            'title' => 'An Elegant Journey of Crafted Cuisine',
            'content' => 'Discover the artistry behind fine dining and handcrafted dishes that tell a story on every plate.',
            'category' => 'Food Story'
        ],
        [
            'title' => 'Experience Gourmet Art and Ambience',
            'content' => 'A deep dive into luxury dining experiences where taste meets visual excellence.',
            'category' => 'Recipes'
        ],
        [
            'title' => 'Secrets of Traditional Indian Spices',
            'content' => 'Explore the rich history and health benefits of Indian spices used in everyday cooking.',
            'category' => 'Spices'
        ],
        [
            'title' => 'Modern Fusion Food Trends in 2025',
            'content' => 'Fusion cuisine is evolving with bold combinations of global flavors and techniques.',
            'category' => 'Trends'
        ],
        [
            'title' => 'Healthy Eating Without Compromise',
            'content' => 'Learn how to maintain a balanced diet while still enjoying delicious meals.',
            'category' => 'Health'
        ],
        [
            'title' => 'Street Food Culture Around the World',
            'content' => 'A journey through global street food traditions and flavors.',
            'category' => 'Travel Food'
        ],
        [
            'title' => 'The Art of Perfect Plating',
            'content' => 'Presentation plays a key role in gourmet dining and culinary excellence.',
            'category' => 'Food Story'
        ],
        [
            'title' => 'Best Breakfast Recipes to Start Your Day',
            'content' => 'Quick and healthy breakfast ideas to boost your morning energy.',
            'category' => 'Recipes'
        ],
        [
            'title' => 'Farm to Table Movement Explained',
            'content' => 'Understanding how fresh ingredients impact sustainability and taste.',
            'category' => 'Lifestyle'
        ],
        [
            'title' => 'Top 10 Desserts You Must Try',
            'content' => 'Indulge in the sweetest desserts from around the world.',
            'category' => 'Desserts'
        ],
        [
            'title' => 'Why Organic Food Matters Today',
            'content' => 'Organic food is a healthy lifestyle choice for modern living.',
            'category' => 'Health'
        ],
        [
            'title' => 'Exploring Italian Culinary Heritage',
            'content' => 'From pasta to pizza, explore Italy’s rich culinary traditions.',
            'category' => 'Travel Food'
        ],
        [
            'title' => 'Street Food Hygiene Tips You Should Know',
            'content' => 'Stay safe while enjoying your favorite street food.',
            'category' => 'Health'
        ],
        [
            'title' => 'The Rise of Vegan Cuisine',
            'content' => 'Plant-based diets are becoming more popular worldwide.',
            'category' => 'Lifestyle'
        ],
        [
            'title' => 'Mastering Homemade Pizza Recipes',
            'content' => 'Learn how to make restaurant-style pizza at home.',
            'category' => 'Recipes'
        ],
        [
            'title' => 'Coffee Culture and Its Global Impact',
            'content' => 'Coffee is more than a drink — it’s a global culture.',
            'category' => 'Lifestyle'
        ],
        [
            'title' => 'The Science Behind Cooking Techniques',
            'content' => 'Understanding heat, chemistry, and texture in cooking.',
            'category' => 'Food Science'
        ],
        [
            'title' => 'Top Culinary Destinations in the World',
            'content' => 'Explore cities known for their outstanding food culture.',
            'category' => 'Travel Food'
        ],
        [
            'title' => 'Easy One-Pot Meal Recipes',
            'content' => 'Quick meals that require minimal effort and maximum taste.',
            'category' => 'Recipes'
        ],
        [
            'title' => 'How Food Influences Mood and Health',
            'content' => 'Discover the connection between food and emotions.',
            'category' => 'Health'
        ]
    ];

    foreach ($blogs as $blog) {

        wp_insert_post([
            'post_title'   => $blog['title'],
            'post_content' => $blog['content'],
            'post_status'  => 'publish',
            'post_type'    => 'restaurant_blog',
            'post_excerpt' => wp_trim_words($blog['content'], 20)
        ]);

    }
}
// add_action('init', 'seed_dummy_blogs');

// add_action('init', 'create_demo_restaurant_products');

function create_demo_restaurant_products() {


// Prevent duplicate creation
if (get_option('restaurant_demo_created')) {
    return;
}

if (!class_exists('WooCommerce')) {
    return;
}

$categories = [
    'Appetizers',
    'Main Dishes',
    'Desserts'
];

foreach ($categories as $cat_name) {

    if (!term_exists($cat_name, 'product_cat')) {

        wp_insert_term(
            $cat_name,
            'product_cat',
            [
                'slug' => sanitize_title($cat_name)
            ]
        );
    }
}

$products = [

    // Appetizers
    [
        'name' => 'Stuffed Mushrooms',
        'price' => '25',
        'category' => 'appetizers',
        'description' => 'Flavorful mushrooms filled with breadcrumbs, herbs and cheese.'
    ],

    [
        'name' => 'Jalapeno Poppers',
        'price' => '29',
        'category' => 'appetizers',
        'description' => 'Crispy jalapenos stuffed with creamy cheese filling.'
    ],

    [
        'name' => 'Caprese Skewers',
        'price' => '45',
        'category' => 'appetizers',
        'description' => 'Fresh mozzarella, tomatoes and basil with balsamic glaze.'
    ],

    [
        'name' => 'Greek Salad',
        'price' => '50',
        'category' => 'appetizers',
        'description' => 'Tomatoes, cucumber, olives and feta cheese.'
    ],

    // Main Dishes
    [
        'name' => 'Roasted Salmon',
        'price' => '25.50',
        'category' => 'main-dishes',
        'description' => 'Perfectly roasted salmon served with seasonal vegetables.'
    ],

    [
        'name' => 'Baked Eggplant',
        'price' => '40',
        'category' => 'main-dishes',
        'description' => 'Layered eggplant baked with cheese and tomato sauce.'
    ],

    [
        'name' => 'Steamed Crab Legs',
        'price' => '10',
        'category' => 'main-dishes',
        'description' => 'Fresh crab legs steamed and served with butter.'
    ],

    [
        'name' => 'Skirt Steak',
        'price' => '39',
        'category' => 'main-dishes',
        'description' => 'Tender grilled steak with chef special seasoning.'
    ],

    // Desserts
    [
        'name' => 'Chocolate Mousse',
        'price' => '25',
        'category' => 'desserts',
        'description' => 'Rich and creamy chocolate mousse.'
    ],

    [
        'name' => 'Pavlova',
        'price' => '29',
        'category' => 'desserts',
        'description' => 'Light meringue dessert topped with fruit.'
    ],

    [
        'name' => 'Apple Crumble',
        'price' => '45',
        'category' => 'desserts',
        'description' => 'Warm baked apples with crunchy topping.'
    ],

    [
        'name' => 'Creme Brulee',
        'price' => '50',
        'category' => 'desserts',
        'description' => 'Classic vanilla custard with caramelized sugar.'
    ]
];

foreach ($products as $item) {

    $product = new WC_Product_Simple();

    $product->set_name($item['name']);
    $product->set_regular_price($item['price']);
    $product->set_description($item['description']);
    $product->set_short_description($item['description']);
    $product->set_status('publish');

    $product_id = $product->save();

    wp_set_object_terms(
        $product_id,
        $item['category'],
        'product_cat'
    );
}

update_option('restaurant_demo_created', true);

}


function custom_blog_comment_submit() {

    if (isset($_POST['submit_comment'])) {

        $commentdata = array(
            'comment_post_ID' => intval($_POST['post_id']),
            'comment_author'  => sanitize_text_field($_POST['author']),
            'comment_author_email' => sanitize_email($_POST['email']),
            'comment_author_url'   => esc_url($_POST['website']),
            'comment_content'      => sanitize_textarea_field($_POST['comment']),
            'comment_approved'     => 0 // Pending Approval
        );

        wp_insert_comment($commentdata);

        wp_redirect(get_permalink($_POST['post_id']) . '?comment=success');
        exit;
    }
}

function custom_comment_scripts() {

    wp_enqueue_script(
        'comment-ajax',
        get_template_directory_uri() . '/assets/js/comment-ajax.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script('comment-ajax', 'comment_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'custom_comment_scripts');

add_action('wp_ajax_submit_blog_comment', 'submit_blog_comment');
add_action('wp_ajax_nopriv_submit_blog_comment', 'submit_blog_comment');

function submit_blog_comment() {

    $commentdata = array(
        'comment_post_ID'      => intval($_POST['post_id']),
        'comment_author'       => sanitize_text_field($_POST['author']),
        'comment_author_email' => sanitize_email($_POST['email']),
        'comment_author_url'   => esc_url($_POST['website']),
        'comment_content'      => sanitize_textarea_field($_POST['comment']),
        'comment_approved'     => 0
    );

    $comment_id = wp_insert_comment($commentdata);

    if ($comment_id) {
        wp_send_json_success(array(
            'message' => 'Thank you! Your comment has been submitted and is awaiting approval.'
        ));
    }

    wp_send_json_error(array(
        'message' => 'Something went wrong. Please try again.'
    ));
}