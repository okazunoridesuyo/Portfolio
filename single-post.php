<?php get_header(); ?>
<div class="blog__page_wrap_container">

    <main id="blog" class="single">
        <div class="inner">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>

                    <h1 class="title"><?php the_title(); ?></h1>

                    <?php
                    $class_name = 'blog__single--thumbnail';
                    get_template_part('template-parts/loop', 'get_thumbnail', [$class_name]);
                    ?>

                    <div class="the_content">
                        <?php the_content(); ?>
                    </div>

                <?php endwhile; ?>
            <?php endif; ?>

            <h2 class="category_link__title">CATEGORIES</h2>
            <?php get_template_part('template-parts/loop', 'the_post_category_link'); ?>
            <?php get_template_part('template-parts/loop', 'prev_next_post_link', ['thumbnail' => true]); ?>
        </div>

        <section class="blog__recommended">
            <h2 class="title">RECOMMENDED POSTS</h2>

            <?php
            $args = [
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post__not_in' => [get_the_ID()],
                'orderby' => 'rand',
            ];
            $new_query = new WP_Query($args);
            ?>
            <div class="blog-single__wrap_container">
                <?php if ($new_query->have_posts()): ?>
                    <?php while ($new_query->have_posts()): $new_query->the_post(); ?>
                        <?php get_template_part('template-parts/loop', 'card_list_layout', [
                            'order' => [
                                'thumbnail',
                                'time',
                                'title',
                                'category',
                            ],
                            'section' => 'blog-single',
                            'no-image' => true,
                        ]); ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
        </section>
    </main>


    <aside class="blog__archive_link_section">
        <?php get_template_part('template-parts/loop', 'archive_category_list', $argc = ['year' => $year]); ?>
        <?php get_template_part('template-parts/loop', 'search_form'); ?>
    </aside>

</div>
<?php get_footer(); ?>