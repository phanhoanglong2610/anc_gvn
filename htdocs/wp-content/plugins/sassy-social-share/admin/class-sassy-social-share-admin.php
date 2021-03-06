<?php

/**
 * Contains functions responsible for functionality at admin side
 *
 * @since      1.0.0
 *
 */

/**
 * This class defines all code necessary for functionality at admin side
 *
 * @since      1.0.0
 *
 */
class Sassy_Social_Share_Admin {

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
	 * Flag to check if BuddyPress is active.
	 *
	 * @since    1.0.0
	 */
	private $is_bp_active = false;

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
	 * Creates plugin menu in admin area
	 *
	 * @since    1.0.0
	 */
	public function create_admin_menu() {

		$page = add_menu_page( __( 'Sassy Social Share by Heateor', 'sassy-social-share' ), 'Sassy Social Share', 'manage_options', 'heateor-sss-options', array( $this, 'options_page' ), plugins_url( '../images/logo.png', __FILE__ ) );
		// options
		$options_page = add_submenu_page( 'heateor-sss-options', __( "Sassy Social Share - General Options", 'sassy-social-share' ), __( "Sassy Social Share", 'sassy-social-share' ), 'manage_options', 'heateor-sss-options', array( $this, 'options_page' ) );
		// What's new (keep it for next release)
		//$whats_new_page = add_submenu_page( 'heateor-sss-options', __( "Sassy Social Share - What's New", 'sassy-social-share' ), __( "What's New", 'sassy-social-share' ), 'manage_options', 'heateor-sss-whats-new', array( $this, 'whats_new_page' ) );
		add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_scripts' ) );
		add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_style' ) );
		add_action( 'admin_print_scripts-' . $page, array( $this, 'fb_sdk_script' ) );
		add_action( 'admin_print_scripts-' . $options_page, array( $this, 'admin_scripts' ) );
		add_action( 'admin_print_scripts-' . $options_page, array( $this, 'fb_sdk_script' ) );
		add_action( 'admin_print_styles-' . $options_page, array( $this, 'admin_style' ) );
		add_action( 'admin_print_scripts-' . $options_page, array( $this, 'admin_options_scripts' ) );
		add_action( 'admin_print_styles-' . $options_page, array( $this, 'admin_options_style' ) );
	
	}

	/**
	 * Register plugin settings and its sanitization callback.
	 *
	 * @since    1.0.0
	 */
	public function options_init() {

		register_setting( 'heateor_sss_options', 'heateor_sss', array( $this, 'validate_options' ) );
		
		// show option to disable sharing on particular page/post
		$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
		$post_types = array_unique( array_merge( $post_types, array( 'post', 'page' ) ) );
		foreach ( $post_types as $type ) {
			add_meta_box( 'heateor_sss_meta', 'Sassy Social Share', array( $this, 'sharing_meta_setup' ), $type );
		}
		// save sharing meta on post/page save
		add_action( 'save_post', array( $this, 'save_sharing_meta' ) );

	}

	/**
	 * Update options in all the old blogs.
	 *
	 * @since    1.0.0
	 */
	public function update_old_blogs( $old_config ) {
		
		$option_parts = explode( '_', current_filter() );
		$option = $option_parts[2] . '_' . $option_parts[3] . '_' . $option_parts[4];
		$new_config = get_option( $option );
		if ( isset( $new_config['config_multisite'] ) && $new_config['config_multisite'] == 1 ) {
			$blogs = get_blog_list( 0, 'all' );
			foreach ( $blogs as $blog ) {
				update_blog_option( $blog['blog_id'], $option, $new_config );
			}
		}
	
	}

	/**
	 * Replicate the options to the new blog created.
	 *
	 * @since    1.0.0
	 */
	public function replicate_settings( $blog_id ) {

		add_blog_option( $blog_id, 'heateor_sss', $this->options );
	
	}

