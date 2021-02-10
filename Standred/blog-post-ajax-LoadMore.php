<?php 
/*
Template Name: Load more Post
*/
get_header(); ?>

<div class="entry-content">
    <?php
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => '2',
        'paged' => 1,
    );
    $blog_posts = new WP_Query( $args );
    ?>
 
    <?php if ( $blog_posts->have_posts() ) : ?>
        <div class="blog-posts">
            <?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
                <h2><?php the_title(); ?></h2>
                <?php the_excerpt(); ?>
            <?php endwhile; ?>
        </div>
       <button class="loadmore">Load More...</button>
    <?php endif; ?>
</div>

<?php

/*-----------------------------------------------------------------------------------
 * Load admin ajax localize scripts functions.php
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'blog_scripts' );
function blog_scripts() {
    // Register the script
    wp_register_script( 'custom-script', get_template_directory_uri(). '/assets/js/custom.js', array('jquery'), false, true );
    // Localize the script with new data
    $script_data_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'load_more_posts' ),
    );
    wp_localize_script( 'custom-script', 'blog', $script_data_array );
    // Enqueued script with localized data.
    wp_enqueue_script( 'custom-script' );
}

/*Ajax Callback Action*/
add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');

function load_posts_by_ajax_callback() {
    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => '2',
        'paged' => $paged,
    );
    $blog_posts = new WP_Query( $args ); ?>
    <?php if ( $blog_posts->have_posts() ) : ?>
        <?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
        <h2><?php the_title(); ?></h2>
            <?php the_excerpt(); ?>   
        <?php endwhile; ?>
        <?php
    endif;
    wp_die();
}

/*-----------------------------------------------------------------------------------
 * Load javascript custom.js
 ================================

var page = 2;
jQuery(function($) {
    $('body').on('click', '.loadmore', function() {
        var data = {
            'action': 'load_posts_by_ajax',
            'page': page,
            'security': blog.security
        };
 
        $.post(blog.ajaxurl, data, function(response) {
            if($.trim(response) != '') {
                $('.blog-posts').append(response);
                page++;
            } else {
                $('.loadmore').hide();
            }
        });
    });
});

/*-----------------------------------------------------------------------------------*/


