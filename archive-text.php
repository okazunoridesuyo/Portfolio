<?php get_header(); ?>

<main id="text" class="page">
    <div class="grid__wrap_container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>

                <?php get_template_part('template-parts/loop', 'card_list_layout', [
                    'order' => [
                        'thumbnail',
                        'title',
                        'category',
                    ],
                    'section' => 'text',
                    'no-image' => true,
                ]) ?>

            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>