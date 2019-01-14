<?php
/**
 * Header
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
defined('ABSPATH') or die("No script kiddies please!");
?>
<!doctype html>
<html>
    <head>
        <!--
            META CONFIG
        -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <!--
            CSS
        -->
        <?php 
		$data = get_option('srly_settings');
		extract($data);

        if (!empty($font_name)) {
            echo '<link href="https://fonts.googleapis.com/css?family='.str_replace(' ', '+', $font_name).':300,400,700" rel="stylesheet">';
        };

        wp_head();

        printf('
        <style>
        body, html {font-family: "%1$s", sans-serif}
        h1 {font-weight:%2$s;font-size:%3$s;color:%4$s}
        time {font-weight:%5$s;font-size:%6$s;color:%7$s}
        .content {font-size:%8$s}
        </style>',
        $font_name,
        $font_header_weight,
        $font_header_size,
        $font_header_color,
        $font_meta_weight,
        $font_meta_size,
        $font_meta_color,
//        $font_content_weight,
        $font_content_size
//        $font_content_color
        );
        ?>

    </head>
    <body <?php body_class()?>>
    <?php if (!empty($logo_url)) : ?>
    <div class="logo <?php echo $logo_position ?>">
        <img src="<?php echo $logo_url ?>" alt="">
    </div>
    <?php endif; ?>
    