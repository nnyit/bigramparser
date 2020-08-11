<?php

$test = new TestDev();
$test->createImage();


class TestDev
{
  public function createImage()
  {
    //https://www.php.net/manual/en/function.imagestring.php
        // Create a 100*30 image
    $im = imagecreate(100, 30);

    // White background and blue text
    $bg = imagecolorallocate($im, 255, 255, 255);
    $textcolor = imagecolorallocate($im, 0, 0, 255);

    // Write the string at the top left
    imagestring($im, 5, 0, 0, 'Hello world!', $textcolor);

    // Output the image
    header('Content-type: image/png');

    imagepng($im);
    $image = base64_encode(imagepng($im));
    imagedestroy($im);
    return $image;

  }

}

