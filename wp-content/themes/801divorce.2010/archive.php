<?php get_header(); ?>

	<div id="blogSidebar"><?php include dirname(__FILE__).'/inc.sidebar.php'; ?></div>
	<div id="blogContent">
		<?php if (have_posts()) : ?>
			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<?php if (is_category()) { /* If this is a category archive */ ?>
				<h1 class="pagetitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
			<?php } elseif (is_day()) { /* If this is a daily archive */ ?>
				<h1 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h1>
			<?php } elseif (is_month()) { /* If this is a monthly archive */ ?>
				<h1 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h1>
			<?php } elseif (is_year()) { /* If this is a yearly archive */ ?>
				<h1 class="pagetitle">Archive for <?php the_time('Y'); ?></h1>
			<?php } elseif (is_author()) { /* If this is an author archive */ ?>
				<h1 class="pagetitle">Author Archive</h1>
			<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { /* If this is a paged archive */ ?>
				<h1 class="pagetitle">Blog Archives</h1>
			<?php } ?>
		
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
		<?php else : ?>	
			<h2 class="center">Not Found</h2>
			<p class="center">Sorry, but you are looking for something that isn't here.</p>
			<?php include (TEMPLATEPATH . "/searchform.php"); ?>	
		<?php endif; ?>
	</div>

<?php get_footer(); ?>
