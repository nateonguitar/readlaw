<?php

//	GET ACTION VARIABLE

$action = (isset($_POST['action'])) ? $_POST['action'] : '';

$form_type = (isset($_POST['form_type'])) ? $_POST['form_type'] : '';



//	CHECK TO SEE IF FORM WAS SUBMITTED

if (($action == 'submit') && ($form_type == 'contact')) {

	//	Require Mailer Class

	require get_template_directory() . '/inc/mailer.class.php';

	$Mailer = new Mailer;



	//	SCREEN FOR SPAM

	$pv = (isset($_POST['pv'])) ? $_POST['pv'] : 'unverified';

	if ($pv == 'verified') {

		

		$Mailer->bHtml = true;

		$Mailer->bSmtp = false;

		#$Mailer->addCc('support@edit.com');

		$Mailer->addTo('david@801divorce.com');

		$Mailer->addTo('801divorce@gmail.com');

		$Mailer->addTo('dread@strongandhanni.com');

		$Mailer->addFrom('website@'.$Mailer->strDomainName);

		$Mailer->addSubject('Consultation Form Submission ('.$Mailer->strDomainName.')');

		

		unset($_POST['form_type']);

		

		$Mailer->addParsedPostDataToMessage();

		if ( $Mailer->sendMail() ) {

			$action = 'showconfirmation';

		} else {

			$action = 'mailerror';

		}

	} else $action = 'spamdetected';

}



//include contact.js on this page

wp_enqueue_script('form-scripting',get_bloginfo('template_url').'/inc/contact.js',array('jquery')); ?>



<?php if ($action == 'submit') echo $Mailer->generateFormPreloadJS(); ?>



<script>

	$(document).ready(function(){

		// SIDEBAR FORM

		

		// name

		jNameInput = $("form#sidebarContactForm input#full-name");

		jNameText = jNameInput.parent().children('label').text();

		jNameInput.val(jNameText);

		jNameInput.focus(function() {

			jNameUserInput = jNameInput.val();

			if ((jNameUserInput == '') || (jNameUserInput == jNameText)) { jNameInput.val(''); }

		});

		jNameInput.blur(function() {

			jNameUserInput = jNameInput.val();

			if (jNameUserInput == '') { jNameInput.val(jNameText); }

		});

		

		// email

		jEmailInput = $("form#sidebarContactForm input#email");

		jEmailText = jEmailInput.parent().children('label').text();

		jEmailInput.val(jEmailText);

		jEmailInput.focus(function() {

			jEmailUserInput = jEmailInput.val();

			if ((jEmailUserInput == '') || (jEmailUserInput == jEmailText)) { jEmailInput.val(''); }

		});

		jEmailInput.blur(function() {

			jEmailUserInput = jEmailInput.val();

			if (jEmailUserInput == '') { jEmailInput.val(jEmailText); }

		});

		

		// phone

		jPhoneInput = $("form#sidebarContactForm input#phone");

		jPhoneText = jPhoneInput.parent().children('label').text();

		jPhoneInput.val(jPhoneText);

		jPhoneInput.focus(function() {

			jPhoneUserInput = jPhoneInput.val();

			if ((jPhoneUserInput == '') || (jPhoneUserInput == jPhoneText)) { jPhoneInput.val(''); }

		});

		jPhoneInput.blur(function() {

			jPhoneUserInput = jPhoneInput.val();

			if (jPhoneUserInput == '') { jPhoneInput.val(jPhoneText); }

		});

		

		// description

		jDescriptionInput = $("form#sidebarContactForm textarea#description");

		jDescriptionText = jDescriptionInput.parent().children('label').text();

		jDescriptionInput.val(jDescriptionText);

		jDescriptionInput.focus(function() {

			jDescriptionUserInput = jDescriptionInput.val();

			if ((jDescriptionUserInput == '') || (jDescriptionUserInput == jDescriptionText)) { jDescriptionInput.val(''); }

		});

		jDescriptionInput.blur(function() {

			jDescriptionUserInput = jDescriptionInput.val();

			if (jDescriptionUserInput == '') { jDescriptionInput.val(jDescriptionText); }

		});	

		

		// form submit

		$('form#sidebarContactForm').submit(function(){

			if ($('#i_have_read_the_disclaimer').attr('checked')) {

				return true;

			} else {

				alert('Please verify that you have read the disclaimer.');

				return false;

			}			

		});		

	});

