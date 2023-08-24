<?php
function wooux_test_function() {
    // This is a test function.
}

function wooux_admin_page() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var colorInputs = document.querySelectorAll('input[type="color"]');
            colorInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    this.nextElementSibling.value = this.value;
                });
                input.nextElementSibling.addEventListener('input', function() {
                    this.previousElementSibling.value = this.value;
                });
            });
        });
    </script>
    <?php
    ?>
    <div class="wrap">
        <h2><?php _e('WooUX Enhancer Settings', 'wooux-enhancer'); ?></h2>
        <h3>Quantity selector options:</h3>
        <form action="options.php" method="post">
            <?php
            settings_fields('wooux-enhancer');
            do_settings_sections('wooux-enhancer');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


// Register settings, sections, and fields
function wooux_settings_init() {
    register_setting('wooux-enhancer', 'wooux_background_color');
    register_setting('wooux-enhancer', 'wooux_hover_background_color');

    add_settings_section(
        'wooux_button_colors',
        __('Button Colors', 'wooux-enhancer'),
        'wooux_button_colors_section_callback',
        'wooux-enhancer'
    );

    add_settings_field(
        'wooux_background_color',
        __('Background Color', 'wooux-enhancer'),
        'wooux_background_color_render',
        'wooux-enhancer',
        'wooux_button_colors'
    );

    add_settings_field(
        'wooux_hover_background_color',
        __('Hover Background Color', 'wooux-enhancer'),
        'wooux_hover_background_color_render',
        'wooux-enhancer',
        'wooux_button_colors'
    );
}

// Render background color field
// Render background color field
function wooux_background_color_render() {
    $color = get_option('wooux_background_color', '#B1B1B1');
    echo '<input type="text" class="wooux-color-picker" name="wooux_background_color" value="' . esc_attr($color) . '">';
}

// Render hover background color field
function wooux_hover_background_color_render() {
    $color = get_option('wooux_hover_background_color', '#959595');
    echo '<input type="text" class="wooux-color-picker" name="wooux_hover_background_color" value="' . esc_attr($color) . '">';
}


// Enqueue WP Color Picker scripts and styles
function wooux_enqueue_color_picker() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_add_inline_script('wp-color-picker', '
        jQuery(document).ready(function($){
            $(".wooux-color-picker").wpColorPicker();
        });
    ');
}
add_action('admin_enqueue_scripts', 'wooux_enqueue_color_picker');


// Section callback
function wooux_button_colors_section_callback() {
    echo __('Customize the background and hover colors for the quantity buttons.', 'wooux-enhancer');
}
