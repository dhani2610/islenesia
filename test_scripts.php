<?php
$html = file_get_contents('http://127.0.0.1:8000/');
preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $html, $matches);
foreach ([2, 3, 6] as $idx) {
    if (isset($matches[0][$idx])) {
        file_put_contents("script_{$idx}.js", $matches[1][$idx]);
        echo "Script $idx written, size: " . strlen($matches[1][$idx]) . "\n";
    }
}
