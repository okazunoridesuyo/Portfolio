<?php $terms = get_terms($args); ?>
<?php if ($terms): ?>
    <div class="taxonomy_list__container">
        <?php foreach ($terms as $term): ?>
            <span class="taxonomy_list__item"><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>