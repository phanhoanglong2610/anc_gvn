<?php

/**
 * Fired when the plugin is deleted.
 *
 * Works in single as well as in Multisite/Network installs.
 *
 * @since    1.0.0
 */

defined( 'ABSPATH' ) or die( "Cheating........Uh!!" );

//if uninstall not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// check if current user is eligible to perform uninstall
if ( ! current_user_can( 'activate_plugins' ) ) {
	return;
}

$heateor_sss_options = get_option( 'heateor_sss' );
$heateor_sss_option_to_delete = 'heateor_sss';

if ( isset( $heateor_sss_options['delete_options'] ) ) {
	global $wpdb;
	
	// For Single site
	if ( ! is_multisite() ) {
		delete_option( $heateor_sss_option_to_delete );
		$wpdb->query( "delete from $wpdb->postmeta where meta_key like '_heateor_sss%'" );
	} else {
		// for multisite
		$heateor_sss_blog_ids = heateor_sss_get_blog_ids();
		$heateor_sss_original_blog_id = get_current_blog_id();
		foreach ( $heateor_sss_blog_ids as $blog_id ) {
			switch_to_blog( $blog_id );
			delete_site_option( $heateor_sss_option_to_delete );
		}
		switch_to_blog( $heateor_sss_original_blog_id );    // should use "restore_current_blog"?
	}
}

/**
 * Get all blog IDs of blogs in the current network that are not:
 * archived, spam, deleted
 *
 * @since    1.0.0
 * @return   array|boolean    The blog IDs, (bool) FALSE if: no matches.
 */
function heateor_sss_get_blog_ids() {
	global $wpdb;

	$sql = <<<SQL
SELECT blog_id
FROM {$wpdb->blogs}
WHERE archived = '0'
AND spam = '0'
AND deleted = '0'
SQL;

	return $wpdb->get_col( esc_sql( $sql ) );
}
