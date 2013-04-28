<?php
/*
Template Name: Gallery
*/
?>

<?php get_header(); ?>

<div id="container">

	<div id="content" class="wide">
    
        <div class="postarea">
        
        	<div class="posttitle">
            	<h2><?php the_title(); ?></h2>
            </div>
            
            <?php $wp_query = new WP_Query(array('category_name'=>'gallery','showposts'=>15,'paged'=>$paged)); ?>
            <?php $first_or_second = 'first'; ?>
			<?php if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <?php global $more; $more = 0; ?>
            
            <div class="portfolio <?php echo $first_or_second; ?>">
            <?php $first_or_second = ('first'==$first_or_second) ? 'second' : 'first'; ?>

                <div class="portfolioimg">
                    <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'gallery-img' ); ?></a>
                </div>
                
                <div class="portfoliotitle">              
                    <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                    <?php the_excerpt(); ?>
                </div>	
            
            </div>
							
			<?php endwhile; ?>
            
            <div id="pagenav">
				<div class="prev"><p><?php previous_posts_link(); ?></p></div>
				<div class="next"><p><?php next_posts_link(); ?></p></div>
        	</div>
            
            <?php else : // do not delete ?>

            <h3><?php _e("Page not Found"); ?></h3>
            <p><?php _e("We're sorry, but the page you're looking for isn't here."); ?></p>

			<?php endif; // do not delete ?>
		
		</div>
		
	</div>
    
    <div id="sponsorwidget">
        <ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sponsor Widget') ) : ?>
        <?php endif; ?>
        </ul>
    </div>

</div>

<?php get_footer(); ?>