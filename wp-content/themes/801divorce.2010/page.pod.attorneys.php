<?php /* Template Name: Attorneys Page */ 
get_header(); ?>

<style>
	div.attorneyListing { margin-bottom: 15px; }
	div.attorneyImage { float: left; width: 200px; min-height: 200px; margin-right: 10px; }
		div.attorneyImage img { width: 100%; border: 0; }
	div.email { font-size: 14px; margin-bottom: 15px; }
</style>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if (!is_front_page() && (stripos(trim(get_the_content()),'<h1>') !== 0) ): ?>
			<h1><?php the_title(); ?></h1>
		<?php endif; ?>
		
		<?php the_content(); ?>
		
		<?php
			$oAttorneys = new Pod('attorneys');
			$oAttorneys->findRecords('t.order ASC', -1);
			$iNumAttorneys = $oAttorneys->getTotalRows();
			$c = 0;
		?>
		<?php if ($iNumAttorneys > 0) : ?>
			<?php while ($oAttorneys->fetchRecord()) : ?>
				<?php if ($c>=1) { ?><hr><?php } ?>
				<div class="attorneyListing">
					<div class="attorneyImage">
						<?php
							$arImageIDs = $oAttorneys->get_field('image.ID');
							if (!is_array($arImageIDs)) $arImageIDs = array($arImageIDs);
							$arImages = array();
							foreach ($arImageIDs as $iImageID) $arImages[] = wp_get_attachment_image_src($iImageID,'full');
						?>
						<?php foreach ($arImages as $arImage) : ?>						
							<?php if ($arImage[0] !== null) { ?>
								<img src="<?php echo $arImage[0]; ?>">
							<?php } ?>
						<?php endforeach; ?>
					</div>
					<h2><?php echo $oAttorneys->get_field('name'); ?></h2>
					<?php if ($oAttorneys->get_field('email') !== '') { ?>
						<div class="email"><a href="mailto:<?php echo $oAttorneys->get_field('email'); ?>"><?php echo $oAttorneys->get_field('email'); ?></a></div>
					<?php } ?>
					<div class="bio"><?php echo wpautop($oAttorneys->get_field('bio')); ?></div>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>