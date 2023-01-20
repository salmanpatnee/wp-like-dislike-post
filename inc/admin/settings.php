<?php
if (!function_exists('spld_register_settings')) {
    function spld_register_settings()
    {
        register_setting('spld-settings', 'spld_like_btn_label');
        register_setting('spld-settings', 'spld_dislike_btn_label');

        add_settings_section('spld_label_settings_section', 'Like Dislike Button Labels', 'spld_label_settings_section_callback', 'spld-settings');

        add_settings_field('spld_like_label_field', 'Like Button Label', 'spld_like_label_field_callback', 'spld-settings', 'spld_label_settings_section');
        add_settings_field('spld_dislike_label_field', 'Dislike Button Label', 'spld_dislike_label_field_callback', 'spld-settings', 'spld_label_settings_section');
    }
}

function spld_label_settings_section_callback()
{
    return null;
}

function spld_like_label_field_callback()
{
    $setting = get_option('spld_like_btn_label');
?>
    <input type="text" name="spld_like_btn_label" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
<?php
}
function spld_dislike_label_field_callback()
{
    $setting = get_option('spld_dislike_btn_label');
?>
    <input type="text" name="spld_dislike_btn_label" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
<?php
}
