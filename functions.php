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
    if (is_post_type_archive('web')) {
        wp_enqueue_style('portfolio-web', get_template_directory_uri() . '/css/page/web.css', [], filemtime(get_theme_file_path('/css/page/web.css')));
    }
    if (is_post_type_archive('illust') || is_tax('genre')) {
        wp_enqueue_style('portfolio-illust', get_template_directory_uri() . '/css/page/illust.css', [], filemtime(get_theme_file_path('/css/page/illust.css')));
    }
    if (is_page('profile')) {
        wp_enqueue_style('portfolio-profile', get_template_directory_uri() . '/css/page/profile.css', [], filemtime(get_theme_file_path('/css/page/profile.css')));
    }
    if (is_page('blog') || is_date() || is_category() || is_singular('post')) {
        wp_enqueue_style('portfolio-blog', get_template_directory_uri() . '/css/page/blog.css', [], filemtime(get_theme_file_path('/css/page/blog.css')));
    }
    if (is_post_type_archive('game')) {
        wp_enqueue_style('portfolio-game', get_template_directory_uri() . '/css/page/game.css', [], filemtime(get_theme_file_path('/css/page/game.css')));
    }
    if (is_post_type_archive('stream')) {
        wp_enqueue_style('portfolio-stream', get_template_directory_uri() . '/css/page/stream.css', [], filemtime(get_theme_file_path('/css/page/stream.css')));
    }
    if (is_post_type_archive('text') || is_tax('text_tag')) {
        wp_enqueue_style('portfolio-text', get_template_directory_uri() . '/css/page/text.css', [], filemtime(get_theme_file_path('/css/page/text.css')));
    }
    if (is_search()) {
        wp_enqueue_style('portfolio-search', get_template_directory_uri() . '/css/page/search.css', [], filemtime(get_theme_file_path('/css/page/search.css')));
    }
    if (is_singular('text')) {
        wp_enqueue_style('portfolio-single-text', get_template_directory_uri() . '/css/page/single-text.css', [], filemtime(get_theme_file_path('/css/page/single-text.css')));
        wp_enqueue_script('portfolio-single-text', get_template_directory_uri() . '/js/single-text.js', [], filemtime(get_theme_file_path('/js/single-text.js')), true);
    } elseif (is_singular('stream')) {
        wp_enqueue_style('portfolio-single-stream', get_template_directory_uri() . '/css/page/single-stream.css', [], filemtime(get_theme_file_path('/css/page/single-stream.css')));
    } elseif (is_single()) {
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

    register_post_type(
        'game',
        [
            'label' => 'ゲーム',
            'public' => true,
            'has_archive' => true,
            'menu_position' => 7,
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
        'stream',
        [
            'label' => '音楽・動画',
            'public' => true,
            'has_archive' => true,
            'menu_position' => 8,
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
        'text',
        [
            'label' => '読み物',
            'public' => true,
            'has_archive' => true,
            'menu_position' => 9,
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

    register_taxonomy(
        'game_genre',
        'game',
        [
            'label' => 'ゲームジャンル',
            'hierarchical' => true,
            'rewrite' => [
                'slug' => 'game_genre',
                'with_front' => false,
            ],
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'show_in_quick_edit' => true,
        ],
    );

    register_taxonomy(
        'media_category',
        'stream',
        [
            'label' => 'メディアカテゴリ',
            'hierarchical' => true,
            'rewrite' => [
                'slug' => 'media_category',
                'with_front' => false,
            ],
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'show_in_quick_edit' => true,
        ],
    );

    register_taxonomy(
        'text_tag',
        'text',
        [
            'label' => 'タグ',
            'hierarchical' => false,
            'rewrite' => [
                'slug' => 'text_tag',
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
        'insert_custom_fields_illust',
        'illust',
        'normal',
    );

    add_meta_box(
        'stream_management',
        'コンテンツ詳細',
        'insert_custom_fields_stream',
        'stream',
        'normal',
    );
});

function insert_custom_fields_illust($post)
{
    $illust_based_on = get_post_meta($post->ID, 'illust_based_on', true);

    echo '<div>';
    echo '<label for="illust_based_on">原作名：</label>';
    echo '<input type="text" name="illust_based_on" class="illust_based_on" id= "illust_based_on" value="' . $illust_based_on . '" >';
    echo '</div>';
}

function insert_custom_fields_stream($post)
{
    $stream_content = get_post_meta($post->ID, 'stream_content', true);
    echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    echo '<label for="stream_content">動画・音声ファイル：</label>';
    echo '<input type="hidden" name="stream_content" class="stream_content_input" value="' . $stream_content . '" />';
    echo '<video class="stream_content__preview_field" src="' . $stream_content . '" style="width:200px; height:100px; object-fit:contain; margin-inline:8px;" controls playsinline ></video>';
    echo '<button type="button" id="stream_content_select" style="margin-right:8px;">選択</button>';
    echo '<button type="button" id="stream_content_delete">削除</button>';
    echo '<p class="stream_content_filename" style="margin-inline:10px;">ファイル名： ' . basename($stream_content) . '</p>';
    echo '</div>';

    $stream_img = get_post_meta($post->ID, 'stream_img', true);
    echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    echo '<label for="stream_img">ジャケット画像：</label>';
    echo '<input type="hidden" name="stream_img" class="stream_img_input" value="' . $stream_img . '" />';
    echo '<img class="stream_img__preview_field" src="' . $stream_img . '" alt="" style="width:100px; height:100px; margin-inline:8px;" />';
    echo '<button type="button" id="stream_img_select" style="margin-right:8px;">選択</button>';
    echo '<button type="button" id="stream_img_delete">削除</button>';
    echo '</div>';

    $stream_lyric = get_post_meta($post->ID, 'stream_lyric', true);
    echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    echo '<label for="stream_lyric">作詞：</label>';
    echo '<input type="text" name="stream_lyric" class="stream_lyric_input" value="' . $stream_lyric . '" />';
    echo '</div>';

    $stream_music = get_post_meta($post->ID, 'stream_music', true);
    echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    echo '<label for="stream_music">作曲：</label>';
    echo '<input type="text" name="stream_music" class="stream_music_input" value="' . $stream_music . '" />';
    echo '</div>';

    $stream_arrangement = get_post_meta($post->ID, 'stream_arrangement', true);
    echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    echo '<label for="stream_arrangement">編曲：</label>';
    echo '<input type="text" name="stream_arrangement" class="stream_arrangement_input" value="' . $stream_arrangement . '" />';
    echo '</div>';

    $stream_edit = get_post_meta($post->ID, 'stream_edit', true);
    echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    echo '<label for="stream_edit">編集：</label>';
    echo '<input type="text" name="stream_edit" class="stream_edit_input" value="' . $stream_edit . '" />';
    echo '</div>';

    $stream_lyrics_text = get_post_meta($post->ID, 'stream_lyrics_text', true);
    echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    echo '<label for="stream_lyrics_text">歌詞：</label><br>';
    echo '<textarea type="text" name="stream_lyrics_text" class="stream_lyrics_text_input" rows="10" cols="50">' . $stream_lyrics_text . '</textarea>';
    echo '</div>';

    $stream_detail = get_post_meta($post->ID, 'stream_detail', true);
    echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    echo '<label for="stream_detail">詳細：</label><br>';
    echo '<textarea type="text" name="stream_detail" class="stream_detail_input" rows="8" cols="50">' . $stream_detail . '</textarea>';
    echo '</div>';
}

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_media();
    wp_enqueue_script('custom_media_uploader', get_template_directory_uri() . '/js/custom_media_uploader.js', ['jquery'], null, true);
});

add_action('save_post', function ($post) {
    if (isset($_POST['illust_based_on']) && $_POST['illust_based_on'] !== '') {
        update_post_meta($post, 'illust_based_on', $_POST['illust_based_on']);
    } else {
        delete_post_meta($post, 'illust_based_on');
    }

    if (isset($_POST['stream_content']) && $_POST['stream_content'] !== '') {
        update_post_meta($post, 'stream_content', $_POST['stream_content']);
    } else {
        delete_post_meta($post, 'stream_content');
    }

    if (isset($_POST['stream_img']) && $_POST['stream_img'] !== '') {
        update_post_meta($post, 'stream_img', $_POST['stream_img']);
    } else {
        delete_post_meta($post, 'stream_img');
    }

    if (isset($_POST['stream_lyric']) && $_POST['stream_lyric'] !== '') {
        update_post_meta($post, 'stream_lyric', $_POST['stream_lyric']);
    } else {
        delete_post_meta($post, 'stream_lyric');
    }

    if (isset($_POST['stream_music']) && $_POST['stream_music'] !== '') {
        update_post_meta($post, 'stream_music', $_POST['stream_music']);
    } else {
        delete_post_meta($post, 'stream_music');
    }

    if (isset($_POST['stream_arrangement']) && $_POST['stream_arrangement'] !== '') {
        update_post_meta($post, 'stream_arrangement', $_POST['stream_arrangement']);
    } else {
        delete_post_meta($post, 'stream_arrangement');
    }

    if (isset($_POST['stream_edit']) && $_POST['stream_edit'] !== '') {
        update_post_meta($post, 'stream_edit', $_POST['stream_edit']);
    } else {
        delete_post_meta($post, 'stream_edit');
    }

    if (isset($_POST['stream_lyrics_text']) && $_POST['stream_lyrics_text'] !== '') {
        update_post_meta($post, 'stream_lyrics_text', $_POST['stream_lyrics_text']);
    } else {
        delete_post_meta($post, 'stream_lyrics_text');
    }

    if (isset($_POST['stream_detail']) && $_POST['stream_detail'] !== '') {
        update_post_meta($post, 'stream_detail', $_POST['stream_detail']);
    } else {
        delete_post_meta($post, 'stream_detail');
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
