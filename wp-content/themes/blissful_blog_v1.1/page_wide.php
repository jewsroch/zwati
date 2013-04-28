<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

<div id="container">

	<div id="content" class="wide">
    
        <div class="postarea">
    
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <div class="posttitle">
            	<h2><?php the_title(); ?></h2>
            </div>
            
            <?php the_content(__('Read More'));?><div style="clear:both;"></div><?php edit_post_link('(Edit)', '', ''); ?>
            
            <?php endwhile; else: ?>
            
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
            
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