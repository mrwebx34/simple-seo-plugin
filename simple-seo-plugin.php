<?php
/*
Plugin Name: Simple SEO Plugin
Description: Enhance your WordPress site's SEO by adding custom meta information to your posts and pages.
Version: 1.0
Author: Ranjan
*/

// Add SEO meta box to posts and pages
function simple_seo_plugin_meta_box() {
    add_meta_box('simple_seo_meta_box', 'SEO Settings', 'simple_seo_plugin_render_meta_box', ['post', 'page'], 'normal', 'high');
}
add_action('add_meta_boxes', 'simple_seo_plugin_meta_box');

// Render SEO meta box content
function simple_seo_plugin_render_meta_box($post) {
    // Get existing meta values
    $meta_title = get_post_meta($post->ID, '_simple_seo_title', true);
    $meta_description = get_post_meta($post->ID, '_simple_seo_description', true);
    $focus_keyword = get_post_meta($post->ID, '_simple_seo_focus_keyword', true);
    ?>
    <div class="simple-seo-container">
        <div class="simple-seo-form-group">
            <label for="simple_seo_title">SEO Title</label>
            <input type="text" id="simple_seo_title" name="simple_seo_title" value="<?php echo esc_attr($meta_title); ?>">
        </div>
        <div class="simple-seo-form-group">
            <label for="simple_seo_description">SEO Description</label>
            <textarea id="simple_seo_description" name="simple_seo_description"><?php echo esc_textarea($meta_description); ?></textarea>
        </div>
        <div class="simple-seo-form-group">
            <label for="simple_seo_focus_keyword">Focus Keyword</label>
            <input type="text" id="simple_seo_focus_keyword" name="simple_seo_focus_keyword" value="<?php echo esc_attr($focus_keyword); ?>">
        </div>
    </div>
    <style>
        .simple-seo-container {
            margin-top: 20px;
        }

        .simple-seo-form-group {
            margin-bottom: 20px;
        }

        .simple-seo-form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .simple-seo-form-group input,
        .simple-seo-form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
    </style>
    <?php
}

// Save SEO meta box data
function simple_seo_plugin_save_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Save meta values
    update_post_meta($post_id, '_simple_seo_title', sanitize_text_field($_POST['simple_seo_title']));
    update_post_meta($post_id, '_simple_seo_description', sanitize_textarea_field($_POST['simple_seo_description']));
    update_post_meta($post_id, '_simple_seo_focus_keyword', sanitize_text_field($_POST['simple_seo_focus_keyword']));
}
add_action('save_post', 'simple_seo_plugin_save_meta_box');
