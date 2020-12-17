<?php
/*
#1.Basic:  WP_Query displaying ALL POSTS

*/

$condition = array(
			"post-type"=>"post",
			"post_status"=>"publish",
			// Conditional Statements
);

$the_query = new WP_Query($condition);  //createing wp_query instance

if ($the_query->have_posts()) {    // checking we have post or not provided condition
	while($the_query->have_posts()){  // loop through on all posts
				$the_query->the_post();			// incrementing the loop
				the_title();
				the_content();
	}
	wp_reset_postdata(); // restore our orignal post data
}else{
	// no posts
}

?>



<?php
/*
#2.Basic:  WP_Query displaying
          ==>Multiple post type array("post","page","books","movies")
          ==>Posts for (p , name)
          ==>Page for(page_id, pagename)

*/

$condition = array(
			"post-type" =>array("post","movies","books","page"),
			"post_status" => "publish",
			"p"	=> 12   //for the post id
			"name"=>"welcome", //post slug name.
			"page_id"=>32 // for the displaying page id 32
			"pagename"=>"about_us" // for the displying page slug name

			// Conditional Statements
);

$the_query = new WP_Query($condition);

if ($the_query->have_posts()) {
	while($the_query->have_posts()){
				$the_query->the_post();
				the_title();
				the_content();
	}
	wp_reset_postdata(); // restore our orignal post data
}else{
	// no posts
}

?>




<?php

/*
#3. Basic:  WP_Query displaying to AUTHOR PERAMETER

*/

$condition = array(
			"post_type" => "post",
			"post_status"=>"publish",
			"author" => 2
			"author" => "2,3",    //displaying multipla author post
			"author" => -1,   //    if we don't want to display specific author post
			"author__not_in" => array(2,3), //if we don't want to display specific author post
			"author__in" => array(2,3) , //if we want to display authors post .
);

$the_query = new WP_Query($condition);
if ($the_query->have_posts()) {
	while($the_query->have_posts()){
				$the_query->the_post();		
				the_title();
				the_content();
	}
	wp_reset_postdata(); // restore our orignal post data
}else{
	// no posts
}

?>



<?php

/*
#4. Basic:  WP_Query displaying CATEGORIY PERAMITER

*/

$condition = array(
			"post-type"=>"post",
			"post_status"=>"publish",
			"cat" => 1 ,                			 // display single coategory )
			"cat" => "4,5",										// Displaying ,multipal category
			"category__in" => array(2,3),			// Displaying ,multipal category
			"cat" => -6 , 										// if dont want to display category 2 all posts
			"category__not_in" => array(7,8),  // if we dont want to display multipla categorys
			"category_name"=> "wordpress"     //with the help of cat_slug name we display catgory
			// Conditional Statements
);

$the_query = new WP_Query($condition);  //createing wp_query instance

if ($the_query->have_posts()) {    // checking we have post or not provided condition
	while($the_query->have_posts()){  // loop through on all posts
				$the_query->the_post();			// incrementing the loop
				the_title();
				the_content();
	}
	wp_reset_postdata(); // restore our orignal post data
}else{
	// no posts
}

?>




<?php
/*
#5.  WP_Query displaying Tag Parameter

*/

$condition = array(
			"post-type"=>"post",
			"post_status"=>"publish",
			"tag" => "old,new", // tag name
			"tag_id"=> 6				// In database table term_id displya tag_id
			"tag__in" => array(7,8,19)
			"tag__not_in" => array(2,5,3)
			// Conditional Statements
);

$the_query = new WP_Query($condition);  //createing wp_query instance

if ($the_query->have_posts()) {    // checking we have post or not provided condition
	while($the_query->have_posts()){  // loop through on all posts
				$the_query->the_post();			// incrementing the loop
				the_title();
				the_content();
	}
	wp_reset_postdata(); // restore our orignal post data
}else{
	// no posts
}

?>



<?php
/*
#6:  WP_Query displaying Search Peramiter

*/

$condition = array(
			'post_type' => array('page','post'),
			'posts_per_page' => 10,
			"post_status"=>"publish",
			"s"	=> "php"  // displaying php keyword in whole posts

			// Conditional Statements
);

$the_query = new WP_Query($condition);  //createing wp_query instance

if ($the_query->have_posts()) {    // checking we have post or not provided condition
	while($the_query->have_posts()){  // loop through on all posts
				$the_query->the_post();			// incrementing the loop
				the_title();
				the_content();
	}
	wp_reset_postdata(); // restore our orignal post data
}else{
	// no posts
}
?>





<!--Stories Blog Categories -->
<div class="col-xs-12 col-sm-12 col-md-12">             	
<!-- Wp_query arg -->
<?php
$args = array(
    'post_type'    =>  'stories', // post type cpt name
    'post_status'  =>  'publish',
    'orderby'      =>  'date', 
    'order'        =>  'DSC',
    'posts_per_page'    => -1,
    'paged'             => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'story_type', // taxonomy name 
            'field'    => 'slug',
            'terms'    => 'blog',      // taxonomy-term name    
        ),
    ),
);
$query = new WP_Query( $args ); ?>

<!-- if condition  -->
<?php if ( $query->have_posts()) : ?>
<h3>Custom post type and custom texnomy term displaying</h3>

<div class="__team_content row" id="__team_isotop">
<!-- while condition  -->
<?php while ( $query->have_posts() ) : $query->the_post(); 
$publish_date = get_the_date( ' M j, Y' ); ?>
	<div class="col-xs-12 col-sm-6 col-md-4 grid staff">
		<div class="__team_bg">
			<div class="team_desc">
				<h4 style="height: 100px;">
					<small>Punlished on : <?php echo $publish_date; ?></small>
					<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
				</h4>
				<div class="__location">&nbsp;</div>
			</div>
		</div>
	</div>
	<!-- while End condition  -->
	 <?php endwhile; ?>	
	</div>
	<!-- loop if end -->
	<?php endif; ?>	
</div>         
</div>  <!-- End Stories Blog Categories  -->
       

