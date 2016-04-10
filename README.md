# FasterImage [![Build Status](https://img.shields.io/travis/willwashburn/fasterimage/master.svg?style=flat-square)](https://travis-ci.org/willwashburn/fasterimage) [![Packagist](https://img.shields.io/packagist/v/fasterimage/fasterimage.svg?style=flat-square)](https://packagist.org/packages/fasterimage/fasterimage) [![Packagist](https://img.shields.io/packagist/dt/fasterimage/fasterimage.svg?style=flat-square)](https://packagist.org/packages/fasterimage/fasterimage) [![Packagist](https://img.shields.io/packagist/l/fasterimage/fasterimage.svg?style=flat-square)](https://github.com/willwashburn/fasterimage#license)

FasterImage finds the dimensions or filetype of a remote image file given its uri by fetching as little as needed, based on the excellent [Ruby implementation by Stephen Sykes](https://github.com/sdsykes/fastimage) and [PHP implementation by Tom Moor](https://github.com/tommoor/fastimage).

FasterImage uses the curl_muli* suite to run requests in parallel. Currently supports JPG, GIF, PNG, WEPB, BMP, PSD, TIFF, and ICO files.

## Usage
```php

        $client = new \FasterImage\FasterImage();
        
        $images = $client->batch([
            'http://wwww.example.com/image1.jpg',
            'http://wwww.example.com/image2.gif',
            'http://wwww.example.com/image3.png',
            'http://wwww.example.com/image4.bmp',
            'http://wwww.example.com/image5.tiff',
            'http://wwww.example.com/image6.psd',
            'http://wwww.example.com/image7.webp',
            'http://wwww.example.com/image8.ico',
            'http://wwww.example.com/image9.cur'
        ]);
        
        foreach ($images as $image) {
            list($width,$height) = $image['size'];
        }
```

## Install

```composer require fasterimage/fasterimage```

Alternatively, add ```"fasterimage/fasterimage": "~1.0"``` to your composer.json

## Changelog

### 1.0.3 (2016-04-9)
* Use external stream package

### 1.0.2 (2015-08-27)
* Fail invalid image exceptions gracefully when using batch requests

### 1.0.1 (2015-05-16)

* Support PHP v5.4+

### 1.0.0 (2015-05-16) [stable release!]

* Support for .PSD
* Support for .ICO + .CUR

### 0.0.7 (2015-05-16)

* Only support PHP v5.5+ for now :/

### 0.0.6 (2015-05-11)

* Add option to set timeout of requests
* Support for EXIF in .jpgs
* Better support for .bmp (including negative height bitmaps)
* Normalized response indexes for all file types

### 0.0.5 (2015-05-09)

* Support for .webp

### 0.0.4 (2015-05-07)

* Support for .tiff
* Start throwing exceptions for unknown file types

### 0.0.3 (2015-05-07)

* Force curl to follow redirects so you get less bad responses

### 0.0.2 (2015-05-06)

* Update curl headers to mimic browser so you get less bad responses

### 0.0.1 (2015-05-06) [alpha release!]

* Support for .jpg
* Support for .bmp
* Support for .gif
* Support for .png
* Support for parallel requests

## References

* https://github.com/sdsykes/fastimage
* https://github.com/tommoor/fastimage
* http://pennysmalls.com/find-jpeg-dimensions-fast-in-pure-ruby-no-ima
* http://snippets.dzone.com/posts/show/805
* http://www.anttikupila.com/flash/getting-jpg-dimensions-with-as3-without-loading-the-entire-file/
* http://imagesize.rubyforge.org/

## License

(c) 2015 Will Washburn. MIT License
