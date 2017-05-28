<?php
/*
Plugin Name: Admin Display Customization (Edit.com)
Plugin URI: http://edit.com/
Description: A custom plugin for edit.com clients that cleans up admin display by removing unused elements.
Author: Edit.com
Version: 1.0
Author URI: http://edit.com/
*/

$edc_custom_fields = array(
	"page.2-boxes.php" => array(
		'box-title' => 'Feature Boxes Content',
		'columns' => '1',
		'fields' => array(
			"left-box-title" => array('label' => 'Left Box Title','type'=>'text', 'description' => ''),
			"left-box-content" => array('label' => 'Left Box Content','type' => 'wysiwyg','description' => ''),
			"right-box-title" => array('label' => 'Right Box Title','type'=>'text', 'description' => ''),
			"right-box-content" => array('label' => 'Right Box Content','type' => 'wysiwyg','description' => '')
		)
	),
	"page.3-boxes.php" => array(
		'box-title' => 'Feature Boxes Content',
		'columns' => '1',
		'fields' => array(
			"left-box-title" => array('label' => 'Left Box Title','type'=>'text', 'description' => ''),
			"left-box-content" => array('label' => 'Left Box Content','type' => 'wysiwyg','description' => ''),
			"middle-box-title" => array('label' => 'Middle Box Title','type'=>'text', 'description' => ''),
			"middle-box-content" => array('label' => 'Middle Box Content','type' => 'wysiwyg','description' => ''),
			"right-box-title" => array('label' => 'Right Box Title','type'=>'text', 'description' => ''),
			"right-box-content" => array('label' => 'Right Box Content','type' => 'wysiwyg','description' => '')
		)
	),
	"page.4-boxes.php" => array(
		'box-title' => 'Feature Boxes Content',
		'columns' => '1',
		'fields' => array(
			"top-left-box-title" => array('label' => 'Top Left Box Title','type'=>'text', 'description' => ''),
			"top-left-box-content" => array('label' => 'Top Left Box Content','type' => 'wysiwyg','description' => ''),
			"top-right-box-title" => array('label' => 'Top Right Box Title','type'=>'text', 'description' => ''),
			"top-right-box-content" => array('label' => 'Top Right Box Content','type' => 'wysiwyg','description' => ''),
			"bottom-left-box-title" => array('label' => 'Bottom Left Box Title','type'=>'text', 'description' => ''),
			"bottom-left-box-content" => array('label' => 'Bottom Left Box Content','type' => 'wysiwyg','description' => ''),
			"bottom-right-box-title" => array('label' => 'Bottom Right Box Title','type'=>'text', 'description' => ''),
			"bottom-right-box-content" => array('label' => 'Bottom Right Box Content','type' => 'wysiwyg','description' => '')
		)
	),
	"page.2-columns.php" => array(
		'box-title' => 'Right Column Content',
		'columns'	=> '1',
		'fields' => array(
			"right-column-content" => array('label' => 'Right Column Content','type'=>'wysiwyg', 'description' => '')
		)
	),
	"page.capture-form.php" => array(
		'box-title' => 'Right Column Content',
		'columns'	=> '1',
		'fields' => array(
			"right-column-content" => array('label' => 'Right Column Content','type'=>'wysiwyg', 'description' => '')
		)
	),
	"page.contact.php" => array(
		'box-title' => 'Bottom Content',
		'columns'	=> '1',
		'fields' => array(
			"bottom-content" => array('label' => 'Bottom Content','type'=>'wysiwyg', 'description' => '')
		)
	)
);

/* PODS UI: control & customize left navigation location of pods edit screens
	- Activate Pods UI plugin (not pods ui demo)
	- Do not set pod as a top-level menu item
	- Add array elements using example below
*/
$edc_pods_menu = array();
$edc_pods_menu['Sidebar'] = array();			// Menu Button Label (note, will link to first menu item)
$edc_pods_menu['Sidebar']['Boxes'] = array(		// 1st Menu Item Label
	'pod' => 'sidebar_boxes'								// The name of the pod to be managed
	,'items_title' => 'Boxes'						// Plural Friendly Name - e.g. View all [items_title]
	,'item_title' => 'Box'							// Signular Friendly Name - e.g. Delete this [item_title]
	,'list_columns' => array(
		'name'=>'Name',
		'sidebar_box_type'=>'Type',
		'content'=>'Content',
		'page_link_title'=>'Page Link Title',
		'page_to_link_to'=>'Page To Link To'
	)	// Columns to show on list screen - [field-name] => [label]
	//,'list_filters' => 'category'							// Filters to show for a Pod on list page (may be pick fields only)
	,'list_sort' => 't.order ASC'							// Sort Order for list page t.[column-name] [ASC|DSC]
	,'order_field' => 'order'								// Enable drag/drop reordering by specifying number field to order by
);

