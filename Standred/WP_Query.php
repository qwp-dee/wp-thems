<div class="container">

	<div class="row">
		<h1><?php _e( 'Latest News', 'wp' ); ?></h1>
			<?php 
		    // First Loop
			$featured = new WP_Query( 'post_type=post' );
                 	if( $featured->have_posts() ):
						while( $featured->have_posts() ): $featured->the_post(); ?>
			<div class="col-12">	
			<article <?php post_class( array( 'class' => 'featured' ) ); ?>>
					<div class="thumbnail">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?></a>
					</div>
					<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		
					<div class="meta-info">
					<p>
					by <span><?php the_author_posts_link(); ?></span> 
					Categories: <span><?php the_category( ' ' ); ?></span>
					<?php the_tags( ' Tags: <span>', ', ', '</span>' ); ?>
					</p>
					<p><span><?php echo get_the_date(); ?></p>		
				</div>
				<p><?php the_excerpt(); ?></p>
			</article>
			</div>
				<?php
					endwhile;
				wp_reset_postdata();
			endif;
			?>

	</div>




	<div class="row">
		<?php
		// Second Loop
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 2,
				'category__not_in' => array( 3 ),
			    'category__in' => array( 7, 11 ),
				'offset' => 1
				);
		    $secondary = new WP_Query( $args );
               if( $secondary->have_posts() ):
					while( $secondary->have_posts() ): $secondary->the_post(); ?>
                
<div class="col-sm-6">
	<article <?php post_class( array( 'class' => 'secondary' ) ); ?>>

	<div class="thumbnail">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?></a>
	</div>

	<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
	
	<div class="meta-info">
		<p>
			by <span><?php the_author_posts_link(); ?></span> 
			Categories: <span><?php the_category( ' ' ); ?></span>
			<?php the_tags( ' Tags: <span>', ', ', '</span>' ); ?>
		</p>		
	</div>
	<p><?php the_excerpt(); ?></p>
	
</article>
</div>
  <?php
	endwhile;
		wp_reset_postdata();
  endif; ?>								
 </div>
	</div>

</div>




<div class="row">
	
<?php // opinion posts loop begins here displaying categorys 
		$ourPosts = new WP_Query('cat=6&posts_per_page=2');
			if ($ourPosts->have_posts()) :
				while ($ourPosts->have_posts()) : $ourPosts->the_post(); ?>
					<!-- post-item -->
						<div class="post-item clearfix">
							<!-- post-thumbnail -->
							<div class="square-thumbnail">
								<a href="<?php the_permalink(); ?>"><?php
									if (has_post_thumbnail()) {
										the_post_thumbnail();
										} ?>			
								</a>
							</div><!-- /post-thumbnail -->

						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span class="subtle-date"><?php the_time('n/j/Y'); ?></span></h4>
							<?php the_excerpt(); 

							wp_trim_words( get_the_content(), 20 ) ?>
						</div><!-- /post-item -->
						<?php endwhile;
							else :
								// fallback no content message here
						endif;
						wp_reset_postdata(); ?>
						
					<span class="horiz-center"><a href="<?php echo get_category_link(6); ?>" class="btn-a">View all Posts</a></span>
						
		</div><!-- /post-item -->
</div>







<div class="row">
	<?php 
	// loop for displaying custom post type name movies and category in 4-8
      	$args = array(
            'post_type' => 'movies',
      		'posts_per_page' => 2,
      	    'category__not_in' => array( 2 ),
      		'category__in' => array( 4, 11 )
      	     );

      		$cpt_movie = new WP_Query( $args );

      			if( $cpt_movie->have_posts() ):
      				while( $cpt_movie->have_posts() ): $cpt_movie->the_post(); ?>

      				    <div class="col-sm-6">
      						<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>"><?php
										if (has_post_thumbnail()) {
											the_post_thumbnail();
										} ?></a>
							</div><!-- /post-thumbnail -->
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span class="subtle-date"><?php the_time('n/j/Y'); ?></span></h4>
									<?php the_excerpt();
									wp_trim_words( get_the_content(), 20 ) ?>
      					</div>

      					<?php
      				endwhile;
      					wp_reset_postdata();
      			endif; ?>





<div class="row">
	<!-- display custom post type and post both categorys  -->

<?php 						
    $args = array(
      		'post_type' => array('movies','post'),
      		'posts_per_page' => 10,
      		'category' => array(5, 9 ) );
			// First Loop
	$loop = new WP_Query( $args );
	// 'category&tag_ID=array(7,8)&post_type=movies&posts_per_page=2'
		if( $loop->have_posts() ):
				while( $loop->have_posts() ): $loop->the_post(); ?>

				<div class="col-12">
					<?php get_template_part( 'template-parts/content', 'loop' ); 
					wp_trim_words( get_the_content(), 20 )
					?>
				</div>
		<?php
			endwhile;
			wp_reset_postdata();
		endif; ?>
</div>

</div>



</div>





<!-- Paggination  -->

<div class="row">
	<div class="pages col-6 text-left"><?php next_post_link( '&laquo; %link' ); ?></div>
	<div class="pages col-6 text-right"><?php previous_post_link( '%link &raquo;' );  ?></div>
</div>