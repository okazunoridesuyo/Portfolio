<?php get_header(); ?>

<div class="blog__page_wrap_container">
    <main id="blog" class="blog__main_content_section page">
        <section class="blog__card_list_section">
            <?php if (is_date()): ?>
                <h1 class="title">ARCHIVE >
                    <?php echo get_query_var('year') . '年'; ?>
                    <?php if (is_month()): ?>
                        <?php echo ' > ' . get_query_var('monthnum') . '月'; ?>
                    <?php endif; ?>
                </h1>
            <?php elseif (is_category()): ?>
                <h1 class="title">CATEGORY > <?php echo get_queried_object()->name; ?></h1>
            <?php endif; ?>
            <div class="blog__wrap_container">

                <?php if (have_posts()): ?>
                    <?php while (have_posts()): the_post(); ?>

                        <?php
                        $year = $new_query->posts[0] ? get_the_date('Y', $new_query->posts[0]->ID) : '';

                        $order = [
                            'order' => [
                                'thumbnail',
                                'title',
                                'time',
                                'category'
                            ],
                            'section' => 'blog',
                        ];
                        get_template_part('template-parts/loop', 'card_list_layout', $order);
                        ?>

                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>

                <?php get_template_part('template-parts/loop', 'pagination'); ?>

            </div>

        </section>
    </main>

    <aside class="blog__archive_link_section">

        <?php get_template_part('template-parts/loop', 'archive_category_list'); ?>
        <?php get_template_part('template-parts/loop', 'search_form'); ?>

    </aside>


</div><?php get_footer(); ?>