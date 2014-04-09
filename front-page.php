<?php
/*
Template Name: Home - Student Focused
*/
?>
<?php get_header(); 
    $theme_option = flagship_sub_get_global_options();
    
    if ( false === ( $slider_query = get_transient( 'slider_query' ) ) ) {
		$slider_query = new WP_Query(array(
			'post_type' => 'slider',
			'posts_per_page' => '1'));
		set_transient( 'slider_query', $slider_query, 2592000 );
	} 	

		if ( false === ( $latest_profile_query = get_transient( 'latest_profile_query' ) ) ) {
		// It wasn't there, so regenerate the data and save the transient
		$latest_profile_query = new WP_Query(array(
			'post_type' => 'profile',
			'posts_per_page' => 1)); 
			set_transient( 'latest_profile_query', $latest_profile_query, 2592000 );
        } 
		$news_query_cond = $theme_option['flagship_sub_news_query_cond'];
			if ( false === ( $news_query = get_transient( 'news_mainpage_query' ) ) ) {
				if ($news_query_cond === 1) {
					$news_query = new WP_Query(array(
						'post_type' => 'post',
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'slug',
								'terms' => array( 'books' ),
								'operator' => 'NOT IN'
							)
						),
						'posts_per_page' => 3)); 
				} else {
					$news_query = new WP_Query(array(
						'post_type' => 'post',
						'posts_per_page' => 3)); 
				}
			set_transient( 'news_mainpage_query', $news_query, 2592000 );
			} 	

?>
<!-- Set video background -->
<?php if ( $slider_query->have_posts() ) : while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
	<div class="row">
		<div class="six columns">
			<h2 class="white text-shadow"><strong><?php the_title(); ?></strong></h2>
		</div>
	</div>
	<?php the_content(); ?>
<?php endwhile; endif; ?>
<!-- Begin main content area -->
<div class="row wrapper radius10" id="page" role="main">
	<div class="twelve columns">
	    <div class="row">
	        <?php if ( $latest_profile_query->have_posts() ) : ?>
	            <div class="six columns">
                    <h4>Student Profiles</h4>
            <?php while ($latest_profile_query->have_posts()) : $latest_profile_query->the_post(); ?>
                    <div class="row post-container">
                        <div class="eleven columns centered post">
                    <a href="<?php the_permalink(); ?>">
                        <div class="row featured">
                                <?php if ( has_post_thumbnail()) { the_post_thumbnail('rectangle', array('align'=>'center')); }?>
                        </div>
                        <h5><?php the_title(); ?></h5>
                        <?php the_excerpt(); ?>
                    </a>
                        </div>
                    </div>
            <?php endwhile; ?>
	            </div>
            <?php endif; ?>
	        <div class="panel callout radius10 five columns last">
	            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                <h4><?php the_title(); ?></h4>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
	        </div>
	    </div>
	    <?php if ( $news_query->have_posts() ) : ?>
	    	<div class="row">
	    		<div class="twelve columns">
	    			<h4><?php echo $theme_option['flagship_sub_feed_name']; ?></h4>
	    		</div>
	    	</div>
	        <div class="row">
	           <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
	                <div class="four columns post-container">
	                    <div class="row">
	                        <div class="eleven columns centered post">
        	                    <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
            	                    <?php if(has_post_thumbnail()) { ?>
            	                        <div class="row">
            	                            <div class="twelve columns">
            	                                <?php the_post_thumbnail('rss', array('align'=>'center')); ?>
            	                            </div>
            	                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="twelve columns">
                                            <h5><?php the_title(); ?></h5>
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
        	                    </a>
	                        </div>
	                    </div>
	                </div>
	           <?php endwhile; ?>
	        </div>
        <div class="row">
		    <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><h5 class="black">View All <?php echo $theme_option['flagship_sub_feed_name']; ?></h5></a>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>