$edc_pods_menu['Footer'] = array();			// Menu Button Label (note, will link to first menu item)
$edc_pods_menu['Footer']['Logos'] = array(		// 1st Menu Item Label
	'pod' => 'footer_logos'								// The name of the pod to be managed
	,'items_title' => 'Logos'						// Plural Friendly Name - e.g. View all [items_title]
	,'item_title' => 'Logo'							// Signular Friendly Name - e.g. Delete this [item_title]
	,'list_columns' => array(
		'logo_image'=>array('label'=>'Image','display_helper'=>'pods_ui_column_thumbnail'),
		'name'=>'Name',
		'link'=>'Link',
		'order'=>'Display Order'
	)	// Columns to show on list screen - [field-name] => [label]
	//,'list_filters' => 'category'							// Filters to show for a Pod on list page (may be pick fields only)
	,'list_sort' => 't.order ASC'							// Sort Order for list page t.[column-name] [ASC|DSC]
	,'order_field' => 'order'								// Enable drag/drop reordering by specifying number field to order by
);

$edc_pods_menu['Attorneys'] = array();			// Menu Button Label (note, will link to first menu item)
$edc_pods_menu['Attorneys']['Attorneys'] = array(		// 1st Menu Item Label
	'pod' => 'attorneys'								// The name of the pod to be managed
	,'items_title' => 'Attorneys'						// Plural Friendly Name - e.g. View all [items_title]
	,'item_title' => 'Attorney'							// Signular Friendly Name - e.g. Delete this [item_title]
	,'list_columns' => array(
		'image'=>array('label'=>'Image','display_helper'=>'pods_ui_column_thumbnail'),
		'name'=>'Name',
		'email'=>'Email',
		'order'=>'Display Order'
	)	// Columns to show on list screen - [field-name] => [label]
	//,'list_filters' => 'category'							// Filters to show for a Pod on list page (may be pick fields only)
	,'list_sort' => 't.order ASC'							// Sort Order for list page t.[column-name] [ASC|DSC]
	,'order_field' => 'order'								// Enable drag/drop reordering by specifying number field to order by
);

$edc_pods_menu['Disclaimers'] = array();			// Menu Button Label (note, will link to first menu item)
$edc_pods_menu['Disclaimers']['Form_Disclaimer'] = array(		// 1st Menu Item Label
	'pod' => 'disclaimer'								// The name of the pod to be managed
	,'items_title' => 'Disclaimers'						// Plural Friendly Name - e.g. View all [items_title]
	,'item_title' => 'Disclaimer'							// Signular Friendly Name - e.g. Delete this [item_title]
	,'list_columns' => array(
		'name'=>'Name',
		'content'=>'Content',
		'order'=>'Display Order'
	)	// Columns to show on list screen - [field-name] => [label]
	//,'list_filters' => 'category'							// Filters to show for a Pod on list page (may be pick fields only)
	,'list_sort' => 't.order ASC'							// Sort Order for list page t.[column-name] [ASC|DSC]
	,'order_field' => 'order'								// Enable drag/drop reordering by specifying number field to order by
);
$edc_pods_menu['Disclaimers']['Blog_Disclaimer'] = array(		// 1st Menu Item Label
	'pod' => 'blog_disclaimer'								// The name of the pod to be managed
	,'items_title' => 'Disclaimers'						// Plural Friendly Name - e.g. View all [items_title]
	,'item_title' => 'Disclaimer'							// Signular Friendly Name - e.g. Delete this [item_title]
	,'list_columns' => array(
		'name'=>'Name',
		'content'=>'Content',
		'order'=>'Display Order'
	)	// Columns to show on list screen - [field-name] => [label]
	//,'list_filters' => 'category'							// Filters to show for a Pod on list page (may be pick fields only)
	,'list_sort' => 't.order ASC'							// Sort Order for list page t.[column-name] [ASC|DSC]
	,'order_field' => 'order'								// Enable drag/drop reordering by specifying number field to order by
);

