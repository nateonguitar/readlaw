<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/inc/styles.css" type="text/css" media="all" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/inc/jquery.corner.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/inc/jquery.cycle.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/inc/jquery.pngFix.js"></script> 
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/inc/site.js"></script>
	
	<!-- RSS Feeds -->
	<link href="<?php bloginfo('rss2_url'); ?>" title="<?php bloginfo('name'); ?> RSS Feed" rel="alternate" type="application/rss+xml" />
	<link href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php bloginfo('name'); ?> Comments RSS Feed" rel="alternate" type="application/rss+xml" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapOuter">
	<div id="wrap">
		<div id="header">
			<a class="homeLink" href="<?php echo home_url('/'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="<?php bloginfo('title'); ?>" title="<?php bloginfo('title'); ?>" border="0" class="logo" /></a>
			<div id="icons">
				<a href="JavaScript:window.print();"><img src="<?php bloginfo('template_directory'); ?>/images/icon-print.jpg" border="0" /></a>
				<a href="mailto:?subject=Check out http://www.801divorce.com"><img src="<?php bloginfo('template_directory'); ?>/images/icon-email.jpg" border="0" /></a>
			</div>
			<img src="<?php bloginfo('template_directory'); ?>/images/phone.png" alt="801-DIVORCE (348-6723)" title="801-DIVORCE (348-6723)" border="0" class="phone" />
			<div id="NavBar">
				<ul id="nav"><?php wp_list_pages('sort_column=menu_order&title_li&meta_key=edc-show-in-nav&meta_value=yes&exclude=20'); ?></ul>
			</div>
			<div class="clear"></div>
		</div>
		<?php if (is_front_page()) { ?>
			<div id="banner">
				<div id="bannerSlideshow">
					<img src="<?php bloginfo('template_directory'); ?>/images/banner-1.jpg">
					<img src="<?php bloginfo('template_directory'); ?>/images/banner-2.jpg">
				</div>
				<div id="bannerLink">
					Schedule a Consultation <a href="<?php echo home_url('/'); ?>schedule-a-consultation">Here</a>
				</div>
			</div>
		<?php } ?>
		<div id="content">
			<div id="mainContent">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
					<?php if (!is_front_page()) : ?>					
						<?php
							// Get Top Level Parent of Current Page
							$arTopPage = $post;
							while ($arTopPage->post_parent) $arTopPage = get_page($arTopPage->post_parent);
						?>					
						<?php if (get_children($arTopPage->ID )) { ?>
						<td id="leftNav">
							<ul id="left-nav"><?php wp_list_pages('sort_column=menu_order&title_li&child_of='.$arTopPage->ID); ?></ul>
						</td>
						<?php } ?>						
					<?php endif; ?>
						<td id="leftContent">
						<!-- Begin Left Content Area -->