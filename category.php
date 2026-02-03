<?php get_header(); ?>

<main id="illust" class="page">

    <h1 class="illust__category_name"><?php echo get_queried_object()->name; ?></h1>

    <div class="illust__wrap_container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <div class="illust__item_container">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="illust__item_container--img">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    <?php else: ?>
                        <div class="illust__item_container--img no-image"></div>
                    <?php endif; ?>

                    <h2 class="illust__item_container--title"><?php the_title(); ?></h2>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</main>
<?php get_footer(); ?>