$edc_pods_menu['FAQs'] = array();			// Menu Button Label (note, will link to first menu item)
$edc_pods_menu['FAQs']['FAQs'] = array(		// 1st Menu Item Label
	'pod' => 'faqs'								// The name of the pod to be managed
	,'items_title' => 'FAQs'						// Plural Friendly Name - e.g. View all [items_title]
	,'item_title' => 'FAQ'							// Signular Friendly Name - e.g. Delete this [item_title]
	,'list_columns' => array(
		'name'=>'Question'
		//,'answer'=>'Answer'
		,'order'=>'Display Order'
	)	// Columns to show on list screen - [field-name] => [label]
	//,'list_filters' => 'category'							// Filters to show for a Pod on list page (may be pick fields only)
	,'list_sort' => 't.order ASC'							// Sort Order for list page t.[column-name] [ASC|DSC]
	,'order_field' => 'order'								// Enable drag/drop reordering by specifying number field to order by
);

function create_meta_box() {
	global $post, $edc_custom_fields;
	
	// ADD Navigations Bars Option to Right Side of Pages Screen
	add_meta_box( 'edc-nav-location', 'Navigation Bars' , 'display_nav_location', 'page', 'side', 'low' );
	
	if( function_exists( 'add_meta_box' ) && IsSet($post,$post->page_template)) {
		if (array_key_exists($post->page_template,$edc_custom_fields)) {
			add_meta_box( 'edc-custom-fields', $edc_custom_fields[$post->page_template]['box-title'] , 'display_meta_box', 'page', 'normal', 'high' );
		}
	}
}
add_action( 'admin_notices', 'create_meta_box' );

function display_nav_location(){
	global $post;
	$bChecked = !(get_post_meta($post->ID, "edc-show-in-nav", true) != 'no');
	?>
		<div class="form-wrap"> 
			<div class="form-field form-required">
				<label><input type="checkbox" class="checkbox" name="edc-show-in-nav" id="edc-show-in-nav" value="no" <?php if ($bChecked) echo "checked"; ?> style="border:0;width:15px;margin-bottom:2px;" />
					Remove from site navigation bars?</label>
				<p>If selected, this page will not appear in your main site navigation bars.</p>
			</div>
			<?php wp_nonce_field( plugin_basename( __FILE__ ), 'edc-nav-location', false, true ); ?>
		</div><br clear="all">
	<?php
}

