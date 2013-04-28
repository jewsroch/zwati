<?php get_header(); ?>

<div id="container">

	<div class="postarea">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
        <div class="posttitle">		

			<h2><?php the_title(); ?></h2>

            <div class="postauthor">            
                <p><?php _e("Posted on"); ?> <?php the_time('l, F j, Y'); ?> &middot; <a href="<?php the_permalink(); ?>#respond"><?php comments_number('Leave a Comment', '1 Comment', '% Comments'); ?></a>&nbsp;<?php edit_post_link('(Edit)', '', ''); ?></p>
            </div>
                    
        </div>

		<?php the_content('Read More');?><div style="clear:both;"></div>
		<?php trackback_rdf(); ?>

		<div class="postmeta">
			<p><?php _e("Categories:"); ?> <?php the_category(', ') ?> &middot; <?php _e("Tags:"); ?> <?php the_tags('') ?></p>
		</div>

	</div>

    <div class="postcomments">
		<?php comments_template('',true); ?>
    </div>

	<?php endwhile; else: ?>
	<p><?php _e("Sorry, no posts matched your criteria."); ?></p>
	<?php endif; ?>
    
    <div id="sponsorwidget">
        <ul>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sponsor Widget') ) : ?>
        <?php endif; ?>
        </ul>
	</div>

</div>

<?php get_footer(); ?>