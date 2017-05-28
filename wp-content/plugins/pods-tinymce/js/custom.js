jQuery(document).ready(function($) {
    $('.media-buttons a').each(function() {
        $(this).click(function() {
            var parts = $(this).parent().attr('id').split('-');
            var editor_id = parts[parts.length - 1];
            if(typeof tinyMCE == object)
                tinyMCE.execCommand('mceFocus', false, editor_id);
        });
    });
});
