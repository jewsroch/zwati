<?php get_header(); ?>

<div id="container">
        
    <div class="postarea">
        
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
		<?php global $more; $more = 0; ?>
        
        <?php if ( in_category('gallery') && !is_single() ) continue; ?>
        
        <div <?php post_class(); ?>>
            
        <div class="posttitle">
            
            <div class="postdate">
            	<div class="day"><?php the_time('d') ?></div>
                <div class="month"><?php the_time('M') ?></div>
            </div>
                
            <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <h5 class="cattitle"><?php the_category(' , '); ?></h5>
            
        </div>
                    
		<?php the_content('Read More'); ?>

		<div class="postmeta">
        	<div class="postmeta_left">
				<p><a href="<?php the_permalink() ?>"><?php _e("Link To Full Post"); ?></a></p>
            </div>
            <div class="postmeta_right">
            	<div class="twitter_link">
                    <a target="_blank" title="Share this article with your Twitter followers" href="http://twitter.com/home?status=Reading%3A+<?php the_title(); ?> - <?php  
                     $turl = getTinyUrl(get_permalink($post->ID));
                     echo $turl;
                     ?>" rel="nofollow" class="social-bookmark">Tweet Article</a>
                     <img alt="Tweet Article" src="<?php bloginfo('template_directory'); ?>/images/twitter.png"/>
                </div>
            	<div class="comment_link">
					<p><a href="<?php the_permalink(); ?>#respond"><?php _e("Leave A Comment"); ?></a></p>
                </div>
            </div>
		</div>
        
        </div>

        <?php endwhile; else: ?>
		<p><?php _e("Sorry, no posts matched your criteria."); ?></p>
		<?php endif; ?>
		
        <div id="pagenav">
			<div class="prev"><p><?php previous_posts_link(); ?></p></div>
			<div class="next"><p><?php next_posts_link(); ?></p></div>
        </div>

    </div>
    
    <div id="footerwidgets">
        
        <div class="footerwidgetleft">
            <ul>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Left') ) : ?>
            <?php endif; ?>
            </ul>
        </div>
            
        <div class="footerwidgetmid">
            <ul>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Mid') ) : ?>
            <?php endif; ?>
            </ul>
        </div>
            
        <div class="footerwidgetright">
            <ul>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Right') ) : ?>
            <?php endif; ?>
            </ul>
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