<?php get_header(); ?>

<main class="single">
    <div class="inner">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <h1 class="title"><?php the_title(); ?></h1>

                <div class="the_content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>