	/**
	 * Show sharing meta options
	 *
	 * @since    1.0.0
	 */
	public function sharing_meta_setup() {

		global $post;
		$postType = $post->post_type;
		$sharing_meta = get_post_meta( $post->ID, '_heateor_sss_meta', true );
		?>
		<p>
			<label for="heateor_sss_sharing">
				<input type="checkbox" name="_heateor_sss_meta[sharing]" id="heateor_sss_sharing" value="1" <?php checked( '1', @$sharing_meta['sharing'] ); ?> />
				<?php _e( 'Disable Standard Sharing interface on this ' . $postType, 'sassy-social-share' ) ?>
			</label>
			<br/>
			<label for="heateor_sss_vertical_sharing">
				<input type="checkbox" name="_heateor_sss_meta[vertical_sharing]" id="heateor_sss_vertical_sharing" value="1" <?php checked( '1', @$sharing_meta['vertical_sharing'] ); ?> />
				<?php _e( 'Disable Floating Sharing interface on this ' . $postType, 'sassy-social-share' ) ?>
			</label>
			<?php
			$valid_networks = array( 'facebook', 'twitter', 'linkedin', 'google_plus', 'delicious', 'buffer', 'reddit', 'pinterest', 'stumbleupon', 'vkontakte' );
			if ( isset( $this->options['hor_enable'] ) && isset( $this->options['horizontal_counts'] ) && isset( $this->options['horizontal_re_providers'] ) && count( $this->options['horizontal_re_providers'] ) > 0 ) {
				?>
				<p>
				<strong><?php _e( 'Standard sharing', 'sassy-social-share' ) ?></strong>
				<?php
				foreach ( array_intersect( $this->options['horizontal_re_providers'], $valid_networks ) as $network ) {
					?>
					<br/>
					<label for="heateor_sss_<?php echo $network ?>_horizontal_sharing_count">
						<span style="width: 242px; float:left"><?php _e( 'Starting share count for ' . ucfirst( str_replace ( '_', ' ', $network ) ), 'sassy-social-share' ) ?></span>
						<input type="text" name="_heateor_sss_meta[<?php echo $network ?>_horizontal_count]" id="heateor_sss_<?php echo $network ?>_horizontal_sharing_count" value="<?php echo isset( $sharing_meta[$network . '_horizontal_count'] ) ? $sharing_meta[$network . '_horizontal_count'] : '' ?>" />
					</label>
					<?php
				}
				?>
				</p>
				<?php
			}
			
			if ( isset( $this->options['vertical_enable'] ) && isset( $this->options['vertical_counts'] ) && isset( $this->options['vertical_re_providers'] ) && count( $this->options['vertical_re_providers'] ) > 0 ) {
				?>
				<p>
				<strong><?php _e( 'Floating sharing', 'sassy-social-share' ) ?></strong>
				<?php
				foreach ( array_intersect( $this->options['vertical_re_providers'], $valid_networks ) as $network ) {
					?>
					<br/>
					<label for="heateor_sss_<?php echo $network ?>_vertical_sharing_count">
						<span style="width: 242px; float:left"><?php _e( 'Starting share count for ' . ucfirst( str_replace ( '_', ' ', $network ) ), 'sassy-social-share' ) ?></span>
						<input type="text" name="_heateor_sss_meta[<?php echo $network ?>_vertical_count]" id="heateor_sss_<?php echo $network ?>_vertical_sharing_count" value="<?php echo isset( $sharing_meta[$network . '_vertical_count'] ) ? $sharing_meta[$network . '_vertical_count'] : '' ?>" />
					</label>
					<?php
				}
				?>
				</p>
				<?php
			}
			?>
		</p>
		<?php
	    echo '<input type="hidden" name="heateor_sss_meta_nonce" value="' . wp_create_nonce( __FILE__ ) . '" />';
	
	}

