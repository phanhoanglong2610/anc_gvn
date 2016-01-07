<?php

/******************************************************************************/
/******************************************************************************/

global $wpdb;

$themeContext='ft';
$themeOptionPrefix='ft_option';

/***/

$dummyContentFile=array
(
	array('path'=>get_template_directory().'/dummy_content/content.part0.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part1.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part2.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part3.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part4.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part5.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part6.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part7.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part8.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part9.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part10.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part11.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part12.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part13.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part14.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part15.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part16.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part17.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part18.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part19.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part20.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part21.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part22.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part23.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part24.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part25.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part26.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part27.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part28.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part29.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part30.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part31.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part32.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part33.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part34.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part35.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part36.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part37.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part38.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part39.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part40.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part41.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part42.xml'),
	array('path'=>get_template_directory().'/dummy_content/content.part43.xml')
);

if(TIPlugin::isActive('woocommerce/woocommerce.php'))
	array_push($dummyContentFile,array('path'=>get_template_directory().'/dummy_content/woocommerce.xml'));
	
TIData::set('value','dummy_content_file',$dummyContentFile);

/***/

TIData::set('value','widget_settings_file',array
(
	array('path'=>get_template_directory().'/dummy_content/widget_settings.json')
));

/***/

TIData::set('meta','post_menu',array('post_title'=>'Home - Scrolling One Page','post_type'=>'page','menu_title'=>'Scrolling One Page','meta_name'=>'menu_top'));

/***/

TIData::set('plugin_revslider','path',get_template_directory().'/dummy_content/revslider_1.zip');
TIData::set('plugin_revslider','font',array
(
	array('url'=>'Lato:600,400,300,900,400italic','handle'=>'lato'),
	array('url'=>'Handlee','handle'=>'handlee')
));

/***/

