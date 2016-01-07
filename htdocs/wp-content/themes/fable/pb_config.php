<?php

/******************************************************************************/
/******************************************************************************/

PBData::set('component',array
(
	'accordion'				=>	array(),
	'audio'					=>	array(),
	'background_video'		=>	array(),
	'blockquote'			=>	array(),
	'box'					=>	array(),
	'button'				=>	array(),
	'call_to_action'		=>	array(),
	'class'					=>	array(),
	'contact_form'			=>	array(),
	'counter_box'			=>	array(),
	'counter_list'			=>	array(),
	'divider'				=>	array(),
	'dropcap'				=>	array(),
	'feature'				=>	array(),
	'flex_slider'			=>	array(),
	'gallery'				=>	array(),
	'google_map'			=>	array(),
	'header'				=>	array(),
	'header_subheader'		=>	array(),
	'iframe'				=>	array(),
	'layout'				=>	array(),
	'layout_column'			=>	array(),
	'list'					=>	array(),
	'menu'					=>	array(),
	'nivo_slider'			=>	array(),
	'notice'				=>	array(),
	'preformatted_text'		=>	array(),
	'pricing_plan'			=>	array(),
	'recent_post'			=>	array(),
	'redirect'				=>	array(),
	'screen_preloader'		=>	array(),
	'sitemap'				=>	array(),
	'social_icon'			=>	array(),
	'space'					=>	array(),
	'supersized'			=>	array(),
	'tab'					=>	array(),
	'team'					=>	array(),
	'testimonial'			=>	array(),
	'text'					=>	array(),
	'twitter_user_timeline'	=>	array(),
	'vertical_grid'			=>	array(),
	'video'					=>	array(),
	'zaccordion'			=>	array(),
));

PBData::set('visual_mode',1);

PBData::set('retina_ready',1);

PBData::set('content_width',1050);

PBData::set('responsive_mode',array(1050,960,768,480));

PBData::set('media_library_url_field_enable',1);
PBData::set('media_library_video_url_field_enable',1);

PBData::set('remove_style',array('font-awesome'));

/******************************************************************************/

$path='/multisite/'.get_current_blog_id().'/style/';

PBData::set('theme_path_multisite_style',get_template_directory().$path);
PBData::set('theme_url_multisite_style',get_template_directory_uri().$path);

/******************************************************************************/

PBComponentData::set('accordion','header_important_default','6');

/******************************************************************************/

PBComponentData::set('button','icon_path',get_template_directory().'/media/image/public/icon_feature/tiny/');
PBComponentData::set('button','icon_url',get_template_directory_uri().'/media/image/public/icon_feature/tiny/');
PBComponentData::set('button','icon_url_retina',get_template_directory_uri().'/media/image/public/2x/icon_feature/tiny/');

/******************************************************************************/

PBComponentData::set('box','icon',array
(
	'small'		=>	array
	(
		'label'			=>	__('Small',PLUGIN_PAGE_BUILDER_DOMAIN),
		'path'			=>	get_template_directory().'/media/image/public/icon_feature/small/',
		'url'			=>	get_template_directory_uri().'/media/image/public/icon_feature/small/',
		'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_feature/small/'
	),
	'medium'	=>	array
	(
		'label'			=>	__('Medium',PLUGIN_PAGE_BUILDER_DOMAIN),
		'path'			=>	get_template_directory().'/media/image/public/icon_feature/medium/',
		'url'			=>	get_template_directory_uri().'/media/image/public/icon_feature/medium/',
		'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_feature/medium/'
	),
	'large'		=>	array
	(
		'label'			=>	__('Large',PLUGIN_PAGE_BUILDER_DOMAIN),
		'path'			=>	get_template_directory().'/media/image/public/icon_feature/large/',
		'url'			=>	get_template_directory_uri().'/media/image/public/icon_feature/large/',
		'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_feature/large/'
	)
));

PBComponentData::set('box','icon_size_default','medium');
PBComponentData::set('box','header_important_default','4');

/******************************************************************************/

PBComponentData::set('call_to_action','first_line_header_important_default','4');
PBComponentData::set('call_to_action','second_line_header_important_default','6');

/******************************************************************************/

PBComponentData::set('counter_box','header_important_default','5');

/******************************************************************************/

