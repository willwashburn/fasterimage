# FasterImage [![CircleCI](https://img.shields.io/circleci/project/github/willwashburn/fasterimage.svg?style=flat-square)](https://circleci.com/gh/willwashburn/fasterimage) [![Coveralls](https://img.shields.io/coveralls/willwashburn/fasterimage.svg?maxAge=259200&style=flat-square)](https://coveralls.io/github/willwashburn/fasterimage) [![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg?style=flat-square)](https://php.net/) [![Packagist Version](https://img.shields.io/packagist/v/fasterimage/fasterimage.svg?style=flat-square)](https://packagist.org/packages/fasterimage/fasterimage) [![Packagist Downloads](https://img.shields.io/packagist/dt/fasterimage/fasterimage.svg?style=flat-square)](https://packagist.org/packages/fasterimage/fasterimage/stats) [![License](https://img.shields.io/packagist/l/fasterimage/fasterimage.svg?style=flat-square)](https://github.com/willwashburn/fasterimage/LICENSE)

FasterImage finds the dimensions or filetype of a remote image file given its uri by fetching as little as needed, based on the excellent [Ruby implementation by Stephen Sykes](https://github.com/sdsykes/fastimage) and [PHP implementation by Tom Moor](https://github.com/tommoor/fastimage).

FasterImage uses the curl_muli* suite to run requests in parallel. Currently supports JPG, GIF, PNG, WEBP, BMP, PSD, TIFF, SVG, and ICO files.

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
            'http://wwww.example.com/image9.cur',
            'http://wwww.example.com/image10.svg'
        ]);
        
        foreach ($images as $image) {
            list($width,$height) = $image['size'];
        }
```

## Install

```composer require fasterimage/fasterimage```

Alternatively, add ```"fasterimage/fasterimage": "~1.5"``` to your composer.json

## Changelog

* v1.5.0 - Fallback support when curl_multi_init() is not available
* v1.4.0 - Add support for parsing dimensions from SVG images
* v1.3.0 - Add ability for user agent, buffer size, and SSL host/peer verification to be overridden
* v1.2.1 - Limit isRotated to only check for valid orientation values
* v1.2.0 - Add option to include content-length in result set
* v1.1.2 - Update Accept header to accept images
* v1.1.1 - Properly handle jpeg's with corrupted Exif tags 
* v1.1.0 - Return message in return array when curl fails
* v1.0.3 - Use external stream package
* v1.0.2 - Fail invalid image exceptions gracefully when using batch requests
* v1.0.1 - Support PHP v5.4+
* v1.0.0 - **Stable Release** - Support for `.PSD`, `.ICO` + `.CUR`
* v0.0.7 - Remove support for PHP v5.4
* v0.0.6 - Add option to set timeout of requests, support for EXIF in .jpgs, better support for .bmp (including negative height bitmaps) and normalized response indexes for all file types
* v0.0.5 - Support for `.webp`
* v0.0.4 - Support for `.tiff` and exceptions for unknown file types
* v0.0.3 - Force curl to follow redirects so you get less bad responses
* v0.0.2 - Update curl headers to mimic browser so you get less bad responses
* v0.0.1 - Support for `.jpg`, `.bmp`, `.gif`, `.png` and parallel requests

## References

* https://github.com/sdsykes/fastimage
* https://github.com/tommoor/fastimage
* http://pennysmalls.com/find-jpeg-dimensions-fast-in-pure-ruby-no-ima
* http://snippets.dzone.com/posts/show/805
* http://www.anttikupila.com/flash/getting-jpg-dimensions-with-as3-without-loading-the-entire-file/
* http://imagesize.rubyforge.org/
