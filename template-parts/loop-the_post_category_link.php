<div class="categories_link__container">
    <?php $categories = get_the_terms(get_the_ID(), get_post_taxonomies(get_the_ID())); ?>
    <?php foreach ($categories as $category): ?>
        <div class="categories_link__container--item">
            <a href="<?php echo get_term_link($category); ?>">
                <?php echo $category->name; ?>
            </a>
        </div>
    <?php endforeach; ?>
</div>