<?php
$class_name = $args[0];
$show_no_image = $args[1];
$echo_thumbnail = $args['thumbnail'];
?>

<?php if ($echo_thumbnail): ?>
    <?php if (has_post_thumbnail($echo_thumbnail)): ?>
        <div class="<?php echo $class_name; ?>">
            <?php echo get_the_post_thumbnail($echo_thumbnail); ?>
        </div>
    <?php else: ?>
        <div class="<?php echo $class_name; ?> no-image"></div>
    <?php endif; ?>
<?php elseif (has_post_thumbnail()): ?>
    <div class="<?php echo $class_name; ?>">
        <?php the_post_thumbnail(); ?>
    </div>
<?php elseif ($show_no_image): ?>
    <div class="<?php echo $class_name; ?> no-image"></div>
<?php endif; ?>