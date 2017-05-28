<?php get_header(); ?>

	<div id="blogSidebar"><?php include dirname(__FILE__).'/inc.sidebar.php'; ?></div>
	<div id="blogContent">
		<?php if (have_posts()) : ?>
			<div id="mainContent" class="right">
				<div class="whiteContent">
					<h1 class="pagetitle">Search Results</h1>
					<?php while (have_posts()) : the_post(); ?>	
						<div class="post" id="post-<?php the_ID(); ?>">
							<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
							<p class="date"><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></p>	
							<div class="entry"><?php the_excerpt(); ?></div>
							<p class="postmetadata">Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
						</div>	
					<?php endwhile; ?>
					<div class="navigation">
						<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
						<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
					</div>
				</div>
			</div>
		<?php else : ?>
			<h2 class="center">No posts found. Try a different search?</h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		<?php endif; ?>
	</div>

<?php get_footer(); ?>