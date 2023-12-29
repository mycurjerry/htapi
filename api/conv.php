<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['webpImage'])) {
    $sourceFile = $_FILES['webpImage']['tmp_name'];
    $destinationFile = tempnam(sys_get_temp_dir(), 'conv') . '.png';

    $webpImage = imagecreatefromwebp($sourceFile);
    if (!$webpImage) {
        http_response_code(500);
        echo "Failed to create image from WebP.";
        exit;
    }

    if (imagepng($webpImage, $destinationFile)) {
        header('Content-Type: image/png');
        readfile($destinationFile);
    } else {
        http_response_code(500);
        echo "Failed to convert to PNG.";
    }

    imagedestroy($webpImage);
    unlink($destinationFile);
} else {
    http_response_code(400);
    echo "Invalid request.";
}
?>