TIData::set('plugin_timetable','sql',"INSERT INTO ".$wpdb->base_prefix."event_hours(event_hours_id,event_id,weekday_id,start,end,tooltip,before_hour_text,after_hour_text,category) VALUES
(152, 512, 506, '10:30:00', '11:00:00', '', 'Learning', '', ''),
(159, 521, 502, '10:00:00', '10:30:00', '', 'Play Time', '', ''),
(153, 511, 502, '09:30:00', '10:00:00', '', 'Learning', '', ''),
(155, 512, 505, '10:30:00', '11:00:00', '', 'Learning', '', ''),
(164, 523, 506, '09:30:00', '10:30:00', '', 'Learning', 'Class Educator - Angelica Watson', ''),
(46, 507, 505, '08:00:00', '08:30:00', '', 'Arrival & Dismissal', '', ''),
(45, 507, 504, '08:00:00', '08:30:00', '', 'Arrival & Dismissal', '', ''),
(44, 507, 502, '08:00:00', '08:30:00', '', 'Arrival & Dismissal', '', ''),
(79, 511, 503, '09:30:00', '10:00:00', '', 'Learning', '', ''),
(165, 516, 503, '11:00:00', '12:30:00', '', 'Play Time', '', ''),
(161, 517, 506, '11:00:00', '12:30:00', '', 'Learning', '', ''),
(142, 513, 506, '13:00:00', '15:00:00', '', 'Play Time', 'City Zoo Trip', ''),
(109, 517, 504, '13:00:00', '14:00:00', '', 'Learning', '', ''),
(167, 513, 505, '11:00:00', '12:30:00', '', 'Play Time', '', ''),
(130, 521, 505, '08:00:00', '08:30:00', '', 'Play Time', '', ''),
(169, 522, 503, '10:30:00', '11:00:00', '', 'Learning', '', ''),
(170, 510, 504, '09:30:00', '10:15:00', '', 'Play Time', 'Whole Group', ''),
(34, 518, 502, '17:00:00', '17:30:00', '', '', '', ''),
(35, 518, 503, '17:00:00', '17:30:00', '', '', '', ''),
(127, 508, 504, '08:00:00', '08:30:00', '', 'Play Time', '', ''),
(39, 509, 502, '09:00:00', '09:30:00', '', 'Meals', '', ''),
(166, 522, 505, '09:30:00', '10:00:00', '', 'Learning', '', ''),
(40, 509, 504, '09:00:00', '09:30:00', '', 'Meals', '', ''),
(41, 509, 505, '09:00:00', '09:30:00', '', 'Meals', '', ''),
(42, 509, 503, '09:00:00', '09:30:00', '', 'Meals', '', ''),
(43, 509, 506, '09:00:00', '09:30:00', '', 'Meals', '', ''),
(47, 507, 503, '08:00:00', '08:30:00', '', 'Arrival & Dismissal', '', ''),
(48, 507, 506, '08:00:00', '08:30:00', '', 'Arrival & Dismissal', '', ''),
(150, 520, 502, '13:00:00', '14:30:00', '', 'Exercises', 'Yoga For Kids', ''),
(119, 523, 505, '08:30:00', '09:00:00', '', 'Learning', '', ''),
(131, 524, 504, '08:30:00', '09:00:00', '', 'Play Time', '', ''),
(129, 519, 503, '08:30:00', '09:00:00', '', 'Exercises', '', ''),
(94, 515, 502, '12:30:00', '13:00:00', '', 'Meals', '', ''),
(158, 508, 506, '08:00:00', '09:00:00', '', 'Play Time', 'With Special Guest Ruth Williams', ''),
(196, 845, 502, '09:00:00', '09:30:00', '', '', 'Water or Milk', ''),
(88, 523, 503, '10:00:00', '10:30:00', '', 'Learning', '', ''),
(96, 515, 504, '12:30:00', '13:00:00', '', 'Meals', '', ''),
(95, 515, 503, '12:30:00', '13:00:00', '', 'Meals', '', ''),
(149, 520, 505, '13:00:00', '14:30:00', '', 'Exercises', 'Exercises With Mike Morgan', ''),
(122, 510, 505, '10:00:00', '10:30:00', '', 'Play Time', '', ''),
(97, 515, 505, '12:30:00', '13:00:00', '', 'Meals', '', ''),
(98, 515, 506, '12:30:00', '13:00:00', '', 'Meals', '', ''),
(125, 508, 503, '08:00:00', '08:30:00', '', 'Play Time', '', ''),
(107, 514, 504, '14:00:00', '15:00:00', '', 'Learning', '', ''),
(108, 514, 503, '14:00:00', '15:00:00', '', 'Learning', '', ''),
(110, 517, 503, '13:00:00', '14:00:00', '', 'Learning', '', ''),
(168, 513, 503, '11:00:00', '12:30:00', '', 'Play Time', '', ''),
(157, 508, 502, '08:00:00', '09:00:00', '', 'Play Time', 'Individual Welcome, Self Activities', ''),
(163, 522, 504, '10:30:00', '12:30:00', '', 'Learning', 'Class Educator - Marta Smith', ''),
(198, 856, 506, '15:00:00', '15:15:00', '', '', 'Water and Yoghurt', ''),
(195, 846, 503, '09:00:00', '09:30:00', '', '', 'Water or Milk', ''),
(194, 847, 504, '09:00:00', '09:30:00', '', '', 'Water or Milk', ''),
(211, 849, 502, '12:30:00', '13:00:00', '', '', 'Apple and Cheese, Water, Puree Vegies', ''),
(209, 851, 504, '12:30:00', '13:00:00', '', '', 'Apple and Cheese, Water, Puree Vegies', ''),
(204, 858, 503, '16:00:00', '16:15:00', '', '', 'Water or Juice', ''),
(203, 858, 505, '16:00:00', '16:15:00', '', '', 'Water or Juice', ''),
(201, 853, 502, '15:00:00', '15:15:00', '', '', 'Water and Yoghurt', ''),
(200, 854, 503, '15:00:00', '15:15:00', '', '', 'Water and Yoghurt', ''),
(199, 855, 504, '15:00:00', '15:15:00', '', '', 'Water and Yoghurt', ''),
(210, 851, 506, '12:30:00', '13:00:00', '', '', 'Apple and Cheese, Water, Puree Vegies', ''),
(208, 852, 505, '12:30:00', '13:00:00', '', '', 'Apple and Cheese, Water, Puree Vegies', ''),
(206, 857, 506, '16:00:00', '16:15:00', '', '', 'Water or Juice', ''),
(205, 857, 502, '16:00:00', '16:15:00', '', '', 'Water or Juice', ''),
(192, 850, 503, '12:30:00', '13:00:00', '', '', 'Apple and Cheese, Water, Puree Vegies', ''),
(193, 848, 506, '09:00:00', '09:30:00', '', '', 'Water or Milk', ''),
(197, 845, 505, '09:00:00', '09:30:00', '', '', 'Water or Milk', ''),
(202, 853, 505, '15:00:00', '15:15:00', '', '', 'Water and Yoghurt', ''),
(207, 857, 504, '16:00:00', '16:15:00', '', '', 'Water or Juice', '')");

/***/


TIData::set('post_id',$themeOptionPrefix.'_widget_area_sidebar_woocommerce',array('title'=>'Shop','postType'=>$themeContext.'_widget_area'));

TIData::set('post_id',$themeOptionPrefix.'_widget_area_footer',array('title'=>'Footer','postType'=>$themeContext.'_widget_area'));
TIData::set('post_id',$themeOptionPrefix.'_widget_area_footer_woocommerce',array('title'=>'Footer','postType'=>$themeContext.'_widget_area'));

TIData::set('term_id',$themeOptionPrefix.'_menu_top',array('title'=>'Main','taxonomy'=>'nav_menu'));
TIData::set('term_id',$themeOptionPrefix.'_menu_top_woocommerce',array('title'=>'Main','taxonomy'=>'nav_menu'));

TIData::set('path',$themeOptionPrefix.'_header_background_image_src',array('title'=>'pattern','postType'=>'attachment'));

/***/

TIData::set('post_id',$themeOptionPrefix.'_blog_category_post_id',array('title'=>'Blog Right Sidebar','postType'=>'page'));
TIData::set('post_id',$themeOptionPrefix.'_blog_archive_post_id',array('title'=>'Blog Right Sidebar','postType'=>'page'));
TIData::set('post_id',$themeOptionPrefix.'_blog_search_post_id',array('title'=>'Blog Right Sidebar','postType'=>'page'));
TIData::set('post_id',$themeOptionPrefix.'_blog_author_post_id',array('title'=>'Blog Right Sidebar','postType'=>'page'));

/***/

TIData::set('post_id',$themeOptionPrefix.'_maintenance_mode_post_id',array('title'=>'Maintenance Mode','postType'=>'page'));

/***/

TIData::set('post_id',$themeOptionPrefix.'_page_404_page_id',array('title'=>'Page Not Found','postType'=>'page'));

/***/

TIData::set('path',$themeOptionPrefix.'_footer_top_background_image_src',array('title'=>'pattern','postType'=>'attachment'));

/***/

TIData::set('path',$themeOptionPrefix.'_menu_logo_src',array('title'=>'logo','postType'=>'attachment'));

/***/	

TIData::set('post_id','page_on_front',array('title'=>'Home Style I','postType'=>'page'));

TIData::set('option','show_on_front','page');
TIData::set('option','posts_per_page',5);
TIData::set('option','thread_comments',1);
TIData::set('option','thread_comments_depth',2);
TIData::set('option','page_comments',1);
TIData::set('option','comments_per_page',5);
TIData::set('option','permalink_structure','/%postname%/');

TIData::set('option','show_avatars',1);
TIData::set('option','avatar_default','mystery');

TIData::set('option','date_format','F d, Y');

TIData::set('option','blogname','Fable - Children Kindergarten WordPress Theme');
TIData::set('option','blogdescription','');

/******************************************************************************/
/******************************************************************************/