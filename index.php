<?php 
/**
* Plugin Name: WP Fast Log
* Plugin URI: https://github.com/enderkus/wp-fast-log/
* Description: Fast Log Beta
* Version: 0.1
* Author: Ender KUS
* Author URI: https://github.com/enderkus/
**/
defined( 'ABSPATH' ) || exit;

require_once(plugin_dir_path( __FILE__ ) .'functions.php');
require_once(plugin_dir_path( __FILE__ ) .'settings-page.php');

function fast_log_mail_notification($login) {
    $user = get_userdatabylogin($login);
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else $ip = $_SERVER['REMOTE_ADDR'];
    
    $geo_api_url = 'https://reallyfreegeoip.org/json/'.$ip;
    $json = file_get_contents($geo_api_url);
    $json_data = json_decode($json, false);

    $data = array(
        'blog_name' => get_bloginfo('name'),
        'logged_user' => $user->user_login,
        'ip' => $ip,
        'date_time' => date("Y-m-d H:i:s"),
        'country_code' => $json_data->country_code,
        'country_name' => $json_data->country_name,
        'region_name' => $json_data->region_name,
        'latitude' => $json_data->latitude,
        'longitude' => $json_data->longitude,
    );

    $settings = array (
        'has_active' => get_option( 'has_active' ),
        'alternative_email' => get_option( 'alternative_email' ),
        'alternative_email_status' => get_option( 'alternative_email_status' ),
        'http_request_url' => get_option( 'http_request_url' ),
        'http_request_status' => get_option( 'http_request_status' ),
    );
    if ($settings['has_active']=='enabled') {
        $headers = array('Content-Type: text/html; charset=UTF-8');
        if ($settings['alternative_email_status'] == 'enabled') {
            $to = get_option('alternative_email');
        } else {
            $to = get_option( 'admin_email' );
        }

        $subject = 'New Login Detected : '. $data['blog_name'] . ' User : ' . $data['logged_user'];
        $message = '<b>Logged in user : </b>' . $data['logged_user'].'<br';
        $message .= '<b>Login Date/Time : </b>'. $data['date_time'] .'<br>';
        $message .= '<b>IP Address : </b>'.$data['ip'].'<br>';
        $message .= '<b>Country Code : </b>'.$json_data->country_code.'<br>';
        $message .= '<b>Country Name : </b>'.$json_data->country_name.'<br>';
        $message .= '<b>Region Name : </b>'.$json_data->region_name.'<br>';
        $message .= '<b>Latitude : </b>'.$json_data->latitude.'<br>';
        $message .= '<b>Longitude : </b>'.$json_data->longitude.'<br>';
        
        wp_mail($to, $subject, $message, $headers );
    }

    if ($settings['http_request_status'] == 'enabled') {
        wp_remote_post($settings['http_request_url'], array(
            'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
            'body'        => json_encode($data),
            'method'      => 'POST',
            'data_format' => 'body',
        ));
    }
    
}
add_action('wp_login', 'fast_log_mail_notification');