function display_meta_box() {
	global $post, $edc_custom_fields;
	$arFieldSet = $edc_custom_fields[$post->page_template];
	$strFormWrapCss = ($arFieldSet['columns'] == 2) ? 'width:48%;margin-right:2%;float:left;' : '';
	?>
		<div class="form-wrap" style="<?php echo $strFormWrapCss; ?>"> 
		<?php
			wp_nonce_field( plugin_basename( __FILE__ ), 'custom-fields_wpnonce', false, true );
			$arFields = $arFieldSet['fields'];
			foreach($arFields as $strField => $arField) {
				$data = get_post_meta($post->ID, "custom-fields", true); ?>
				<?php if ($strField == 'right-box-title') echo '</div><div class="form-wrap" style="width:48%;float:left;">'; ?>
				<div class="form-field form-required">
					<label for="<?php echo $strField; ?>"><?php echo $arField['label']; ?></label>
					<?php if ($arField['type']=='wysiwyg') : ?>
						<textarea rows="5" id="<?php echo $strField; ?>" name="<?php echo $strField; ?>" class="additional-info form-input-tip code mceStandard" autocomplete="off" /><?php echo wpautop( $data[ $strField ] ); ?></textarea>
					<?php elseif ($arField['type']=='wysiwyg-simple') : ?>
						<textarea rows="5" id="<?php echo $strField; ?>" name="<?php echo $strField; ?>" class="additional-info form-input-tip code mceSimple" autocomplete="off" /><?php echo wpautop( $data[ $strField ] ); ?></textarea>
					<?php else : ?>
						<input type="text" name="<?php echo $strField; ?>" value="<?php echo htmlspecialchars( $data[ $strField ] ); ?>" />
					<?php endif; ?>
					<?php if (trim($arField['description']!='')) : ?>
						<p><?php echo $arField['description']; ?></p>
					<?php endif; ?>
				</div>
			<?php } ?>
		</div><br clear="all">
		<script type="text/javascript">
			jQuery(document).ready(function() {
				tinyMCEPreInit.mceInit.editor_selector='mceStandard';
				tinyMCEPreInit.mceInit.theme_advanced_buttons2 += ",|,add_image,add_video,add_audio,add_media,|,code";
				tinyMCE.init(tinyMCEPreInit.mceInit);
			
				tinyMCEPreInit.mceInit.theme_advanced_buttons1 = "bold,italic,underline,|,cut,copy,paste,|,bullist,numlist,|,undo";
				tinyMCEPreInit.mceInit.theme_advanced_buttons2 = "link,unlink,|,add_image,add_video,add_audio,add_media,|,code";
				tinyMCEPreInit.mceInit.theme_advanced_buttons3 = "";
				//tinyMCEPreInit.mceInit.width = "250";
				
				tinyMCEPreInit.mceInit.editor_selector='mceSimple';
				tinyMCE.init(tinyMCEPreInit.mceInit);
			});
		</script>
	<?php
}

function save_meta_box( $post_id ) {
	global $edc_custom_fields;
	
	if ( wp_verify_nonce( $_POST['edc-nav-location'], plugin_basename(__FILE__) ) && current_user_can( 'edit_post', $post_id ) ) {
		if (!array_key_exists('edc-show-in-nav',$_POST) || $_POST['edc-show-in-nav'] != 'no') {
			update_post_meta( $post_id, "edc-show-in-nav", 'yes' );
		} else {
			update_post_meta( $post_id, "edc-show-in-nav", 'no' );
		}
	}
	
	if (array_key_exists('page_template',$_POST) && array_key_exists($_POST['page_template'],$edc_custom_fields)) {
	
		$arFields = $edc_custom_fields[$_POST['page_template']]['fields'];
		foreach($arFields as $strField => $arField) {
			$data[$strField] = $_POST[$strField];
		}
		if ( !wp_verify_nonce( $_POST['custom-fields_wpnonce'], plugin_basename(__FILE__) ) )
			return $post_id;
		
		if ( !current_user_can( 'edit_post', $post_id ))
			return $post_id;
	
		update_post_meta( $post_id, "custom-fields", $data );
	}
}
add_action( 'save_post', 'save_meta_box' );


/* Remove Unused Widgets */
function editcom_unregister_widgets() {
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Links' );
	
	//unregister_widget( 'WP_Widget_Calendar' );
	//unregister_widget( 'WP_Widget_Archives' );
	//unregister_widget( 'WP_Widget_Categories' );
	//unregister_widget( 'WP_Widget_Recent_Posts' );
	//unregister_widget( 'WP_Widget_Search' );
	//unregister_widget( 'WP_Widget_Tag_Cloud' );
	//unregister_widget( 'WP_Widget_Text' );
}
add_action('widgets_init', 'editcom_unregister_widgets' );

/* Remove Default Custom Fields Meta Boxes From Page & Post Edit Screen */
function editcom_remove_custom_boxes() {
	foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
		remove_meta_box( 'postcustom', 'post', $context );
		remove_meta_box( 'postcustom', 'page', $context );
		remove_meta_box( 'commentsdiv', 'post', $context );
		remove_meta_box( 'commentsdiv', 'page', $context );
		//remove_meta_box( 'authordiv', 'post', $context );
		//remove_meta_box( 'authordiv', 'page', $context );
		remove_meta_box( 'commentstatusdiv', 'post', $context );
		remove_meta_box( 'commentstatusdiv', 'page', $context );
		
		// HIDE DASHBOARD WIDGETS TOO
		//remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		//remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		//remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
		remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
	}
}
add_action( 'do_meta_boxes', 'editcom_remove_custom_boxes');

