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

/******************************************************************************/
/******************************************************************************/