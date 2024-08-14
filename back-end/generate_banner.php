<?php
$product_image_path = 'C:/laragon/www/shop/images/sony_wh1000xm4.jpg';
$product_name = 'Sac à Main';
$output_path = 'C:/laragon/www/shop/images/abanner_gener.jpg';

$command = escapeshellcmd("python C:/laragon/www/shop/back-end/generate_banner.py $product_image_path $product_name $output_path");
$output = shell_exec($command);

echo "Bannière générée : " . $output_path;
?>