	/**
	 * Save sharing meta fields.
	 *
	 * @since    1.0.0
	 */
	public function save_sharing_meta( $post_id ) {
	    
	    // make sure data came from our meta box
	    if ( ! isset( $_POST['heateor_sss_meta_nonce'] ) || ! wp_verify_nonce( $_POST['heateor_sss_meta_nonce'], __FILE__ ) ) {
			return $post_id;
	 	}
	    // check user permissions
	    if ( $_POST['post_type'] == 'page' ) {
	        if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
	    	}
		} else {
	        if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
	    	}
		}
	    if ( isset( $_POST['_heateor_sss_meta'] ) ) {
			$newData = $_POST['_heateor_sss_meta'];
		} else {
			$newData = array( 'sharing' => 0, 'vertical_sharing' => 0 );
		}
		update_post_meta( $post_id, '_heateor_sss_meta', $newData );
	    return $post_id;

	}

	/** 
	 * Sanitization callback for plugin options.
	 *
	 * IMPROVEMENT: complexity can be reduced (this function is called on each option page validation and "if($k == 'providers'){"
	 * condition is being checked every time)
     * @since    1.0.0
	 */ 
	public function validate_options( $heateorSssOptions ) {
		
		foreach ( $heateorSssOptions as $k => $v ) {
			if ( is_array( $v ) ) {
				$heateorSssOptions[$k] = $heateorSssOptions[$k];
			} else {
				$heateorSssOptions[$k] = esc_attr( trim( $v ) );
			}
		}
		return $heateorSssOptions;

	}

	/**
	 * "Whats's New" page.
	 *
	 * @since    1.0.0
	 */	
	public function whats_new_page() {

		//wp_enqueue_script( 'heateor_sss_fb_sdk_script', plugins_url( '../admin/js/fb_sdk.js', __FILE__ ), false, $this->version );
	
	}

	/**
	 * Include Javascript at plugin options page in admin area.
	 *
	 * @since    1.0.0
	 */	
	public function admin_options_scripts() {

		wp_enqueue_script( 'heateor_sss_admin_options_script', plugins_url( 'js/sassy-social-share-options.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable' ), $this->version );
	
	}

	/**
	 * Include Javascript SDK in admin.
	 *
	 * @since    1.0.0
	 */	
	public function fb_sdk_script() {

		wp_enqueue_script( 'heateor_sss_fb_sdk_script', plugins_url( 'js/sassy-social-share-fb-sdk.js', __FILE__ ), false, $this->version );
	
	}

	/**
	 * Include CSS files in admin.
	 *
	 * @since    1.0.0
	 */	
	public function admin_style() {

		wp_enqueue_style( 'heateor_sss_admin_style', plugins_url( 'css/sassy-social-share-admin.css', __FILE__ ), false, $this->version );
	
	}

	/**
	 * Include CSS files at plugin options page in admin area.
	 *
	 * @since    1.0.0
	 */	
	public function admin_options_style() {

		wp_enqueue_style( 'heateor_sss_admin_svg', plugins_url( 'css/sassy-social-share-svg.css', __FILE__ ), false, $this->version );
		if( $this->options['horizontal_font_color_default'] != '' ) {
			$updated = $this->update_css( 'horizontal_sharing_replace_color', 'horizontal_font_color_default', 'sassy-social-share-default-svg-horizontal' );
			wp_enqueue_style( 'heateor_sss_admin_svg_horizontal', plugins_url( 'css/sassy-social-share-default-svg-horizontal.css', __FILE__ ), false, ( $updated === true ? rand() :  $this->version ) );
		}
		if( $this->options['horizontal_font_color_hover'] != '' ) {
			$updated = $this->update_css( 'horizontal_sharing_replace_color_hover', 'horizontal_font_color_hover', 'sassy-social-share-hover-svg-horizontal' );
			wp_enqueue_style( 'heateor_sss_admin_svg_horizontal_hover', plugins_url( 'css/sassy-social-share-hover-svg-horizontal.css', __FILE__ ), false, ( $updated === true ? rand() :  $this->version ) );
		}
		if( $this->options['vertical_font_color_default'] != '' ) {
			$updated = $this->update_css( 'vertical_sharing_replace_color', 'vertical_font_color_default', 'sassy-social-share-default-svg-vertical' );
			wp_enqueue_style( 'heateor_sss_admin_svg_vertical', plugins_url( 'css/sassy-social-share-default-svg-vertical.css', __FILE__ ), false, ( $updated === true ? rand() :  $this->version ) );
		}
		if( $this->options['vertical_font_color_hover'] != '' ) {
			$updated = $this->update_css( 'vertical_sharing_replace_color_hover', 'vertical_font_color_hover', 'sassy-social-share-hover-svg-vertical' );
			wp_enqueue_style( 'heateor_sss_admin_svg_vertical_hover', plugins_url( 'css/sassy-social-share-hover-svg-vertical.css', __FILE__ ), false, ( $updated === true ? rand() :  $this->version ) );
		}
	
	}

	/**
	 * Update CSS file
	 *
	 * @since    1.0.0
	 */
	private function update_css( $replace_color_option, $logo_color_option, $css_file ) {
		
		if ( $this->options[$replace_color_option] != $this->options[$logo_color_option] ) {
			$path = plugin_dir_url( __FILE__ ) . 'css/' . $css_file . '.css';
			$content = file( $path );
			if ( $content !== false ) {
				$handle = fopen( dirname( __FILE__ ) . '/css/' . $css_file . '.css','w' );
				if ( $handle !== false ) {
					foreach ( $content as $value ) {
					    fwrite( $handle, str_replace( str_replace( '#', '%23', $this->options[$replace_color_option] ), str_replace( '#', '%23', $this->options[$logo_color_option] ), $value ) );
					}
					fclose( $handle );
					$this->options[$replace_color_option] = $this->options[$logo_color_option];
					update_option( 'heateor_sss', $this->options );
					return true;
				}
			}
		}
		return false;

	}

	/**
	 * Include javascript files in admin.
	 *
	 * @since    1.0.0
	 */	
	public function admin_scripts() {
		
		?>
		<script type="text/javascript">var heateorSssWebsiteUrl = '<?php echo site_url() ?>', heateorSssHelpBubbleTitle = "<?php echo __( 'Click to show help', 'sassy-social-share' ) ?>", heateorSssHelpBubbleCollapseTitle = "<?php echo __( 'Click to hide help', 'sassy-social-share' ) ?>"</script>
		<?php
		wp_enqueue_script( 'heateor_sss_admin_script', plugins_url( 'js/sassy-social-share-admin.js', __FILE__ ), array( 'jquery', 'jquery-ui-tabs' ), $this->version );
	
	}

	/**
	 * Renders options page
	 *
	 * @since    1.0.0
	 */
	public function options_page() {

		// message on saving options
		echo $this->settings_saved_notification();
		$options = $this->options;
		/**
		 * The file rendering options page
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/sassy-social-share-options-page.php';
	
	}

	/**
	 * Display notification message when plugin options are saved
	 *
	 * @since    1.0.0
     * @return   string    Notification after saving options
	 */
	private function settings_saved_notification() {

		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) {
			return '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible below-h2"> 
	<p><strong>' . __( 'Settings saved', 'sassy-social-share' ) . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . __( 'Dismiss this notice', 'sassy-social-share' ) . '</span></button></div>';
		}
	
	}

	/**
	 * Check if WooCommerce is active
	 *
	 * @since    1.0.0
	 */
	private function is_woocommerce_active(){
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}

	/**
	 * Set BuddyPress active flag to true
	 *
	 * @since    1.0.0
	 */
	public function is_bp_loaded() {
		
		$this->is_bp_active = true;
	
	}

}
