<?php

		/**
		 * Show error messages
		 *
		 * @author 		WooThemes
		 * @package 	WooCommerce/Templates
		 * @version     1.6.4
		 */

		if(!defined('ABSPATH')) exit;
		if(!$messages) return;

		$secondLine=null;

		foreach ($messages as $message)
		{
			if(!is_null($secondLine)) $secondLine.='<br>';
			$secondLine.=$message;
		}

		$shortcode=
		'
			[pb_notice icon="speaker_alt.png" icon_bg_color="ED2B2B" css_class="pb-margin-bottom-50"]
			[pb_notice_first_line]'.__('Error',THEME_DOMAIN).'[/pb_notice_first_line]
			[pb_notice_second_line]'.$secondLine.'[/pb_notice_second_line]
			[/pb_notice]		
		';
		
		echo do_shortcode($shortcode);