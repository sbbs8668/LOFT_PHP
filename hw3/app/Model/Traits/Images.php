<?php
namespace App\Model\Traits;

use Error;
use Imagick;
use ImagickPixel;

const BLOG_IMAGE_WIDTH = 1200;
trait Images
{
  /**
   * @throws \ImagickException
   */
  protected function imageResize($img): string
  {
    $img = imagecreatefromstring($img);
    $source_width = imagesx($img);
    $source_height = imagesy($img);
    (int)$ratio = $source_height / $source_width;
    $new_width = BLOG_IMAGE_WIDTH;
    (int)$new_height = $ratio * $new_width;

    /*convert logo to png*/
    $logo = '';
    while (!$logo) {
      try {
        $logo = file_get_contents('https://loftschool.com/_nuxt/1c49286792facb9d3e02511cb4a94ceb.svg');
      } catch (Error $e) {
        $logo = '';
      }
    }

    $im = new Imagick();
    $im->setBackgroundColor(new ImagickPixel("transparent"));
    $im->readImageBlob($logo);
    $im->setImageFormat("png24");
    $imRatio = $im->getImageHeight() / $im->getImageWidth();
    $im->resizeImage($new_width, (int)($new_width / $imRatio), imagick::FILTER_BOX, 0, true);
    $logo = (string)$im;
    $im->clear();
    $im->destroy();
    $logo = imagecreatefromstring($logo);
    $opacity = 0.2;
    imagealphablending($logo, false);
    imagesavealpha($logo, true);
    imagefilter($logo, IMG_FILTER_COLORIZE, 0,0,0,(int)(533 * $opacity));
    ob_start();
    imagepng($logo);
    ob_end_clean();
    /*convert logo to png*/

    $thumb = imagecreatetruecolor($new_width, (int)$new_height);
    imagesavealpha($thumb, true);
    $background = imagecolorallocate($thumb, 255, 255, 255);
    $tp = '/jpeg';
    imagefill($thumb, 0, 0, $background);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, $new_width, (int)$new_height, $source_width, $source_height);

    imagecopy($thumb, $logo, 0, (int)((imagesy($thumb) / 3)), 0, 0, $new_width, (int)$new_height);
    ob_start();
    imagejpeg($thumb, NULL, 90);
    $stringdata = ob_get_contents();
    ob_end_clean();
    $img = 'data:image' . $tp . ';base64, ' . base64_encode($stringdata);
    return $img ?? '';
  }
}
