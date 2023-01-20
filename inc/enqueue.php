<?php
if (!function_exists('spld_enqueue_scripts')) {
    function spld_enqueue_scripts()
    {
        wp_enqueue_style('sp-css', SPLD_PLUGIN_DIR_URL . '/assets/public/css/style.css');

        wp_register_script( "sp-js", SPLD_PLUGIN_DIR_URL . '/assets/public/js/main.js', array('jquery'), '1.0.0', true );
        wp_localize_script( 'sp-js', 'data', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));  

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'sp-js' );
    }
}