PBComponentData::set('feature','icon',array
(
	'small'		=>	array
	(
		'label'			=>	__('Small',PLUGIN_PAGE_BUILDER_DOMAIN),
		'path'			=>	get_template_directory().'/media/image/public/icon_feature/small/',
		'url'			=>	get_template_directory_uri().'/media/image/public/icon_feature/small/',
		'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_feature/small/'
	),
	'medium'	=>	array
	(
		'label'			=>	__('Medium',PLUGIN_PAGE_BUILDER_DOMAIN),
		'path'			=>	get_template_directory().'/media/image/public/icon_feature/medium/',
		'url'			=>	get_template_directory_uri().'/media/image/public/icon_feature/medium/',
		'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_feature/medium/'
	),
	'large'		=>	array
	(
		'label'			=>	__('Large',PLUGIN_PAGE_BUILDER_DOMAIN),
		'path'			=>	get_template_directory().'/media/image/public/icon_feature/large/',
		'url'			=>	get_template_directory_uri().'/media/image/public/icon_feature/large/',
		'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_feature/large/'
	)
));

PBComponentData::set('feature','icon_size_default','medium');
PBComponentData::set('feature','header_important_default','5');

PBComponentData::set('feature','icon_type','gr');

/******************************************************************************/

PBComponentData::set('gallery','image_default','image-1050-770');
PBComponentData::set('gallery','image_hover_type_default','fade');
PBComponentData::set('gallery','image_text_caption_header_tag','h6');

/******************************************************************************/

PBComponentData::set('list','bullet',array
(
	'url'			=>	get_template_directory_uri().'/media/image/public/icon_bullet/',
	'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_bullet/',
	'path'			=>	get_template_directory().'/media/image/public/icon_bullet/',
	'css_class'		=>	''	
));

PBComponentData::set('list','icon_type','gr');

/******************************************************************************/

PBComponentData::set('menu','responsive_menu_default','768');

PBComponentData::set('menu','icon_path',get_template_directory().'/media/image/public/icon_menu/');
PBComponentData::set('menu','icon_url',get_template_directory_uri().'/media/image/public/icon_menu/');
PBComponentData::set('menu','icon_url_retina',get_template_directory_uri().'/media/image/public/2x/icon_menu/');

/******************************************************************************/

PBComponentData::set('nivo_slider','image_default','image-1050-770');

/******************************************************************************/

PBComponentData::set('flex_slider','image_default','image-1050-770');

/******************************************************************************/

PBComponentData::set('notice','first_line_header_important_default','6');

PBComponentData::set('notice','icon_path',get_template_directory().'/media/image/public/icon_feature/small/');
PBComponentData::set('notice','icon_url',get_template_directory_uri().'/media/image/public/icon_feature/small/');
PBComponentData::set('notice','icon_url_retina',get_template_directory_uri().'/media/image/public/2x/icon_feature/small/');

/******************************************************************************/

PBComponentData::set('pricing_plan','bullet',array
(
	'url'			=>	get_template_directory_uri().'/media/image/public/icon_bullet/',
	'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_bullet/',
	'path'			=>	get_template_directory().'/media/image/public/icon_bullet/'
));

/******************************************************************************/

PBComponentData::set('recent_post','image_default','image-525-315');
PBComponentData::set('recent_post','image_hover_type_default','fade');

PBComponentData::set('recent_post','template_default','2');
PBComponentData::set('recent_post','header_important_default','5');

/******************************************************************************/

PBComponentData::set('social_icon','icon_path',get_template_directory().'/media/image/public/icon_social/');
PBComponentData::set('social_icon','icon_url',get_template_directory_uri().'/media/image/public/icon_social/');
PBComponentData::set('social_icon','icon_url_retina',get_template_directory_uri().'/media/image/public/2x/icon_social/');

PBComponentData::set('social_icon','icon_type','gr');

/******************************************************************************/

PBComponentData::set('sitemap','bullet',array
(
	'url'			=>	get_template_directory_uri().'/media/image/public/icon_bullet/',
	'url_retina'	=>	get_template_directory_uri().'/media/image/public/2x/icon_bullet/',
	'path'			=>	get_template_directory().'/media/image/public/icon_bullet/'
));

PBComponentData::set('sitemap','icon_type','gr');

/******************************************************************************/

PBComponentData::set('team','image_default','image-525-560');
PBComponentData::set('team','image_hover_type_default','fade');
PBComponentData::set('team','image_text_caption_header_tag','h6');

PBComponentData::set('team','social_icon_path',get_template_directory().'/media/image/public/icon_social/');
PBComponentData::set('team','social_icon_url',get_template_directory_uri().'/media/image/public/icon_social/');
PBComponentData::set('team','social_icon_url_retina',get_template_directory_uri().'/media/image/public/2x/icon_social/');

/******************************************************************************/

PBComponentData::set('zaccordion','image_default','image-1050-770');

/******************************************************************************/

