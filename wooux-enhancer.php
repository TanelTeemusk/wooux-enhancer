<?php
/**
 * Plugin Name: WooUX Enhancer
 * Plugin URI: https://massruum.ee
 * Description: Enhances WooCommerce product pages with better ux and styles.
 * Version: 1.0
 * Author: Massruum
 * Author URI: https://massruum.ee
 */

// Activate the accompanied css file

function wooux_enqueue_styles() {
	if (is_product()) {
    		wp_enqueue_style('wooux-enhancer', plugin_dir_url(__FILE__) . 'wooux-enhancer.css');
	}
}
add_action('wp_enqueue_scripts', 'wooux_enqueue_styles');


// Add setup page to admin in woocommerce section
function wooux_include_admin_settings() {
    if (is_admin()) {
        include plugin_dir_path(__FILE__) . 'wooux-admin.php';
    }
}
add_action('admin_init', 'wooux_include_admin_settings');

function wooux_add_admin_menu() {
    if (!function_exists('WC')) return; // Check if WooCommerce is active

    add_submenu_page(
        'woocommerce', // Parent slug
        'WooUX Enhancer', // Page title
        'WooUX Enhancer', // Menu title
        'manage_options', // Capability
        'wooux-enhancer', // Menu slug
        'wooux_admin_page' // Callback function
    );
}
add_action('admin_menu', 'wooux_add_admin_menu');

add_action('admin_init', 'wooux_settings_init');


// Run on product page only

function wooux_add_minus_button() {
    if (!is_product()) return;
    $minus_icon_url = plugin_dir_url(__FILE__) . 'assets/icon-minus.svg';
    echo '<div class="input-button-group"><button class="wooux-minus"><img src="' . $minus_icon_url . '" alt="-"></button>';
}
add_action('woocommerce_before_quantity_input_field', 'wooux_add_minus_button');

function wooux_add_plus_button() {
    if (!is_product()) return;
    $plus_icon_url = plugin_dir_url(__FILE__) . 'assets/icon-plus.svg';
    echo '<button class="wooux-plus"><img src="' . $plus_icon_url . '" alt="+"></button></div>';
}
add_action('woocommerce_after_quantity_input_field', 'wooux_add_plus_button');


function wooux_add_quantity_buttons_script() {
    if (!is_product()) return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.input-button-group').on('click', '.plus', function(e) {
                var input = $(this).siblings('input.qty');
                input.val((input.val() - 0) + 1).trigger('change');
            });
            $('.input-button-group').on('click', '.minus', function(e) {
                var input = $(this).siblings('input.qty');
                if (input.val() > 1) {
                    input.val((input.val() - 0) - 1).trigger('change');
                }
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'wooux_add_quantity_buttons_script');
