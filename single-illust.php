<?php get_header(); ?>

<main id="illust" class="single">
    <div class="inner">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <h1 class="title"><?php the_title(); ?></h1>

                <div class="the_content">
                    <?php the_content(); ?>
                </div>

                <?php if (in_category('fan_art') && $illust_based_on = get_post_meta(get_the_ID(), 'illust_based_on', true)): ?>
                    <p class="illust_based_on"><span>原作名：</span><?php echo $illust_based_on; ?></p>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>