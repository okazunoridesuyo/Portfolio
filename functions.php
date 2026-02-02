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

    if (is_front_page()) {
        wp_enqueue_style('portfolio-top', get_template_directory_uri() . '/css/page/top.css', [], filemtime(get_theme_file_path('/css/page/top.css')));
    }
    if (is_page('web')) {
        wp_enqueue_style('portfolio-web', get_template_directory_uri() . '/css/page/web.css', [], filemtime(get_theme_file_path('/css/page/web.css')));
    }
    if (is_page('illust')) {
        wp_enqueue_style('portfolio-illust', get_template_directory_uri() . '/css/page/illust.css', [], filemtime(get_theme_file_path('/css/page/illust.css')));
    }
    if (is_page('profile')) {
        wp_enqueue_style('portfolio-profile', get_template_directory_uri() . '/css/page/profile.css', [], filemtime(get_theme_file_path('/css/page/profile.css')));
    }
};
