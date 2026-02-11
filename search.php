<?php get_header(); ?>

<main id="search" class="page">

    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>

            <?php
            get_template_part(
                'template-parts/loop',
                'card_list_layout',
                [
                    'order' => [
                        'thumbnail',
                        'time',
                        'title',
                        'category',
                    ],
                    'section' => 'search',
                ]
            ) ?>

        <?php endwhile; ?>

    <?php else: ?>
        <p>NOT SEARCH RESULT.</p>
    <?php endif; ?>

    <?php get_template_part('template-parts/loop', 'pagination'); ?>

</main>

<?php get_footer(); ?>