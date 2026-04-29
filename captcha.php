<?php
session_start();

// Generate a random code
$random_alpha = md5(rand());
$captcha_code = substr($random_alpha, 0, 6);
$_SESSION['captcha'] = $captcha_code;

// Create the image
$target_layer = imagecreatetruecolor(120, 40);

// Colors
$bg_color = imagecolorallocate($target_layer, 255, 255, 255); // White
$text_color = imagecolorallocate($target_layer, 0, 0, 0); // Black
$line_color = imagecolorallocate($target_layer, 64, 64, 64); // Dark Gray

imagefilledrectangle($target_layer, 0, 0, 120, 40, $bg_color);

// Add some random lines like the user asked for "security code display" style
for($i=0; $i<5; $i++) {
    imageline($target_layer, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $line_color);
}

// Add the text
// Using imagestring basic font for simplicity as requested, 
// or could load a font file if available. Standard GD font is safest.
imagestring($target_layer, 5, 30, 12, $captcha_code, $text_color);

header("Content-type: image/png");
imagepng($target_layer);
imagedestroy($target_layer);
?>