/* Use CSS to Customize Main WP Menus */
function editcom_custom_admin_menu() {
	echo '<style type="text/css">';
	// HIDE Blog-Related Left Nav Items (if no blog!)
	echo 'ul#adminmenu li#menu-links {display:none;}';
	//echo 'ul#adminmenu li#menu-posts {display:none;}';
	echo 'ul#adminmenu li#menu-comments {display:none;}';
	
	// HIDE Blog-Related Right Now Dashboard Items (if no blog!)
	echo 'div#dashboard_right_now div.table_discussion {display:none;}';
	echo 'div#dashboard_right_now div.table_content {width:100%;}';
	echo 'div#dashboard_right_now div.table_content TR TD {display:none;}';
	echo 'div#dashboard_right_now div.table_content TR TD.pages {display:table-cell;}';
	echo 'div#dashboard_right_now div.table_content TR TD.b_pages {display:table-cell;}';
	echo '</style>';
}
add_action('admin_head','editcom_custom_admin_menu', 1000);

/* Customize TinyMCE: add site-specific css */
function editcom_add_site_styles_to_tinymce($url) {
	if (!empty($url) ) $url .= ',';
	// Change the path here if using sub-directory
	$url .= trailingslashit( get_stylesheet_directory_uri() ) . 'inc/styles.css';
	
	return $url;
}
add_filter('mce_css', 'editcom_add_site_styles_to_tinymce');
//TO DO: replace above with add_editor_style( 'inc/styles.css' );

/* Customize TinyMCE: customize buttons in toolbar */
function editcom_custom_mce_buttons_row1($orig) {
	return array(	'bold','italic','underline','|','cut','copy','paste','|', 
					'bullist','numlist','blockquote','|', 
					'justifyleft', 'justifycenter', 'justifyright', '|', 
					'link', 'unlink', '|', 
					'undo','redo','search','replace','|', 
					'fullscreen','wp_adv','spellchecker','|','wp_help');
}
add_filter('mce_buttons', 'editcom_custom_mce_buttons_row1', 999 );


function editcom_custom_mce_buttons_row2($orig) {
	//to add style selector, change first line of array to: 'formatselect', 'styleselect', '|',
	return array(	'formatselect', '|',
					'pastetext','pasteword','removeformat','charmap','anchor','|', 
					'outdent', 'indent'
					,'|','vvqYouTube','vvqGoogleVideo','vvqDailyMotion','vvqVimeo','vvqVeoh','vvqViddler','vvqMetacafe','vvqBlipTV','vvqFlickrVideo','vvqSpike','vvqMySpace','vvqFLV','vvqQuicktime','vvqVideoFile' );
}
add_filter('mce_buttons_2', 'editcom_custom_mce_buttons_row2', 999 );


/* Customize TinyMCE: style and blockformat dropdowns */
function mcekit_editor_settings($settings) {
	/* 	CUSTOM STYLES
		Format: "Name to display=class-name", separatedy by ";"  
		Will appear in the link dialog (so they can be applied to links)
		Will appear in main editor toolbar if you add 'styleselect' after 'formatselect' above
	*/
	$settings['theme_advanced_styles'] =    '';	
	
	/* 	CUSTOM BLOCK FORMATS MENUS OPTIONS */
	$settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';
	//$settings['plugins'] .= ',searchreplace';
	//$settings['width'] = '250px';
	//$settings['editor_selector'] = '/theEditor/';

	return $settings;
}
add_filter('tiny_mce_before_init', 'mcekit_editor_settings');

/* Set WordPress Admin Defaults - Runs once (when plugin activated) */
function editcom_set_wp_defaults() {
	//set # of rows for tinymce (make it taller, default is 10)
	update_option( 'default_post_edit_rows', 20);
    $o = array(
        'avatar_default'            => 'blank',
        'avatar_rating'             => 'G',
        'category_base'             => '/thema',
        'comment_max_links'         => 0,
        'comments_per_page'         => 0,
        'date_format'               => 'd.m.Y',
        'default_ping_status'       => 'closed',
        'default_post_edit_rows'    => 30,
        'links_updated_date_format' => 'j. F Y, H:i',
        'permalink_structure'       => '/%year%/%postname%/',
        'rss_language'              => 'de',
        'timezone_string'           => 'Etc/GMT-1',
        'use_smilies'               => 0,
    );
 
    foreach ( $o as $k => $v ) {
        //update_option($k, $v);
    }
    // Delete dummy post and comment.
    wp_delete_post(1, TRUE);
    wp_delete_comment(1);
 
    return;
}
register_activation_hook(__FILE__, 'editcom_set_wp_defaults');

