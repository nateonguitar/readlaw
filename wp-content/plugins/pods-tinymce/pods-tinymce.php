<?php
/*
Plugin Name: Pods TinyMCE Editor
Plugin URI: http://podscms.org/
Description: TinyMCE editor for Pods "Paragraph text" (desc) column types
Author: Scott Kingsley Clark
Version: 1.1
Author URI: http://www.scottkclark.com/
*/

add_action('pods_manage_content','pods_tinymce_inc',15,1);
add_action('pods_form_init','pods_tinymce_inc',15,1);

$pods_tinymce_included = false;

function pods_tinymce_inc ($val=true) {
    global $pods_tinymce_included;
    if(false===$pods_tinymce_included) {
        require_once(ABSPATH . 'wp-admin/includes/post.php');
        $pods_tinymce_included = true;
        wp_enqueue_style('pods-tinymce','/wp-content/plugins/pods-tinymce/css/pods-tinymce.css',false,'20101307');
        wp_enqueue_style('thickbox');
        wp_enqueue_script('pods-tinymce-custom','/wp-content/plugins/pods-tinymce/js/custom.js',array('jquery'),'20101507');
        wp_enqueue_script('pods-tinymce-quicktags','/wp-content/plugins/pods-tinymce/js/quicktags.dev.js',false,'20101307');
        wp_enqueue_script('pods-tinymce','/wp-content/plugins/pods-tinymce/js/editor.dev.js',false,'20101307');
        wp_enqueue_script('tiny_mce');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('media-upload');
        global $wp_scripts;
        $wp_scripts->localize('pods-tinymce-quicktags','multiquicktagsL10n',array(
                'quickLinks'=>__('(Quick Links)'),
                'wordLookup'=>__('Enter a word to look up:'),
                'dictionaryLookup'=>esc_attr(__('Dictionary lookup')),
                'lookup'=>esc_attr(__('lookup')),
                'closeAllOpenTags'=>esc_attr(__('Close all open tags')),
                'closeTags'=>esc_attr(__('close tags')),
                'enterURL'=>__('Enter the URL'),
                'enterImageURL'=>__('Enter the URL of the image'),
                'enterImageDescription'=>__('Enter a description of the image'),
                'l10n_print_after'=>'try{convertEntities(quicktagsL10n);}catch(e){};'
       ));
        wp_print_styles(array('pods-tinymce','thickbox'));
        wp_print_scripts(array('pods-tinymce-custom','pods-tinymce-quicktags','pods-tinymce','tiny_mce','thickbox','media-upload'));
        wp_tiny_mce();
    }
    if((function_exists('pods_ui_manage')&&false===$val)||false===$val)
        return false;
    return true;
}
function pods_tinymce_default_editor($id = 'content') {
    $r = user_can_richedit() ? 'tinymce' : 'html'; // defaults
    if ( $user = wp_get_current_user() ) { // look for cookie
        $ed = get_user_setting('editor'.'_'.$id, 'tinymce');
        $r = ( in_array($ed, array('tinymce', 'html') ) ) ? $ed : $r;
    }
    return apply_filters( 'wp_default_editor', $r ); // filter
}
function pods_tinymce ($content,$css_id='content',$css_classes='form tinymce_desc',$media_buttons=true,$rows=false) {
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    global $temp_ID;
    $temp_ID = 1;
    if (false===$rows) {
        $rows = get_option('default_post_edit_rows');
        if (($rows < 3) || ($rows > 100))
            $rows = 12;
    }
    if (!current_user_can('upload_files'))
        $media_buttons = false;
    $richedit =  user_can_richedit();
    $wp_default_editor = ($richedit?pods_tinymce_default_editor($css_id):'html');
?>
<div id="<?php echo $css_id; ?>-wrapper" class="pods_tinymce">
<?php
    if ($richedit || $media_buttons) {
?>
    <div id="editor-toolbar-<?php echo $css_id ?>" class="editor-toolbar">
<?php
        if ($richedit) {
?>
        <div class="zerosize"><input accesskey="e" type="button" onclick="switchEditors.go('<?php echo $css_id; ?>')" /></div>
<?php
            if ('html'==$wp_default_editor) {
                add_filter('the_editor_content','wp_htmledit_pre');
                $css_classes .= ' theHtmlContent';
?>
            <a id="edButtonHTML-<?php echo $css_id ?>" class="edButtonHTML active hide-if-no-js" onclick="switchEditors.go('<?php echo $css_id; ?>','html');"><?php _e('HTML'); ?></a>
            <a id="edButtonPreview-<?php echo $css_id ?>" class="edButtonPreview hide-if-no-js" onclick="switchEditors.go('<?php echo $css_id; ?>','tinymce');"><?php _e('Visual'); ?></a>
<?php
            } else {
                add_filter('the_editor_content','wp_richedit_pre');
                $css_classes .= ' theEditor';
?>
            <a id="edButtonHTML-<?php echo $css_id ?>" class="edButtonHTML hide-if-no-js" onclick="switchEditors.go('<?php echo $css_id; ?>','html');"><?php _e('HTML'); ?></a>
            <a id="edButtonPreview-<?php echo $css_id ?>" class="edButtonPreview active hide-if-no-js" onclick="switchEditors.go('<?php echo $css_id; ?>','tinymce');"><?php _e('Visual'); ?></a>
<?php
            }
        }
        if ($media_buttons) {
?>
        <div id="media-buttons-<?php echo $css_id ?>" class="media-buttons hide-if-no-js">
<?php do_action('media_buttons'); ?>
        </div>
<?php
        }
?>
    </div>
<?php
    }
?>
        <div id="quicktags-<?php echo $css_id ?>" class="quicktags">
            <div id="qt-<?php echo $css_id ?>">
            </div>
        </div>
<?php
    $the_editor = apply_filters('the_editor','<div id="editorcontainer-'.$css_id.'" class="editorcontainer"><textarea rows="'.$rows.'" class="'.$css_classes.'" cols="40" name="'.$css_id.'" tabindex="'.$tab_index.'" id="'.$css_id.'">%s</textarea></div>');
    $the_editor_content = apply_filters('the_editor_content',$content);
    printf($the_editor,$the_editor_content);
?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            qtags<?php echo $css_id ?> = new QTags('qtags<?php echo $css_id ?>','<?php echo $css_id ?>','qt-<?php echo $css_id ?>');
<?php
    if($richedit) {
?>
            var h = wpCookies.getHash('TinyMCE_content_size');
            if ( getUserSetting( 'editor<?php echo '_'.$css_id ?>' ) == 'html' ) {
                if ( h )
                    jQuery('#<?php echo $css_id ?>').css('height', h.ch - 15 + 'px');
            } else {
                if ( typeof tinyMCE != 'object' ) {
                    jQuery('#<?php echo $css_id ?>').css('color', '#000');
                } else {
                    jQuery('#quicktags<?php echo '-'.$css_id ?>').hide();
                }
            }
            if(typeof(editItem) == "function")
                switchEditors.go('<?php echo $css_id; ?>','<?php echo ('html'==$wp_default_editor?'html':'tinymce'); ?>');
<?php
    } else {
?>
            edCanvas = document.getElementById('<?php echo $css_id; ?>');
<?php
    }
?>
        });
    </script>
</div>
<?php
}