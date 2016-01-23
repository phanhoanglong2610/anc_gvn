<?php

/**
 * Contains functions responsible for functionality at front-end of website
 *
 * @since      1.0.0
 *
 */

/**
 * This class defines all code necessary for functionality at front-end of website
 *
 * @since      1.0.0
 *
 */
class Sassy_Social_Share_Public {

	/**
	 * Options saved in database.
	 *
	 * @since    1.0.0
	 */
	private $options;

	/**
	 * Current version of the plugin.
	 *
	 * @since    1.0.0
	 */
	private $version;

	/**
	 * Variable to track number of times 'the_content' hook called at homepage.
	 *
	 * @since    1.0.0
	 */
	private $vertical_home_count = 0;

	/**
	 * Variable to track number of times 'the_content' hook called at excerpts.
	 *
	 * @since    1.0.0
	 */
	private $vertical_excerpt_count = 0;

	/**
	 * Short urls calculated for current webpage.
	 *
	 * @since    1.0.0
	 */
	private $short_urls = array();

	/**
	 * Get saved options.
	 *
	 * @since    1.0.0
     * @param    array    $options    Plugin options saved in database
	 */
	public function __construct( $options, $version ) {

		$this->options = $options;
		$this->version = $version;

	}

	/**
	 * Hook the plugin function on 'init' event.
	 *
	 * @since    1.0.0
	 */
	public function init() {

		// Javascripts for front-end of website
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		// stylesheets for front-end of website
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ) );
	
	}

	/**
	 * Javascript files to load at front end.
	 *
	 * @since    1.0.0
	 */
	public function frontend_scripts() {

		$in_footer = isset( $this->options['footer_script'] ) ? true : false;
		?>
		<script type="text/javascript">function heateorSssLoadEvent(e){var t=window.onload;if(typeof window.onload!="function"){window.onload=e}else{window.onload=function(){t();e()}}}</script>
		<?php
		global $post;
		$sharing_meta = get_post_meta( $post->ID, '_heateor_sss_meta', true );
		if ( is_front_page() || ! isset( $sharing_meta['sharing'] ) || $sharing_meta['sharing'] != 1 || ! isset( $sharing_meta['vertical_sharing'] ) || $sharing_meta['vertical_sharing'] != 1 ) {
			?>
			<script> var heateorSssSharingAjaxUrl = '<?php echo get_admin_url() ?>admin-ajax.php', heateorSssCloseIconPath = '<?php echo plugins_url( '../images/close.png', __FILE__ ) ?>', heateorSssPluginIconPath = '<?php echo plugins_url( '../images/logo.png', __FILE__ ) ?>', heateorSssHorizontalSharingCountEnable = <?php echo isset( $this->options['hor_enable'] ) && ( isset( $this->options['horizontal_counts'] ) || isset( $this->options['horizontal_total_shares'] ) ) ? 1 : 0 ?>, heateorSssVerticalSharingCountEnable = <?php echo isset( $this->options['vertical_enable'] ) && ( isset( $this->options['vertical_counts'] ) || isset( $this->options['vertical_total_shares'] ) ) ? 1 : 0 ?>, heateorSssSharingOffset = <?php echo isset( $this->options['alignment'] ) && $this->options['alignment'] != '' && isset( $this->options[$this->options['alignment'].'_offset'] ) && $this->options[$this->options['alignment'].'_offset'] != '' ? $this->options[$this->options['alignment'].'_offset'] : 0; ?>;
			<?php
			if ( isset( $this->options['horizontal_counts'] ) && isset( $this->options['horizontal_counter_position'] ) ) {
				echo in_array( $this->options['horizontal_counter_position'], array( 'inner_left', 'inner_right' ) ) ? 'var heateorSssReduceHorizontalSvgWidth = true;' : '';
				echo in_array( $this->options['horizontal_counter_position'], array( 'inner_top', 'inner_bottom' ) ) ? 'var heateorSssReduceHorizontalSvgHeight = true;' : '';
			}
			if ( isset( $this->options['vertical_counts'] ) ) {
				echo isset( $this->options['vertical_counter_position'] ) && in_array( $this->options['vertical_counter_position'], array( 'inner_left', 'inner_right' ) ) ? 'var heateorSssReduceVerticalSvgWidth = true;' : '';
				echo ! isset( $this->options['vertical_counter_position'] ) || in_array( $this->options['vertical_counter_position'], array( 'inner_top', 'inner_bottom' ) ) ? 'var heateorSssReduceVerticalSvgHeight = true;' : '';
			}
			?>
			var heateorSssUrlCountFetched = '';
			function heateorSssPopup(e){window.open(e,"popUpWindow","height=400,width=600,left=400,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes")}
			</script>
			<?php
			if ( $this->facebook_like_recommend_enabled() ) {
				?>
				<script type="text/javascript">
				function heateorSssInitiateFB(){FB.init({appId:"",channelUrl:"",status:!0,cookie:!0,xfbml:!0,version:"v2.4"})}window.fbAsyncInit=function(){heateorSssInitiateFB(),<?php echo defined( 'HEATEOR_SOCIAL_SHARE_MYCRED_INTEGRATION_VERSION' ) && $this->facebook_like_recommend_enabled() ? 1 : 0 ?>&&(FB.Event.subscribe("edge.create",function(e){heateorSsmiMycredPoints("Facebook_like_recommend","",e?e:"")}),FB.Event.subscribe("edge.remove",function(e){heateorSsmiMycredPoints("Facebook_like_recommend","",e?e:"","Minus point(s) for undoing Facebook like-recommend")})),<?php echo defined( 'HEATEOR_SHARING_GOOGLE_ANALYTICS_VERSION' ) ? 1 : 0 ?>&&(FB.Event.subscribe("edge.create",function(e){heateorSsgaSocialPluginsTracking("Facebook","Like",e?e:"")}),FB.Event.subscribe("edge.remove",function(e){heateorSsgaSocialPluginsTracking("Facebook","Unlike",e?e:"")}))},function(e){var n,i="facebook-jssdk",o=e.getElementsByTagName("script")[0];e.getElementById(i)||(n=e.createElement("script"),n.id=i,n.async=!0,n.src="//connect.facebook.net/<?php echo $this->options['language'] ? $this->options['language'] : 'en_US' ?>/sdk.js",o.parentNode.insertBefore(n,o))}(document);
				</script>
				<?php
			}
			wp_enqueue_script( 'heateor_sss_sharing_js', plugins_url( 'js/sassy-social-share-public.js', __FILE__ ), array( 'jquery' ), $this->version, $in_footer );
		}
	
	}

	/**
	 * Check if Facebook Like/Recommend is enabled
	 *
	 * @since    1.0.0
	 */
	private function facebook_like_recommend_enabled() {
		
		if ( ( isset( $this->options['hor_enable'] ) && isset( $this->options['horizontal_re_providers'] ) && ( in_array( 'facebook_like', $this->options['horizontal_re_providers'] ) || in_array( 'facebook_recommend', $this->options['horizontal_re_providers'] ) ) ) || ( isset( $this->options['vertical_enable'] ) && isset( $this->options['vertical_re_providers'] ) && ( in_array( 'facebook_like', $this->options['vertical_re_providers'] ) || in_array( 'facebook_recommend', $this->options['vertical_re_providers'] ) ) ) ) {
			return true;
		}

		return false;

	}

	/**
	 * Generate bitly short url for sharing buttons
	 *
	 * @since    1.0.0
	 */
	public function generate_bitly_url( $url, $post_id = 0 ) {
	    
	    $bitlyUrl = get_post_meta( $post_id, '_heateor_sss_bitly_url', true );
	    if ( $bitlyUrl ) {
	    	return $bitlyUrl;
	    } else {
		    //generate the URL
		    $bitly = 'http://api.bit.ly/v3/shorten?format=txt&login=' . $this->options['bitly_username'] . '&apiKey=' . $this->options['bitly_key'] . '&longUrl=' . urlencode( $url );
			$response = wp_remote_get( $bitly,  array( 'timeout' => 15 ) );
			if ( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ) {
				$short_url = trim( wp_remote_retrieve_body( $response ) );
				update_post_meta( $post_id, '_heateor_sss_bitly_url', $short_url );
				return $short_url;
			}
		}
		return false;

	}

	/**
	 * Get short url.
	 *
	 * @since    1.0.0
	 */
	public function get_short_url( $url, $post_id ) {

		$short_url = '';
		
		if ( isset( $this->short_urls[$url] ) ) {
			// short url already calculated for this post ID
			$short_url = $this->short_urls[$url];
		} elseif ( isset( $this->options['use_shortlinks'] ) && function_exists( 'wp_get_shortlink' ) ) {
			$short_url = wp_get_shortlink();
			if ( $short_url ) {
				$this->short_urls[$url] = $short_url;
			}
			// if bit.ly integration enabled, generate bit.ly short url
		} elseif ( isset( $this->options['bitly_enable'] ) && $this->options['bitly_username'] != '' && $this->options['bitly_key'] != '' ) {
			$short_url = $this->generate_bitly_url( $url, $post_id );
			if ( $short_url ) {
				$this->short_urls[$url] = $short_url;
			}
		}

		return $short_url;

	}

	/**
	 * Render sharing interface html.
	 *
	 * @since    1.0.0
	 */
	public function prepare_sharing_html( $post_url, $sharing_type = 'horizontal', $display_count, $total_shares ) {
	
		global $post;

		if ( $sharing_type == 'vertical' && ( is_front_page() || is_home() ) ) {
			$post_title = wp_title( '', false );
			if ( $post_title == '' ) {
				$post_title = get_bloginfo( 'name' ) . " - " . get_bloginfo( 'description' );
			}
		} else {
			$post_title = $post->post_title;
		}
		$post_title = html_entity_decode( $post_title, ENT_QUOTES, 'UTF-8' );
	    $post_title = urlencode( $post_title );
	    $post_title = str_replace( '#', '%23', $post_title );
	    $post_title = esc_html( $post_title );

		$output = apply_filters( 'heateor_sss_sharing_interface_filter', '', $post_url, $sharing_type, $this->options, $post, $display_count, $total_shares );
		if ( $output != '' ) {
			return $output;
		}
		$html = '';
		$sharing_meta = '';
		if (! is_front_page() || ( is_front_page() && 'page' == get_option( 'show_on_front' ) ) ) {
			$sharing_meta = get_post_meta( $post->ID, '_heateor_sss_meta', true );
		}

		if ( isset( $this->options[$sharing_type.'_re_providers'] ) ) {

			$sharing_networks_object = new Sassy_Social_Share_Sharing_Networks();
			
			$sharing_networks = $sharing_networks_object->fetch_sharing_networks();

			$html = '<ul ' . ( $sharing_type == 'horizontal' && $this->options['hor_sharing_alignment'] == "center" ? "style='list-style: none;position: relative;left: 50%;'" : "" ) .' class="heateor_sss_sharing_ul">';
			$style = 'style="width:' . ( $this->options[$sharing_type . '_sharing_shape'] != 'rectangle' ? $this->options[$sharing_type . '_sharing_size'] : $this->options[$sharing_type . '_sharing_width'] ) . 'px;height:' . ( $this->options[$sharing_type . '_sharing_shape'] != 'rectangle' ? $this->options[$sharing_type . '_sharing_size'] : $this->options[$sharing_type . '_sharing_height'] ) . 'px;';
			$counter_container_init_html = '<ss class="heateor_sss_square_count';
			$counter_container_end_html = '</ss>';
			$inner_style = 'display:block;';
			$li_class = 'heateorSssSharingRound';
			if ( $this->options[$sharing_type . '_sharing_shape'] == 'round' ) {
				$style .= 'border-radius:999px;';
				$inner_style .= 'border-radius:999px;';
			} elseif ( $this->options[$sharing_type . '_border_radius'] != '' ) {
				$style .= 'border-radius:' . $this->options[$sharing_type . '_border_radius'] . 'px;';
			}
			if ( $sharing_type == 'vertical' && $this->options[$sharing_type . '_sharing_shape'] == 'square' ) {
				$style .= 'margin:0;';
				$li_class = '';
			}
			$style .= '"';
			$li_items = '';
			$language = $this->options['language'] != '' ? $this->options['language'] : '';
			$like_button_count_container = '';
			if ( $display_count ) {
				$like_button_count_container = $counter_container_init_html . '">&nbsp;' . $counter_container_end_html;
			}

			$counter_placeholder = '';
			$counter_placeholder_value = '';

			if ( $display_count ) {
				if ( ! isset( $this->options[$sharing_type . '_counter_position'] ) ) {
					$counter_position = $sharing_type == 'horizontal' ? 'top' : 'inner_top';
				} else {
					$counter_position = $this->options[$sharing_type . '_counter_position'];
				}
				
				switch ( $counter_position ) {
					case 'left':
					case 'top':
						$counter_placeholder = '><i';
						break;
					case 'right':
					case 'bottom':
						$counter_placeholder = 'i><';
						break;
					case 'inner_left':
					case 'inner_top':
						$counter_placeholder = '><ss';
						break;
					case 'inner_right':
					case 'inner_bottom':
						$counter_placeholder = 'ss><';
						break;
					default:
				}
				$counter_placeholder_value = str_replace( '>', '>' . $counter_container_init_html . ' heateor_sss_%network%_count">&nbsp;' . $counter_container_end_html, $counter_placeholder );
			}
			
			$twitter_username = $this->options['twitter_username'] != '' ? $this->options['twitter_username'] : '';

			foreach ( $this->options[$sharing_type.'_re_providers'] as $provider ) {
				//var_dump($twitter_username);
				$li_items .= str_replace(
					array(
						'%padding%',
						'%network%',
						'%ucfirst_network%',
						'%like_count_container%',
						'%post_url%',
						'%post_title%',
						'%decoded_post_title%',
						'%twitter_username%',
						'%via_twitter_username%',
						'%language%',
						'%buffer_username%',
						'%style%',
						'%inner_style%',
						'%li_class%',
						$counter_placeholder,
						'%title%'
					),
					array(
						( $this->options[$sharing_type . '_sharing_shape'] == 'rectangle' ? $this->options[$sharing_type . '_sharing_height'] : $this->options[$sharing_type . '_sharing_size'] ) * 21/100,
						$provider,
						ucfirst( str_replace( array( ' ', '_', '.' ), '', $provider ) ),
						$like_button_count_container,
						$post_url,
						$post_title,
						urldecode( $post_title ),
						$twitter_username,
						$twitter_username ? 'via=' . $twitter_username . '&' : '',
						$language,
						$this->options['buffer_username'] != '' ? $this->options['buffer_username'] : '',
						$style,
						$inner_style,
						$li_class,
						str_replace( '%network%', $provider, isset( $sharing_meta[$provider . '_' . $sharing_type . '_count'] ) && $sharing_meta[$provider . '_' . $sharing_type . '_count'] != '' ? str_replace( '>&nbsp;', ' sss_st_count="' . $sharing_meta[$provider . '_' . $sharing_type . '_count'] . '">&nbsp;', $counter_placeholder_value ) : $counter_placeholder_value ),
						ucfirst( str_replace( '_', ' ', $provider ) )
					),
					$sharing_networks[$provider]
				);
			}
			
			if ( isset( $this->options[$sharing_type . '_more'] ) ) {
				$li_items .= '<li class="' . ( $li_class != '' ? $li_class : '' ) . '">';
				if ( $display_count) {
					$li_items .= $counter_container_init_html . '">&nbsp;' . $counter_container_end_html;
				}
				$li_items .= '<i ' . $style . ' title="More" alt="More" class="heateorSssSharing heateorSssMoreBackground" onclick="heateorSssMoreSharingPopup(this, \'' . $post_url . '\', \''.$post_title.'\' )" ><ss style="display:block" class="heateorSssSharingSvg heateorSssMoreSvg"></ss></i></li>';
			}
			
			$total_shares_html = '';
			if ( $total_shares ) {
				$total_shares_html = '<li class="' . $li_class . '">';
				if ( $display_count) {
					$total_shares_html .= $counter_container_init_html . '">&nbsp;' . $counter_container_end_html;
				}
				if ( $sharing_type == 'horizontal' ) {
					$add_style = ';margin-left:9px !important;';
				} else {
					$add_style = ';margin-bottom:9px !important;';
				}
				$add_style .= '"';
				$style = str_replace( ';"', $add_style, $style );
				$total_shares_html .= '<i ' . $style . ' title="Total Shares" alt="Total Shares" class="heateorSssSharing heateorSssTCBackground"></i></li>';
			}

			if ( $sharing_type == 'vertical' ) {
				$html .= $total_shares_html . $li_items;
			} else {
				$html .= $li_items . $total_shares_html;
			}

			$html .= '</ul><div style="clear:both"></div>';
		}
		return $html;
	}

	/**
	 * Get http/https protocol at the website
	 *
	 * @since    1.0.0
	 */
	public function get_http_protocol() {
		
		if ( isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) {
			return "https://";
		} else {
			return "http://";
		}
	
	}

	/**
	 * Enable sharing interface at selected areas.
	 *
	 * @since    1.0.0
	 */
	public function render_sharing( $content ) {
		
		global $post;
		// hook to bypass sharing
		$disable_sharing = apply_filters( 'heateor_sss_disable_sharing', $post, $content );
		// if $disable_sharing value is 1, return content without sharing interface
		if ( $disable_sharing === 1 ) {
			return $content;
		}
		$sharing_meta = get_post_meta( $post->ID, '_heateor_sss_meta', true );
		
		$sharing_bp_activity = false;

		if ( current_filter() == 'bp_activity_entry_meta' ) {
			if ( isset( $this->options['bp_activity'] ) ) {
				$sharing_bp_activity = true;
			}
		}
		
		$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
		$post_types = array_diff( $post_types, array( 'post', 'page' ) );

		// sharing interface
		if ( isset( $this->options['hor_enable'] ) && ! ( isset( $sharing_meta['sharing'] ) && $sharing_meta['sharing'] == 1 && ( ! is_front_page() || ( is_front_page() && 'page' == get_option('show_on_front' ) ) ) ) ) {
			$post_id = $post -> ID;
			// default post url
			$post_url = get_permalink( $post->ID );
			if ( $sharing_bp_activity ) {
				$post_url = bp_get_activity_thread_permalink();
				$post_id = 0;
			} else {
				if ( $this->options['horizontal_target_url'] == 'default' ) {
					$post_url = get_permalink( $post->ID );
					if ( $post_url == '' ) {
						$post_url = html_entity_decode( esc_url( $this->get_http_protocol() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) );
					}
				} elseif ( $this->options['horizontal_target_url'] == 'home' ) {
					$post_url = site_url();
					$post_id = 0;
				} elseif ( $this->options['horizontal_target_url'] == 'custom' ) {
					$post_url = $this->options['horizontal_target_url_custom'] ? $this->options['horizontal_target_url_custom'] : get_permalink( $post->ID );
					$post_id = 0;
				}
			}
			
			$sharing_url = $this->get_short_url( $post_url, $post->ID );
			
			$sharing_div = $this->prepare_sharing_html( $sharing_url ? $sharing_url : $post_url, 'horizontal', isset( $this->options['horizontal_counts'] ), isset( $this->options['horizontal_total_shares'] ) );
			$sharing_container_style = '';
			$sharing_title_style = 'style="font-weight:bold"';
			
			if ( $this->options['hor_sharing_alignment'] == 'right' ) {
				$sharing_container_style = 'style="float: right"';
			} elseif ( $this->options['hor_sharing_alignment'] == 'center' ) {
				$sharing_container_style = 'style="float: right;position: relative;left: -50%;text-align: left;"';
				$sharing_title_style = 'style="font-weight: bold;list-style: none;position: relative;left: 50%;"';
			}
			
			$horizontal_div = "<div style='clear: both'></div><div ". $sharing_container_style ." class='heateor_sss_sharing_container heateor_sss_horizontal_sharing' heateor-sss-data-href='" . $post_url . "'><div class='heateor_sss_sharing_title' " . $sharing_title_style . " >" . ucfirst( $this->options['title'] ) . "</div>" . $sharing_div . "</div><div style='clear: both'></div>";
			if ( $sharing_bp_activity ) {
				echo $horizontal_div;
			}
			// show horizontal sharing
			if ( ( isset( $this->options['home'] ) && is_front_page() ) || ( isset( $this->options['category'] ) && is_category() ) || ( isset( $this->options['archive'] ) && is_archive() ) || ( isset( $this->options['post'] ) && is_single() && isset( $post -> post_type ) && $post -> post_type == 'post' ) || ( isset( $this->options['page'] ) && is_page() && isset( $post -> post_type ) && $post -> post_type == 'page' ) || ( isset( $this->options['excerpt'] ) && is_front_page() && current_filter() == 'get_the_excerpt' ) || ( isset( $this->options['bb_reply'] ) && current_filter() == 'bbp_get_reply_content' ) || ( isset( $this->options['bb_forum'] ) && ( isset( $this->options['top'] ) && current_filter() == 'bbp_template_before_single_forum' || isset( $this->options['bottom'] ) && current_filter() == 'bbp_template_after_single_forum' ) ) || ( isset( $this->options['bb_topic'] ) && ( isset( $this->options['top'] ) && in_array( current_filter(), array( 'bbp_template_before_single_topic', 'bbp_template_before_lead_topic' ) ) || isset( $this->options['bottom'] ) && in_array( current_filter(), array( 'bbp_template_after_single_topic', 'bbp_template_after_lead_topic' ) ) ) ) || ( isset( $this->options['woocom_shop'] ) && current_filter() == 'woocommerce_after_shop_loop_item' ) || ( isset( $this->options['woocom_product'] ) && current_filter() == 'woocommerce_share' ) || ( isset( $this->options['woocom_thankyou'] ) && current_filter() == 'woocommerce_thankyou' ) || (current_filter() == 'bp_before_group_header' && isset( $this->options['bp_group'] ) ) ) {
				if ( in_array( current_filter(), array( 'bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum', 'bbp_template_after_single_topic', 'bbp_template_after_lead_topic', 'bbp_template_after_single_forum', 'woocommerce_after_shop_loop_item', 'woocommerce_share', 'woocommerce_thankyou', 'bp_before_group_header' ) ) ) {
					echo '<div style="clear:both"></div>' . $horizontal_div . '<div style="clear:both"></div>';
				} else {
					if ( isset( $this->options['top'] ) && isset( $this->options['bottom'] ) ) {
						$content = $horizontal_div . '<br/>' . $content . '<br/>' . $horizontal_div;
					} else {
						if ( isset( $this->options['top'] ) ) {
							$content = $horizontal_div.$content;
						} elseif ( isset( $this->options['bottom'] ) ) {
							$content = $content.$horizontal_div;
						}
					}
				}
			} elseif ( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if ( isset( $this->options[$post_type] ) && ( is_single() || is_page() ) && isset( $post -> post_type ) && $post -> post_type == $post_type ) {
						if ( isset( $this->options['top'] ) && isset( $this->options['bottom'] ) ) {
							$content = $horizontal_div . '<br/>' . $content.'<br/>'.$horizontal_div;
						} else {
							if ( isset( $this->options['top'] ) ) {
								$content = $horizontal_div.$content;
							} elseif ( isset( $this->options['bottom'] ) ) {
								$content = $content.$horizontal_div;
							}
						}
					}
				}
			}
		}
		if ( isset( $this->options['vertical_enable'] ) && ! ( isset( $sharing_meta['vertical_sharing'] ) && $sharing_meta['vertical_sharing'] == 1 && ( ! is_front_page() || ( is_front_page() && 'page' == get_option('show_on_front' ) ) ) ) ) {
			$post_id = $post -> ID;
			$post_url = get_permalink( $post->ID );
			
			if ( $this->options['vertical_target_url'] == 'default' ) {
				$post_url = get_permalink( $post->ID );
				if ( $post_url == '' ) {
					$post_url = html_entity_decode( esc_url( $this->get_http_protocol() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) );
				}
			} elseif ( $this->options['vertical_target_url'] == 'home' ) {
				$post_url = site_url();
				$post_id = 0;
			} elseif ( $this->options['vertical_target_url'] == 'custom' ) {
				$post_url = $this->options['vertical_target_url_custom'] ? $this->options['vertical_target_url_custom'] : get_permalink( $post->ID );
				$post_id = 0;
			}
			
			$sharing_url = $this->get_short_url( $post_url, $post->ID );

			$vertical_sharing_width = ( $this->options['vertical_sharing_shape'] == 'rectangle' ? $this->options['vertical_sharing_width'] : $this->options['vertical_sharing_size'] );
			if ( isset( $this->options['vertical_counts'] ) && isset( $this->options['vertical_counter_position'] ) && in_array( $this->options['vertical_counter_position'], array( 'left', 'right' ) ) ) {
				$vertical_sharing_width += $vertical_sharing_width*60/100;
			}
			$sharing_div = $this->prepare_sharing_html( $sharing_url ? $sharing_url : $post_url, 'vertical', isset( $this->options['vertical_counts'] ), isset( $this->options['vertical_total_shares'] ) );
			$offset = ( $this->options['alignment'] != '' && $this->options[$this->options['alignment'].'_offset'] != '' ? $this->options['alignment'] . ': ' . $this->options[$this->options['alignment'].'_offset'] . 'px;' : '' ) . ( $this->options['top_offset'] != '' ? 'top: '.$this->options['top_offset'] . 'px;' : '' );
			$vertical_div = "<div class='heateor_sss_sharing_container heateor_sss_vertical_sharing" . ( isset( $this->options['bottom_mobile_sharing'] ) ? ' heateor_sss_bottom_sharing' : '' ) . "' style='width:" . ( $vertical_sharing_width + 4 ) . "px;" . $offset . ( $this->options['vertical_bg'] != '' ? 'background-color: '.$this->options['vertical_bg'] : '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;' ) . "' heateor-sss-data-href='" . $post_url . "'>" . $sharing_div . "</div>";
			// show vertical sharing
			if ( ( isset( $this->options['vertical_home'] ) && is_front_page() ) || ( isset( $this->options['vertical_category'] ) && is_category() ) || ( isset( $this->options['vertical_archive'] ) && is_archive() ) || ( isset( $this->options['vertical_post'] ) && is_single() && isset( $post -> post_type ) && $post -> post_type == 'post' ) || ( isset( $this->options['vertical_page'] ) && is_page() && isset( $post -> post_type ) && $post -> post_type == 'page' ) || ( isset( $this->options['vertical_excerpt'] ) && is_front_page() && current_filter() == 'get_the_excerpt' ) || ( isset( $this->options['vertical_bb_forum'] ) && current_filter() == 'bbp_template_before_single_forum' ) || ( isset( $this->options['vertical_bb_topic'] ) && in_array( current_filter(), array( 'bbp_template_before_single_topic', 'bbp_template_before_lead_topic' )) ) || (current_filter() == 'bp_before_group_header' && isset( $this->options['vertical_bp_group'] ) ) ) {
				if ( in_array( current_filter(), array( 'bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum', 'bp_before_group_header' ) ) ) {
					echo $vertical_div;
				} else {
					if ( is_front_page() ) {
						if ( current_filter() == 'the_content' ) {
							$var = $this->vertical_home_count;
						} elseif ( current_filter() == 'get_the_excerpt' ) {
							$var = $this->vertical_excerpt_count;
						}
						if ( $var == 0 ) {
							if ( $this->options['vertical_target_url'] == 'default' ) {
								$post_url = site_url();
								$sharing_url = $this->get_short_url( $post_url, 0 );
								
								$sharing_div = $this->prepare_sharing_html( $sharing_url ? $sharing_url : $post_url, 'vertical', isset( $this->options['vertical_counts'] ), isset( $this->options['vertical_total_shares'] ) );
								$vertical_div = "<div class='heateor_sss_sharing_container heateor_sss_vertical_sharing" . ( isset( $this->options['bottom_mobile_sharing'] ) ? ' heateor_sss_bottom_sharing' : '' ) . "' style='width:" . ( $vertical_sharing_width + 4 ) . "px;" . $offset . ( $this->options['vertical_bg'] != '' ? 'background-color: ' . $this->options['vertical_bg'] : '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;' ) . "' heateor-sss-data-href='" . $post_url . "'>" . $sharing_div . "</div>";
							}
							$content = $content . $vertical_div;
							if ( current_filter() == 'the_content' ) {
								$this->vertical_home_count++;
							} elseif ( current_filter() == 'get_the_excerpt' ) {
								$this->vertical_excerpt_count++;
							}
						}
					} else {
						$content = $content . $vertical_div;
					}
				}
			} elseif ( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if ( isset( $this->options['vertical_' . $post_type] ) && ( is_single() || is_page() ) && isset( $post -> post_type ) && $post -> post_type == $post_type ) {
						$content = $content . $vertical_div;
					}
				}
			}
		}
		return $content;
	}

	/**
	 * Return ajax response
	 *
	 * @since    1.0.0
	 */
	private function ajax_response( $response ) {
		
		$response = apply_filters( 'heateor_sss_ajax_response_filter', $response );
		die( json_encode( $response ) );

	}

	/**
	 * Get sharing count for providers
	 *
	 * @since    1.0.0
	 */
	public function fetch_share_counts() {

		if ( isset( $_GET['urls'] ) && count( $_GET['urls'] ) > 0 ) {
			$target_urls = array_unique( $_GET['urls'] );
			foreach ( $target_urls as $k => $v ) {
				$target_urls[$k] = esc_attr( $v );
			}
		} else {
			$this->ajax_response( array( 'status' => 0, 'message' => __( 'Invalid request' ) ) );
		}
		$horizontal_sharing_networks = $this->options['horizontal_re_providers'] ? $this->options['horizontal_re_providers'] : array();
		$vertical_sharing_networks = $this->options['vertical_re_providers'] ? $this->options['vertical_re_providers'] : array();
		$sharing_networks = array_unique( array_merge( $horizontal_sharing_networks, $vertical_sharing_networks ) );
		if ( count( $sharing_networks ) == 0 ) {
			$this->ajax_response( array( 'status' => 0, 'message' => __( 'Providers not selected' ) ) );
		}
		
		$tweet_count_service = 'newsharecounts';
		if ( isset( $this->options['tweet_count_service'] ) ) {
			$tweet_count_service = $this->options['tweet_count_service'];
		} elseif ( isset( $this->options['vertical_tweet_count_service'] ) ) {
			$tweet_count_service = $this->options['vertical_tweet_count_service'];
		}

		if ( $tweet_count_service == 'opensharecount' ) {
			$twitter_count_api = 'http://opensharecount.com/count.json?url=';
		} elseif ( $tweet_count_service == 'newsharecounts' ) {
			$twitter_count_api = 'http://public.newsharecounts.com/count.json?url=';
		}
		
		$response_data = array();
		foreach ( $target_urls as $target_url ) {
			foreach ( $sharing_networks as $provider ) {
				switch ( $provider ) {
					case 'facebook':
						$url = 'http://api.facebook.com/restserver.php?method=links.getStats&urls=' . $target_url . '&format=json&callback=';
						break;
					case 'twitter':
						$url = $twitter_count_api . $target_url;
						break;
					case 'linkedin':
						$url = 'http://www.linkedin.com/countserv/count/share?url=' . $target_url . '&format=json';
						break;
					case 'reddit':
						$url = 'http://www.reddit.com/api/info.json?url=' . $target_url;
						break;
					case 'delicious':
						$url = 'http://feeds.delicious.com/v2/json/urlinfo/data?url=' . $target_url;
						break;
					case 'pinterest':
						$url = 'http://api.pinterest.com/v1/urls/count.json?callback=heateorSss&url=' . $target_url;
						break;
					case 'buffer':
						$url = 'https://api.bufferapp.com/1/links/shares.json?url=' . $target_url;
						break;
					case 'stumbleupon':
						$url = 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $target_url;
						break;
					case 'google_plus':
						$url = 'http://share.yandex.ru/gpp.xml?url=' . $target_url;
						break;
					case 'vkontakte':
						$url = 'https://vk.com/share.php?act=count&url=' . $target_url;
						break;
					default:
						$url = '';
				}
				if ( $url == '' ) { continue; }
				$response = wp_remote_get( $url,  array( 'timeout' => 15 ) );
				if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ) {
					$body = wp_remote_retrieve_body( $response );
					if ( $provider == 'pinterest' ) {
						$body = str_replace( array( 'heateorSss(', ')' ), '', $body );
					}
					if ( ! in_array( $provider, array( 'google_plus', 'vkontakte') ) ) {
						$body = json_decode( $body );
					}
					switch ( $provider ) {
						case 'facebook':
							if ( ! empty( $body[0] -> total_count ) ) {
								$response_data[$target_url]['facebook'] = $body[0] -> total_count;
							} else {
								$response_data[$target_url]['facebook'] = 0;
							}
							break;
						case 'twitter':
							if ( ! empty( $body -> count ) ) {
								$response_data[$target_url]['twitter'] = $body -> count;
							} else {
								$response_data[$target_url]['twitter'] = 0;
							}
							break;
						case 'linkedin':
							if ( ! empty( $body -> count ) ) {
								$response_data[$target_url]['linkedin'] = $body -> count;
							} else {
								$response_data[$target_url]['linkedin'] = 0;
							}
							break;
						case 'reddit':
							$response_data[$target_url]['reddit'] = 0;
							if ( ! empty( $body -> data -> children ) ) {
								$children = $body -> data -> children;
								if ( ! empty( $children[0] -> data -> score ) ) {
									$response_data[$target_url]['reddit'] = $children[0] -> data -> score;
								}
							}
							break;
						case 'delicious':
							if ( ! empty( $body[0] -> total_posts ) ) {
								$response_data[$target_url]['delicious'] = $body[0] -> total_posts;
							} else {
								$response_data[$target_url]['delicious'] = 0;
							}
							break;
						case 'pinterest':
							if ( ! empty( $body -> count ) ) {
								$response_data[$target_url]['pinterest'] = $body -> count;
							} else {
								$response_data[$target_url]['pinterest'] = 0;
							}
							break;
						case 'buffer':
							if ( ! empty( $body -> shares ) ) {
								$response_data[$target_url]['buffer'] = $body -> shares;
							} else {
								$response_data[$target_url]['buffer'] = 0;
							}
							break;
						case 'stumbleupon':
							if ( ! empty( $body -> result ) && isset( $body -> result -> views ) ) {
								$response_data[$target_url]['stumbleupon'] = $body -> result -> views;
							} else {
								$response_data[$target_url]['stumbleupon'] = 0;
							}
							break;
						case 'google_plus':
							if ( ! empty( $body ) ) {
								$response_data[$target_url]['google_plus'] = $body;
							} else {
								$response_data[$target_url]['google_plus'] = 0;
							}
							break;
						case 'vkontakte':
							if ( ! empty( $body ) ) {
								$response_data[$target_url]['vkontakte'] = $body;
							} else {
								$response_data[$target_url]['vkontakte'] = 0;
							}
							break;
					}
				}
			}
		}
		$this->ajax_response( array( 'status' => 1, 'message' => $response_data ) );
	}

	/**
	 * Stylesheets to load at front end.
	 *
	 * @since    1.0.0
	 */
	public function frontend_styles() {
		?>
		<style type="text/css">
		.heateor_sss_horizontal_sharing .heateorSssSharing{
			<?php if ( $this->options['horizontal_bg_color_default'] != '' ) { ?>
				background-color: <?php echo $this->options['horizontal_bg_color_default'] ?>;
			<?php  } ?>
				color: <?php echo $this->options['horizontal_font_color_default'] ? $this->options['horizontal_font_color_default'] : '#fff' ?>;
			<?php
			$border_width = 0;
			if ( $this->options['horizontal_border_width_default'] != '' ) {
				$border_width = $this->options['horizontal_border_width_default'];
			} elseif ( $this->options['horizontal_border_width_hover'] != '' ) {
				$border_width = $this->options['horizontal_border_width_hover'];
			}
			?>
			border-width: <?php echo $border_width ?>px;
			border-style: solid;
			border-color: <?php echo $this->options['horizontal_border_color_default'] != '' ? $this->options['horizontal_border_color_default'] : 'transparent'; ?>;
		}
		<?php if ( $this->options['horizontal_font_color_default'] == '' ) { ?>
		.heateor_sss_horizontal_sharing .heateorSssTCBackground{
			color:#666;
		}
		<?php } ?>
		.heateor_sss_horizontal_sharing .heateorSssSharing:hover{
			<?php if ( $this->options['horizontal_bg_color_hover'] != '' ) { ?>
				background-color: <?php echo $this->options['horizontal_bg_color_hover'] ?>;
			<?php }
			if ( $this->options['horizontal_font_color_hover'] != '' ) { ?>
				color: <?php echo $this->options['horizontal_font_color_hover'] ?>;
			<?php  } ?>
			border-color: <?php echo $this->options['horizontal_border_color_hover'] != '' ? $this->options['horizontal_border_color_hover'] : 'transparent'; ?>;
		}
		.heateor_sss_vertical_sharing .heateorSssSharing{
			<?php if ( $this->options['vertical_bg_color_default'] != '' ) { ?>
				background-color: <?php echo $this->options['vertical_bg_color_default'] ?>;
			<?php } ?>
				color: <?php echo $this->options['vertical_font_color_default'] ? $this->options['vertical_font_color_default'] : '#fff' ?>;
			<?php
			$verticalBorderWidth = 0;
			if ( $this->options['vertical_border_width_default'] != '' ) {
				$verticalBorderWidth = $this->options['vertical_border_width_default'];
			} elseif ( $this->options['vertical_border_width_hover'] != '' ) {
				$verticalBorderWidth = $this->options['vertical_border_width_hover'];
			}
			?>
			border-width: <?php echo $verticalBorderWidth ?>px;
			border-style: solid;
			border-color: <?php echo $this->options['vertical_border_color_default'] != '' ? $this->options['vertical_border_color_default'] : 'transparent'; ?>;
		}
		<?php if ( $this->options['horizontal_font_color_default'] == '' ) { ?>
		.heateor_sss_vertical_sharing .heateorSssTCBackground{
			color:#666;
		}
		<?php } ?>
		.heateor_sss_vertical_sharing .heateorSssSharing:hover{
			<?php if ( $this->options['vertical_bg_color_hover'] != '' ) { ?>
				background-color: <?php echo $this->options['vertical_bg_color_hover'] ?>;
			<?php }
			if ( $this->options['vertical_font_color_hover'] != '' ) { ?>
				color: <?php echo $this->options['vertical_font_color_hover'] ?>;
			<?php  } ?>
			border-color: <?php echo $this->options['vertical_border_color_hover'] != '' ? $this->options['vertical_border_color_hover'] : 'transparent'; ?>;
		}
		<?php
		if ( isset( $this->options['horizontal_counts'] ) ) {
			$svg_height = $this->options['horizontal_sharing_shape'] == 'rectangle' ? $this->options['horizontal_sharing_height'] : $this->options['horizontal_sharing_size'];
			if ( isset( $this->options['horizontal_counter_position'] ) && in_array( $this->options['horizontal_counter_position'], array( 'inner_top', 'inner_bottom' ) ) ) {
				$line_height_percent = $this->options['horizontal_counter_position'] == 'inner_top' ? 38 : 19;
				?>
				div.heateor_sss_horizontal_sharing .heateorSssSharingSvg{height:70%;margin-top:<?php echo $svg_height*15/100 ?>px}div.heateor_sss_horizontal_sharing .heateor_sss_square_count{line-height:<?php echo $svg_height*$line_height_percent/100 ?>px;}
				<?php
			} elseif ( isset( $this->options['horizontal_counter_position'] ) && in_array( $this->options['horizontal_counter_position'], array( 'inner_left', 'inner_right' ) ) ) { ?>
				div.heateor_sss_horizontal_sharing .heateorSssSharingSvg{width:50%;margin:auto;}div.heateor_sss_horizontal_sharing .heateor_sss_square_count{float:left;width:50%;line-height:<?php echo $svg_height; ?>px;}
				<?php
			} elseif ( isset( $this->options['horizontal_counter_position'] ) && in_array( $this->options['horizontal_counter_position'], array( 'left', 'right' ) ) ) { ?>
				div.heateor_sss_horizontal_sharing .heateor_sss_square_count{float:<?php echo $this->options['horizontal_counter_position'] ?>;margin:0 8px;line-height:<?php echo $svg_height + 2 * $border_width; ?>px;}
				<?php
			} elseif ( ! isset( $this->options['horizontal_counter_position'] ) || $this->options['horizontal_counter_position'] == 'top' ) { ?>
				div.heateor_sss_horizontal_sharing .heateor_sss_square_count{display: block}
				<?php
			}

		}
		if ( isset( $this->options['vertical_counts'] ) ) {
			$vertical_svg_height = $this->options['vertical_sharing_shape'] == 'rectangle' ? $this->options['vertical_sharing_height'] : $this->options['vertical_sharing_size'];
			$vertical_svg_width = $this->options['vertical_sharing_shape'] == 'rectangle' ? $this->options['vertical_sharing_width'] : $this->options['vertical_sharing_size'];
			if ( ( isset( $this->options['vertical_counter_position'] ) && in_array( $this->options['vertical_counter_position'], array( 'inner_top', 'inner_bottom' ) ) ) || ! isset( $this->options['vertical_counter_position'] ) ) {
				$vertical_line_height_percent = ! isset( $this->options['vertical_counter_position'] ) || $this->options['vertical_counter_position'] == 'inner_top' ? 38 : 19;
				?>
				div.heateor_sss_vertical_sharing .heateorSssSharingSvg{height:70%;margin-top:<?php echo $vertical_svg_height*15/100 ?>px}div.heateor_sss_vertical_sharing .heateor_sss_square_count{line-height:<?php echo $vertical_svg_height*$vertical_line_height_percent/100; ?>px;}
				<?php
			} elseif ( isset( $this->options['vertical_counter_position'] ) && in_array( $this->options['vertical_counter_position'], array( 'inner_left', 'inner_right' ) ) ) { ?>
				div.heateor_sss_vertical_sharing .heateorSssSharingSvg{width:50%;margin:auto;}div.heateor_sss_vertical_sharing .heateor_sss_square_count{float:left;width:50%;line-height:<?php echo $vertical_svg_height; ?>px;}
				<?php
			}  elseif ( isset( $this->options['vertical_counter_position'] ) && in_array( $this->options['vertical_counter_position'], array( 'left', 'right' ) ) ) { ?>
				div.heateor_sss_vertical_sharing .heateor_sss_square_count{float:<?php echo $this->options['vertical_counter_position'] ?>;margin:0 8px;line-height:<?php echo $vertical_svg_height; ?>px; <?php echo $this->options['vertical_counter_position'] == 'left' ? 'min-width:' . $vertical_svg_width*30/100 . 'px;display: block' : '';?>}
				<?php
			} elseif ( isset( $this->options['vertical_counter_position'] ) && $this->options['vertical_counter_position'] == 'top' ) { ?>
				div.heateor_sss_vertical_sharing .heateor_sss_square_count{display: block}
				<?php
			}
		}
		echo isset( $this->options['hide_mobile_sharing'] ) && $this->options['vertical_screen_width'] != '' ? '@media screen and (max-width:' . $this->options['vertical_screen_width'] . 'px){.heateor_sss_vertical_sharing{display:none!important}}' : '';
		$bottom_sharing_postion_inverse = $this->options['bottom_sharing_alignment'] == 'left' ? 'right' : 'left';
		echo isset( $this->options['bottom_mobile_sharing'] ) && $this->options['horizontal_screen_width'] != '' ? '@media screen and (max-width:' . $this->options['horizontal_screen_width'] . 'px){.heateor_sss_bottom_sharing{' . ( $this->options['bottom_sharing_position'] != '' ? $this->options['bottom_sharing_alignment'] . ':' . $this->options['bottom_sharing_position'] . 'px!important;' . $bottom_sharing_postion_inverse . ':auto!important;' : '' ) . 'display:block!important;width: auto!important;bottom: -10px!important;top: auto!important;}.heateor_sss_bottom_sharing .heateor_sss_square_count{line-height: inherit;}.heateor_sss_bottom_sharing .heateorSssSharingArrow{display:none;}.heateor_sss_bottom_sharing .heateorSssTCBackground{margin-right: 1.1em !important}}' : '';
		echo $this->options['custom_css'];
		?>
		</style>
		<?php
		wp_enqueue_style( 'heateor_sss_frontend_css', plugins_url( 'css/sassy-social-share-public.css', __FILE__ ), false, $this->version );
		$default_svg = false;
		if ( isset( $this->options['hor_enable'] ) ) {
			if ( isset( $this->options['horizontal_more'] ) ) {
				$default_svg = true;
			}
			if ( $this->options['horizontal_font_color_default'] != '' ) {
				wp_enqueue_style( 'heateor_sss_sharing_svg', plugins_url( '../admin/css/sassy-social-share-default-svg-horizontal.css', __FILE__ ), false, $this->version );
			} else {
				$default_svg = true;
			}
			if ( $this->options['horizontal_font_color_hover'] != '' ) {
				wp_enqueue_style( 'heateor_sss_sharing_svg_hover', plugins_url( '../admin/css/sassy-social-share-hover-svg-horizontal.css', __FILE__ ), false, $this->version );
			}
		}
		if ( isset( $this->options['vertical_enable'] ) ) {
			if ( isset( $this->options['vertical_more'] ) ) {
				$default_svg = true;
			}
			if ( $this->options['vertical_font_color_default'] != '' ) {
				wp_enqueue_style( 'heateor_sss_vertical_sharing_svg', plugins_url( '../admin/css/sassy-social-share-default-svg-vertical.css', __FILE__ ), false, $this->version );
			} else {
				$default_svg = true;
			}
			if ( $this->options['vertical_font_color_hover'] != '' ) {
				wp_enqueue_style( 'heateor_sss_vertical_sharing_svg_hover', plugins_url( '../admin/css/sassy-social-share-hover-svg-vertical.css', __FILE__ ), false, $this->version );
			}
		}
		if ( $default_svg ) {
			wp_enqueue_style( 'heateor_sss_sharing_default_svg', plugins_url( '../admin/css/sassy-social-share-svg.css', __FILE__ ), false, $this->version );
		}
	
	}

	public function update_db_check() {

		if ( get_option( 'heateor_sss_version' ) != $this->version ) {
			if ( $this->options['horizontal_sharing_replace_color'] != '#fff' ) {
				heateor_sss_update_svg_css( $this->options['horizontal_sharing_replace_color'], 'sassy-social-share-default-svg-horizontal' );
			}
			if ( $this->options['horizontal_font_color_hover'] != '#fff' ) {
				heateor_sss_update_svg_css( $this->options['horizontal_font_color_hover'], 'sassy-social-share-hover-svg-horizontal' );
			}
			if ( $this->options['vertical_font_color_default'] != '#fff' ) {
				heateor_sss_update_svg_css( $this->options['vertical_font_color_default'], 'sassy-social-share-default-svg-vertical' );
			}
			if ( $this->options['vertical_font_color_hover'] != '#fff' ) {
				heateor_sss_update_svg_css( $this->options['vertical_font_color_hover'], 'sassy-social-share-hover-svg-vertical' );
			}
			
			// update plugin version in database
			update_option( 'heateor_sss_version', $this->version );
		}
	
	}

}
