<?php get_header(); ?>

<main id="text" class="single">
    <div class="inner">
        <section class="text__main_content_section">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <?php
                    $title = get_the_title();
                    $content = apply_filters('the_content', get_post_field('post_content', get_the_ID()));
                    ?>

                    <h1 class="title">
                        <?php the_title(); ?>
                    </h1>

                    <?php get_template_part('template-parts/loop', 'add_outline_id', [
                        $content,
                        $title,
                    ]); ?>

                <?php endwhile; ?>
            <?php endif; ?>
        </section>

        <aside class="text__sub_content_section">
            <?php get_template_part('template-parts/loop', 'get_content_outline', [
                $content,
                $title,
            ]); ?>

            <?php if (has_term('', 'text_tag')): ?>
                <section class="text__tag">
                    <?php get_template_part('template-parts/loop', 'the_post_category_link'); ?>
                </section>
            <?php endif; ?>
        </aside>
    </div>
</main>

<?php get_footer(); ?>