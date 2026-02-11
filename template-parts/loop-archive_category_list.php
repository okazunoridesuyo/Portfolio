<?php
$monthly_archives = wp_get_archives([
    'type' => 'monthly',
    'format' => 'custom',
    'echo' => 0,
]);
$yearly_archives = wp_get_archives([
    'type' => 'yearly',
    'format' => 'custom',
    'echo' => 0,
]);

$categories_list = wp_list_categories([
    'title_li' => '',
    'orderby' => 'ID',
    'order' => 'ASC',
    'hide_empty' => false,
    'echo' => 0,
]);

preg_match_all('#(<a[^>]*>)(.*?)(</a>)#i', $monthly_archives, $monthly_archives_arr);
preg_match_all('#<a[^>]*>.*?</a>#i', $yearly_archives, $yearly_archives_arr);
?>

<div class="archive_list__container">

    <div class="archive_list__container--yearly_container">
        <?php foreach ($yearly_archives_arr[0] as $ya): ?>
            <?php
            $ya_list = preg_replace_callback(
                '#(<a[^>]*>)(.*?)(</a>)#i',
                function ($str) {
                    $fixed_ya = $str[1] . $str[2] . '年' . $str[3];
                    return $fixed_ya;
                },
                $ya
            ); ?>

            <div class="archive_list__container--yearly_container--item">
                <?php echo ($ya_list); ?>
            </div>

            <?php preg_match('#(<a[^>]*>)(.*?)(</a>)#i', $ya_list, $a);
            $year =  intval(preg_replace('/年/', '', $a[2]));
            $year_query = $args['year'] ? intval($args['year']) : intval(get_query_var('year'));
            ?>

            <?php if ($year === $year_query): ?>
                <div class="archive_list__container--monthly_container">
                    <?php foreach ($monthly_archives_arr[0] as $ma) : ?>

                        <?php $ma_list = preg_replace_callback(
                            '#(<a[^>]*>)(.*?)(</a>)#i',
                            function ($str) use ($year_query) {
                                $fixed_ma = $str[1] . preg_replace('/[0-9]*?年/i', '', $str[2]) . $str[3];
                                return $year_query === intval(preg_replace('/年.*/i', '', $str[2])) ? $fixed_ma : '';
                            },
                            $ma
                        ); ?>

                        <?php if ($ma_list): ?>
                            <div class="archive_list__container--monthly_container--item">
                                <?php echo $ma_list; ?>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
</div>

<div class="category_list__container">
    <?php echo $categories_list; ?>
</div>