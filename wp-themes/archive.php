<?php

get_header(); ?>

<div class="page-banner">

  <!-- Here we can add custom header image via inner folders  -->
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <!-- Category title  -->
    <h1 class="page-banner__title"><?php the_archive_title(); ?></h1>
    <div class="page-banner__intro">
      <!-- Category descriptions -->
      <p><?php the_archive_description(); ?></p>
    </div>
  </div>  
</div>

<div class="container container--narrow page-section">
  <!-- start wordpress loops  -->
<?php
  while(have_posts()) {
    the_post(); ?>
    <div class="post-item">
      <!-- posts title -->
      <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

      <!-- post-thumbnail -->
      <div class="fetured-image">
          <a href="<?php the_permalink(); ?>"><?php
            if (has_post_thumbnail()) {
                the_post_thumbnail( array( 500, 500 ));
                  } ?></a>
      </div><!--End post-thumbnail -->

      <!-- Authors and category detils -->
      <div class="metabox">
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
      </div>
      <!-- content summery -->
      <div class="generic-content">
        <?php the_excerpt(); ?>
        <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
      </div>

    </div>
  <?php }
  echo paginate_links();
?>
</div>

<?php get_footer();

?>