PBData::set('css_class',array
(
	array('value'=>'pb-top-0','description'=>'Reset top margin'),
	array('value'=>'pb-bottom-0','description'=>'Reset top margin'),
	array('value'=>'pb-margin-top-0','description'=>'Set a 0px top margin'),
	array('value'=>'pb-margin-top-10','description'=>'Set a 10px top margin'),
	array('value'=>'pb-margin-top-20','description'=>'Set a 20px top margin'),
	array('value'=>'pb-margin-top-30','description'=>'Set a 30px top margin'),
	array('value'=>'pb-margin-top-40','description'=>'Set a 40px top margin'),
	array('value'=>'pb-margin-top-50','description'=>'Set a 50px top margin'),
	array('value'=>'pb-margin-top-60','description'=>'Set a 60px top margin'),
	array('value'=>'pb-margin-top-70','description'=>'Set a 70px top margin'),
	array('value'=>'pb-margin-top-80','description'=>'Set a 80px top margin'),
	array('value'=>'pb-margin-top-90','description'=>'Set a 90px top margin'),
	array('value'=>'pb-margin-top-100','description'=>'Set a 100px top margin'),
	array('value'=>'pb-margin-bottom-0','description'=>'Set a 0px bottom margin'),
	array('value'=>'pb-margin-bottom-10','description'=>'Set a 10px bottom margin'),
	array('value'=>'pb-margin-bottom-20','description'=>'Set a 20px bottom margin'),
	array('value'=>'pb-margin-bottom-30','description'=>'Set a 30px bottom margin'),
	array('value'=>'pb-margin-bottom-40','description'=>'Set a 40px bottom margin'),
	array('value'=>'pb-margin-bottom-50','description'=>'Set a 50px bottom margin'),
	array('value'=>'pb-margin-bottom-60','description'=>'Set a 60px bottom margin'),
	array('value'=>'pb-margin-bottom-70','description'=>'Set a 70px bottom margin'),
	array('value'=>'pb-margin-bottom-80','description'=>'Set a 80px bottom margin'),
	array('value'=>'pb-margin-bottom-90','description'=>'Set a 90px bottom margin'),
	array('value'=>'pb-margin-bottom-100','description'=>'Set a 100px bottom margin'),
	array('value'=>'pb-margin-left-0','description'=>'Set a 0px left margin'),
	array('value'=>'pb-margin-left-10','description'=>'Set a 10px left margin'),
	array('value'=>'pb-margin-left-20','description'=>'Set a 20px left margin'),
	array('value'=>'pb-margin-left-30','description'=>'Set a 30px left margin'),
	array('value'=>'pb-margin-left-40','description'=>'Set a 40px left margin'),
	array('value'=>'pb-margin-left-50','description'=>'Set a 50px left margin'),
	array('value'=>'pb-margin-left-60','description'=>'Set a 60px left margin'),
	array('value'=>'pb-margin-left-70','description'=>'Set a 70px left margin'),
	array('value'=>'pb-margin-left-80','description'=>'Set a 80px left margin'),
	array('value'=>'pb-margin-left-90','description'=>'Set a 90px left margin'),
	array('value'=>'pb-margin-left-100','description'=>'Set a 100px left margin'),
	array('value'=>'pb-margin-right-0','description'=>'Set a 0px right margin'),
	array('value'=>'pb-margin-right-10','description'=>'Set a 10px right margin'),
	array('value'=>'pb-margin-right-20','description'=>'Set a 20px right margin'),
	array('value'=>'pb-margin-right-30','description'=>'Set a 30px right margin'),
	array('value'=>'pb-margin-right-40','description'=>'Set a 40px right margin'),
	array('value'=>'pb-margin-right-50','description'=>'Set a 50px right margin'),
	array('value'=>'pb-margin-right-60','description'=>'Set a 60px right margin'),
	array('value'=>'pb-margin-right-70','description'=>'Set a 70px right margin'),
	array('value'=>'pb-margin-right-80','description'=>'Set a 80px right margin'),
	array('value'=>'pb-margin-right-90','description'=>'Set a 90px right margin'),
	array('value'=>'pb-margin-right-100','description'=>'Set a 100px right margin'),
	array('value'=>'pb-position-absolute','description'=>'Set element absolute'),
	array('value'=>'pb-position-relative','description'=>'Set element relative'),
	array('value'=>'pb-float-left','description'=>'Add left float'),
	array('value'=>'pb-float-right','description'=>'Add right float'),
	array('value'=>'theme-section-padding-top','description'=>'Add default (80px) top padding to the layout'),
	array('value'=>'theme-section-padding-bottom','description'=>'Add default (80px) bottom padding to the layout'),
	array('value'=>'theme-section-white','description'=>'Create selected component in white version')
));

/******************************************************************************/