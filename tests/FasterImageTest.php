<?php
chdir(__DIR__);
include('../vendor/autoload.php');

/**
 * Class FasterImageTest
 */
class FasterImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @throws Exception
     */
    public function test_invalid_images_return_failed()
    {
        $uris = [
            'http://example.com/foobarimage.jpg',
            'https://example.com/foobarimage.jpg',
            'sdfsdfdsfds',
        ];

        $client = new \FasterImage\FasterImage();
        $images = $client->batch($uris);

        foreach ( $images as $uri => $image ) {
            $this->assertArrayHasKey('size', $image);
            $this->assertEquals('failed', $image['size']);
        }
    }

    /**
     * @throws \Exception
     */
    public function test_batch_returns_size_and_type()
    {
        $data = $this->linksProvider();

        // Only do one of the batch tests to avoid timeouts in travis
        // feel free to test this locally without it
        $data = array_slice($data, 0, 1);

        $expected = [];
        $uris     = [];

        foreach ( $data as $link ) {
            $uri    = current($link);
            $width  = next($link);
            $height = next($link);
            $type   = next($link);

            $uris[]         = $uri;
            $expected[$uri] = compact('width', 'height', 'type');
        }

        $client = new \FasterImage\FasterImage();
        $client->setTimeout(120);
        $images = $client->batch($uris);

        foreach ( $images as $uri => $image ) {
            $this->assertArrayHasKey('type', $image, "$uri is missing type: " . print_r($image, true));
            $this->assertEquals($expected[$uri]['type'], $image['type'], "Failed to get the right type for $uri");
            $this->assertArrayHasKey('size', $image, "There is no size defined for $uri " . print_r($image, true));
            $this->assertEquals($expected[$uri]['width'], $image['size'][0], "Failed to get the right width for $uri " . print_r($image, true));
            $this->assertEquals($expected[$uri]['height'], $image['size'][1], "Failed to get the right height for $uri " . print_r($image, true));
        }
    }

    /**
     * @return array
     */
    public function linksProvider()
    {
        return array(
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/exif_orientation.jpg', 600, 450, 'jpeg'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/favicon.ico', 16, 16, 'ico'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/infinite.jpg', 160, 240, 'jpeg'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/man.ico', 48, 48, 'ico'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/orient_2.jpg', 230, 408, 'jpeg'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.bmp', 40, 27, 'bmp'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.cur', 32, 32, 'cur'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.gif', 17, 32, 'gif'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.jpg', 882, 470, 'jpeg'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.png', 30, 20, 'png'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.psd', 17, 32, 'psd'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.tiff', 85, 67, 'tiff'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test2.bmp', 1920, 1080, 'bmp'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test2.jpg', 250, 188, 'jpeg'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test2.tiff', 333, 225, 'tiff'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test3.jpg', 630, 367, 'jpeg'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test4.jpg', 1485, 1299, 'jpeg'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/webp_vp8.webp', 550, 368, 'webp'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/webp_vp8l.webp', 386, 395, 'webp'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/webp_vp8x.webp', 386, 395, 'webp'],
            ['http://ketosizeme.com/wp-content/uploads/2016/11/Keto-Corn-Dog-Recipe-Low-Carb-High-Fat-.jpg', 700, 467, 'jpeg'],
            ['http://gluesticksgumdrops.com/wp-content/uploads/2015/03/how-to-find-more-time-to-read-to-your-kids.jpg', 700, 1000, 'jpeg'],
        );
    }
}