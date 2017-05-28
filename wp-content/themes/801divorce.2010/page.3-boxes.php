<?php /* Template Name: Page with 3 Boxes */ 
get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if (!is_front_page() && (stripos(trim(get_the_content()),'<h1>') !== 0) ): ?>
			<h1><?php the_title(); ?></h1>
		<?php endif; ?>
		
		<?php the_content(); ?>
		
		<?php $arCustomFields = get_post_meta($post->ID, "custom-fields", true); ?>
		
		<div id="homeBoxes3">
			<div class="homeBox left">
				<div class="homeBoxInner">
					<h2><?php echo $arCustomFields['left-box-title']; ?></h2>
					<div class="homeBoxContent"><?php echo wpautop($arCustomFields['left-box-content']); ?></div>
				</div>
			</div>
			<div class="homeBox middle">
				<div class="homeBoxInner">
					<h2><?php echo $arCustomFields['middle-box-title']; ?></h2>
					<div class="homeBoxContent"><?php echo wpautop($arCustomFields['middle-box-content']); ?></div>
				</div>
			</div>
			<div class="homeBox right">
				<div class="homeBoxInner">
					<h2><?php echo $arCustomFields['right-box-title']; ?></h2>
					<div class="homeBoxContent"><?php echo wpautop($arCustomFields['right-box-content']); ?></div>
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