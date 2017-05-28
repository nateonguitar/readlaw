<?php
/*
Plugin Name:  LinkedIn Share Button
Description:  Add a LinkedIn Share button to your blog posts
Version:      1.2
Plugin URI:   http://frankprendergast.ie/resources/linkedin-button-for-wordpress/
Author:       <a href="http://johnblackbourn.com/">John Blackbourn</a> & <a href="http://frankprendergast.ie/">Frank Prendergast</a>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

class LinkedInButton {

	var $plugin;
	var $settings;
	var $print_js;
	var $defaults = array(
		'placement' => array(
			'is_single' => 1,
			'is_page'   => 1
		),
		'position' => 'top',
		'float'    => 'right'
	);

	function LinkedInButton() {
		add_action( 'linkedin_button', 'linkedin_button', 10, 2 );
		add_action( 'plugins_loaded',  array( $this, 'register_plugin' ) );
		add_action( 'admin_menu',      array( $this, 'menu' ) );
		add_action( 'admin_init',      array( $this, 'load' ) );
		add_action( 'save_post',       array( $this, 'save' ), 10, 2 );
		add_filter( 'the_content',     array( $this, 'content' ) );
		add_filter( 'wp_footer',       array( $this, 'print_js' ) );
	}

	function print_js() {
		if ( $this->print_js ) {
			wp_enqueue_script(
				$this->plugin->dom,
				$this->plugin->url . '/linkedin-share-button.js',
				array(),
				null,
				true
			);
			# http://core.trac.wordpress.org/ticket/11944:
			wp_print_scripts( $this->plugin->dom );
		}
	}

	function load() {

		add_meta_box(
			$this->plugin->dom,
			__( 'LinkedIn Share Button', $this->plugin->dom ),
			array( $this, 'meta_box' ),
			'page',
			'side'
		);
		add_meta_box(
			$this->plugin->dom,
			__( 'LinkedIn Share Button', $this->plugin->dom ),
			array( $this, 'meta_box' ),
			'post',
			'side'
		);

	}

	function save( $post_id, $post ) {

		if ( defined('DOING_AJAX') and DOING_AJAX )
			return;
		if ( wp_is_post_revision( $post_id ) or wp_is_post_autosave( $post_id ) )
			return;

		if ( isset( $_POST[$this->plugin->dom] ) ) {
			if ( $_POST[$this->plugin->dom] )
				update_post_meta( $post_id, $this->plugin->dom, $_POST[$this->plugin->dom] );
			else
				delete_post_meta( $post_id, $this->plugin->dom );
		}

	}

	function options() {
		$buttons = $this->get_buttons();
		if ( !isset( $this->settings['button'] ) )
			$this->settings['button'] = current( $buttons );
		?>	
		<div class="wrap">

		<?php screen_icon(); ?>
		<h2><?php _e( 'LinkedIn Button Settings', $this->plugin->dom ); ?></h2>

		<form action="options.php" method="post">
		<?php settings_fields( $this->plugin->dom, $this->plugin->dom ); ?>

		<table class="form-table">

		<tr valign="top">
			<th scope="row"><?php _e( 'Automatic Button Display', $this->plugin->dom ); ?></th>
			<td>
				<p><label><input value="1" type="checkbox" name="<?php echo $this->plugin->dom; ?>[placement][is_single]" <?php checked( $this->settings['placement']['is_single'] ); ?> /> <?php _e( 'Display on posts', $this->plugin->dom ); ?></label></p>
				<p><label><input value="1" type="checkbox" name="<?php echo $this->plugin->dom; ?>[placement][is_page]" <?php checked( $this->settings['placement']['is_page'] ); ?> /> <?php _e( 'Display on pages', $this->plugin->dom ); ?></label></p>
				<p><label><input value="1" type="checkbox" name="<?php echo $this->plugin->dom; ?>[placement][is_home]" <?php checked( $this->settings['placement']['is_home'] ); ?> /> <?php _e( 'Display on posts on the home page', $this->plugin->dom ); ?></label></p>
				<p><label><input value="1" type="checkbox" name="<?php echo $this->plugin->dom; ?>[placement][is_archive]" <?php checked( $this->settings['placement']['is_archive'] ); ?> /> <?php _e( 'Display on posts in archive listings', $this->plugin->dom ); ?></label></p>
				<p><label><input value="1" type="checkbox" name="<?php echo $this->plugin->dom; ?>[placement][is_search]" <?php checked( $this->settings['placement']['is_search'] ); ?> /> <?php _e( 'Display on posts in search results', $this->plugin->dom ); ?></label></p>

				<p class="description"><?php printf( __( 'If you choose not to display the button automatically, you will need to add the %s template tag to your template.', $this->plugin->dom ), "<code>&lt;?php do_action('linkedin_button'); ?&gt;</code>" ); ?></p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Button Style', $this->plugin->dom ); ?></th>
			<td>
			<?php foreach ( $buttons as $button ) { ?>
				<div style="float:left;text-align:center;width:70px"><label><img style="margin-bottom:5px" src="<?php echo esc_url( $button ); ?>" alt="" /><br /><input value="<?php echo esc_url( $button ); ?>" type="radio" name="<?php echo $this->plugin->dom; ?>[button]" <?php checked( $this->settings['button'] === esc_url( $button ) ); ?> /></label></div>
			<?php } ?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Button Position', $this->plugin->dom ); ?></th>
			<td>
				<select name="<?php echo $this->plugin->dom; ?>[position]">
					<option <?php selected( $this->settings['position'] === 'top' ); ?> value="top"><?php _e( 'Beginning of post', $this->plugin->dom ); ?>&nbsp;</option>
					<option <?php selected( $this->settings['position'] === 'bottom' ); ?> value="bottom"><?php _e( 'End of post', $this->plugin->dom ); ?>&nbsp;</option>
				</select>
				<select name="<?php echo $this->plugin->dom; ?>[float]">
					<option <?php selected( $this->settings['float'] === 'right' ); ?> value="right"><?php _e( 'Floated right', $this->plugin->dom ); ?>&nbsp;</option>
					<option <?php selected( $this->settings['float'] === 'left' ); ?> value="left"><?php _e( 'Floated left', $this->plugin->dom ); ?>&nbsp;</option>
					<option <?php selected( $this->settings['float'] === 'none' ); ?> value="none"><?php _e( 'Displayed inline', $this->plugin->dom ); ?>&nbsp;</option>
				</select>
			</td>
		</tr>

		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
		<p>

		</form>

		</div>
		<?php
	}

	function meta_box( $post ) {
		?>
		<p class="howto"><?php printf( __( 'You can override the default LinkedIn Share Button settings for this %s:', $this->plugin->dom ), $post->post_type ); ?></p>
		<p><label><input type="radio" name="<?php echo $this->plugin->dom; ?>" <?php checked( !get_post_meta( $post->ID, $this->plugin->dom, true ) ); ?> value="0" /> <?php _e( 'Use the default setting', $this->plugin->dom ); ?></label><br />
		<label><input type="radio" name="<?php echo $this->plugin->dom; ?>" <?php checked( get_post_meta( $post->ID, $this->plugin->dom, true ), 'yes' ); ?> value="yes" /> <?php _e( 'Show the button', $this->plugin->dom ); ?></label><br />
		<label><input type="radio" name="<?php echo $this->plugin->dom; ?>" <?php checked( get_post_meta( $post->ID, $this->plugin->dom, true ), 'no' ); ?> value="no" /> <?php _e( 'Do not show the button', $this->plugin->dom ); ?></label></p>
		<?php
	}

	function menu() {
		add_options_page(
			__( 'LinkedIn Button Settings', $this->plugin->dom ),
			__( 'LinkedIn Button', $this->plugin->dom ),
			'manage_options',
			$this->plugin->dom,
			array( $this, 'options' )
		);
	}

	function get_buttons() {

		$buttons = array();

		if ( $d = opendir( $this->plugin->dir . '/buttons/' ) ) {
			while ( ( $button = readdir( $d ) ) !== false ) {
				if ( in_array( substr( $button, -4 ), array( '.png', '.gif' ) ) )
					$buttons[] =  $this->plugin->url . '/buttons/' . $button;
			}
			closedir( $d );
		}

		# Is there no better way to get the theme directory path?
		$themeurl = get_bloginfo('template_directory');
		$themedir = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $themeurl );

		if ( file_exists( $themedir . '/images/linkedin-button.png' ) )
			$buttons[] = $themeurl . '/images/linkedin-button.png';
		if ( file_exists( $themedir . '/images/linkedin-button.gif' ) )
			$buttons[] = $themeurl . '/images/linkedin-button.gif';

		return $buttons;

	}

	function content( $content ) {

		global $post;

		if ( !in_array( $post->post_status, array( 'publish', 'draft' ) ) )
			return $content;

		$override = get_post_meta( $post->ID, $this->plugin->dom, true );
		$show = false;

		if ( !empty( $this->settings['placement'] ) ) {
			foreach ( $this->settings['placement'] as $key => $p ) {
				if ( $p and $key() ) {
					$show = true;
					break;
				}
			}
		}

		if ( is_singular() and ( 'no' === $override ) )
			$show = false;
		if ( is_singular() and ( 'yes' === $override ) )
			$show = true;

		if ( !$show )
			return $content;

		if ( !isset( $this->settings['button'] ) )
			$this->settings['button'] = $this->plugin->url . '/buttons/01.png';

		if ( 'right' == $this->settings['float'] )
			$style = 'float:right;margin:0px 0px 10px 10px';
		else if ( 'left' == $this->settings['float'] )
			$style = 'float:left;margin:0px 10px 10px 0px';
		else
			$style = '';

		$button = '<div class="linkedin_share_container" style="' . $style . '">' . $this->button( $post->ID ) . '</div>';

		if ( 'bottom' == $this->settings['position'] )
			$content = $content . $button;
		else
			$content = $button . $content;

		return $content;

	}

	function get_the_excerpt( $post_id ) {

		# This is a clone of WordPress' wp_trim_excerpt() function without
		# the 'the_content' filter.
		# Why aren't we just using WordPress' get_the_excerpt() function?
		# http://lists.automattic.com/pipermail/wp-hackers/2010-June/032424.html

		$post = get_post( $post_id );
		$text = trim( $post->post_excerpt );

		if ( '' == $text ) {

			$text = get_the_content('');

			$text = strip_shortcodes( $text );

			/* ******************************************** */
			/* $text = apply_filters('the_content', $text); */
			$text = trim( wpautop( $text ) );
			/* ******************************************** */

			$text = str_replace(']]>', ']]&gt;', $text);
			$text = strip_tags($text);
			$excerpt_length = apply_filters('excerpt_length', 55);
			$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
			$words = explode(' ', $text, $excerpt_length + 1);
			if (count($words) > $excerpt_length) {
				array_pop($words);
				$text = implode(' ', $words);
				$text = $text . $excerpt_more;
			}
		}

		return $text;

	}

	function button( $post_id = 0, $echo = false ) {

		$this->print_js = true;

		$post    = get_post( $post_id );
		$url     = urlencode( get_permalink( $post->ID ) );
		$title   = urlencode( get_the_title( $post->ID ) );
		$summary = urlencode( $this->get_the_excerpt( $post->ID ) );
		$source  = urlencode( get_bloginfo( 'name' ) );

		$link = 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $url . '&amp;title=' . $title . '&amp;summary=' . $summary . '&amp;source=' . $source;

		$button = '<a href="' . $link . '" onclick="return popupLinkedInShare(this.href,\'console\',400,570)" class="linkedin_share_button"><img src="' . $this->settings['button'] . '" alt="" /></a>';

		if ( $echo )
			echo $button;

		return $button;

	}

	/*
		Generic plugin functionality by John Blackbourn
		20100726
	*/

	function register_plugin() {
		$this->plugin = (object) array(
			'dom' => strtolower( get_class( $this ) ),
			'url' => WP_PLUGIN_URL . '/' . basename( dirname( __FILE__ ) ),
			'dir' => WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) )
		);
		$this->settings = get_option( $this->plugin->dom );
		if ( !$this->settings ) {
			add_option( $this->plugin->dom, $this->defaults, true, true );
			$this->settings = $this->defaults;
		}
		load_plugin_textdomain(
			$this->plugin->dom, false, $this->plugin->dom
		);
		add_action( 'admin_init', array( $this, 'register_setting' ) );
	}

	function register_setting() {
		if ( $callback = method_exists( $this, 'sanitize' ) )
			$callback = array( $this, 'sanitize' );
		register_setting(
			$this->plugin->dom, $this->plugin->dom, $callback
		);
	}

}

function linkedin_button( $post_id = 0, $echo = true ) {
	return $GLOBALS['linkedinbutton']->button( $post_id, $echo );
}

$linkedinbutton = new LinkedInButton();

?>