<?php
namespace App\Model\Traits;

const BLOG_IMAGE_WIDTH = 1200;
trait Images
{
  protected function imageResize($img): string
  {
    $im = imagecreatefromstring($img);
    $source_width = imagesx($im);
    $source_height = imagesy($im);
    (int)$ratio = $source_height / $source_width;
    $new_width = BLOG_IMAGE_WIDTH;
    (int)$new_height = $ratio * $new_width;
    $thumb = imagecreatetruecolor($new_width, (int)$new_height);
    imagesavealpha($thumb, true);
    $background = imagecolorallocate($thumb, 255, 255, 255);
    $tp = '/jpeg';
    imagefill($thumb, 0, 0, $background);
    imagecopyresampled($thumb, $im, 0, 0, 0, 0, (int)$new_width, (int)$new_height, $source_width, $source_height);
    ob_start();
    imagejpeg($thumb, NULL, 90);
    $stringdata = ob_get_contents();
    ob_end_clean();
    $img = 'data:image' . $tp . ';base64, ' . base64_encode($stringdata);
    return $img ?? '';
  }
}
