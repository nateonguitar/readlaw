<?php /* Template Name: Capture Form */ 

//	GET ACTION VARIABLE
$action = (isset($_POST['action'])) ? $_POST['action'] : '';

//	CHECK TO SEE IF FORM WAS SUBMITTED
if ($action == 'submit') {
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
wp_enqueue_script('form-scripting',get_bloginfo('template_url').'/inc/contact.js',array('jquery'));

?><?php get_header(); ?>

<script>
	$(document).ready(function(){
		// form submit
		$('form#captureForm').submit(function(){
			if ($('#i_have_read_the_disclaimer_2').attr('checked')) {
				return true;
			} else {
				alert('Please verify that you have read the disclaimer.');
				return false;
			}			
		});		
	});
</script>

	<?php if ($action == 'submit') echo $Mailer->generateFormPreloadJS(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<?php if (!is_front_page() && (stripos(trim(get_the_content()),'<h1>') !== 0) ): ?>
			<h1><?php the_title(); ?></h1>
		<?php endif; ?>
		<div id="page-copy-full" class="scrollpane">
			<?php if ($action == 'showconfirmation'): ?>
				<p class="messageSuccess">Thank you for your request. We will be in touch shortly.</p>			
			<?php else: ?>
				<?php if ($action == 'spamdetected'): ?>
					<p class="messageWarning">Your request was detected as SPAM. If this is a valid request, please try resubmitting or contact us by phone or email.</p>
				<?php elseif ($action == 'mailerror'): ?>
					<p class="messageWarning">There was an error sending your email, please try again.</p>
				<?php else: ?>
					<?php the_content(); ?>
				<?php endif; ?>
				<form id="captureForm" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" onsubmit="return fnValidate(this)" style="margin:0;">
				 	<input type="hidden" name="action" id="action" value="submit">
					<input type="hidden" name="pv" id="pv" value="">
					<input type="hidden" name="form_type" id="form_type" value="capture">
					<div class="col2 col2-left">
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
							<input type="checkbox" id="i_have_read_the_disclaimer_2" name="i_have_read_the_disclaimer" class="checkbox" validationtype="" value="yes" required="required"> I have read the <a href="" class="colorbox">disclaimer</a>
						</fieldset>
						<fieldset>
							<input type="submit" class="submit" value="Submit">
						</fieldset>
					</div>
					<div class="col2"><br>
						<?php $arCustomFields = get_post_meta($post->ID, "custom-fields", true); ?>
						<?php echo wpautop($arCustomFields['right-column-content']); ?>
					</div>
					<br clear="all">					
				</form>
			<?php endif; ?>		
		</div>
			
	<?php endwhile; endif; ?>

<?php get_footer(); ?>