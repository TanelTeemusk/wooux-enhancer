<?php

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
        <form action="options.php" method="post">
            <?php
            settings_fields('wooux-enhancer');
            do_settings_sections('wooux-enhancer');
            submit_button();
            ?>
        </form>


<style>
    .wp-button {
      background: #0073aa;
      border-color: #0073aa;
      color: #fff;
      text-decoration: none;
      text-shadow: none;
      cursor: pointer;
      border-radius: 3px;
      padding: 7px 10px;
      font-size: 12px;
    }
    .wp-button:hover {
      background: #008ec2;
      color: #fff;
    }
  </style>

<div style="border: 1px solid #B1B1B1; border-radius: 4px; width: 300px; padding: 15px; text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background-color: #FEFEFE;">
  
    <!-- Massruum Logo -->
    <a href="https://massruum.ee/en" title="Massruum, We Build Ecommerce Sites"><img src="<?php echo plugins_url('assets/massruum-logo.svg', __FILE__); ?>" alt="Massruum Logo" style="width: 80px; height: 80px; margin-bottom: 0px;"></a>
    <h2>Massruum</h2>
  
    <!-- Text -->
    <p style="margin-bottom: 10px;">Experience issues with WordPress or WooCommerce?</p>
    <p style="margin-bottom: 10px;">You're not alone, and we've got your back.</p>
  <br/>
    <!-- Call to Action -->
    <a href="https://massruum.ee/en/contact/" class="wp-button" title="Contact Massruum today and let's work together!">
      Contact us now
    </a>
  
  </div> <!-- massruum card end-->


    </div> <!-- admin page end-->

    <?php
}

// Register settings, sections, and fields
function wooux_settings_init() {
    register_setting('wooux-enhancer', 'wooux_plusminus_background');
    register_setting('wooux-enhancer', 'wooux_plusminus_hover_color');

    add_settings_section(
        'wooux_button_colors',
        __('Button Colors', 'wooux-enhancer'),
        'wooux_button_colors_section_callback',
        'wooux-enhancer'
    );

    add_settings_field(
        'wooux_plusminus_background',
        __('Background Color', 'wooux-enhancer'),
        'wooux_plusminus_background_render',
        'wooux-enhancer',
        'wooux_button_colors'
    );

    add_settings_field(
        'wooux_plusminus_hover_color',
        __('Hover Background Color', 'wooux-enhancer'),
        'wooux_plusminus_hover_color_render',
        'wooux-enhancer',
        'wooux_button_colors'
    );
}


// Render background color field
function wooux_plusminus_background_render() {
    $color = get_option('wooux_plusminus_background', '#B1B1B1');
    echo '<input type="text" class="wooux-color-picker" name="wooux_plusminus_background" value="' . esc_attr($color) . '">';
}

// Render hover background color field
function wooux_plusminus_hover_color_render() {
    $color = get_option('wooux_plusminus_hover_color', '#959595');
    echo '<input type="text" class="wooux-color-picker" name="wooux_plusminus_hover_color" value="' . esc_attr($color) . '">';
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
