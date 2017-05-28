<?php get_header(); ?>

	<div id="blogSidebar"><?php include dirname(__FILE__).'/inc.sidebar.php'; ?></div>
	<div id="blogContent">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h1><?php the_title(); ?></h1>
				<p class="date"><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></p>					
				<div class="entry">
					<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<p class="postmetadata">Posted in <?php the_category(', ') ?><?php edit_post_link('Edit', ' | ', ''); ?></p>
					<?php if (('open' == $post-> comment_status)) { ?><a href="#respond">Leave a reply &#x2193;</a><?php } ?>
				</div>
			</div>
			<div class="navigation">
				<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
				<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
			</div>
		<?php endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
	</div>

<?php get_footer(); ?>
