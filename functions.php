<?php


// Add support for Custom Logo
add_theme_support('custom-logo', array(
    'height' => 60,
    'width' => 160,
    'flex-height' => true,
    'flex-width' => true,
));

// Add support for Custom Menus
register_nav_menus(array(
    'primary' => __('Primary Menu', 'your-theme-textdomain'),
));

function customize_header_settings($wp_customize) {
    // Add a section for Header Settings
    $wp_customize->add_section('header_settings', array(
        'title' => __('Header Settings', 'your-theme-textdomain'),
        'priority' => 30,
    ));

    // Add a setting for the logo
    $wp_customize->add_setting('custom_logo_setting', array(
        'default' => '',
        'sanitize_callback' => 'absint', // You can use other sanitization callbacks
    ));

    // Add a control for the logo
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'custom_logo_setting', array(
        'label' => __('Select Logo', 'your-theme-textdomain'),
        'section' => 'header_settings',
        'settings' => 'custom_logo_setting',
        'mime_type' => 'image',
    )));

    // Add a setting for the menu
    $wp_customize->add_setting('custom_menu_setting', array(
		'default' => 'primary',
		'sanitize_callback' => 'your_theme_sanitize_menu',
		'transport' => 'postMessage', // Enable live preview
	));
	

    // Add a control for the menu
    $wp_customize->add_control('custom_menu_setting', array(
        'type' => 'select',
        'label' => __('Select Menu', 'your-theme-textdomain'),
        'section' => 'header_settings',
        'choices' => your_theme_get_all_menus(), // Create a function to get all menus
    ));
}
add_action('customize_register', 'customize_header_settings');


// Sanitize menu selection
function your_theme_sanitize_menu($input) {
    return sanitize_key($input);
}

// Get all menus for dropdown
function your_theme_get_all_menus() {
    $menus = get_terms('nav_menu', array('hide_empty' => false));
    $menu_choices = array();

    foreach ($menus as $menu) {
        $menu_choices[$menu->term_id] = $menu->name;
    }

    return $menu_choices;
}


class Dm_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $current_object_id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $output .= '<li class="' . esc_attr(implode(' ', $classes)) . '">';

        // Add Font Awesome arrow if it's a parent with a submenu
        if ($args->walker->has_children) {
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . ' <i class="fas fa-chevron-down"></i></a>';
        } else {
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
        }
    }
}




function enqueue_styles() {
    wp_enqueue_style('styles', get_template_directory_uri() . '/css/styles.min.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');


