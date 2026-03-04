<?php get_header(); ?>
<?php $category_name = $post->post_type; ?>

<main id="<?php echo $category_name; ?>" class="page">

    <h1 class="<?php echo $category_name; ?>__category_name"><?php echo strtoupper(str_replace('_', ' ', get_queried_object()->name)); ?></h1>

    <div class="<?php echo $category_name; ?>__wrap_container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <div class="<?php echo $category_name; ?>__item_container">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="<?php echo $category_name; ?>__item_container--img">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    <?php else: ?>
                        <div class="<?php echo $category_name; ?>__item_container--img no-image"></div>
                    <?php endif; ?>

                    <h2 class="<?php echo $category_name; ?>__item_container--title"><?php the_title(); ?></h2>
                    <a href="<?php the_permalink(); ?>"></a>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <p class="link_page"><a href="<?php echo home_url($category_name); ?>">投稿一覧＞</a></p>

</main>
<?php get_footer(); ?>