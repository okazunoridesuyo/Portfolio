<?php get_header(); ?>

<main class="single">
    <div class="inner">
        <h1 class="title"><?php the_title(); ?></h1>

        <div class="the_content">
            <?php the_content(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>