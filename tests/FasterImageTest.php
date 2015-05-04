<?php
chdir(__DIR__);
include('../vendor/autoload.php');

/**
 * @group proxy-url
 */
class ProxyUrlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @throws \Exception
     * @internal     param $original
     * @internal     param $proxy
     */
    public function test_batch_returns_size_and_type()
    {
        $uris = $this->linksProvider();

        $client = new \FasterImage\FasterImage();
        $images = $client->batch($uris);

        foreach($images as $image) {
            $this->assertArrayHasKey('size',$image);
            $this->assertArrayHasKey('type',$image);
        }
    }

    /**
     * @return array
     */
    public function linksProvider()
    {
        return array(
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQC3-MnPUUr3Z-pNsIl7Z33BXTUG0DtEzmbtjXV_hNhBnup5QyYPeUKpo',
            'http://cdn.shopify.com/s/files/1/0224/1915/files/bunny.jpg?22110',
            'http://36.media.tumblr.com/a5dbdd0882a3de34b48f9109599a3060/tumblr_nnp84siJ5x1qjcdw9o1_1280.jpg',
        );
    }
}