<?php get_header(); ?>

<main id="text" class="page">
    <h1 class="title">TAG > <?php echo get_queried_object()->name; ?></h1>

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