<?php
chdir(__DIR__);
include('../vendor/autoload.php');

/**
 * Class FasterImageTest
 */
class FasterImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @throws \Exception
     * @internal     param $original
     * @internal     param $proxy
     */
    public function test_batch_returns_size_and_type()
    {
        $data = $this->linksProvider();

        $expected = [];
        $uris     = [];

        foreach ( $data as list( $uri, $width, $height, $type ) ) {
            $uris[]           = $uri;
            $expected[ $uri ] = compact('width', 'height', 'type');
        }

        $client = new \FasterImage\FasterImage();
        $images = $client->batch($uris);

        foreach($images as $uri => $image) {
            $this->assertEquals($expected[$uri]['width'],$image['size'][0],"Failed to get the right width for $uri");
            $this->assertEquals($expected[$uri]['height'],$image['size'][1],"Failed to get the right height for $uri");
            $this->assertEquals($expected[$uri]['type'],$image['type'],"Failed to get the right type for $uri");
        }
    }

    /**
     * @return array
     */
    public function linksProvider()
    {
        return array(
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.bmp',40,27,'bmp'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test2.bmp',1920,1080,'bmp'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/test.gif',17,32,'gif'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/webp_vp8.webp',550,368,'webp'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/webp_vp8x.webp',386,395,'webp'],
            ['https://github.com/sdsykes/fastimage/raw/master/test/fixtures/webp_vp8l.webp',386,395,'webp'],
        );
    }
}