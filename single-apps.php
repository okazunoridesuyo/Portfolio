<?php get_header(); ?>

<main id="apps" class="single">
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>

            <h1 class="title">
                <?php the_title(); ?>
            </h1>

            <?php the_content(); ?>

        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>