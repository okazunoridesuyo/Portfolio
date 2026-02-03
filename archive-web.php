<?php get_header(); ?>

<main id="web" class="page">
    <div class="works__wrap_container">

        <?php
        $args = [
            'post_type' => 'web',
            'posts_per_page' => -1,
        ];
        $new_query = new WP_Query($args);
        ?>
        <?php if ($new_query->have_posts()): ?>
            <?php while ($new_query->have_posts()): $new_query->the_post(); ?>
                <div class="works__item_container">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="works__item_container--img">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    <?php else: ?>
                        <div class="works__item_container--img no-image"></div>
                    <?php endif; ?>

                    <h2 class="works__item_container--title"><?php the_title(); ?></h2>

                    <div class="works__item_container--info">
                        <?php
                        $category_list_arr = get_the_terms(get_the_ID(), 'info');
                        usort($category_list_arr, function ($a, $b) {
                            return $a->term_id > $b->term_id ? 1 : 0;
                        });
                        ?>
                        <?php foreach ($category_list_arr as $index => $category): ?>
                            <span class="works__item_container--info--item"><?php echo $category->name; ?><?php echo !(count($category_list_arr) - 1 === $index) ? ' / ' : ''; ?><wbr /></span>
                        <?php endforeach; ?>
                    </div>

                    <a href="<?php the_permalink(); ?>"></a>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>