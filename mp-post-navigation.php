<?php
/*
Plugin Name: MP Post Navigation Same Category
Plugin URI: https://manipovore.com/labo/mp-post-navigation-same-category/
Description: Adds navigation links on a post to the previous or next post of the same current category.
Version: 2.0
Author: Benjamin oliveira
Author URI: https://manipovore.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

class MP_Post_Navigation {

	public function __construct() {
		add_action( 'wp_print_styles', array( $this, 'mp_post_navigation_stylesheet') );
		add_action( 'the_content', array( $this, 'mp_post_navigation_links') );
	}

	public function mp_post_navigation_stylesheet() {
		wp_deregister_style('wp_single_post_navigation');
		wp_register_style('wp_single_post_navigation', plugins_url('/css/mp-single-post-navigation.css', __FILE__), false, '1.0', 'screen');
		wp_enqueue_style( 'wp_single_post_navigation' );
	}

	public function mp_post_navigation_links($post) {
		if ( is_single() ) {
		return $post.self::mp_post_navigation_render_nav();
		}else{
			return $post;
		}
	}

	public static function mp_post_navigation_render_nav(){

		$next_title = get_next_post()->post_title;
		$previous_title = get_previous_post()->post_title;
		$size_title = 55;

		$next_post_title = strlen($next_title) > $size_title ? substr_replace($next_title, ' ...', $size_title) : $next_title;
		$previous_post_title = strlen($previous_title) > $size_title ? substr_replace($previous_title, ' ...', $size_title) : $previous_title;

		$next = '<div id="mpn-nextpost">'.get_next_post_link( '%link', '<span>&raquo;</span>' . $next_post_title, true ).'</div>';
		$previous = '<div id="mpn-prevpost">'.get_previous_post_link( '%link', '<span>&laquo;</span>' . $previous_post_title, true ).'</div>';

		return '<div class="mpn-container">' . $previous . $next  . '</div>';
	}

}

new MP_Post_Navigation();

?>