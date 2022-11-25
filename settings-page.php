<?php 
defined( 'ABSPATH' ) || exit;

function fast_log_settings_page(){
?>
 <div class="wrap">
  <h1>WP Fast Log Setting</h1>
  <form method="post" action="options.php">
  <?php settings_fields( 'wp_fast_log_main' ); ?>
  <p></p>
  <table class="form-table" role="presentation">
    <tbody>
        <tr>
        <th scope="row"><label for="has_active">WP Fast Log Status :</label></th>
        <td>
            <select name="has_active" id="has_active">
                <option value="enabled" <?= (get_option('has_active') == 'enabled' ? 'selected' : '' ) ?>>Enabled</option>
                <option value="disabled" <?= (get_option('has_active') == 'disabled' ? 'selected' : '' ) ?>>Disabled</option>
            </select>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="alternative_email">Alternative Email :</label></th>
        <td>
            <input name="alternative_email" type="email" id="alternative_email" value="<?= get_option('alternative_email') ?>" class="regular-text">
            <p class="description">WP Fast Log sends to the Wordpress admin e-mail address defined by default. If you want to send notifications to a different email address, type your email address and set the alternative email status value to enabled.</p>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="alternative_email_status">Alternative Email Status :</label></th>
        <td>
            <select name="alternative_email_status" id="alternative_email_status">
                <option value="enabled" <?= (get_option('alternative_email_status') == 'enabled' ? 'selected' : '' ) ?>>Enabled</option>
                <option value="disabled" <?= (get_option('alternative_email_status') == 'disabled' ? 'selected' : '' ) ?>>Disabled</option>
            </select>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="http_request_url">HTTP Request URL :</label></th>
        <td>
            <input name="http_request_url" type="text" id="http_request_url" value="<?= get_option('http_request_url') ?>" class="large-text">
            <p class="description">If you want to send the login information in JSON format with an HTTP request, enter the webhook address in this field. Then activate the HTTP Request Status option.</p>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="http_request_status">HTTP Request Status :</label></th>
        <td>
            <select name="http_request_status" id="http_request_status">
                <option value="enabled" <?= (get_option('http_request_status') == 'enabled' ? 'selected' : '' ) ?>>Enabled</option>
                <option value="disabled" <?= (get_option('http_request_status') == 'disabled' ? 'selected' : '' ) ?>>Disabled</option>
            </select>
        </td>
        </tr>

    </tbody>
  </table>

  <?php submit_button(); ?>
  </form>
  </div>
<?php
}
?>