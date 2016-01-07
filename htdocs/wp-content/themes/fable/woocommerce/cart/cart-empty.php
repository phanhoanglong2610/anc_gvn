<?php

		/**
		 * Empty cart page
		 *
		 * @author 		WooThemes
		 * @package 	WooCommerce/Templates
		 * @version     2.0.0
		 */

		if(!defined('ABSPATH')) exit;
		
		wc_print_notices();

		$shortcode=
		'
			[pb_notice icon="speaker_alt.png" icon_bg_color="ED2B2B" css_class="pb-margin-bottom-30"]
			[pb_notice_first_line]'.__('Cart',THEME_DOMAIN).'[/pb_notice_first_line]
			[pb_notice_second_line]'.__('Your cart is currently empty.','woocommerce').'&nbsp;<a href="'.apply_filters('woocommerce_return_to_shop_redirect',get_permalink(wc_get_page_id('shop'))).'">'.__('Return to shop',THEME_DOMAIN).'</a>[/pb_notice_second_line]
			[/pb_notice]		
		';
		
		echo do_shortcode($shortcode);