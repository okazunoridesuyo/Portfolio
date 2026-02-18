<?php get_header(); ?>

<main id="game" class="page">
    <div class="grid__wrap_container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>

                <?php get_template_part('template-parts/loop', 'card_list_layout', [
                    'order' => [
                        'thumbnail',
                        'title',
                        'category' => ['media_category'],
                        'category1' => ['media_genre'],
                    ],
                    'section' => 'media',
                    'no-image' => true,
                ]); ?>

            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>