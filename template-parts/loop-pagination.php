<?php
if (is_page('blog')) {
    $total = $args->max_num_pages;
}
if (is_date() || is_category() || is_search()) {
    $total = $wp_query->max_num_pages;
}
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
?>

<?php if ($total > 1): ?>
    <div class="pagination_container">
        <div class="pagination_container__item_wrap">
            <?php echo paginate_links([
                'total' => $total,
                'current' => $paged,
                'mid_size' => 2,
                'prev_next' => true,
                'prev_text' => '前へ',
                'next_text' => '次へ'
            ]); ?>
        </div>
    </div>
<?php endif; ?>