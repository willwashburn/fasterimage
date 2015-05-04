<?php

$time = microtime(true);

$images = [
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQC3-MnPUUr3Z-pNsIl7Z33BXTUG0DtEzmbtjXV_hNhBnup5QyYPeUKpo',
    'http://cdn.shopify.com/s/files/1/0224/1915/files/bunny.jpg?22110',
    'http://36.media.tumblr.com/a5dbdd0882a3de34b48f9109599a3060/tumblr_nnp84siJ5x1qjcdw9o1_1280.jpg',
];


$time = microtime(true);
$fast  = new FasterImage\FasterImage();
$sizes = $fast->batch($images);

foreach ( $sizes as $image ) {

    list($width, $height) = $image['size'];
    echo "FasterImage: \n";
    echo "Width: " . $width . "px Height: " . $height . "px in " . (microtime(true) - $time) . " seconds \n";

}

echo "FasterImage for all three: " . $fasterimage = (microtime(true) - $time) . " seconds \n";

$time = microtime(true);
foreach ( $images as $image ) {

    $time = microtime(true);
    list($width, $height) = getimagesize($image);
    echo "getimagesize: \n";
    echo "Width: " . $width . "px Height: " . $height . "px in " . (microtime(true) - $time) . " seconds \n";
}

echo "getimagesize for all three: " . $getimagesize = (microtime(true) - $time) . " seconds \n";
echo PHP_EOL;
echo $getimagesize - $fasterimage ." seconds faster";
exit;