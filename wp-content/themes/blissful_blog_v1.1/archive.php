<?php get_header(); ?>

<div id="container">

	<div id="content" class="left">
    
		<div class="postarea">
	
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            
            <div class="postauthor">
        		<p><?php _e("Posted on"); ?> <?php the_time('F j, Y'); ?> &middot; <a href="<?php the_permalink(); ?>#comments"><?php comments_number('Leave a Comment', '1 Comment', '% Comments'); ?></a>&nbsp;<?php edit_post_link('(Edit)', '', ''); ?></p>  
            </div>
            
            <?php the_excerpt(); ?><div style="clear:both;"></div>
            
			<div class="postmeta">
				<p><?php _e("Categories:"); ?> <?php the_category(', ') ?> &middot; <?php _e("Tags:"); ?> <?php the_tags('') ?></p>
			</div>
            		
			<?php endwhile; else: ?>
                    
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
            
            <div class="pagination">
            	<?php if (function_exists("number_paginate")) { number_paginate(); } ?>
            </div>
        
        </div>
	
	</div>
	
	<div id="sidebar">
	    <ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?>
	    <?php endif; ?>
	    </ul>
	</div>

</div>

<?php get_footer(); ?>