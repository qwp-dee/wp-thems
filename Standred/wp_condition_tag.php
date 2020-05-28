<div class="content">

 
<!-- Static home page -->
<?php if ( is_front_page() && ! is_home() ): ?>
  <h1>Static Front Page </h1>
<?php  endif; ?>

  
  
<!-- Blog page -->
<?php if (is_home()) : ?>
  <h1>Blog Page </h1>
<?php  endif; ?>

  
  
<!--Page ( Not Front Page )  -->
<?php if ( is_page() && !is_front_page() ) : ?>
<h1>Page</h1>
<?php endif; ?>

  
  
<!-- single post -->
<?php  if (is_single( ) && !is_attachment() ): ?>
<h1>Post</h1>
<?php endif; ?>


<!-- single attachment -->
<?php  if (is_attachment() ): ?>
<h1>Attachement</h1>
<?php endif; ?>

  
<!-- Category Archive -->
<?php if (is_category() ): ?>
<h1><?php single_cat_title(); ?> </h1>
<?php endif;?>


<!-- Tag Archive -->
<?php if (is_tag() ): ?>
<h1><?php single_tag_title(); ?> </h1>
<?php endif;?>

<!-- Author Archive -->
<?php if (is_author() ): ?>
<h1><?php the_archive_title(); ?> </h1>
<?php endif;?>

  
<!-- Date Archive -->
<?php if (is_date() ): ?>
<h1><?php the_archive_title(); ?> </h1>
<?php endif;?>

  
<!-- 404 Page -->
<?php if (is_404() ): ?>
<h1>404 </h1>
<?php endif;?>



</div>
