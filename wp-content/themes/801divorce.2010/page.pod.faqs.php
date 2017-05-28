<?php /* Template Name: FAQs Page */ 
get_header(); ?>

<style>
	li.answer { clear: both; margin-bottom: 15px; }
	li.answer h3 a { color: #000; text-decoration: none; }
	a.backToTop { float: right; display: block; padding: 5px 0; }
</style>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if (!is_front_page() && (stripos(trim(get_the_content()),'<h1>') !== 0) ): ?>
			<h1><?php the_title(); ?></h1>
		<?php endif; ?>
		
		<?php the_content(); ?>
		
		<?php
			$oFAQs = new Pod('faqs');
			$oFAQs->findRecords('t.order ASC', -1);
			$iNumFAQs = $oFAQs->getTotalRows();
		?>
		<?php if ($iNumFAQs > 0) : ?>
			<h2>Questions</h2>
			<ol>
			<?php $i = 0; ?>
			<?php while ($oFAQs->fetchRecord()) : ?>
				<?php $i++; ?>
				<li><a href="#<?php echo $i; ?>"><?php echo $oFAQs->get_field('name'); ?></a></li>
			<?php endwhile; ?>
			</ol>
			
			<br>
			
			<h2>Answers</h2>
			<ol>
			<?php $i = 0; ?>
			<?php $oFAQs->resetPointer(); ?>
			<?php while ($oFAQs->fetchRecord()) : ?>
				<?php $i++; ?>
				<li class="answer">
					<h3><a id="<?php echo $i; ?>" name="<?php echo $i; ?>"><?php echo $oFAQs->get_field('name'); ?></a></h3>
					<div class="answer"><?php echo wpautop($oFAQs->get_field('answer')); ?></div>
					<a href="#" class="backToTop">back to top</a>
				</li>
			<?php endwhile; ?>
			</ol>
			
		<?php else: ?>
			<em>Sorry, there are no FAQs at this time. Please check back soon.</em>
		<?php endif; ?>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>