<?php
/**
 * Make sure we don't expose any info if called directly.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  ScreenlyCast
 * @author   Peter Monte <pmonte@screenly.io>
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html  GPLv2
 * @link     https://github.com/Screenly/Screenly-Cast-for-WordPress
 * @since    0.0.1
 */

/**
 * Register our srlyOptionsPage to the admin_menu action hook
 *
 * @package ScreenlyCast
 * @since   0.0.1
 */
add_action( 'admin_menu', 'srlyOptionsPage' );


/**
 * Register our srlySettingsInit to the admin_init action hook
 *
 * @package ScreenlyCast
 * @since   0.0.1
 */
add_action( 'admin_init', 'srlySettingsInit' );


/**
 * Add the sub-menu item to main menu under Settings. Creates a dedicated page for
 * the plugin.
 *
 * @package ScreenlyCast
 * @since   0.0.1
 * @return  void
 */
function srlyOptionsPage()
{
    add_options_page(
        'Screenly Cast',      // $page_title,
        'Screenly',           // $menu_title,
        'manage_options',     // $capability,
        'screenly',           // $menu_slug,
        'srlyOptionsPageHTML' // Callback
    );
}


/**
 * Custom option and settings
 *
 * @package ScreenlyCast
 * @since   0.0.1
 * @return  void
 */
function srlySettingsInit()
{
    $data = get_option( 'srly_settings' );

    register_setting(
        'srly_settings_group',
        'srly_settings'
    );

    add_settings_section(
        'section_logo',
        __('Settings', SRLY_THEME),
        'srlyRenderSectionLogo',
        'screenly'
    );

    add_settings_field(
        'section_logo_field_path',
        __('Brand logo', SRLY_THEME),
        'srlyRenderSectionLogoFieldUrl',
        'screenly',
        'section_logo',
        array (
            'label_for'   => 'screenly_options_logo',
            'name'        => 'url',
            'value'       => esc_attr( $data['url'] ),
            'option_name' => 'srly_settings',
        )
    );
}

function srlyRenderSectionLogo()
{
    print '<p>Use this page to change your settings.</p>';
}
function srlyRenderSectionLogoFieldUrl( $args )
{
    printf(
        '<input type="url" id="%1$s" name="%4$s[%2$s]" class="large-text" value="%3$s">
         <p class="description">Upload an image to you media library. Check it\'s url and copy paste to the input above.</p>
         <p class="description">We recomend an image with the proportion of <b>314 x 98 px</b></p>',
        $args['label_for'],
        $args['name'],
        $args['value'],
        $args['option_name']
    );
}

/**
 * Prints out the form and also any succes message.
 *
 * @package ScreenlyCast
 * @since   0.0.1
 * @return  void
 */
function srlyOptionsPageHTML()
{
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="POST">
            <?php 
            settings_fields( 'srly_settings_group' );
            do_settings_sections( 'screenly' ); 
            submit_button( 'Save Settings' ); 
            ?>
        </form>
    </div>
    <?php
}
