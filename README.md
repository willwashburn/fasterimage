# FasterImage [![Build Status](https://travis-ci.org/willwashburn/fasterimage.svg?branch=master)](https://travis-ci.org/willwashburn/FasterImage)

FasterImage finds the dimensions or filetype of a remote image file given its uri by fetching as little as needed, based on the excellent [Ruby implementation by Stephen Sykes](https://github.com/sdsykes/fastimage) and [PHP implementation by Tom Moor](https://github.com/tommoor/fastimage).

FasterImage uses the curl_muli* suite to run requests in parallel. Currently supports JPG, GIF, PNG, WEPB, BMP, PSD, TIFF, and ICO files.

## Usage
```php

        $client = new \FasterImage\FasterImage();
        
        $images = $client->batch(array(
            'http://wwww.example.com/image1.jpg',
            'http://wwww.example.com/image2.gif',
            'http://wwww.example.com/image3.png',
            'http://wwww.example.com/image4.bmp',
            'http://wwww.example.com/image5.tiff',
            'http://wwww.example.com/image6.psd',
            'http://wwww.example.com/image7.webp',
            'http://wwww.example.com/image8.ico',
            'http://wwww.example.com/image9.cur'
        ));
        
        foreach ($images as $image) {
            list($width,$height) = $image['size'];
        }
```

## Install

```composer require fasterimage/fasterimage```

Alternatively, add ```"fasterimage/fasterimage": "~1.0"``` to your composer.json

## References

* https://github.com/sdsykes/fastimage
* https://github.com/tommoor/fastimage
* http://pennysmalls.com/find-jpeg-dimensions-fast-in-pure-ruby-no-ima
* http://snippets.dzone.com/posts/show/805
* http://www.anttikupila.com/flash/getting-jpg-dimensions-with-as3-without-loading-the-entire-file/
* http://imagesize.rubyforge.org/

## License

(c) 2015 Will Washburn. MIT License
