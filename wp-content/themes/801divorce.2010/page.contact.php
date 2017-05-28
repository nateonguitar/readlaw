<?php /* Template Name: Contact Page */ 
get_header(); ?>

<style>
	div.googleMap { margin: 0 0 15px; }
</style>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if (!is_front_page() && (stripos(trim(get_the_content()),'<h1>') !== 0) ): ?>
			<h1><?php the_title(); ?></h1>
		<?php endif; ?>
		
		<?php the_content(); ?>
		
		<div class="googleMap"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.1864374009697!2d-111.89734999999999!3d40.757923999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8752f51b94e9dbb7%3A0xfa2e6e6aaaada72d!2s510+S+200+W+%23200!5e0!3m2!1sen!2sus!4v1394945410117" width="600" height="450" frameborder="0" style="border:0"></iframe><br /></div>
		
		<?php $arCustomFields = get_post_meta($post->ID, "custom-fields", true); ?>
		<?php echo wpautop($arCustomFields['bottom-content']); ?>
		
	<?php endwhile; endif; ?>

<?php get_footer(); ?>