/* Add Dashboard Widget */
function edc_general_dashboard_widget() {
	echo '<p>Content TBD.</p>';
}

function edc_general_add_dashboard_widget() {
	wp_add_dashboard_widget( 'edc_general_dashboard_widget', 'Edit.com Client Information', 'edc_general_dashboard_widget' );
}
//add_action( 'wp_dashboard_setup', 'edc_general_add_dashboard_widget' );

/* PODS UI Configuration */
function edc_pods_ui_menu() {
	global $edc_pods_menu;
	if (!is_array($edc_pods_menu)) return;
	foreach($edc_pods_menu as $strMenuTitle => $arMenuItems) {
		if (!is_array($arMenuItems)) return;
		$iMenuItem = 0;	
		foreach($arMenuItems as $strMenuItemTitle => $arMenuItemProperties) {
			$iMenuItem++;
			if ($iMenuItem == 1) {
				//create new menu
				$strMenuId = 'edcpm-'.$strMenuTitle.'-'.$strMenuItemTitle;
				$strDisplayTitle = strtr($strMenuTitle,'_',' ');
				$function = '';$icon_url = '';$icon = '';$access_level = 'read';
				// Note: clicking menu will go to first item by design
				add_object_page( $strMenuTitle, $strMenuTitle, $access_level, $strMenuId, $function, $icon_url );
			}
			
			$strMenuItemId = 'edcpm-'.$strMenuTitle.'-'.$strMenuItemTitle;
			$strDisplayTitle = strtr($strMenuItemTitle,'_',' ');
			add_submenu_page( $strMenuId, $strDisplayTitle, $strDisplayTitle, $access_level, $strMenuItemId, 'edc_pods_ui_page_generation');
		}
	}
}

function edc_pods_ui_page_generation() {
	global $edc_pods_menu;
	$arPage = explode('-',$_REQUEST['page']);
	$arProperties = $edc_pods_menu[$arPage[1]][$arPage[2]];
	
	$object = new Pod($arProperties['pod']);
	$add_fields = $edit_fields = $reorder_columns = null;
	$object->ui = array('wpcss' => 1);
	if (array_key_exists('items_title',$arProperties)) $object->ui['title'] = $arProperties['items_title'];		// Plural Friendly Name - e.g. View all [title]
	if (array_key_exists('item_title',$arProperties)) $object->ui['item'] = $arProperties['item_title']; 		// Signular Friendly Name - e.g. Delete this [item]
	if (array_key_exists('list_columns',$arProperties)) $object->ui['columns'] = $arProperties['list_columns'];	// Columns to show on list screen - $column_name=>$column_label (pick columns have .name appended and only show first value);
	if (array_key_exists('list_sort',$arProperties)) $object->ui['sort'] = $arProperties['list_sort'];			// Default Sort Order
	if (array_key_exists('list_filters',$arProperties)) $object->ui['filters'] = $arProperties['list_filters'];	// Filters to show for a Pod on list page (may be pick fields only)
	if (array_key_exists('order_field',$arProperties)) $object->ui['reorder'] = $arProperties['order_field'];	// Enable drag/drop reordering by specifying number field to order by
	
	/* NOT CURRENTLY EXPOSED:
		'add_fields'  => $add_fields,				// Fields to show on add screen
		'edit_fields' => $edit_fields,				// Fields to show on add screen
		'reorder_columns' => $reorder_columns,		// Columns to show on re-order screen
		'sortable' => null,							// Specify value to disable sorting
		'limit' => 25,								// Default limit (can be overridden by user/gui)
		'where' => null,							// Specify a filter for management (e.g. hide some items) - see also, edit_where and sql properties
	*/
	pods_ui_manage($object);
}
add_action('admin_menu','edc_pods_ui_menu');
