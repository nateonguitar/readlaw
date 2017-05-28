<?php /* Template Name: 2 Column Page */ 
get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if (!is_front_page()): ?><h1><?php the_title(); ?></h1><?php endif; ?>
		
		<div class="col2 col2-left">
			<?php the_content(); ?>
		</div>
		<div class="col2">
			<?php $arCustomFields = get_post_meta($post->ID, "custom-fields", true); ?>
			<?php echo wpautop($arCustomFields['right-column-content']); ?>
		</div>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>