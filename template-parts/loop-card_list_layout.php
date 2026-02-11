<?php
// $args=[
//     'order'=>[ <-何の項目を出力させるか
//         'thumbnail' => string $class_name_thumbnail='', <-'出力させる項目'=> クラス名
//         'time' => string $class_name_time='',
//         'title' => string $class_name_title='',
//         'category'=>[string $taxonomy_slug , string $class_name_taxonomy=''], <-[タクソノミー名（スラッグ）, クラス名]
//         'content' => string $class_name_content='',
//     ],
//     'section'=>string $section_name='', <-どのセクションかを文字列で指定（決められたクラス名の先頭に付く文字列）
//     'no-image'=> boolean, <-サムネイルが無かったときにNo-Imageを表示させるか否か
// ];
$args_def = [
    'order' => [
        'thumbnail' => '',
        'time' => '',
        'title' => '',
        'category' => ['', ''],
        'content' => '',
    ],
    'section' => '',
    'no-image' => false,
];

$format_args = [];

foreach ($args['order'] as $key => $val) {
    $taxonomy_name = get_post_taxonomies(get_the_ID());
    if (is_int($key)) {
        $format_args['order'][$val] = $val === 'category' ? [$taxonomy_name[0], ''] : '';
    } else {
        $format_args['order'][$key] = $val;
    }
    if ($key === 'category') {
        $format_args['order'][$key][0] = $val[0] ?? '';
        $format_args['order'][$key][1] = $val[1] ?? '';
    }
}
$replace_args = array_replace($format_args, array_intersect_key($format_args, $args_def));
$order_list = wp_parse_args($replace_args, $args);
?>

<?php $class_name_def = $order_list['section'] === '' ? 'item_container' : $order_list['section'] . '__item_container'; ?>

<div class="<?php echo $class_name_def; ?>">
    <?php $counter = 0; ?>
    <?php foreach ($order_list['order'] as $key => $val): ?>
        <?php
        if ($key === 'category') {
            $class_name = $val[1] === '' ? $class_name_def . '--' . $key : $val[1];
        } else {
            $class_name = $val === '' ? $class_name_def . '--' . $key : $val;
        }
        ?>

        <?php if ($key === 'thumbnail'): ?>
            <?php if (has_post_thumbnail()): ?>
                <div class="<?php echo $class_name; ?>">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php elseif ($order_list['no-image']): ?>
                <div class="<?php echo $class_name; ?> no-image"></div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($key === 'time'): ?>
            <time class="<?php echo $class_name; ?>" datetime="<?php echo the_time('Y-m-d'); ?>"><?php echo the_time('Y年m月d日'); ?></time>
        <?php endif; ?>

        <?php if ($key === 'title'): ?>
            <h2 class="<?php echo $class_name; ?>"><?php the_title(); ?></h2>
        <?php endif; ?>

        <?php if ($key === 'category'): ?>
            <?php $categories = get_the_terms(get_the_ID(), $val[0]); ?>
            <?php if ($categories): ?>
                <div class="<?php echo $class_name; ?>">
                    <?php foreach ($categories as $category): ?>
                        <span class="<?php echo $class_name . '--item'; ?>">
                            <?php echo $category->name; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($key === 'content'): ?>
            <div class="<?php echo $class_name; ?>">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>

        <?php $counter++; ?>

        <?php if ($counter === count($order_list['order'])): ?>
            <a class="<?php echo $class_name_def . '--link'; ?>" href="<?php the_permalink(); ?>"></a>
        <?php endif; ?>
    <?php endforeach; ?>


</div>