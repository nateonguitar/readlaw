<?php
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name'          => 'Blog Sidebar',
		'id'            => 'blog-sidebar',
		'description'   => 'This will display on the blog side of your website pages.',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
	/* Add One Call to register_sidebar() for each sidebar you need.
	register_sidebar(array(
        'name'          => 'Left Sidebar',
		'id'            => 'sidebar-left',
		'description'   => 'This will display on the left side of your website pages under the left navigation.',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
	*/
}

function add_custom_mime_types($mime_types){
	$mime_types['vcf'] = 'text/x-vcard'; //Adding avi extension 
	return $mime_types;
}
add_filter('upload_mimes', 'add_custom_mime_types', 1, 1);