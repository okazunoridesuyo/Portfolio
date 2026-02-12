<?php
$prev_thumbnail = get_previous_post()->ID;
$next_thumbnail = get_next_post()->ID;

if ($args['thumbnail']) {
    $echo_thumbnail = ['prev_next__thumbnail', true];
}
?>

<div class="prev_next__container">

    <?php if (get_previous_post()): ?>
        <div class="prev_next__container--item prev">
            <div class="prev_next__container--icon prev"></div>

            <?php if ($echo_thumbnail): ?>
                <?php
                $echo_thumbnail['thumbnail'] = $prev_thumbnail;
                get_template_part('template-parts/loop', 'get_thumbnail', $echo_thumbnail);
                ?>
            <?php endif; ?>

            <div class="prev_next__container--detail prev">
                <div class="prev_next__container--detail time prev">
                    <?php echo get_the_time('Y年m月d日', get_previous_post()) ?>
                </div>
                <div class="prev_next__container--detail title prev">
                    <?php echo get_the_title(get_previous_post()); ?>
                </div>
            </div>
            <a href="<?php the_permalink(get_previous_post()); ?>"></a>
        </div>
    <?php else: ?>
        <div class="prev_next__container--item prev blank"></div>
    <?php endif; ?>

    <?php if (get_next_post()): ?>
        <div class="prev_next__container--item next">
            <div class="prev_next__container--icon next"></div>

            <?php if ($echo_thumbnail): ?>
                <?php
                $echo_thumbnail['thumbnail'] = $next_thumbnail;
                get_template_part('template-parts/loop', 'get_thumbnail', $echo_thumbnail);
                ?>
            <?php endif; ?>

            <div class="prev_next__container--detail next">
                <div class="prev_next__container--detail time next">
                    <?php echo get_the_time('Y年m月d日', get_next_post()) ?>
                </div>
                <div class="prev_next__container--detail title next">
                    <?php echo get_the_title(get_next_post()); ?>
                </div>
            </div>
            <a href="<?php the_permalink(get_next_post()); ?>"></a>
        </div>

    <?php else: ?>
        <div class="prev_next__container--item next blank"></div>
    <?php endif; ?>

</div>