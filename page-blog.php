<?php get_header(); ?>

<div class="blog__page_wrap_container">
    <main id="blog" class="blog__main_content_section page">
        <section class="blog__card_list_section">
            <div class="blog__wrap_container">

                <?php
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $args = [
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'nopaging' => false,
                    'paged' => $paged,
                    'order' => 'DESC',
                    'orderby' => 'date',
                ];
                $new_query = new WP_Query($args);
                ?>

                <?php if ($new_query->have_posts()): ?>
                    <?php while ($new_query->have_posts()): $new_query->the_post(); ?>

                        <?php
                        $year = $new_query->posts[0] ? get_the_date('Y', $new_query->posts[0]->ID) : '';

                        $order = [
                            'order' => [
                                'time',
                                'title',
                                'thumbnail',
                                'content',
                                'category',
                            ],
                            'section' => 'blog',
                            'no-image' => true,
                        ];
                        get_template_part('template-parts/loop', 'card_list_layout', $order);
                        ?>

                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>

                <?php get_template_part('template-parts/loop', 'pagination', $new_query); ?>


            </div>

        </section>
    </main>

    <aside class="blog__archive_link_section">
        <?php get_template_part('template-parts/loop', 'archive_category_list', $argc = ['year' => $year]); ?>
        <?php get_template_part('template-parts/loop', 'search_form'); ?>
    </aside>


</div><?php get_footer(); ?>