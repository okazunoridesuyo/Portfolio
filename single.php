<?php get_header(); ?>

<main class="single">
    <div class="inner">
        <h1 class="title"><?php the_title(); ?></h1>

        <?php the_content(); ?>

        <?php if (in_category('fan_art') && $based_on = get_post_meta(get_the_ID(), 'based_on', true)): ?>
            <p class="based_on"><span>原作名：</span><?php echo $based_on; ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>