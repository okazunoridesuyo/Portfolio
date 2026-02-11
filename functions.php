<?php

add_theme_support('title-tag');
add_theme_support('post-thumbnails');

add_filter('document_title_separator', 'my_title_separator');
function my_title_separator($sep)
{
    $sep = '|';
    return $sep;
};

add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query()) {

        if ($query->is_date()) {
            $query->set('posts_per_page', 5);
        }

        if ($query->is_category()) {
            $query->set('posts_per_page', 5);
        }
    }
});

add_action('wp_enqueue_scripts', 'my_enqueue_script');
function my_enqueue_script()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Gabarito:wght@400..900&family=Kumbh+Sans:wght,YOPQ@100..900,300&family=Lexend+Tera:wght@100..900&family=M+PLUS+1+Code:wght@100..700&family=Murecho:wght@100..900&family=Vend+Sans:ital,wght@0,300..700;1,300..700&display=swap', [], null);
    wp_enqueue_style('google-icon-font', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=mail', [], null);

    wp_enqueue_style('portfolio-common', get_template_directory_uri() . '/css/common.css', [], filemtime(get_theme_file_path('/css/common.css')));
    wp_enqueue_script('portfolio-common', get_template_directory_uri() . '/js/common.js', [], filemtime(get_theme_file_path('/js/common.js')), true);

    if (is_front_page()) {
        wp_enqueue_style('portfolio-top', get_template_directory_uri() . '/css/page/top.css', [], filemtime(get_theme_file_path('/css/page/top.css')));
    }
    if (is_archive('web')) {
        wp_enqueue_style('portfolio-web', get_template_directory_uri() . '/css/page/web.css', [], filemtime(get_theme_file_path('/css/page/web.css')));
    }
    if (is_archive('illust') || is_tax('genre')) {
        wp_enqueue_style('portfolio-illust', get_template_directory_uri() . '/css/page/illust.css', [], filemtime(get_theme_file_path('/css/page/illust.css')));
    }
    if (is_page('profile')) {
        wp_enqueue_style('portfolio-profile', get_template_directory_uri() . '/css/page/profile.css', [], filemtime(get_theme_file_path('/css/page/profile.css')));
    }
    if (is_single()) {
        wp_enqueue_style('portfolio-single', get_template_directory_uri() . '/css/page/single.css', [], filemtime(get_theme_file_path('/css/page/single.css')));
    }
    if (is_page('blog') || is_date() || is_category()) {
        wp_enqueue_style('portfolio-blog', get_template_directory_uri() . '/css/page/blog.css', [], filemtime(get_theme_file_path('/css/page/blog.css')));
    }
    if (is_search()) {
        wp_enqueue_style('portfolio-search', get_template_directory_uri() . '/css/page/search.css', [], filemtime(get_theme_file_path('/css/page/search.css')));
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

    register_post_type(
        'illust',
        [
            'label' => 'イラスト',
            'public' => true,
            'has_archive' => true,
            'menu_position' => 6,
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
            'label' => '担当箇所',
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

    register_taxonomy(
        'illust_category',
        'illust',
        [
            'label' => 'イラスト区分',
            'hierarchical' => true,
            'rewrite' => [
                'slug' => 'illust_category',
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
        'illust',
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


add_action('after_setup_theme', function () {
    add_theme_support('editor-styles');
    add_editor_style('css/editor-style.css');
});

add_filter('wp_image_editors', function () {
    return ['WP_Image_Editor_GD', 'WP_Image_Editor_Imagick'];
});

add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    $ext = $data['ext'];
    $type = $data['type'];

    if (empty($ext) || empty($type)) {
        $base_type = wp_check_filetype($filename, $mimes);
        $data['ext']  = $base_type['ext'];
        $data['type'] = $base_type['type'];
    }
    return $data;
}, 10, 4);
