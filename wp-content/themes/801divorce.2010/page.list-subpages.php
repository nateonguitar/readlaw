<?php /* Template Name: List SubPages Below Content */

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if (!is_front_page() && (stripos(trim(get_the_content()),'<h1>') !== 0) ): ?>
			<h1><?php the_title(); ?></h1>
		<?php endif; ?>
		
		<?php the_content(); ?>
		
		<ul class="in-page-nav"><?php wp_list_pages('sort_column=menu_order&title_li&child_of='.$post->ID); ?></ul>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>