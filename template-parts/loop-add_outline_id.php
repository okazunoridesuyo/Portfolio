<?php
$content = $args[0];
$ID_name = $args[1] ? $args[1] : 'content_outline';
?>

<?php
$html = new DOMDocument();
$html->preserveWhiteSpace = false;
@$html->loadHTML('<?xml encoding="UTF-8">' . $content);
$xpath = new DOMXPath($html);
$query = $xpath->query('//h1|//h2|//h3|//h4|//h5|//h6');

foreach ($query as $key => $val) {
    if ($val instanceof DOMElement) {
        $val->setAttribute('id', $ID_name . sprintf('%03d', $key + 1));
    }
}
echo $html->saveHTML();
?>