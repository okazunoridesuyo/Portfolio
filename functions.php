<?php

add_theme_support('title-tag');
add_theme_support('post-thumbnails');

add_filter('document_title_separator', 'my_title_separator');
function my_title_separator($sep)
{
    $sep = '|';
    return $sep;
};

add_action('wp_enqueue_scripts', 'my_enqueue_script');
function my_enqueue_script()
{
    wp_enqueue_style('portfolio-common', get_template_directory_uri() . '/css/common.css', [], filemtime(get_theme_file_path('/css/common.css')));
    wp_enqueue_script('portfolio-common', get_template_directory_uri() . '/js/common.js', [], filemtime(get_theme_file_path('/js/common.js')), true);

    if (is_front_page()) {
        wp_enqueue_style('portfolio-top', get_template_directory_uri() . '/css/page/top.css', [], filemtime(get_theme_file_path('/css/page/top.css')));
    }
    if (is_archive('web')) {
        wp_enqueue_style('portfolio-web', get_template_directory_uri() . '/css/page/web.css', [], filemtime(get_theme_file_path('/css/page/web.css')));
    }
    if (is_page('illust') || is_category()) {
        wp_enqueue_style('portfolio-illust', get_template_directory_uri() . '/css/page/illust.css', [], filemtime(get_theme_file_path('/css/page/illust.css')));
    }
    if (is_page('profile')) {
        wp_enqueue_style('portfolio-profile', get_template_directory_uri() . '/css/page/profile.css', [], filemtime(get_theme_file_path('/css/page/profile.css')));
    }
    if (is_single()) {
        wp_enqueue_style('portfolio-single', get_template_directory_uri() . '/css/page/single.css', [], filemtime(get_theme_file_path('/css/page/single.css')));
    }
};

add_action('init', function () {
    register_post_type(
        'web',
        [
            'label' => 'Webサイト',
            'public' => true,
            'has_archive' => true,
            'menu_position' => 5,
            'show_in_rest' => true,
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'author',
                'excerpt',
                'custom-fields',
                'post-formats',
            ],
        ],
    );
});

add_action('init', function () {
    register_taxonomy(
        'info',
        'web',
        [
            'label' => '手掛けた部分',
            'hierarchical' => true,
            'rewrite' => [
                'slug' => 'info',
                'with_front' => false,
            ],
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'show_in_quick_edit' => true,
        ],
    );
});

add_action('admin_menu', function () {
    add_meta_box(
        'info_setting',
        '詳細',
        'insert_custom_fields',
        'post',
        'normal',
    );
});

function insert_custom_fields($post)
{
    $based_on = get_post_meta($post->ID, 'based_on', true);

    echo '<div>';
    echo '<label for="based_on">原作名：</label>';
    echo '<input type="text" name="based_on" class="based_on" id= "based_on" value="' . $based_on . '" >';
    echo '</div>';
}

add_action('save_post', function ($post) {
    if (isset($_POST['based_on']) && $_POST['based_on'] !== '') {
        update_post_meta($post, 'based_on', $_POST['based_on']);
    } else {
        delete_post_meta($post, 'based_on');
    }
});
