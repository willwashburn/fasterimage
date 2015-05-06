<?php
chdir(__DIR__);
include('../vendor/autoload.php');

/**
 * Class FasterImageTest
 */
class FasterImageTest  extends PHPUnit_Framework_TestCase
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
        $uris = [];

        foreach($data as list($uri,$width,$height,$type)) {
            $uris[]=$uri;
            $expected[$uri] = compact('width','height','type');
        }

        $client = new \FasterImage\FasterImage();
        $images = $client->batch($uris);

        foreach($images as $uri => $image) {
            $this->assertEquals($expected[$uri]['width'],$image['size'][0],"Failed to get the right width fro $uri");
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
            ['https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQC3-MnPUUr3Z-pNsIl7Z33BXTUG0DtEzmbtjXV_hNhBnup5QyYPeUKpo',178,119,'jpeg'],
            ['http://cdn.shopify.com/s/files/1/0224/1915/files/bunny.jpg?22110',450,250,'jpeg']
        );
    }
}