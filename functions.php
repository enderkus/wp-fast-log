<?php
// Abspath defined
defined( 'ABSPATH' ) || exit;

function fast_log_register_settings() {
    add_option( 'has_active', 'enabled');
    register_setting( 'wp_fast_log_main', 'has_active', 'has_active_callback' );
    add_option( 'alternative_email', 'info@yourdomain');
    register_setting( 'wp_fast_log_main', 'alternative_email', 'alternative_email_callback' );
    add_option( 'alternative_email_status', 'disabled');
    register_setting( 'wp_fast_log_main', 'alternative_email_status', 'alternative_email_status_callback' );
    add_option( 'http_request_url', 'https://zapier.com/');
    register_setting( 'wp_fast_log_main', 'http_request_url', 'alternative_email_status_callback' );
    add_option( 'http_request_status', 'disabled');
    register_setting( 'wp_fast_log_main', 'http_request_status', 'alternative_email_status_callback' );
 }
 add_action( 'admin_init', 'fast_log_register_settings' );

function fast_log_options_page() {
    add_options_page('WP Fast Log Settings', 'WP Fast Log', 'manage_options', 'fast_log', 'fast_log_settings_page');
  }
add_action('admin_menu', 'fast_log_options_page');