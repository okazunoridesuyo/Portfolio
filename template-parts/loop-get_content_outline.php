<?php
$content = $args[0];
$ID_name = $args[1] ? $args[1] : 'content_outline';
?>

<?php
preg_match_all('#(<h[1-6].*?>)(.*?)(</h[1-6]>)#is', $content, $content_outline);

foreach ($content_outline[2] as $key => $val) {
    $fix_val = '<a href="#' . $ID_name . sprintf('%03d', $key + 1) . '">' . $val . '</a>';
    $fix_val_arr[] = '<li>' . $fix_val . '</li>';
};
?>

<?php if ($fix_val_arr): ?>
    <div class="text__outline">
        <?php
        foreach ($fix_val_arr as $val) {
            echo $val;
        };
        ?>
    </div>
<?php endif; ?>