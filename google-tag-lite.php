<?php
/*
Plugin Name: Google Tag Lite
Description: Add Google Tag Manager to your Site
Version: 1.0
Author: spamdalfz
*/

// Add plugin settings menu
function custom_google_tag_manager_menu() {
    add_menu_page(
        'Google Tag Lite Settings',
        'Google Tag Lite',
        'manage_options',
        'custom-google-tag-manager',
        'custom_google_tag_manager_settings_page',
        'dashicons-analytics'
    );
}
add_action('admin_menu', 'custom_google_tag_manager_menu');

// Register and display plugin settings
function custom_google_tag_manager_settings() {
    register_setting('custom-google-tag-manager-settings-group', 'google_tag_manager_id');
}
add_action('admin_init', 'custom_google_tag_manager_settings');

function custom_google_tag_manager_settings_page() {
    ?>
    <div class="wrap">
        <h1>Google Tag Manager Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('custom-google-tag-manager-settings-group'); ?>
            <?php do_settings_sections('custom-google-tag-manager-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Google Tag Manager ID:</th>
                    <td><input type="text" name="google_tag_manager_id" value="<?php echo esc_attr(get_option('google_tag_manager_id')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Enqueue the Google Tag Manager script
function add_google_tag_manager_script() {
    $tag_manager_id = get_option('google_tag_manager_id');
    if ($tag_manager_id) {
        wp_enqueue_script(
            'google-tag-manager',
            'https://www.googletagmanager.com/gtag/js?id=' . esc_attr($tag_manager_id),
            array(),
            null,
            false
        );
    }
}
add_action('wp_enqueue_scripts', 'add_google_tag_manager_script');
