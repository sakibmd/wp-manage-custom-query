<?php

/**
 * Plugin Name:       Excerpt Support
 * Plugin URI:        https://sakibmd.xyz/
 * Description:       To add excerpt checkbox in your screen
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sakib Mohammed
 * Author URI:        https://sakibmd.xyz/
 * License:           GPL v2 or later
 * License URI:
 * Text Domain:       excerpt
 * Domain Path:       /languages
 */

class Excerpt
{
    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'excerpt_load_textdomain'));
        add_action('admin_menu', array($this, 'excerpt_add_metabox'));
        add_action('save_post', array($this, 'excerpt_save_metabox'));
        add_action('pre_get_posts', array($this, 'excerpt_hide_blogs_from_blogpage')); //for hide some posts from blogpost

    }

    public function excerpt_hide_blogs_from_blogpage($wpq)
    {
        if (is_home() && is_main_query()) {
            $wpq->set('post__not_in', array(15,17)); 
            $wpq->set('tag__not_in', array(3));
        }
    }

    public function excerpt_save_metabox($post_id)
    {

        $is_featured = isset($_POST['excerpt_is_featured']) ? $_POST['excerpt_is_featured'] : '';
        $is_homepage = isset($_POST['excerpt_is_homepage']) ? $_POST['excerpt_is_homepage'] : '';

        $is_featured = sanitize_text_field($is_featured);
        $is_homepage = sanitize_text_field($is_homepage);

        update_post_meta($post_id, 'excerpt_is_featured', $is_featured);
        update_post_meta($post_id, 'excerpt_is_homepage', $is_homepage);
    }

    public function excerpt_add_metabox()
    {
        add_meta_box(
            'excerpt_is_featured',
            __('Add value to show featured image', 'excerpt'),
            array($this, 'excerpt_is_featured_display_metabox'),
            'post',
        );
    }

    public function excerpt_is_featured_display_metabox($post)
    {
        $excerpt_is_featured_value = get_post_meta($post->ID, 'excerpt_is_featured', true);
        $excerpt_is_homepage_value = get_post_meta($post->ID, 'excerpt_is_homepage', true);

        $label1 = __('Featured Value', 'excerpt');
        $label2 = __('Homepage', 'excerpt');

        $metabox_html = <<<EOD
<p>
<label for="excerpt_is_featured">{$label1}: </label>
<input type="text" name="excerpt_is_featured" id="excerpt_is_featured" value="{$excerpt_is_featured_value}" />
<br/><br/>
<label for="excerpt_is_homepage">{$label2}: </label>
<input type="text" name="excerpt_is_homepage" id="excerpt_is_homepage" value="{$excerpt_is_homepage_value}" />
<p>

EOD;

        echo $metabox_html;

    }

    public function excerpt_load_textdomain()
    {
        load_plugin_textdomain('excerpt', false, dirname(__FILE__) . "/languages");
    }

}

new Excerpt();
