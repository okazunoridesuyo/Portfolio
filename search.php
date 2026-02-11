<?php get_header(); ?>

<main id="search" class="page">
    <h1 class="title">SEARCH KEYWORD > <?php echo the_search_query(); ?></h1>

    <?php get_template_part('template-parts/loop', 'search_form'); ?>

    <div class="search__wrap_container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>

                <?php
                get_template_part(
                    'template-parts/loop',
                    'card_list_layout',
                    [
                        'order' => [
                            'thumbnail',
                            'time',
                            'title',
                            'category',
                        ],
                        'section' => 'search',
                        'no-image' => true,
                    ]
                ) ?>

            <?php endwhile; ?>

        <?php else: ?>
            <div class="search__alert">
                <p>NOT SEARCH RESULT.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php get_template_part('template-parts/loop', 'pagination'); ?>

</main>

<?php get_footer(); ?>