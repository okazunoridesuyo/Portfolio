<?php get_header(); ?>

<main id="apps" class="page">
    <?php $term_arr = get_terms('apps_category'); ?>
    <?php if ($term_arr): ?>
        <?php foreach ($term_arr as $term): ?>

            <h1 class="title"><?php echo strtoupper($term->name); ?></h1>

            <div class="grid__wrap_container">

                <?php
                $args = [
                    'post_type' => 'apps',
                    'posts_per_page' => -1,
                    'tax_query' => [
                        'relation' => 'AND',
                        [
                            'taxonomy' => $term->taxonomy,
                            'terms' => $term->slug,
                            'field' => 'slug',
                        ],
                    ],
                ];
                $new_query = new WP_Query($args);
                ?>

                <?php if ($new_query->have_posts()): ?>
                    <?php while ($new_query->have_posts()): $new_query->the_post(); ?>

                        <?php get_template_part('template-parts/loop', 'card_list_layout', [
                            'order' => [
                                'thumbnail',
                                'title',
                                'category' => ['apps_category'],
                                'category1' => ['apps_genre'],
                            ],
                            'section' => 'apps',
                            'no-image' => true,
                        ]) ?>

                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>