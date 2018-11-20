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

    $option_values = get_option( 'srly_settings' );

    $default_values = array (
        'logo_url'              => '',
        'logo_position'         => 'bottom-left',
        'web_font'              => '',
        'font_header_weight'    => '600',
        'font_header_size'      => '4.5vw'
    );

    $data = shortcode_atts( $default_values, $option_values );

    register_setting(
        'srly_settings_group',
        'srly_settings'
    );

    add_settings_section(
        'section_logo',
        'Logo Settings',
        'srlyRenderSectionLogo',
        'screenly'
    );

    add_settings_field(
        'section_logo_url',
        'Brand logo',
        'srlyRenderSectionLogoUrl',
        'screenly',
        'section_logo',
        array (
            'label_for'   => 'screenly_logo_url',
            'name'        => 'logo_url',
            'value'       => esc_attr( $data['logo_url'] ),
            'option_name' => 'srly_settings',
        )
    );

    add_settings_field(
        'section_logo_position',
        'Logo position',
        'srlyRenderSectionLogoPosition',
        'screenly',
        'section_logo',
        array (
            'label_for'   => 'section_logo_position',
            'name'        => 'logo_position',
            'value'       => esc_attr( $data['logo_position'] ),
            'options'     => array (
                'top-left'     => 'Top Left',
                'top-center'   => 'Top Center',
                'top-right'    => 'Top Right',
                'bottom-left'  => 'Bottom Left',
                'bottom-right' => 'Bottom Right'
            ),
            'option_name' => 'srly_settings',
        )
    );

    add_settings_section(
        'section_font',
        'Font Settings',
        'srlyRenderSectionFont',
        'screenly'
    );

    add_settings_field(
        'section_font_url',
        'Webfont url',
        'srlyRenderSectionFontUrl',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_url',
            'name'        => 'font_url',
            'value'       => esc_attr( $data['font_url'] ),
            'option_name' => 'srly_settings',
        )
    );

    add_settings_field(
        'section_font_header_weight',
        'Header\'s font weight',
        'srlyRenderSectionFontHWeight',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_header_weight',
            'name'        => 'font_header_weight',
            'value'       => esc_attr( $data['font_header_weight'] ),
            'options'     => array (
                '100'       => 'Thin',
                '400'       => 'Normal',
                '600'       => 'Bold'
            ),
            'option_name' => 'srly_settings',
        )
    );

    add_settings_field(
        'section_font_header_size',
        'Header\'s font size',
        'srlyRenderSectionFontHSize',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_header_size',
            'name'        => 'font_header_size',
            'value'       => esc_attr( $data['font_header_size'] ),
            'options'     => array (
                '2.5vw'     => 'X-Small',
                '3.5vw'     => 'Small',
                '4.5vw'     => 'Medium',
                '5.5vw'     => 'Large',
                '6,5vw'     => 'X-Large'
            ),
            'option_name' => 'srly_settings',
        )
    );

}

function srlyRenderSectionLogo()
{
    print '<p>The following options control the logo. You can select the URL of picture and set the position of the logo on the screen.</p>';
}

function srlyRenderSectionLogoUrl( $args )
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

function srlyRenderSectionLogoPosition( $args )
{
    printf(
        '<select name="%1$s[%2$s]" id="%3$s">',
        $args['option_name'],
        $args['name'],
        $args['label_for']
    );

    foreach ( $args['options'] as $val => $title )
        printf(
            '<option value="%1$s" %2$s>%3$s</option>',
            $val,
            selected( $val, $args['value'], FALSE ),
            $title
        );

    print '</select>';
}

function srlyRenderSectionFont()
{
    print '<p>Here you can configure the font settings for different elements of page.</p>';
}

function srlyRenderSectionFontUrl( $args )
{
    printf(
        '<input type="url" id="%1$s" name="%4$s[%2$s]" class="large-text" value="%3$s">',
        $args['label_for'],
        $args['name'],
        $args['value'],
        $args['option_name']
    );
}

function srlyRenderSectionFontHWeight( $args )
{
    printf(
        '<select name="%1$s[%2$s]" id="%3$s">',
        $args['option_name'],
        $args['name'],
        $args['label_for']
    );

    foreach ( $args['options'] as $val => $title )
        printf(
            '<option value="%1$s" %2$s>%3$s</option>',
            $val,
            selected( $val, $args['value'], FALSE ),
            $title
        );

    print '</select>';
}

function srlyRenderSectionFontHSize( $args )
{
    printf(
        '<select name="%1$s[%2$s]" id="%3$s">',
        $args['option_name'],
        $args['name'],
        $args['label_for']
    );

    foreach ( $args['options'] as $val => $title )
        printf(
            '<option value="%1$s" %2$s>%3$s</option>',
            $val,
            selected( $val, $args['value'], FALSE ),
            $title
        );

    print '</select>';
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
