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
 * Register our srlyEnqueueScripts to the admin_enqueue_scripts action hook
 *
 * @package ScreenlyCast
 * @since   0.0.1
 */
add_action( 'admin_enqueue_scripts', 'srlyEnqueueScripts' );


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
/*
    $option_values = get_option( 'srly_settings' );

    $default_values = array (
        'logo_url'              => '',
        'logo_position'         => 'top-right',
        'font_url'              => 'https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500',
        'font_header_weight'    => '600',
        'font_header_size'      => '4.5vw',
        'font_header_color'     => '#fe4567',
        'font_meta_weight'      => '400',
        'font_meta_size'        => '4.5vw',
        'font_meta_color'       => '#fe4567',
        'font_content_weight'   => '400',
        'font_content_size'     => '4.5vw',
        'font_content_color'    => '#fe4567'
    );

    $data = shortcode_atts( $default_values, $option_values );
*/

    $data = get_option( 'srly_settings' );

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
        'Google Web Font',
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
        'srlyRenderSectionFontHeaderWeight',
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
        'srlyRenderSectionFontHeaderSize',
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

    add_settings_field(
        'section_font_header_color',
        'Header\'s font color',
        'srlyRenderSectionFontHeaderColor',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_header_color',
            'name'        => 'font_header_color',
            'value'       => esc_attr( $data['font_header_color'] ),
            'option_name' => 'srly_settings',
        )
    );

    add_settings_field(
        'section_font_meta_weight',
        'Meta font weight',
        'srlyRenderSectionFontMetaWeight',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_meta_weight',
            'name'        => 'font_meta_weight',
            'value'       => esc_attr( $data['font_meta_weight'] ),
            'options'     => array (
                '100'       => 'Thin',
                '400'       => 'Normal',
                '600'       => 'Bold'
            ),
            'option_name' => 'srly_settings',
        )
    );

    add_settings_field(
        'section_font_meta_size',
        'Meta font size',
        'srlyRenderSectionFontMetaSize',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_meta_size',
            'name'        => 'font_meta_size',
            'value'       => esc_attr( $data['font_meta_size'] ),
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

    add_settings_field(
        'section_font_meta_color',
        'Meta font color',
        'srlyRenderSectionFontMetaColor',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_meta_color',
            'name'        => 'font_meta_color',
            'value'       => esc_attr( $data['font_meta_color'] ),
            'option_name' => 'srly_settings',
        )
    );

    add_settings_field(
        'section_font_content_weight',
        'Content font weight',
        'srlyRenderSectionFontContentWeight',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_content_weight',
            'name'        => 'font_content_weight',
            'value'       => esc_attr( $data['font_content_weight'] ),
            'options'     => array (
                '100'       => 'Thin',
                '400'       => 'Normal',
                '600'       => 'Bold'
            ),
            'option_name' => 'srly_settings',
        )
    );

    add_settings_field(
        'section_font_content_size',
        'Content font size',
        'srlyRenderSectionFontContentSize',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_content_size',
            'name'        => 'font_content_size',
            'value'       => esc_attr( $data['font_content_size'] ),
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

    add_settings_field(
        'section_font_content_color',
        'Content font color',
        'srlyRenderSectionFontContentColor',
        'screenly',
        'section_font',
        array (
            'label_for'   => 'screenly_font_content_color',
            'name'        => 'font_content_color',
            'value'       => esc_attr( $data['font_content_color'] ),
            'option_name' => 'srly_settings',
        )
    );

}

function srlyRenderSectionLogo()
{
    print '<p>The following options control the logo. You can select the URL the picture and set the position of the logo on the screen.</p>';
}

function srlyRenderSectionLogoUrl( $args )
{
    printf(
        '<input type="url" id="%1$s" name="%4$s[%2$s]" class="regular-text srly-url" value="%3$s" />
         <input type="button" class="button srly-browse" value="Choose Image" />
         <input type="button" class="button srly_clear_url" value="&times" />
         <p class="description">Please, select an image in the media library. We recommend using PNG with transparency.</p>
         <p class="srly-image-preview"><img style="max-width:98px;" src=""/></p>',
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
    print '<p>Here you can configure the font settings for different elements the page.</p>';
}

function srlyRenderSectionFontUrl( $args )
{
    printf(
        '<input type="url" id="%1$s" name="%4$s[%2$s]" class="regular-text" value="%3$s" />
        <input type="button" class="button srly_clear_url" value="&times" />
        <p class="description">Here you can add Google web fonts to your website. Specify the font family with the base URL.</p>
        <p class="description">More information on a <a href="https://fonts.google.com/" target="_blank">Google Fonts API</a> page.</p>',
        $args['label_for'],
        $args['name'],
        $args['value'],
        $args['option_name']
    );
}

function srlyRenderSectionFontHeaderWeight( $args )
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

function srlyRenderSectionFontHeaderSize( $args )
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

function srlyRenderSectionFontHeaderColor( $args )
{
    printf(
        '<input type="text" id="%1$s" name="%4$s[%2$s]" class="iris_color" value="%3$s" />',
        $args['label_for'],
        $args['name'],
        $args['value'],
        $args['option_name']
    );
}

function srlyRenderSectionFontMetaWeight( $args )
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

function srlyRenderSectionFontMetaSize( $args )
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

function srlyRenderSectionFontMetaColor( $args )
{
    printf(
        '<input type="text" id="%1$s" name="%4$s[%2$s]" class="iris_color" value="%3$s" />',
        $args['label_for'],
        $args['name'],
        $args['value'],
        $args['option_name']
    );
}

function srlyRenderSectionFontContentWeight( $args )
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

function srlyRenderSectionFontContentSize( $args )
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

function srlyRenderSectionFontContentColor( $args )
{
    printf(
        '<input type="text" id="%1$s" name="%4$s[%2$s]" class="iris_color" value="%3$s" />',
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


function srlyEnqueueScripts( $hook ) {
    if( 'settings_page_'.'screenly' != $hook )
        return;
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_media();
    add_action( 'admin_footer', 'srlyFooterScript', 99 );
}


function srlyFooterScript(){
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('.iris_color').wpColorPicker({
            change: function(event, ui){ },
            clear: function(){ },
            hide: true,
            palettes: false,
            target: false,
            color: false
        });

        $('.srly-browse').on('click', function(event){
            event.preventDefault();

            var self = $(this);

            // Create the media frame.
            var file_frame = (wp.media.frames.file_frame = wp.media({
                title: self.data('uploader_title'),
                button:{
                    text: self.data('uploader_button_text')
                },
                multiple: false
            }));

            file_frame.on('select', function(){
                attachment = file_frame
                    .state()
                    .get('selection')
                    .first()
                    .toJSON();
                self
                    .prev('.srly-url')
                    .val(attachment.url)
                    .change();
			});

			// Open the modal
			file_frame.open();
		});

		$('input.srly-url').on('change keyup paste input', function(){
            var self = $(this);
            self
                .parent()
                .children('.srly-image-preview')
                .children('img')
                .attr('src', self.val());
        })
        .change();
        
        $('.srly_clear_url').click(function() {
            var answer = confirm('You want to clear this field. Are you sure?');
            if (answer == true) {
                var self = $(this);
                self
                    .parent()
                    .children('input[type=url]')
                    .val('')
                    .change();
            }
            return false;
        });
});
    </script>
    <?php
}
