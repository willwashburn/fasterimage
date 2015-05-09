[![Build Status](https://travis-ci.org/willwashburn/FasterImage.svg?branch=master)](https://travis-ci.org/willwashburn/FasterImage)
# FasterImage
FasterImage finds the dimensions or filetype of a remote image file given its uri by fetching as little as needed, based on the excellent [Ruby implementation by Stephen Sykes](https://github.com/sdsykes/fastimage) and [PHP implementation by Tom Moor](https://github.com/tommoor/fastimage).

FasterImage uses the curl_muli* suite to run requests in parallel.

## Usage
```php

        $client = new \FasterImage\FasterImage();
        
        $images = $client->batch(array(
            'http://wwww.example.com/image1.jpg',
            'http://wwww.example.com/image2.gif',
            'http://wwww.example.com/image3.png'
        ));
        
        foreach ($images as $image) {
            list($width,$height) = $image['size'];
        }
```

## Installation

```composer require fasterimage/fasterimage```

Alternatively, add ```"fasterimage/fasterimage": "0.0.5"``` to your composer.json

## References

* https://github.com/sdsykes/fastimage
* https://github.com/tommoor/fastimage
* http://pennysmalls.com/find-jpeg-dimensions-fast-in-pure-ruby-no-ima
* http://snippets.dzone.com/posts/show/805
* http://www.anttikupila.com/flash/getting-jpg-dimensions-with-as3-without-loading-the-entire-file/
* http://imagesize.rubyforge.org/


## License

FasterImage is released under the MIT license. It is simple and easy to understand and places almost no restrictions on what you can do with the software. [More Information](http://en.wikipedia.org/wiki/MIT_License)

## Download
Releases are available for download from
[GitHub](http://github.com/willwashburn/fasterimage/downloads).