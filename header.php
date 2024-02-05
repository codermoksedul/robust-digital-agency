<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <header id="dm_header_area">
        <div class="container">
            <div class="dm_logo">
                <?php
                // Display custom logo
                $custom_logo_id = get_theme_mod('custom_logo_setting');
                $default_logo_url = get_template_directory_uri() . '/assets/images/logo.png';

                if ($custom_logo_id) {
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    echo '<a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '"></a>';
                } else {
                    // Fallback to default logo
                    echo '<a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($default_logo_url) . '" alt="' . get_bloginfo('name') . '"></a>';
                }
                ?>

                <!-- Other site branding elements -->

            </div>
            <button id="dm_nav_toggler">
                <i class="fas fa-bars"></i>
            </button>
            <nav class="dm_navbar_area">
                <?php
                // Display custom menu
                $custom_menu_slug = get_theme_mod('custom_menu_setting', 'primary');
                if (has_nav_menu($custom_menu_slug)) {
                    wp_nav_menu(array(
                        'theme_location' => $custom_menu_slug,
                        'menu_class' => 'nav-menu',
                        'walker' => new Dm_Nav_Walker(), // Custom walker for Font Awesome arrow
                    ));
                } else {
                    wp_nav_menu(array(
                        'theme_location' => 'primary', // Display default menu if custom menu is not set
                        'menu_class' => 'nav-menu',
                        'walker' => new Dm_Nav_Walker(), // Custom walker for Font Awesome arrow
                    ));
                }
                ?>
            </nav>
        </div>
    </header>

