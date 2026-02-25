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
    if (is_post_type_archive('apps')) {
        wp_enqueue_style('portfolio-apps', get_template_directory_uri() . '/css/page/apps.css', [], filemtime(get_theme_file_path('/css/page/apps.css')));
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

add_action('rest_api_init', function () {
    register_rest_route('json_delivery/v1', '/receive-data', [
        'methods' => 'GET',
        'callback' => 'get_json_data',
        'permission_callback' => function ($request) {
            return current_user_can('edit_posts');
        },
    ]);

    register_rest_route('json_delivery/v1', '/receive-data', [
        'methods' => 'POST',
        'callback' => 'post_json_data',
        'permission_callback' => function ($request) {
            return current_user_can('edit_posts');
        },
    ]);
});

function get_json_data($request)
{
    $json = $request->get_params();

    return [
        'status' => 'get ok.',
        'data' => $json,
    ];
}

function post_json_data($request)
{
    $json = $request->get_json_params();

    $post_id = $json['post_id'];

    update_post_meta($post_id, 'jsf_counter', wp_json_encode($json));

    return [
        'status' => 'post ok.',
        'data' => $json,
    ];
}

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
        'apps',
        [
            'label' => 'アプリ（ソフトウェア）',
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
        'illust_tag',
        'illust',
        [
            'label' => 'イラストタグ',
            'hierarchical' => false,
            'rewrite' => [
                'slug' => 'illust_tag',
                'with_front' => false,
            ],
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'show_in_quick_edit' => true,
        ],
    );

    register_taxonomy(
        'apps_category',
        'apps',
        [
            'label' => 'ソフトウェアカテゴリ',
            'hierarchical' => true,
            'rewrite' => [
                'slug' => 'apps_category',
                'with_front' => false,
            ],
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'show_in_quick_edit' => true,
        ],
    );

    register_taxonomy(
        'apps_genre',
        'apps',
        [
            'label' => '技術・ジャンル',
            'hierarchical' => false,
            'rewrite' => [
                'slug' => 'apps_genre',
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
        'media_genre',
        'stream',
        [
            'label' => 'ジャンル',
            'hierarchical' => false,
            'rewrite' => [
                'slug' => 'media_genre',
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

    add_meta_box(
        'apps_files',
        '追加ファイル',
        'insert_custom_fields_apps',
        'apps',
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

function insert_custom_fields_apps($post)
{
    $json_data = get_post_meta($post->ID, 'jsf_counter', true);
    $json_data = json_decode($json_data, true);

    $count = $json_data['count'] ?? 0;

    wp_localize_script('custom_media_uploader', 'jsf_counter', [
        'post_id' => $post->ID,
        'count' => $count,
        'resturl' => esc_url(rest_url()),
        'nonce' => wp_create_nonce('wp_rest'),
    ]);

    echo 'count:' . $count;

    echo '<div id="add_js_file__section" style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';

    echo '<label for="add_js_file">読み込みJavaScriptファイルの追加：</label>';
    echo '<button type="button" id="add_js_file__btn" style="font-size:16px;">＋</button>';
    echo '<button type="button" id="remove_js_file__btn" style="font-size:16px;">ー</button>';

    echo '<div class="add_js_file__select_file_section" style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
    if ($count) {
        for ($i = 1; $i <= $count; $i++) {
            ${'js_file_url' . $i} = get_post_meta($post->ID, 'js_file_url' . $i, true);
            echo '<div class="additional_js_file__section' . $i . '" style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
            echo '<label for="additional_js_file__input' . $i . '" style="margin-right:8px;">追加JavaScriptファイル' . $i . '：</label>';
            echo '<input type="hidden" name="additional_js_file__input' . $i . '" class="additional_js_file__input' . $i . '" value="' . ${'js_file_url' . $i} . '" />';
            echo '<button type="button" class="additional_js_file__btn--select' . $i . '" style="margin-right:8px;">選択</button>';
            echo '<button type="button" class="additional_js_file__btn--delete' . $i . '" style="margin-right:8px;">削除</button>';
            echo '<p class="additional_js_file__display' . $i . '">ファイル名： ' . basename(${'js_file_url' . $i}) . '</p>';
            echo '</div>';
        }
    }
    echo '</div>';

    echo '</div>';

    for ($i = 1; $i <= 5; $i++) {
        ${'add_stylesheet_0' . $i} = get_post_meta($post->ID, 'add_stylesheet_0' . $i, true);
        echo '<div style="border-bottom:1px solid black; padding:8px; margin-bottom:16px;">';
        echo '<label for="add_stylesheet_0' . $i . '">読み込みCSSファイル' . $i . '：</label>';
        echo '<input type="hidden" name="add_stylesheet_0' . $i . '" class="add_stylesheet_0' . $i . '_input" value="' . ${'add_stylesheet_0' . $i} . '" />';
        echo '<button type="button" id="add_stylesheet_0' . $i . '_select" style="margin-right:8px;">選択</button>';
        echo '<button type="button" id="add_stylesheet_0' . $i . '_delete">削除</button>';
        echo '<p class="add_stylesheet_0' . $i . '_filename" style="margin-inline:10px;">ファイル名： ' . basename(${'add_stylesheet_0' . $i}) . '</p>';
        echo '</div>';
    };
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

add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (wp_is_post_revision($post_id)) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['illust_based_on']) && $_POST['illust_based_on'] !== '') {
        update_post_meta($post_id, 'illust_based_on', $_POST['illust_based_on']);
    } else {
        delete_post_meta($post_id, 'illust_based_on');
    }

    if (isset($_POST['stream_content']) && $_POST['stream_content'] !== '') {
        update_post_meta($post_id, 'stream_content', $_POST['stream_content']);
    } else {
        delete_post_meta($post_id, 'stream_content');
    }

    if (isset($_POST['stream_img']) && $_POST['stream_img'] !== '') {
        update_post_meta($post_id, 'stream_img', $_POST['stream_img']);
    } else {
        delete_post_meta($post_id, 'stream_img');
    }

    if (isset($_POST['stream_lyric']) && $_POST['stream_lyric'] !== '') {
        update_post_meta($post_id, 'stream_lyric', $_POST['stream_lyric']);
    } else {
        delete_post_meta($post_id, 'stream_lyric');
    }

    if (isset($_POST['stream_music']) && $_POST['stream_music'] !== '') {
        update_post_meta($post_id, 'stream_music', $_POST['stream_music']);
    } else {
        delete_post_meta($post_id, 'stream_music');
    }

    if (isset($_POST['stream_arrangement']) && $_POST['stream_arrangement'] !== '') {
        update_post_meta($post_id, 'stream_arrangement', $_POST['stream_arrangement']);
    } else {
        delete_post_meta($post_id, 'stream_arrangement');
    }

    if (isset($_POST['stream_edit']) && $_POST['stream_edit'] !== '') {
        update_post_meta($post_id, 'stream_edit', $_POST['stream_edit']);
    } else {
        delete_post_meta($post_id, 'stream_edit');
    }

    if (isset($_POST['stream_lyrics_text']) && $_POST['stream_lyrics_text'] !== '') {
        update_post_meta($post_id, 'stream_lyrics_text', $_POST['stream_lyrics_text']);
    } else {
        delete_post_meta($post_id, 'stream_lyrics_text');
    }

    if (isset($_POST['stream_detail']) && $_POST['stream_detail'] !== '') {
        update_post_meta($post_id, 'stream_detail', $_POST['stream_detail']);
    } else {
        delete_post_meta($post_id, 'stream_detail');
    }

    $json_data = get_post_meta($post_id, 'jsf_counter', true);
    $json_data = json_decode($json_data, true);
    $count = $json_data['count'] ?? 0;
    if ($count) {
        for ($i = 1; $i <= $count; $i++) {
            if (isset($_POST['additional_js_file__input' . $i]) && $_POST['additional_js_file__input' . $i] !== '') {
                update_post_meta($post_id, 'js_file_url' . $i, $_POST['additional_js_file__input' . $i]);
            } else {
                delete_post_meta($post_id, 'js_file_url' . $i);
            }
        }
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
