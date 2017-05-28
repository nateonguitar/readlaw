<h1>801-Divorce Blog</h1>
<?php
	$oBlogDisclaimers = new Pod('blog_disclaimer');
	$oBlogDisclaimers->findRecords('t.order ASC', 1);
	$iNumBlogDisclaimers = $oBlogDisclaimers->getTotalRows();
?>
<?php if ($iNumBlogDisclaimers > 0) { ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			// colorbox
			jQuery("a#readBlogDisclaimer").colorbox({
				width:"400px",
				height:"auto",
				inline:true,
				href:"#blogDisclaimer"
			});
		});
	</script>
	<div class="blogPad"><a href="Javascript://Read Blog Disclaimer" id="readBlogDisclaimer">Read Blog Disclaimer</a></div>
	<div class="hide">
		<div id="blogDisclaimer">
			<?php while ($oBlogDisclaimers->fetchRecord()) : ?>
				<h3><?php echo $oBlogDisclaimers->get_field('name'); ?></h3>
				<?php echo $oBlogDisclaimers->get_field('content'); ?>
			<?php endwhile; ?>
		</div>
	</div>
<?php } ?>
<hr>
<?php $arBlogUsers = get_users('role=editor'); ?>
<?php foreach ($arBlogUsers as $user) { ?>
	<div class="blogUser">
		<div class="userPhoto"><?php userphoto($user->ID); ?></div>
		<h3 class="userName"><?php echo $user->display_name; ?></h3>
		<div><a href="<?php echo home_url('/'); ?>author/<?php echo $user->user_nicename; ?>">View Blog Posts</a></div>		
		<div class="clear"></div>
		<?php
			$arCategories = array();
			$oAuthorPosts = get_posts(array('author' => $user->ID,'showposts'=>-1,'caller_get_posts'=>1));
			if ($oAuthorPosts) {
				foreach ($oAuthorPosts as $oPost) {
					foreach(get_the_category($oPost->ID) as $oCategory) {
						$arCategories[$oCategory->term_id] = $oCategory->term_id;
					}
				}
			}
			$strCategoryIds = implode(',', $arCategories);
		?>
		<ul><?php wp_list_categories('include='.$strCategoryIds.'&title_li='); ?></ul>
	</div>
<?php } ?>
<?php dynamic_sidebar('blog-sidebar'); ?>