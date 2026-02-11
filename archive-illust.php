<?php get_header(); ?>

<main id="illust" class="page">

    <?php
    $categories = get_terms(['taxonomy' => 'illust_category', 'orderby' => 'id',]);
    ?>

    <?php foreach ($categories as $category): ?>
        <?php if ($category): ?>
            <section class="illust__category_section">
                <h1 class="illust__category_name"><a href="<?php echo get_term_link($category); ?>"><?php echo strtoupper(str_replace('_', ' ', $category->slug)); ?></a></h1>

                <div class="illust__wrap_container">
                    <?php
                    $args = [
                        'post_type' => 'illust',
                        'posts_per_page' => -1,
                        'tax_query' => [
                            'relation' => 'AND',
                            [
                                'taxonomy' => $category->taxonomy,
                                'terms' => $category->slug,
                                'field' => 'slug',
                            ],
                        ],
                    ];
                    $new_wpquery = new WP_Query($args);
                    ?>
                    <?php if ($new_wpquery->have_posts()): ?>
                        <?php while ($new_wpquery->have_posts()): $new_wpquery->the_post(); ?>
                            <div class="illust__item_container">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="illust__item_container--img">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="illust__item_container--img no-image"></div>
                                <?php endif; ?>

                                <h2 class="illust__item_container--title"><?php the_title(); ?></h2>

                                <a href="<?php the_permalink(); ?>"></a>
                            </div>
                            <?php wp_reset_postdata(); ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </section>

        <?php endif; ?>
    <?php endforeach; ?>

</main>

<?php get_footer(); ?>