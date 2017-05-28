<?php /* Template Name: Page with 4 Boxes */ 
get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if (!is_front_page() && (stripos(trim(get_the_content()),'<h1>') !== 0) ): ?>
			<h1><?php the_title(); ?></h1>
		<?php endif; ?>
		
		<?php the_content(); ?>
		
		<?php $arCustomFields = get_post_meta($post->ID, "custom-fields", true); ?>
		
		<div id="homeBoxes4">
			<div class="homeBox left">
				<div class="homeBoxInner">
					<h2><?php echo $arCustomFields['top-left-box-title']; ?></h2>
					<div class="homeBoxContent"><?php echo wpautop($arCustomFields['top-left-box-content']); ?></div>
				</div>
			</div>
			<div class="homeBox right">
				<div class="homeBoxInner">
					<h2><?php echo $arCustomFields['top-right-box-title']; ?></h2>
					<div class="homeBoxContent"><?php echo wpautop($arCustomFields['top-right-box-content']); ?></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="homeBox left">
				<div class="homeBoxInner">
					<h2><?php echo $arCustomFields['bottom-left-box-title']; ?></h2>
					<div class="homeBoxContent"><?php echo wpautop($arCustomFields['bottom-left-box-content']); ?></div>
				</div>
			</div>
			<div class="homeBox right">
				<div class="homeBoxInner">
					<h2><?php echo $arCustomFields['bottom-right-box-title']; ?></h2>
					<div class="homeBoxContent"><?php echo wpautop($arCustomFields['bottom-right-box-content']); ?></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php /*
		
<p>Vestibulum interdum mattis dolor, quis dignissim arcu aliquet eget. Donec posuere, nisi eget pellentesque hendrerit, purus odio dignissim ante, vitae placerat ligula libero vehicula ipsum.</p>
<p><a href="Javascript://More Information">More Information ></a></p>

		*/ ?>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>