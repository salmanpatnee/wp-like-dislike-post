<?php

if (!function_exists('spld_register_menu_page')) {
    function spld_register_menu_page()
    {
        add_menu_page('SP Like Dislike', 'SP Like Dislike', 'manage_options', 'spld-settings', 'spld_settings_page_callback', 'dashicons-thumbs-up', 30);
    }
}


function spld_settings_page_callback()
{
    if (!is_admin()) {
        return;
    }
?>

    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="POST">
            <?php
            settings_errors();
            settings_fields('spld-settings');
            do_settings_sections('spld-settings');
            submit_button('Save');
            ?>
        </form>
    </div>
<?php
}