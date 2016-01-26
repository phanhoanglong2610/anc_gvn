<?php
/******************************************************************************/
/******************************************************************************/

require_once('include.php');

load_theme_textdomain(THEME_DOMAIN,THEME_PATH.'languages/');

$Theme=new Theme();

if(is_admin()) require_once('admin/functions.php');
else require_once('public/functions.php');

add_action('after_setup_theme',array($Theme,'setupTheme'));
add_action('switch_theme',array($Theme,'switchTheme'));

function add_search_to_wp_menu ( $items, $args ) {
		$items .= '<li class="menu-item menu-item-search">';
		$items .= '<form method="get" class="menu-search-form" action="' . get_bloginfo('home') . '/">';
		// $items .= '<label style="font-style:italic" class="screen-reader-text" for="s">' . _x( 'Tìm kiếm thông tin', 'label' ) . '</label>';
		$items .= '<p><input class="text_input" type="text" value="Tìm kiếm thông tin" name="s" id="rs" onfocus="if (this.value == \'Tìm kiếm thông tin\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'Tìm kiếm thông tin\';}" /><input type="submit" class="my-wp-search" id="searchsubmit" value="Tìm kiếm" /></p></form>';
		$items .= '</li>';
	return $items;
}

add_filter('wp_nav_menu_items','add_search_to_wp_menu',10,2);



/******************************************************************************/
/******************************************************************************/