</script>

							

							<div class="clear"></div>

							<!-- End Left Content Area -->

							</td>

							<td id="rightContent">

							<!-- Begin Right Content Area -->

								<?php 

									$oBoxes = new Pod('sidebar_boxes');

									if (is_front_page()) {

										$oBoxes->findRecords('t.order ASC', -1, "sidebar_box_type.name!='consultation-form'");

									} else {

										$oBoxes->findRecords('t.order ASC', -1);

									}

									$c = 0;

								?>

								<?php while ($oBoxes->fetchRecord()) : ?>

									<?php if ($c >= 1) : ?><hr><?php endif; ?>

									<?php if ($oBoxes->get_field('sidebar_box_type.name') == 'call-to-action') : ?>

										<div class="sidebar-box" id="call-to-action">

											<?php if ($oBoxes->get_field('hide_title')!=1) { ?><h2><?php echo $oBoxes->get_field('name'); ?></h2><?php } ?>

											<div class="ctaContent">

												<?php echo wpautop($oBoxes->get_field('content')); ?>

												<?php if ($oBoxes->get_field('page_link_title')) { ?><a class="ctaLink" href="<?php echo get_permalink($oBoxes->get_field('page_to_link_to.ID')); ?>"><?php echo $oBoxes->get_field('page_link_title'); ?></a><?php } ?>

											</div>								

										</div>

									<?php elseif ($oBoxes->get_field('sidebar_box_type.name') == 'consultation-form') : ?>

										<div class="sidebar-box">

											<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/inc/colorbox.css" type="text/css" media="all" />

											<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/inc/jquery.colorbox.js"></script>

											<script type="text/javascript">

												jQuery(document).ready(function(){

													// colorbox

													jQuery("a.colorbox").colorbox({

														width:"400px",

														height:"auto",

														inline:true,

														href:"#formDisclaimer"

													});

												});

											</script>

											<form id="sidebarContactForm" class="sidebarForm" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" onsubmit="return fnValidate(this)">

												<?php if ($oBoxes->get_field('hide_title')!=1) { ?><h2><?php echo $oBoxes->get_field('name'); ?></h2><?php } ?>

												<?php if ($action == 'showconfirmation'): ?>

													<em>Thank you for your request. We will be in touch shortly.</em>

												<?php else: ?>

													<?php if ($action == 'spamdetected'): ?>

														<p class="messageWarning">Your request was detected as SPAM. If this is a valid request, please try resubmitting or contact us by phone or email.</p>

													<?php elseif ($action == 'mailerror'): ?>

														<p class="messageWarning">There was an error sending your email, please try again.</p>

													<?php else: ?>

														<?php echo wpautop($oBoxes->get_field('content')); ?>

														<?php if ($oBoxes->get_field('page_link_title')) { ?><a class="ctaLink" href="<?php echo get_permalink($oBoxes->get_field('page_to_link_to.ID')); ?>"><?php echo $oBoxes->get_field('page_link_title'); ?></a><br><br><?php } ?>

													<?php endif; ?>												

													<input type="hidden" name="action" id="action" value="submit">

													<input type="hidden" name="pv" id="pv" value="">

													<input type="hidden" name="form_type" id="form_type" value="contact">

													<fieldset>

														<label>Name</label>

														<input type="text" id="full-name" name="full-name" class="standard" validationtype="" title="Please enter a name." required="required">

													</fieldset>

													<fieldset>

														<label>Email</label>

														<input type="text" id="email" name="email" class="standard" validationtype="email" title="Please enter a valid e-mail address." required="required">

													</fieldset>

													<fieldset>

														<label>Phone</label>

														<input type="text" id="phone" name="phone" class="standard" validationtype="" title="Please enter a phone number.">

													</fieldset>

													<fieldset>

														<label>Please state a convenient time for us to contact you.</label>

														<textarea type="text" id="description" name="description" class="standard" validationtype=""></textarea>

													</fieldset>

													<fieldset>

														<input type="checkbox" id="i_have_read_the_disclaimer" name="i_have_read_the_disclaimer" class="checkbox" validationtype="" value="yes"> I have read the <a href="Javascript://Disclaimer" class="colorbox">disclaimer</a>

													</fieldset>

													<fieldset>

														<input type="submit" class="submit" value="Submit">

													</fieldset>

												</form>

											<?php endif; ?>

											<div class="hide">

												<?php

													$oDisclaimers = new Pod('disclaimer');

													$oDisclaimers->findRecords('t.order ASC', 1);

													$iNumDisclaimers = $oDisclaimers->getTotalRows();

												?>

												<div id="formDisclaimer">

													<?php while ($oDisclaimers->fetchRecord()) : ?>

														<h2><?php echo $oDisclaimers->get_field('name'); ?></h2>

														<?php echo $oDisclaimers->get_field('content'); ?>

													<?php endwhile; ?>

												</div>

											</div>

										</div>

									<?php else : ?>						

										<div class="sidebar-box">

											<?php if ($oBoxes->get_field('hide_title')!=1) { ?><h2><?php echo $oBoxes->get_field('name'); ?></h2><?php } ?>

											<?php echo wpautop($oBoxes->get_field('content')); ?>

											<a class="sidebarLink" href="<?php echo get_permalink($oBoxes->get_field('page_to_link_to.ID')); ?>"><?php echo $oBoxes->get_field('page_link_title'); ?></a>

										</div>

									<?php endif; ?>

									<?php $c++; ?>

								<?php endwhile; ?>

							<!-- End Right Content Area -->

							</td>

						</tr>

					</table>

				</div>

				<hr class="bottom">

				<div id="footer">

					<div id="BottomLogos">

						<div align="center">

							<table align="center" cellpadding="0" cellspacing="0" border="0">

								<tr>

									<!--

									<td><?php if (function_exists('fbshare_manual')) echo fbshare_manual(); ?></td>

									<td><?php do_action('linkedin_button'); ?></td>

									<td><div class="tweetmeme_button">

										<script type="text/javascript">tweetmeme_url = '<?php the_permalink(); ?>';</script>

										<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>

									</div></td>

									-->

									<?php 

										$oFooterLinks = new Pod('footer_logos');

										$oFooterLinks->findRecords('t.order ASC', -1);

										$iNumLinks = $oFooterLinks->getTotalRows();

									?>

									<?php if ($iNumLinks > 0) : ?>

										<?php while ($oFooterLinks->fetchRecord()) : ?>

										<?php

											$iImageID = $oFooterLinks->get_field('logo_image.ID');

											$arImage = wp_get_attachment_image_src($iImageID,'full');

											$strImageSrc = $arImage[0];

											$iImageWidth = $arImage[1];

											$iImageHeight = $arImage[2];

										?>

										<td>

											<?php if ($oFooterLinks->get_field('link') !== '') { ?><a href="<?php echo $oFooterLinks->get_field('link'); ?>"><?php } ?>

											<img src="<?php echo $strImageSrc; ?>" border="0" alt="<?php echo $oFooterLinks->get_field('name'); ?>">

											<?php if ($oFooterLinks->get_field('link') !== '') { ?></a><?php } ?>

										</td>

										<?php endwhile; ?>

									<?php endif; ?>

								</tr>

							</table>						

					</div>

				</div>

				<?php $arPages = get_pages('parent=0&sort_column=menu_order&meta_key=edc-show-in-nav&meta_value=yes'); ?>

				<?php for ($iPage=0; $iPage < count($arPages); $iPage++): ?>

				     <a href="<?php echo get_page_link($arPages[$iPage]->ID) ?>"><?php echo $arPages[$iPage]->post_title ?></a>

				     <?php if ($iPage ==  count($arPages)-1) echo "<br />"; else  echo "|"; ?>

				<?php endfor; ?>

				510 South 200 West, Suite 200, Salt Lake City, Utah 84101 | &copy; <?php echo date('Y'); ?> Law Office of David W. Read, LLC | All rights reserved

			</div>

		</div>

	</div>

</div>
    
<?php wp_footer(); ?>



</body>

</html>