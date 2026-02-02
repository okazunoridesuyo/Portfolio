<?php get_header(); ?>

<main id="web" class="page">
    <div class="works__wrap_container">

        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <div class="works__item_container">
                    <img src="" alt="" class="works__item_container--img">

                    <h2 class="works__item_container--title">title</h2>

                    <p class="works__item_container--info">Design/ <wbr />Cording(Responsive) / <wbr />WordPress / <wbr />Banner Design</p>

                    <a href="<?php the_permalink(); ?>"></a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>